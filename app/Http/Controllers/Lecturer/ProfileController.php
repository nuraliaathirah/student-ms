<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lecturer;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display the lecturer's profile form.
     */
    public function edit()
    {
        $user = auth()->user();

        if ($user->role !== 'lecturer') {
            abort(403);
        }

        
        $expectedId = 'L' . str_pad((string) $user->id, 3, '0', STR_PAD_LEFT);

        
        $lecturer = Lecturer::where('user_id', $user->id)
                            ->orWhere('lecturer_id', $expectedId)
                            ->first();

        
        if (!$lecturer) {
            $lecturer = Lecturer::create([
                'lecturer_id' => $expectedId,
                'user_id'     => $user->id,
                'name'        => $user->name,
                'staff_no'    => null, 
                'department'  => null,
            ]);
        }

        return view('lecturer.profile.edit', compact('lecturer', 'user'));
    }

    /**
     * Update the lecturer's profile information.
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        $lecturer = $user->lecturer;

        // Validation
        $request->validate([
            // 'nullable' allows them to save other info without filling this yet
            'staff_no'   => ['nullable', 'string', 'max:20', 'unique:lecturer,staff_no,' . $lecturer->lecturer_id . ',lecturer_id'],
            'department' => ['required', 'string', 'max:100'],
            'phone_no'   => ['nullable', 'string', 'max:20'],
        ]);

        // Update Database
        $lecturer->update([
            'staff_no'   => $request->staff_no,
            'department' => $request->department,
            'phone_no'   => $request->phone_no ?? $lecturer->phone_no, // Update if provided
        ]);

        return redirect()->route('lecturer.dashboard')->with('success', 'Profile updated successfully!');
    }
}