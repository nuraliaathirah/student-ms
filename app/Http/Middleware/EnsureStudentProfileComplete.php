<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureStudentProfileComplete
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        // Only for student
        if ($user && $user->role === 'student') {
            $student = $user->student;

            $incomplete = !$student
                || empty($student->matric_no)
                || empty($student->program_code)
                || empty($student->intake_year);

            if ($incomplete && !$request->routeIs('student.profile.*')) {
                return redirect()->route('student.profile.edit')
                    ->with('warning', 'Please complete your profile first.');
            }
        }

        return $next($request);
    }
}
