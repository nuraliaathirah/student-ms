@extends('layouts.app')

@section('title','Complete Profile')

@push('styles')
<style>
    body { font-size: .85rem; }

    /* Container & Wrapper */
    .profile-wrapper {
        min-height: calc(100vh - 80px);
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding-top: 60px;
    }
    .profile-wrapper .container { max-width: 620px !important; }

    /* Card - INCREASED RADIUS */
    .profile-wrapper .card {
        width: 100%;
        border-radius: 20px !important; /* Matches lecturer style */
        border: 1px solid rgba(0,0,0,.1);
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .card-header {
        padding: .65rem .9rem;
        font-size: .95rem;
        background-color: #fff !important;
        font-weight: 600;
        border-bottom: 1px solid rgba(0,0,0,.05);
    }

    .card-body {
        padding: 1.5rem; /* Increased for better breathing room */
    }

    /* Form Elements */
    .form-label {
        font-size: .8rem;
        margin-bottom: .25rem;
        font-weight: 500;
    }

    /* Inputs - ROUNDED */
    .form-control {
        font-size: .85rem;
        padding: .45rem .65rem;
        border-radius: 10px;
    }

    .text-muted {
        font-size: .75rem;
    }

    .mb-3 {
        margin-bottom: 1rem !important;
    }

    /* Buttons - SMALLER & PILL RADIUS */
    .btn-dark {
        font-size: .75rem;     /* Smaller font */
        padding: .35rem .85rem; /* Reduced padding for smaller look */
        border-radius: 50px;   /* Pill-shaped radius */
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-dark:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    /* Alerts */
    .alert {
        font-size: .8rem;
        padding: .5rem .75rem;
        border-radius: 12px;
    }
</style>
@endpush

@section('content')
<div class="profile-wrapper">
<div class="container">
  <div class="card shadow-sm">
    <div class="card-header bg-white">
        <i class="fas fa-user-graduate me-2"></i>Complete Student Profile
    </div>
    <div class="card-body">

      @if(session('success'))
        <div class="alert alert-success mb-3">{{ session('success') }}</div>
      @endif
      @if($errors->any())
        <div class="alert alert-danger mb-3">{{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ route('student.profile.update') }}">
        @csrf
        @method('PATCH')

        <div class="mb-3">
          <label class="form-label">Full Name</label>
          <input class="form-control bg-light" value="{{ $student->name ?? auth()->user()->name }}" disabled>
          <small class="text-muted">Registered Name.</small>
        </div>

        <div class="mb-3">
          <label class="form-label">Matric No</label>
          <input name="matric_no" class="form-control" value="{{ old('matric_no', $student->matric_no ?? '') }}" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Program</label>
          <input name="program_code" class="form-control" value="{{ old('program_code', $student->program_code) }}" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Intake Year</label>
          <input name="intake_year" type="number" class="form-control" value="{{ old('intake_year', $student->intake_year) }}" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Phone No</label>
          <input name="phone_no" class="form-control" value="{{ old('phone_no', $student->phone_no) }}">
        </div>

        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-dark px-4">Save</button>
        </div>
      </form>
    </div>
    </div>
  </div>
</div>
@endsection