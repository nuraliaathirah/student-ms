<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Semester;

class DashboardController extends Controller
{
    /**
     * Display the student dashboard
     * 
     * ✅ FUNCTION d) Enhanced UI with statistics
     * ✅ FUNCTION b) Shows notifications
     */
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;
        $notifications = auth()->user()->unreadNotifications;

        // Get current semester
        $currentSemester = Semester::where('is_current', 1)->first() 
                           ?? Semester::orderBy('start_date', 'desc')->first();

        // Get the authenticated student's enrolled courses (current semester only)
        $enrolledCourses = collect([]);
        $totalCredits = 0;
        $pendingCount = 0;

        if ($student && $currentSemester) {
            // Get enrolled courses for current semester
            $enrolledCourses = $user->student->registrations()
                ->with(['section.course', 'section.lecturer']) // Eager load relationships
                ->whereHas('section', function($query) use ($currentSemester) {
                    $query->where('semester_id', $currentSemester->semester_id);
                })
                ->whereIn('status', ['pending', 'approved'])
                ->orderBy('registered_at', 'desc')
                ->get();

            // ✅ Calculate total credits for statistics card
            $totalCredits = $enrolledCourses->sum(function($reg) {
                return $reg->section->course->credit_hours ?? 0;
            });

            // ✅ Count pending registrations for statistics card
            $pendingCount = $enrolledCourses->where('status', 'pending')->count();
        } else {
            // If no student profile, get basic registrations
            $enrolledCourses = $user->registrations()
                ->with(['section.course', 'section.lecturer'])
                ->whereIn('status', ['pending', 'approved'])
                ->orderBy('registered_at', 'desc')
                ->get();

            $totalCredits = $enrolledCourses->sum(function($reg) {
                return $reg->section->course->credit_hours ?? 0;
            });

            $pendingCount = $enrolledCourses->where('status', 'pending')->count();
        }

        return view('student.dashboard', compact(
            'enrolledCourses',
            'totalCredits',
            'pendingCount'
        ));
    }
}