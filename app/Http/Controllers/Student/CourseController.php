<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Registration;
use App\Models\Semester;

class CourseController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $student = $user->student;

        if (!$student) {
            return redirect()
                ->route('student.profile.edit')
                ->with('error', 'Please complete your student profile first.');
        }

        // =========================
        // ALL COURSES (any programme)
        // =========================
        $allCourses = Course::orderBy('course_id')->get();

        // =========================
        // Student course history
        // =========================
        $courseHistory = Registration::with([
                'section.course',
                'section.semester'
            ])
            ->where('student_id', $student->student_id)
            ->orderBy('registered_at', 'desc')
            ->get()
            ->groupBy('section.semester.semester_id');

        return view('student.courses.index', compact(
            'student',
            'allCourses',
            'courseHistory'
        ));
    }
}
