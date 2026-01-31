<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Registration;
use App\Models\Semester;
use App\Models\Programme;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
// Import the notification class
use App\Notifications\RegistrationStatusNotification;

class AdminController extends Controller
{
    // (e) Dashboard
    public function dashboard()
    {
        $today = now();
        
        // Find current semester based on date range
        $currentSemester = Semester::whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->first();
        
        // If no active semester, get the most recent one
        if (!$currentSemester) {
            $currentSemester = Semester::orderBy('start_date', 'desc')->first();
        }

        $totalStudents = User::where('role', 'student')->count();
        $totalLecturers = User::where('role', 'lecturer')->count();
        $totalCourses = Course::count();
        $totalProgrammes = Programme::count();
        
        // Fetch Pending Registrations for Requirement (d)
        $pendingRegistrations = Registration::with(['student.user', 'section.course'])
            ->where('status', 'pending')
            ->orderBy('registered_at', 'desc')
            ->limit(10)
            ->get();

        // Recent registrations (last 7 days)
        $recentRegistrations = Registration::where('registered_at', '>=', now()->subDays(7))
            ->count();

        return view('admin.dashboard', compact(
            'totalStudents', 
            'totalLecturers', 
            'totalCourses', 
            'totalProgrammes',
            'pendingRegistrations', 
            'currentSemester',
            'recentRegistrations'
        ));
    }

    // =========================================================
    // COURSE MANAGEMENT (a, b, c)
    // =========================================================

    public function coursesIndex()
    {
        $courses = Course::with('programme')->orderBy('course_id')->paginate(15);
        return view('admin.courses.index', compact('courses'));
    }

    // (a) Add new course details
    public function courseCreate()
    {
        $programmes = Programme::orderBy('program_name')->get();
        return view('admin.courses.create', compact('programmes'));
    }

    public function courseStore(Request $request)
    {
        $request->validate([
            'course_id' => 'required|unique:course,course_id|max:20',
            'course_name' => 'required|string|max:100',
            'credit_hours' => 'required|integer|min:1|max:6',
            'max_students' => 'required|integer|min:1', 
            'program_code' => 'required|exists:programme,program_code'
        ]);

        Course::create($request->all());

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully!');
    }

    // (b) Modify course details
    public function courseEdit($id)
    {
        $course = Course::findOrFail($id);
        $programmes = Programme::orderBy('program_name')->get();
        return view('admin.courses.edit', compact('course', 'programmes'));
    }

    public function courseUpdate(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $request->validate([
            'course_name' => 'required|string|max:100',
            'credit_hours' => 'required|integer|min:1|max:6',
            'max_students' => 'required|integer|min:1',
            'program_code' => 'required|exists:programme,program_code'
        ]);

        $course->update($request->all());

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully!');
    }

    // (c) Delete course
    public function courseDestroy($id)
    {
        $course = Course::findOrFail($id);
        
        if($course->sections && $course->sections->count() > 0) {
            return back()->withErrors(['error' => 'Cannot delete course because it has active sections.']);
        }

        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully!');
    }

    // =========================================================
    // REGISTRATION MANAGEMENT (d)
    // =========================================================

    // (d) Amend: Approve
    public function approveRegistration($id)
    {
        $reg = Registration::with('student.user', 'section.course')->findOrFail($id);
        
        $reg->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now()
        ]);

        // Send Email Notification to Student
        if ($reg->student && $reg->student->user) {
            $reg->student->user->notify(new RegistrationStatusNotification($reg));
        }

        return back()->with('success', 'Registration approved and student notified.');
    }

    // (d) Amend: Reject/Cancel
    public function rejectRegistration($id)
    {
        $reg = Registration::with('student.user', 'section.course')->findOrFail($id);
        
        $reg->update(['status' => 'cancelled']);

        // Notify Student of Cancellation
        if ($reg->student && $reg->student->user) {
            $reg->student->user->notify(new RegistrationStatusNotification($reg));
        }

        return back()->with('success', 'Registration cancelled and student notified.');
    }

    // (d) Delete Registration entirely
    public function deleteRegistration($id)
    {
        $reg = Registration::findOrFail($id);
        $reg->delete();

        return back()->with('success', 'Registration record deleted successfully.');
    }

    // =========================================================
    // PROGRAMME MANAGEMENT
    // =========================================================

    public function programmeCreate()
    {
        return view('admin.programmes.create');
    }

    public function programmeStore(Request $request)
    {
        $request->validate([
            'program_code' => 'required|unique:programme,program_code|max:20',
            'program_name' => 'required|string|max:100',
            'faculty'      => 'required|string|max:100',
        ]);

        Programme::create([
            'program_code' => $request->program_code,
            'program_name' => $request->program_name,
            'faculty'      => $request->faculty,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Programme added successfully!');
    }
}