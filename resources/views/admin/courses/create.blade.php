@extends('layouts.app')

@section('title', 'Add New Course')

@push('styles')
<style>
    .page-wrap {
        width: 100%;
        max-width: 800px;
        margin: 0 auto;
    }

    .page-header {
        background: linear-gradient(135deg, #d32f2f, #f44336);
        color: white;
        border-radius: 15px;
        padding: 25px 30px;
        margin-bottom: 30px;
    }

    .page-header h4 {
        margin: 0;
        font-weight: 700;
        font-size: 1.25rem;
    }

    .form-card {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
        font-size: 0.85rem;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #dee2e6;
        padding: 10px 15px;
        font-size: 0.85rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #d32f2f;
        box-shadow: 0 0 0 0.2rem rgba(211, 47, 47, 0.1);
    }

    .invalid-feedback {
        font-size: 0.75rem;
    }

    .btn-submit {
        background: #4caf50;
        color: white;
        border: none;
        padding: 10px 30px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: background 0.2s;
    }

    .btn-submit:hover {
        background: #45a049;
        color: white;
    }

    .btn-cancel {
        background: #f5f5f5;
        color: #666;
        border: 1px solid #ddd;
        padding: 10px 30px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        display: inline-block;
        transition: all 0.2s;
    }

    .btn-cancel:hover {
        background: #e0e0e0;
        color: #333;
    }

    .required-asterisk {
        color: #d32f2f;
    }

    .form-help-text {
        font-size: 0.75rem;
        color: #6c757d;
        margin-top: 4px;
    }
</style>
@endpush

@section('content')
<div class="page-wrap">

    {{-- Page Header --}}
    <div class="page-header">
        <h4 class="text-light">Add New Course</h4>
        <small class="opacity-75">Create a new course with details and maximum student capacity</small>
    </div>

    {{-- Form Card --}}
    <div class="form-card">
        <form action="{{ route('admin.courses.store') }}" method="POST">
            @csrf

            {{-- Course ID --}}
            <div class="mb-3">
                <label for="course_id" class="form-label">
                    Course Code <span class="required-asterisk">*</span>
                </label>
                <input type="text" 
                       class="form-control @error('course_id') is-invalid @enderror" 
                       id="course_id" 
                       name="course_id" 
                       value="{{ old('course_id') }}"
                       placeholder="e.g., SECP2304"
                       required>
                <div class="form-help-text">Enter course code.</div>
                @error('course_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Course Name --}}
            <div class="mb-3">
                <label for="course_name" class="form-label">
                    Course Name <span class="required-asterisk">*</span>
                </label>
                <input type="text" 
                       class="form-control @error('course_name') is-invalid @enderror" 
                       id="course_name" 
                       name="course_name" 
                       value="{{ old('course_name') }}"
                       placeholder="e.g., Introduction to Computer Science"
                       required>
                @error('course_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Programme --}}
            <div class="mb-3">
                <label for="program_code" class="form-label">
                    Programme <span class="required-asterisk">*</span>
                </label>
                <select class="form-select @error('program_code') is-invalid @enderror" 
                        id="program_code" 
                        name="program_code"
                        required>
                    <option value="">Select Programme</option>
                    @foreach($programmes as $programme)
                        <option value="{{ $programme->program_code }}" 
                                {{ old('program_code') == $programme->program_code ? 'selected' : '' }}>
                            {{ $programme->program_name }} ({{ $programme->program_code }})
                        </option>
                    @endforeach
                </select>
                @error('program_code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                {{-- Credit Hours --}}
                <div class="col-md-6 mb-3">
                    <label for="credit_hours" class="form-label">
                        Credit Hours <span class="required-asterisk">*</span>
                    </label>
                    <input type="number" 
                           class="form-control @error('credit_hours') is-invalid @enderror" 
                           id="credit_hours" 
                           name="credit_hours" 
                           value="{{ old('credit_hours') }}"
                           min="1"
                           max="6"
                           placeholder="e.g., 3"
                           required>
                    <div class="form-help-text">Value between 1 and 6</div>
                    @error('credit_hours')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Max Students --}}
                <div class="col-md-6 mb-3">
                    <label for="max_students" class="form-label">
                        Maximum Students <span class="required-asterisk">*</span>
                    </label>
                    <input type="number" 
                           class="form-control @error('max_students') is-invalid @enderror" 
                           id="max_students" 
                           name="max_students" 
                           value="{{ old('max_students') }}"
                           min="1"
                           placeholder="e.g., 40"
                           required>
                    <div class="form-help-text">Maximum capacity per section</div>
                    @error('max_students')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <a href="{{ route('admin.courses.index') }}" class="btn-cancel">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save me-2"></i>Create Course
                </button>
            </div>
        </form>
    </div>

</div>
@endsection