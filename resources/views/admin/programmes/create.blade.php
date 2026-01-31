@extends('layouts.app')

@section('title', 'Add New Programme')

@push('styles')
<style>
    /* Card Styling */
    .custom-card-radius {
        border-radius: 20px !important;
        overflow: hidden;
        border: none;
    }

    /* Input Styling */
    .form-control {
        border-radius: 12px;
        padding: 12px;
        border: 1px solid #e0e0e0;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(211, 47, 47, 0.1);
        border-color: #d32f2f;
    }

    /* Primary Button (Save) */
    .btn-pill {
        border-radius: 50px !important;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-save {
        background-color: #d32f2f;
        border: none;
        color: white;
    }

    .btn-save:hover {
        background-color: #b71c1c;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(211, 47, 47, 0.3);
        color: white;
    }

    /* Enhanced Cancel Button Visibility */
    .btn-cancel {
        background-color: #f8f9fa;
        border: 2px solid #dee2e6; /* Clear, visible border */
        color: #495057;
    }

    .btn-cancel:hover {
        background-color: #e9ecef;
        border-color: #adb5bd;
        color: #212529;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    /* Required Asterisk Style */
    .text-danger-asterisk {
        color: #d32f2f;
        margin-left: 2px;
    }
</style>
@endpush

@section('content')
<div class="container py-4" style="max-width: 800px;">
    <div class="card shadow-sm custom-card-radius">
        {{-- Header stays left-aligned as requested --}}
        <div class="card-header bg-white py-4 border-0">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-graduation-cap me-2 text-danger"></i>Add New Programme
            </h5>
        </div>

        <div class="card-body p-4 pt-0">
            <form action="{{ route('admin.programmes.store') }}" method="POST">
                @csrf
                
                <div class="row g-4">
                    {{-- Programme Code --}}
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Programme Code<span class="text-danger-asterisk">*</span></label>
                        <input type="text" name="program_code" 
                               class="form-control @error('program_code') is-invalid @enderror" 
                               placeholder="e.g. SECPH" value="{{ old('program_code') }}" required>
                        @error('program_code') 
                            <div class="invalid-feedback">{{ $message }}</div> 
                        @enderror
                    </div>

                    {{-- Programme Name --}}
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Programme Name<span class="text-danger-asterisk">*</span></label>
                        <input type="text" name="program_name" 
                               class="form-control @error('program_name') is-invalid @enderror" 
                               placeholder="e.g. Data Engineering" value="{{ old('program_name') }}" required>
                        @error('program_name') 
                            <div class="invalid-feedback">{{ $message }}</div> 
                        @enderror
                    </div>

                    {{-- Faculty --}}
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Faculty<span class="text-danger-asterisk">*</span></label>
                        <input type="text" name="faculty" 
                               class="form-control @error('faculty') is-invalid @enderror" 
                               placeholder="e.g. Faculty of Science" value="{{ old('faculty') }}" required>
                        @error('faculty') 
                            <div class="invalid-feedback">{{ $message }}</div> 
                        @enderror
                    </div>
                </div>

                {{-- Centered Button Group --}}
                <div class="mt-5 d-flex justify-content-center gap-3">
                    <button type="submit" class="btn btn-save btn-pill px-5 py-2 shadow-sm">
                        <i class="fas fa-save me-2"></i> Save
                    </button>
                    
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-cancel btn-pill px-5 py-2 shadow-sm">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection