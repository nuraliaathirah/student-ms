@extends('layouts.app')

@section('title', 'Student Dashboard')

@push('styles')
<style>
    .welcome-wrap {
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
        gap: 16px;
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

    /* ✅ Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: transform 0.2s, box-shadow 0.2s;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    }

    .stat-card .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stat-card.blue .stat-icon {
        background: #e3f2fd;
        color: #1976d2;
    }

    .stat-card.green .stat-icon {
        background: #e8f5e9;
        color: #4caf50;
    }

    .stat-card.orange .stat-icon {
        background: #fff3e0;
        color: #ff9800;
    }

    .stat-card .stat-content h3 {
        margin: 0;
        font-size: 1.75rem;
        font-weight: 700;
        color: #1a1a1a;
    }

    .stat-card .stat-content p {
        margin: 0;
        font-size: 0.8rem;
        color: #919aa1;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* ✅ Quick Actions */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        margin-bottom: 30px;
    }

    .action-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: transform 0.2s, box-shadow 0.2s;
        text-decoration: none;
        color: inherit;
    }

    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        text-decoration: none;
    }

    .action-card .action-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 15px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .action-card.blue .action-icon {
        background: #e3f2fd;
        color: #1976d2;
    }

    .action-card.green .action-icon {
        background: #e8f5e9;
        color: #4caf50;
    }

    .action-card.purple .action-icon {
        background: #f3e5f5;
        color: #9c27b0;
    }

    .action-card.red .action-icon {
        background: #ffebee;
        color: #f44336;
    }

    .action-card h6 {
        margin: 0 0 5px;
        font-size: 0.9rem;
        font-weight: 700;
        color: #1a1a1a;
    }

    .action-card p {
        margin: 0;
        font-size: 0.75rem;
        color: #919aa1;
    }

    .course-card {
        background: linear-gradient(to right, #ffffff, #f8f9fa);
        border: 1px solid #eef2f7;
        border-radius: 15px;
        padding: 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 10px rgba(0,0,0,0.03);
        transition: transform 0.2s, box-shadow 0.2s;
        font-size: 0.85rem;
        margin-bottom: 15px;
    }

    .course-card:hover { 
        transform: translateY(-3px); 
        box-shadow: 0 6px 15px rgba(0,0,0,0.08);
        border-color: #bbdefb;
    }

    .course-icon {
        width: 45px;
        height: 45px;
        background: #e3f2fd;
        color: #1976d2;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-right: 15px;
    }

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

    /* ✅ Notification Item */
    .notification-item {
        background: #e3f2fd;
        border: 1px solid #bbdefb;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 12px;
        display: flex;
        align-items: start;
        gap: 12px;
    }

    .notification-item .notif-icon {
        width: 35px;
        height: 35px;
        background: #1976d2;
        color: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .notification-item .notif-content {
        flex: 1;
    }

    .notification-item .notif-content .notif-text {
        font-size: 0.85rem;
        color: #1a1a1a;
        margin-bottom: 5px;
    }

    .notification-item .notif-content .notif-time {
        font-size: 0.75rem;
        color: #919aa1;
    }

    .badge-status {
        font-size: 0.7rem;
        padding: 5px 10px;
        border-radius: 50px;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        .quick-actions {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endpush

@section('content')
<div class="welcome-wrap">
    {{-- Banner --}}
    <div class="welcome-banner">
        <div>
            <h4 class="mb-1">Welcome back, {{ auth()->user()->name }}! 👋</h4>
            <div class="small-muted mb-2">
                @if(auth()->user()->student)
                    Student ID: <strong>{{ auth()->user()->student->student_id }}</strong>
                @endif
            </div>
            <div class="small-muted">
                Date: <strong>{{ now()->format('F d, Y') }}</strong> • Always stay updated in your student portal
            </div>
        </div>
        <div class="d-none d-md-block">
            <i class="fas fa-user-graduate fa-3x opacity-25"></i>
        </div>
    </div>

    {{-- ✅ FUNCTION d) Statistics Cards --}}
    <div class="stats-grid">
        {{-- Registered Courses --}}
        <div class="stat-card blue">
            <div class="stat-content">
                <p>Registered Courses</p>
                <h3>{{ $enrolledCourses->count() }}</h3>
            </div>
            <div class="stat-icon">
                <i class="fas fa-book"></i>
            </div>
        </div>

        {{-- Total Credits --}}
        <div class="stat-card green">
            <div class="stat-content">
                <p>Total Credits</p>
                <h3>{{ $totalCredits }}<span style="font-size: 1rem; color: #919aa1;">/20</span></h3>
            </div>
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>

        {{-- Pending Approvals --}}
        <div class="stat-card orange">
            <div class="stat-content">
                <p>Pending Approvals</p>
                <h3>{{ $pendingCount }}</h3>
            </div>
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>

    {{-- ✅ FUNCTION d) Quick Actions --}}
    <div class="quick-actions">
        <a href="{{ route('student.registration.index') }}" class="action-card blue">
            <div class="action-icon">
                <i class="fas fa-plus"></i>
            </div>
            <h6>Register Courses</h6>
            <p>Add new courses</p>
        </a>

        <a href="{{ route('student.record') }}" class="action-card green">
            <div class="action-icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <h6>Academic Record</h6>
            <p>View your grades</p>
        </a>

        <a href="{{ route('student.profile.edit') }}" class="action-card purple">
            <div class="action-icon">
                <i class="fas fa-user"></i>
            </div>
            <h6>My Profile</h6>
            <p>Update information</p>
        </a>

        <a href="{{ route('password.edit') }}" class="action-card red">
            <div class="action-icon">
                <i class="fas fa-key"></i>
            </div>
            <h6>Change Password</h6>
            <p>Update security</p>
        </a>
    </div>

    <div class="row">
        {{-- Enrolled Courses Section --}}
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold">Enrolled Courses</h5>
                <a href="{{ route('student.registration.index') }}" class="text-decoration-none small">Manage Courses <i class="fas fa-arrow-right ms-1"></i></a>
            </div>

            {{-- LOOP START --}}
            @forelse($enrolledCourses as $reg)
                <div class="course-card">
                    <div class="d-flex align-items-center">
                        <div class="course-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">{{ $reg->section->course->course_name }}</div>
                            <div class="text-muted small">{{ $reg->section->course->course_id }} • Section {{ $reg->section->section_no }} • {{ $reg->section->course->credit_hours }} Credits</div>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="badge badge-status {{ $reg->status == 'approved' ? 'bg-success-subtle text-success border border-success' : 'bg-warning-subtle text-warning border border-warning' }}">
                            {{ strtoupper($reg->status) }}
                        </span>
                    </div>
                </div>
            @empty
                {{-- Empty State --}}
                <div class="notice-box border">
                    <div class="notice-title">No enrolled courses yet</div>
                    <p class="mb-2 text-muted">Your enrolled courses will appear here once you register for a section.</p>
                    <a href="{{ route('student.registration.index') }}" class="text-decoration-none fw-bold">
                        Register Now <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            @endforelse
            {{-- LOOP END --}}
        </div>

        {{-- ✅ FUNCTION b) Notifications Section --}}
        <div class="col-lg-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold">📬 Notifications</h5>
            </div>

            @if(auth()->user()->unreadNotifications->count() > 0)
                @foreach(auth()->user()->unreadNotifications->take(5) as $notification)
                    <div class="notification-item">
                        <div class="notif-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="notif-content">
                            <div class="notif-text">
                                {{ $notification->data['message'] ?? 'New notification' }}
                            </div>
                            <div class="notif-time">
                                {{ $notification->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="notice-box">
                    <div class="notice-title">No new notifications</div>
                    <p class="mb-0 text-muted">You're all caught up! Notifications will appear here.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection