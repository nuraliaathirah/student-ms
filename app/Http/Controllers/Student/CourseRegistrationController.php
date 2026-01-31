<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CourseSection;
use App\Models\Registration;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('student.profile.edit')
                ->with('error', 'Please complete your student profile first.');
        }

        if (!$student->program_code) {
            return redirect()->route('student.profile.edit')
                ->with('error', 'Please select your programme before course registration.');
        }

        $programCode = $student->program_code;

        // 1. Semester Logic
        // Current semester (Active progress)
        $currentSemester = Semester::where('is_current', 1)->first() 
                           ?? Semester::orderBy('start_date', 'desc')->first();

        // Target semester for NEW registrations (Next semester)
        $registrationSemester = Semester::where('start_date', '>', $currentSemester->start_date)
                                ->orderBy('start_date', 'asc')
                                ->first() ?? $currentSemester;

        // Previous semesters for History
        $previousSemesters = Semester::where('start_date', '<', $currentSemester->start_date)
            ->orderBy('year', 'desc')
            ->orderBy('session', 'desc')
            ->get();

        // 2. IDs for UI button states (Registration Page target)
        $registeredSectionIds = Registration::where('student_id', $student->student_id)
            ->whereHas('section', fn($s) => $s->where('semester_id', $registrationSemester->semester_id))
            ->whereIn('status', ['pending', 'approved'])
            ->pluck('section_id')
            ->toArray();

        $registeredCourseIds = Registration::where('student_id', $student->student_id)
            ->whereHas('section', fn($s) => $s->where('semester_id', $registrationSemester->semester_id))
            ->join('course_section', 'registration.section_id', '=', 'course_section.section_id')
            ->pluck('course_section.course_id')
            ->toArray();

        // 3. Offered sections for the REGISTRATION semester
        $sectionsQuery = CourseSection::with(['course', 'lecturer'])
            ->where('semester_id', $registrationSemester->semester_id)
            ->whereHas('course', function ($q) use ($programCode) {
                $q->where('program_code', $programCode);
            })
            ->withCount([
                'registrations' => function($query) {
                    $query->whereIn('status', ['pending', 'approved']);
                }
            ]);

        // Search Logic
        if ($request->filled('q')) {
            $q = $request->q;
            $sectionsQuery->whereHas('course', function ($sub) use ($q) {
                $sub->where('course_id', 'like', "%{$q}%")
                    ->orWhere('course_name', 'like', "%{$q}%");
            });
        }

        $offeredSections = $sectionsQuery->orderBy('section_id')->get();

        // 4. Current registrations (Active progress - Current Semester)
        $registrations = Registration::with(['section.course', 'section.lecturer'])
            ->where('student_id', $student->student_id)
            ->whereHas('section', fn($s) => $s->where('semester_id', $currentSemester->semester_id))
            ->whereIn('status', ['pending', 'approved'])
            ->orderBy('registered_at', 'desc')
            ->get();

        // 5. Previous registrations grouped for history view
        $previousRegistrations = Registration::with(['section.course', 'section.semester'])
            ->where('student_id', $student->student_id)
            ->whereHas('section', function ($q) use ($previousSemesters) {
                $q->whereIn('semester_id', $previousSemesters->pluck('semester_id'));
            })
            ->whereIn('status', ['approved', 'completed'])
            ->orderBy('registered_at', 'desc')
            ->get()
            ->groupBy('section.semester.semester_id');

        return view('student.registration.index', compact(
            'student', 'currentSemester', 'registrationSemester', 'offeredSections', 
            'registrations', 'registeredSectionIds', 'registeredCourseIds',
            'previousRegistrations', 'previousSemesters'
        ));
    }

    public function store(Request $request)
    {
        $student = auth()->user()->student;

        $data = $request->validate([
            'section_id' => ['required', 'integer', 'exists:course_section,section_id'],
        ]);

        $section = CourseSection::with('course')->findOrFail($data['section_id']);
        
        // 1. Duplicate Checks
        $existingCourseRegistration = Registration::where('student_id', $student->student_id)
            ->whereHas('section', function($q) use ($section) {
                $q->where('course_id', $section->course_id)
                  ->where('semester_id', $section->semester_id);
            })
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($existingCourseRegistration) {
            return back()->withErrors(['section_id' => 'You already registered for this course in a different section.']);
        }

        // 2. Credit Limit Validation
        $newCourseCredit = $section->course->credit_hours;
        $currentTotalCredits = Registration::where('student_id', $student->student_id)
            ->whereHas('section', fn($q) => $q->where('semester_id', $section->semester_id))
            ->whereIn('status', ['pending', 'approved'])
            ->get()
            ->sum(function($reg) {
                return $reg->section->course->credit_hours;
            });

        if (($currentTotalCredits + $newCourseCredit) > 20) {
            return back()->withErrors(['section_id' => 'Credit limit exceeded (Max 20).']);
        }

        // 3. Capacity Check & Status Assignment
        $currentCount = Registration::where('section_id', $section->section_id)
            ->whereIn('status', ['pending','approved'])
            ->count();

        $status = ($currentCount < $section->course->max_students) ? 'approved' : 'pending';

        // 4. Create Registration
        Registration::create([
            'student_id' => $student->student_id,
            'section_id' => $section->section_id,
            'status' => $status,
            'registered_at' => now(),
            'approved_at' => $status === 'approved' ? now() : null,
            'approved_by' => null,
        ]);

        return redirect()->route('student.registration.index')
            ->with('success', $status === 'approved'
                ? 'Registered successfully'
                : 'Your registration is pending approval due to full capacity.'
            );
    }

    public function update(Request $request, Registration $registration)
    {
        $student = auth()->user()->student;
        $newSection = CourseSection::findOrFail($request->new_section_id);
        
        abort_if($registration->student_id !== $student->student_id, 403);

        if ($registration->section->course_id !== $newSection->course_id) {
            return back()->with('error', 'You can only switch sections for the same course.');
        }

        $currentCount = Registration::where('section_id', $newSection->section_id)
            ->whereIn('status', ['pending','approved'])->count();

        if ($currentCount >= $newSection->course->max_students) {
            return back()->with('error', 'The new section is full.');
        }

        $registration->update(['section_id' => $newSection->section_id]);
        return back()->with('success', 'Section switched successfully.');
    }

    public function drop(Registration $registration)
    {
        $student = auth()->user()->student;
        abort_if($registration->student_id !== $student->student_id, 403);

        $registration->delete();
        return back()->with('success', 'Course registration cancelled.');
    }

    public function academicRecord()
    {
        $student = auth()->user()->student;

        $records = Registration::with(['section.course', 'section.semester'])
            ->where('student_id', $student->student_id)
            ->whereIn('status', ['approved', 'completed'])
            ->get()
            ->sortByDesc(function($reg) {
                return $reg->section->semester->year . $reg->section->semester->session;
            })
            ->groupBy(function($reg) {
                return "Session " . $reg->section->semester->year . " - Semester " . $reg->section->semester->session;
            });

        return view('student.record', compact('student', 'records'));
    }

    public function slip()
    {
        return view('student.registration.slip');
    }
}