@extends('layouts.app')

@section('title','Complete Profile')

@push('styles')
<style>
    body {
        font-size: .85rem;
    }
    /* Container */
  .container {
    max-width: 620px !important;
  }

  /* Card */
  .card {
    border-radius: 12px;
  }

  .card-header {
    padding: .65rem .9rem;
    font-size: .95rem;
  }

  .card-body {
    padding: .9rem;
  }

  .profile-wrapper {
    min-height: calc(100vh - 80px);
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding-top: 60px; /* 👈 gap from top */
}

/* Container size */
.profile-wrapper .container {
    max-width: 620px !important;
}

/* Card styling */
.profile-wrapper .card {
    width: 100%;
    border-radius: 12px;
}

  /* Labels */
  .form-label {
    font-size: .8rem;
    margin-bottom: .25rem;
  }

  /* Inputs */
  .form-control {
    font-size: .85rem;
    padding: .45rem .65rem;
  }

  /* Small helper text */
  .text-muted {
    font-size: .75rem;
  }

  /* Spacing between fields */
  .mb-3 {
    margin-bottom: .75rem !important;
  }

  /* Button */
  .btn {
    font-size: .8rem;
    padding: .4rem .9rem;
  }

  /* Alerts */
  .alert {
    font-size: .8rem;
    padding: .5rem .75rem;
  }
</style>
@endpush

@section('content')
<div class="profile-wrapper">
<div class="container">
  <div class="card">
    <div class="card-header bg-white fw-semibold">Complete Student Profile</div>
    <div class="card-body">

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ route('student.profile.update') }}">
        @csrf
        @method('PATCH')

        <div class="mb-3">
          <label class="form-label">Full Name</label>
          <input class="form-control" value="{{ $student->name ?? auth()->user()->name }}" disabled>
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

        <button class="btn btn-dark">Save Profile</button>
      </form>
    </div>
    </div>
  </div>
</div>
@endsection
