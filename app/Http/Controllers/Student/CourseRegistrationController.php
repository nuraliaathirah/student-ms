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
            return redirect()
                ->route('student.profile.edit')
                ->with('error', 'Please complete your student profile first.');
        }

        if (!$student->program_code) {
            return redirect()
                ->route('student.profile.edit')
                ->with('error', 'Please select your programme before course registration.');
        }
        $programCode = $student->program_code;

        // Current semester (simple: latest)
        $currentSemester = Semester::orderBy('start_date', 'desc')->first();
        if (!$currentSemester) {
            return redirect()
                ->route('student.dashboard')
                ->with('error', 'No active semester found.');
        }

        $previousSemesters = Semester::where(function ($q) use ($currentSemester) {
                $q->where('year', '<', $currentSemester->year)
                ->orWhere(function ($q2) use ($currentSemester) {
                    $q2->where('year', $currentSemester->year)
                        ->where('session', '<', $currentSemester->session);
                });
            })
            ->orderBy('year', 'desc')
            ->orderBy('session', 'desc')
            ->get();

        $registeredSectionIds = Registration::where('student_id', $student->student_id)
            ->whereHas('section', fn($s) => $s->where('semester_id', $currentSemester->semester_id))
            ->whereIn('status', ['pending', 'approved'])
            ->pluck('section_id')
            ->toArray();

        $registeredCourseIds = Registration::where('student_id', $student->student_id)
            ->whereHas('section', fn($s) => $s->where('semester_id', $currentSemester->semester_id))
            ->whereIn('status', ['pending', 'approved'])
            ->join('course_section', 'registration.section_id', '=', 'course_section.section_id')
            ->pluck('course_section.course_id')
            ->toArray();

        // Offered sections for current semester
        $sectionsQuery = CourseSection::with(['course', 'lecturer'])
            ->where('semester_id', $currentSemester->semester_id)
            ->whereHas('course', function ($q) use ($programCode) {
                $q->where('program_code', $programCode);
            })
            ->withCount([
                'registrations' => function($query) {
                    $query->whereIn('status', ['pending', 'approved']);
                }
            ]);


        // Search (course code / name)
        if ($request->filled('q')) {
            $q = $request->q;
            $sectionsQuery->whereHas('course', function ($sub) use ($q) {
                $sub->where('course_id', 'like', "%{$q}%")
                    ->orWhere('course_name', 'like', "%{$q}%");
            });
        }

        $offeredSections = $sectionsQuery
            ->orderBy('section_id')
            ->get();

        // Current registrations (student)
        $registrations = Registration::with(['section.course', 'section.lecturer'])
            ->where('student_id', $student->student_id)
            ->whereHas('section', fn($s) => $s->where('semester_id', $currentSemester->semester_id))
            ->whereIn('status', ['pending', 'approved'])
            ->orderBy('registered_at', 'desc')
            ->get();

        $previousRegistrations = Registration::with([
                'section.course',
                'section.semester'
            ])
            ->where('student_id', $student->student_id)
            ->whereHas('section', function ($q) use ($previousSemesters) {
                $q->whereIn(
                    'semester_id',
                    $previousSemesters->pluck('semester_id')
                );
            })
            ->whereIn('status', ['approved', 'cancelled'])
            ->orderBy('registered_at', 'desc')
            ->get()
            ->groupBy('section.semester.semester_id');

        return view('student.registration.index', compact(
            'student', 'currentSemester', 'offeredSections', 'registrations', 'registeredSectionIds', 'registeredCourseIds',
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

        $currentSemester = Semester::orderBy('start_date', 'desc')->first();

        $existingCourseRegistration = Registration::where('student_id', $student->student_id)
            ->whereHas('section', function($q) use ($section, $currentSemester) {
                $q->where('course_id', $section->course_id)
                  ->where('semester_id', $currentSemester->semester_id);
            })
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($existingCourseRegistration) {
            return back()->withErrors(['section_id' => 'You already registered for this course in a different section.']);
        }

        // prevent duplicate register same section
        $exists = Registration::where('student_id', $student->student_id)
            ->where('section_id', $section->section_id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();
        if ($exists) {
            return back()->withErrors(['section_id' => 'You already registered this section.']);
        }

        // capacity check (auto approve if not full)
        $currentCount = Registration::where('section_id', $section->section_id)
            ->whereIn('status', ['pending','approved'])
            ->count();

        $status = ($currentCount < $section->course->max_students) ? 'approved' : 'pending';

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

    public function drop(Registration $registration)
    {
        $student = auth()->user()->student;

        abort_if($registration->student_id !== $student->student_id, 403);

        $registration->delete();

        return back()->with('success', 'Course registration cancelled.');
    }

    public function slip()
    {
        // later: generate slip (PDF/HTML)
        return view('student.registration.slip');
    }
}
