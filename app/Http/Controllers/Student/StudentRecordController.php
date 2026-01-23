<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Registration;
use App\Models\Course;
use App\Models\Section;
use App\Models\Semester; // Ensure you have this model

class StudentRecordController extends Controller
{
    /**
     * Show the Student Dashboard.
     */
    public function dashboard()
    {
        $student = Auth::user();
        
        // Example: Get active registrations for the current semester
        // You can customize the 'current' semester logic as needed
        $activeRegistrations = Registration::with('section.course')
            ->where('student_id', $student->id)
            ->where('status', 'approved')
            ->get();

        return view('student.dashboard', compact('student', 'activeRegistrations'));
    }

    /**
     * Show the Course Registration Page (Index).
     */
    public function registrationIndex(Request $request)
    {
        $student = Auth::user();
        
        // 1. Get Current Semester (You might have a setting or table for this)
        // For now, I'll grab the latest one or hardcode a dummy
        $currentSemester = Semester::orderBy('year', 'desc')->orderBy('session', 'desc')->first(); 

        // 2. Get Sections offered in this semester
        $offeredSections = Section::with(['course', 'lecturer'])
            ->where('semester_id', $currentSemester->id ?? 1) // Fallback to ID 1 if null
            ->get();

        // 3. Get Student's existing registrations for this semester
        $registrations = Registration::with('section.course')
            ->where('student_id', $student->id)
            // Optional: Filter by current semester if your table supports it
            ->get();

        // Arrays for button logic (to disable already registered courses)
        $registeredSectionIds = $registrations->pluck('section_id')->toArray();
        $registeredCourseIds = $registrations->pluck('section.course.course_id')->toArray();

        return view('student.registration.index', compact(
            'student', 
            'currentSemester', 
            'offeredSections', 
            'registrations', 
            'registeredSectionIds', 
            'registeredCourseIds'
        ));
    }

    /**
     * Show All Courses (Searchable).
     */
    public function coursesIndex()
    {
        $student = Auth::user();
        $allCourses = Course::orderBy('course_name')->get();

        return view('student.courses.index', compact('student', 'allCourses'));
    }

    /**
     * Show Academic Record (Previous Semesters & Results).
     */
    public function academicRecord()
    {
        $student = Auth::user();

        // 1. Fetch all 'approved' or 'completed' registrations
        // We load 'course' and 'semester' to display names and group them
        $allRecords = Registration::with(['course', 'semester', 'section'])
            ->where('student_id', $student->id)
            ->whereIn('status', ['approved', 'completed', 'graded']) // Add your specific statuses
            ->get();

        // 2. Calculate CGPA dynamically (Simple 4.0 scale logic)
        $totalPoints = 0;
        $totalCredits = 0;

        foreach ($allRecords as $reg) {
            // Assuming 'grade' column exists (e.g., 'A', 'B+', 'C')
            // You can replace this with your own grading system logic
            $grade = strtoupper($reg->grade ?? 'N/A');
            $credit = $reg->course->credit_hours ?? 3;
            $point = 0;

            // Basic Point System
            if ($grade === 'A' || $grade === 'A+') $point = 4.0;
            elseif ($grade === 'A-') $point = 3.7;
            elseif ($grade === 'B+') $point = 3.3;
            elseif ($grade === 'B')  $point = 3.0;
            elseif ($grade === 'B-') $point = 2.7;
            elseif ($grade === 'C+') $point = 2.3;
            elseif ($grade === 'C')  $point = 2.0;
            elseif ($grade === 'D')  $point = 1.0;
            elseif ($grade === 'F')  $point = 0.0;
            else continue; // Skip ungraded/pass-fail courses for CGPA

            $totalPoints += ($point * $credit);
            $totalCredits += $credit;
        }

        $cgpa = $totalCredits > 0 ? round($totalPoints / $totalCredits, 2) : 0.00;

        // 3. Inject CGPA into student object (temporary for view)
        $student->cgpa = $cgpa;

        // 4. Group records by Semester Name for the Accordion UI
        // We sort by semester ID descending so the latest semester appears first
        $records = $allRecords->sortByDesc(function ($reg) {
            return $reg->section->semester->semester_id ?? 0;
        })->groupBy(function ($reg) {
            // Create a label like "2025/2026 - Semester 1"
            $sem = $reg->section->semester;
            return $sem ? ($sem->year . ' - Sem ' . $sem->session) : 'Unknown';
        });

        return view('student.record', compact('student', 'records'));
    }
}