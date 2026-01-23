<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Lecturer;
use App\Models\Semester;
use App\Models\CourseSection;
use App\Models\Registration;

class LecturerController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        
        // 1. Get the Lecturer Profile linked to this User
        $lecturer = Lecturer::where('user_id', $user->id)->first();

        if (!$lecturer) {
            abort(403, 'Lecturer profile not found.');
        }

        // 2. Determine Semester
        $selectedSemesterId = $request->get('semester_id');
        
        // FIX: Find active semester by DATE instead of 'is_current' column
        $today = now();
        $currentSemester = Semester::whereDate('start_date', '<=', $today)
                            ->whereDate('end_date', '>=', $today)
                            ->first();

        // Fallback: If no semester matches today's date, take the latest one
        if (!$currentSemester) {
            $currentSemester = Semester::orderBy('year', 'desc')
                                ->orderBy('session', 'desc')
                                ->first();
        }

        // If no specific filter, show Current Semester
        $targetSemesterId = $selectedSemesterId ?? $currentSemester->semester_id;

        // 3. Get Assigned Sections for this Lecturer & Semester
        $assignedSections = CourseSection::with('course', 'semester')
            ->where('lecturer_id', $lecturer->lecturer_id)
            ->where('semester_id', $targetSemesterId)
            ->withCount('registrations') // Count students
            ->get();

        // Get all semesters for the dropdown filter
        $semesters = Semester::orderBy('year', 'desc')->orderBy('session', 'desc')->get();

        return view('lecturer.dashboard', compact(
            'lecturer', 
            'assignedSections', 
            'semesters', 
            'targetSemesterId',
            'currentSemester'
        ));
    }

    public function showStudentList($section_id)
    {
        // 1. Fetch Section Details
        $section = CourseSection::with(['course', 'semester', 'lecturer'])
            ->findOrFail($section_id);

        // 2. Fetch Students registered for this section
        $registrations = Registration::with('student.user') // Load Student Profile & User Login Info
            ->where('section_id', $section_id)
            ->where('status', 'approved') // Only show approved students
            ->get();

        return view('lecturer.student-list', compact('section', 'registrations'));
    }
}
