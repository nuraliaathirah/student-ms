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

    public function showGradeEntry($section_id)
    {
        $user = Auth::user();
        $lecturer = Lecturer::where('user_id', $user->id)->first();

        if (!$lecturer) {
            abort(403, 'Lecturer profile not found.');
        }
        
        // Verify this section belongs to the lecturer
        $section = CourseSection::with(['course', 'semester'])
            ->where('section_id', $section_id)
            ->where('lecturer_id', $lecturer->lecturer_id)
            ->firstOrFail();
        
        // Get students with their current grades
        $students = Registration::with(['student'])
            ->where('section_id', $section_id)
            ->where('status', 'approved')
            ->orderBy('student_id')
            ->get();
        
        return view('lecturer.grade-entry', compact('section', 'students'));
    }

    public function updateGrades(Request $request, $section_id)
    {
        $user = Auth::user();
        $lecturer = Lecturer::where('user_id', $user->id)->first();

        if (!$lecturer) {
            abort(403, 'Lecturer profile not found.');
        }
        
        // Verify this section belongs to the lecturer
        $section = CourseSection::where('section_id', $section_id)
            ->where('lecturer_id', $lecturer->lecturer_id)
            ->firstOrFail();
        
        // Validate grades
        $request->validate([
            'grades' => 'required|array',
            'grades.*' => 'nullable|in:A,A-,B+,B,B-,C+,C,C-,D+,D,F',
        ]);
        
        // Update grades for each student
        $updatedCount = 0;
        foreach ($request->grades as $registrationId => $grade) {
            $updated = Registration::where('registration_id', $registrationId)
                ->where('section_id', $section_id)
                ->update(['grade' => $grade ?: null]); // Set to null if empty
            
            if ($updated) {
                $updatedCount++;
            }
        }
        
        return redirect()
            ->route('lecturer.section.grade-entry', $section_id)
            ->with('success', "Grades updated successfully for {$updatedCount} student(s)!");
    }
}