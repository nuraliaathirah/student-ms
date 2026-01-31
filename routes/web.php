<?php

use App\Http\Controllers\Student\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\CourseRegistrationController;
use App\Http\Controllers\Student\CourseController;
use App\Http\Controllers\Student\StudentRecordController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\Lecturer\ProfileController as LecturerProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;

/*
|--------------------------------------------------------------------------
| Web Routes - Enhanced with Security Features
|--------------------------------------------------------------------------
|
| ✅ FUNCTION b) Email verification routes added
| ✅ FUNCTION e) Password change routes added
| ✅ FUNCTION f) Role-based redirects enhanced
| ✅ FUNCTION c) All routes use CSRF protection
|
*/

Route::get('/', function () {
    return view('welcome');
});

// ✅ FUNCTION f) Enhanced redirect with email verification
Route::get('/redirect', function () {
    $user = auth()->user();
    $role = $user->role;

    // ✅ Check email verification
    if (!$user->hasVerifiedEmail()) {
        return redirect()->route('verification.notice');
    }

    // ✅ Check account status
    if ($user->status !== 'active') {
        auth()->logout();
        return redirect()->route('login')->withErrors([
            'email' => 'Your account is not active. Please contact the administrator.',
        ]);
    }

    // Role-based redirect
    return match ($role) {
        'student' => redirect('/student/dashboard'),
        'lecturer' => redirect('/lecturer/dashboard'),
        'admin' => redirect('/admin/dashboard'),
        default => abort(403),
    };
})->middleware('auth')->name('redirect');

// ✅ FUNCTION b) Email Verification Routes
Route::middleware('auth')->group(function () {
    Route::get('verify-email', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', function (Illuminate\Http\Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    })->middleware('throttle:6,1')->name('verification.send');
});

// ✅ FUNCTION e) Password Change Routes (Available to all authenticated users)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('password/change', [PasswordController::class, 'edit'])
        ->name('password.edit');
    Route::put('password/change', [PasswordController::class, 'update'])
        ->name('password.update');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ✅ STUDENT ROUTES - Enhanced with verified middleware
Route::middleware(['auth', 'verified'])->prefix('student')->name('student.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/record', [StudentRecordController::class, 'academicRecord'])->name('record');
});

// ✅ STUDENT ROUTES - Profile Complete Required
Route::middleware(['auth', 'verified', 'student.profile.complete'])
    ->prefix('student')->name('student.')->group(function () {

    // ✅ Dashboard with statistics
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ✅ Course Registration with notifications
    Route::get('/registration', [CourseRegistrationController::class, 'index'])
        ->name('registration.index');

    Route::post('/registration/add', [CourseRegistrationController::class, 'store'])
        ->name('registration.store');

    Route::delete('/registration/{registration}/drop', [CourseRegistrationController::class, 'drop'])
        ->name('registration.drop');

    Route::get('/registration/slip', [CourseRegistrationController::class, 'slip'])
        ->name('registration.slip');

    Route::get('/record', [CourseRegistrationController::class, 'academicRecord'])->name('record');
});

// ✅ LECTURER ROUTES - Enhanced with verified middleware
Route::middleware(['auth', 'verified', 'role:lecturer'])->prefix('lecturer')->name('lecturer.')->group(function () {
    Route::get('/dashboard', [LecturerController::class, 'dashboard'])->name('dashboard');
    Route::get('/section/{section_id}/students', [LecturerController::class, 'showStudentList'])->name('section.students');

    Route::get('/section/{section_id}/grades', [LecturerController::class, 'showGradeEntry'])->name('section.grade-entry');
    Route::post('/section/{section_id}/grades', [LecturerController::class, 'updateGrades'])->name('section.update-grades');

    Route::get('/profile', [LecturerProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [LecturerProfileController::class, 'update'])->name('profile.update');
});

// ✅ ADMIN ROUTES - Enhanced with verified middleware
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Course Management Routes
    Route::get('/courses', [AdminController::class, 'coursesIndex'])->name('courses.index');
    Route::get('/courses/create', [AdminController::class, 'courseCreate'])->name('courses.create');
    Route::post('/courses', [AdminController::class, 'courseStore'])->name('courses.store');
    Route::get('/courses/{id}/edit', [AdminController::class, 'courseEdit'])->name('courses.edit');
    Route::patch('/courses/{id}', [AdminController::class, 'courseUpdate'])->name('courses.update');
    Route::delete('/courses/{id}', [AdminController::class, 'courseDestroy'])->name('courses.destroy');

    // Registration Management Routes
    Route::patch('/registration/{id}/approve', [AdminController::class, 'approveRegistration'])->name('registration.approve');
    Route::patch('/registration/{id}/reject', [AdminController::class, 'rejectRegistration'])->name('registration.reject');
    Route::delete('/registration/{id}', [AdminController::class, 'deleteRegistration'])->name('registration.delete');

    // Programme Management Routes
    Route::get('/programmes/create', [AdminController::class, 'programmeCreate'])->name('programmes.create');
    Route::post('/programmes', [AdminController::class, 'programmeStore'])->name('programmes.store');
});

require __DIR__.'/auth.php';