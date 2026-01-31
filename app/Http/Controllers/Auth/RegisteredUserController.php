<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                    'password' => [
                        'required', 
                        'confirmed',  // ✅ This ensures password_confirmation field matches
                        Rules\Password::defaults()
                            ->min(8)              // Minimum 8 characters
                            ->letters()           // Must contain letters
                            ->mixedCase()         // Must contain both upper and lower case
                            ->numbers()           // Must contain numbers
                            ->symbols()           // Must contain symbols
                            ->uncompromised(),    // Must not be in data breaches
                    ],
                    'role' => ['required', 'string', 'in:student,lecturer'],
                ], [
                    'password.confirmed' => 'The password confirmation does not match.',
                    'password.min' => 'Password must be at least 8 characters.',
                    'password.mixed_case' => 'Password must contain both uppercase and lowercase letters.',
                    'password.numbers' => 'Password must contain at least one number.',
                    'password.symbols' => 'Password must contain at least one symbol.',
                ]);    

                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password), // Password hashing
                    'role' => $request->role,
                    'status' => 'pending', // Changed to pending until email verified
                ]);

                // Create student profile if role is student
                if ($user->role === 'student') {
                    Student::create([
                        'student_id' => 'S' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                        'user_id' => $user->id,
                        'name' => $user->name,
                    ]);
                }

                // ✅ FUNCTION b) Trigger email verification
                event(new Registered($user));

                // Don't log in user yet - they need to verify email first
                // Auth::login($user); // Commented out - user must verify email

                // Redirect to email verification notice
                return redirect()->route('verification.notice')
                    ->with('success', 'Registration successful! Please check your email to verify your account.');
    }
}
    

