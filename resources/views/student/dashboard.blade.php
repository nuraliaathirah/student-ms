@extends('layouts.app')

@section('title', 'Student Dashboard')

@push('styles')
<style>
    .welcome-wrap{
        width: 100%;
        max-width: 980px; 
        margin: 0 auto;
    }

    .welcome-banner {
      background: linear-gradient(135deg, #262d34ff, #2d5782ff);
      color: white;
      border-radius: 15px;
      padding: 30px;
      margin-bottom: 30px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap:16px;
    }

    .welcome-banner h4 {
        margin: 0;
        color: #fff;
        font-weight: 700;
        letter-spacing: .5px;
        font-size: 1.25rem;
        line-height: 1.3;
    }

    .welcome-banner .small-muted {
        opacity: .85;
        font-size: .9rem;
        line-height: 1.4;
    }

    .welcome-banner p {
        font-size: 0.85rem;
    }

    .welcome-text small {
        display: block;
        margin-bottom: 6px;
        font-size: 0.75rem;
        opacity: 0.9;
    }

    .welcome-text h2 {
        margin-bottom: 8px;
        line-height: 1.3;
    }

    .welcome-text p {
        margin-bottom: 0;
        font-size: 0.85rem;
        opacity: 0.9;
    }

    .course-card {
      background: linear-gradient(to right, #e3f2fd, #bbdefb);
      border-radius: 15px;
      padding: 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      transition: transform 0.2s;
      font-size: 0.85rem;
    }
    .course-card:hover { transform: translateY(-5px); }

    .notice-box {
      background: white;
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      margin-bottom: 20px;
      font-size: 0.85rem;
    }
    .notice-title {
      font-weight: bold;
      color: #6200ea;
      font-size: 0.9rem;
    }

    .btn-primary {
      background-color: #7c4dff;
      border: none;
      border-radius: 20px;
      padding: 6px 16px;
      font-weight: bold;
      font-size: 0.75rem;
    }
    .btn-primary:hover { background-color: #6200ea; }


</style>
@endpush

@section('content')
  <!-- Main Content -->
   <div class="welcome-wrap">
        <div class="welcome-banner">
      <div>
        <h4 class="mb-1">Welcome back, {{ auth()->user()->name }}!</h4>

        <div class="small-muted mb-2">
           Date: <strong>{{ now()->format('F d, Y') }}</strong>
        </div>

        <div class="small-muted">
           Always stay updated in your student portal
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5>Enrolled Courses</h5>
          <a href="#" class="text-decoration-none">See all <i class="fas fa-arrow-right ms-1"></i></a>
        </div>

        <div class="notice-box">
          <div class="notice-title">No enrolled courses yet</div>
          <p class="mb-2">Your enrolled courses will appear here once you register for a section.</p>
          <a href="{{ route('student.registration.index') }}" class="text-decoration-none">Go to Registration <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5>Daily Notice</h5>
          <a href="#" class="text-decoration-none">See all <i class="fas fa-arrow-right ms-1"></i></a>
        </div>

        <div class="notice-box">
          <div class="notice-title">No notices</div>
          <p class="mb-2">Announcements and notifications will be shown here.</p>
        </div>
      </div>
    </div>
</div>

@endsection
