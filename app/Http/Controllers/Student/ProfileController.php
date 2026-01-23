<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit()
    {
        $user = auth()->user();
        if ($user->role !== 'student') {
            abort(403); 
        }
        $student = $user->student;
        if (!$student) {
            $student = \App\Models\Student::create([
                'student_id' => 'S' . str_pad((string) $user->id, 3, '0', STR_PAD_LEFT),
                'user_id'    => $user->id,
                'name'       => $user->name,   
                'matric_no'  => null,
                'program_code' => null,        
                'intake_year'  => null,
                'phone_no'     => null,
            ]);
        }

        return view('student.profile.edit', compact('student', 'user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        $student = $user->student;

        $data = $request->validate([
            'matric_no' => ['required','string','max:20','unique:student,matric_no,' . $student->student_id . ',student_id'],
            'program_code' => ['required','string','max:100'],
            'intake_year' => ['required','integer','min:2000','max:' . (date('Y') + 1)],
            'phone_no' => ['nullable','string','max:20'],
        ]);

        $student->update([
            'program_code' => $request->program_code,
            'matric_no' => $request->matric_no,
            'intake_year' => $request->intake_year,
            'phone_no' => $request->phone_no,
        ]);

        return redirect()->route('student.dashboard')->with('success', 'Profile updated!');
    }
}

