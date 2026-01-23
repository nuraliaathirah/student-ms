<?php

use App\Http\Controllers\Student\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\CourseRegistrationController;
use App\Http\Controllers\Student\CourseController;
use App\Http\Controllers\Student\StudentRecordController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\Lecturer\ProfileController as LecturerProfileController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/redirect', function () {
    $role = auth()->user()->role;

    if ($role === 'student') {
        return redirect('/student/dashboard');
    } elseif ($role === 'lecturer') {
        return redirect('/lecturer/dashboard');
    } elseif ($role === 'admin') {
        return redirect('/admin/dashboard');
    }

    abort(403);
})->middleware('auth')->name('redirect');

Route::view('/student/dashboard', 'student.dashboard')
    ->middleware('auth', 'role:student')->name('student.dashboard');

Route::view('/lecturer/dashboard', 'lecturer.dashboard')
    ->middleware('auth', 'role:lecturer')->name('lecturer.dashboard');

Route::view('/admin/dashboard', 'admin.dashboard')
    ->middleware('auth', 'role:admin')->name('admin.dashboard');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/record', [\App\Http\Controllers\Student\StudentRecordController::class, 'academicRecord'])->name('record');
});

Route::middleware(['auth', 'student.profile.complete'])
    ->prefix('student')->name('student.')->group(function () {

    Route::get('/registration', [\App\Http\Controllers\Student\CourseRegistrationController::class, 'index'])
        ->name('registration.index');

    Route::post('/registration/add', [\App\Http\Controllers\Student\CourseRegistrationController::class, 'store'])
        ->name('registration.store');

    Route::delete('/registration/{registration}/drop', [\App\Http\Controllers\Student\CourseRegistrationController::class, 'drop'])
        ->name('registration.drop');

    Route::get('/registration/slip', [\App\Http\Controllers\Student\CourseRegistrationController::class, 'slip'])
        ->name('registration.slip');
});

Route::middleware(['auth', 'role:lecturer'])->prefix('lecturer')->name('lecturer.')->group(function () {
    Route::get('/dashboard', [LecturerController::class, 'dashboard'])->name('dashboard');
    Route::get('/section/{section_id}/students', [LecturerController::class, 'showStudentList'])->name('section.students');

    Route::get('/profile', [LecturerProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [LecturerProfileController::class, 'update'])->name('profile.update');
});





require __DIR__.'/auth.php';
