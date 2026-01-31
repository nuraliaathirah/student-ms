@extends('layouts.app')

@section('title', 'Admin Dashboard')

@push('styles')
<style>
    .page-wrap {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
    }

    .page-banner {
        background: linear-gradient(135deg, #d32f2f, #f44336); /* Red theme for Admin */
        color: white;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .page-banner h4 {
        margin: 0;
        color: #fff;
        font-weight: 700;
        letter-spacing: .5px;
        font-size: 1.25rem;
        line-height: 1.3;
    }

    .page-banner .small-muted {
        opacity: .85;
        font-size: .9rem;
        line-height: 1.4;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        height: 100%;
        transition: transform 0.2s, box-shadow 0.2s;
        border-left: 4px solid #d32f2f;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.1);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #d32f2f;
        margin: 10px 0;
    }

    .stat-label {
        color: #666;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 10px;
    }

    .icon-students { background: #e3f2fd; color: #1976d2; }
    .icon-lecturers { background: #f3e5f5; color: #7b1fa2; }
    .icon-courses { background: #e8f5e9; color: #388e3c; }
    .icon-programmes { background: #fff3e0; color: #f57c00; }

    .pending-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 20px;
        color: #333;
    }

    .registration-item {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: background 0.2s;
    }

    .registration-item:hover {
        background: #e9ecef;
    }

    .student-info {
        flex: 1;
    }

    .student-name {
        font-weight: 600;
        color: #333;
        margin-bottom: 4px;
    }

    .course-info {
        font-size: 0.85rem;
        color: #666;
    }

    .badge-pending {
        background: #fff3cd;
        color: #856404;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-glass-warning {
        background-color: rgba(255, 193, 7, 0.15); 
        color: #856404;                            
        border: 1px solid rgba(255, 193, 7, 0.3); 
        padding: 6px 16px;                         
        border-radius: 50px;                       
        font-weight: 600;
        font-size: 0.75rem;
        backdrop-filter: blur(4px);                
    }

    .action-btns {
        display: flex;
        gap: 8px;
    }

    .btn-sm-custom {
        padding: 4px 12px;
        font-size: 0.75rem;
        border-radius: 6px;
        font-weight: 500;
    }

    .btn-approve {
        background: #4caf50;
        color: white;
        border: none;
    }

    .btn-approve:hover {
        background: #45a049;
        color: white;
    }

    .btn-reject {
        background: #f44336;
        color: white;
        border: none;
    }

    .btn-reject:hover {
        background: #da190b;
        color: white;
    }

    .quick-actions {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .quick-action-btn {
        flex: 1;
        min-width: 200px;
        background: white;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        padding: 15px;
        text-align: center;
        text-decoration: none;
        color: #333;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .quick-action-btn:hover {
        border-color: #d32f2f;
        color: #d32f2f;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #999;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 15px;
        opacity: 0.3;
    }
</style>
@endpush

@section('content')
<div class="page-wrap">

    {{-- Banner --}}
    <div class="page-banner">
        <div>
            <h4 class="mb-1 text-light">Admin Dashboard</h4>
            <div class="small-muted mb-2">
                Date: <strong>{{ now()->format('F d, Y') }}</strong>
            </div>
            <div class="small-muted">
                @if($currentSemester)
                    Current Semester: <strong>{{ $currentSemester->year }} - Semester {{ $currentSemester->session }}</strong>
                @else
                    <strong>No active semester</strong>
                @endif
            </div>
        </div>
        <div class="d-none d-md-block text-end">
            <h2 class="mb-0 text-light">{{ $pendingRegistrations->count() }}</h2>
            <small>Pending Approvals</small>
        </div>
    </div>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Statistics Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon icon-students">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="stat-number">{{ $totalStudents }}</div>
                <div class="stat-label">Total Students</div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon icon-lecturers">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="stat-number">{{ $totalLecturers }}</div>
                <div class="stat-label">Total Lecturers</div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon icon-courses">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stat-number">{{ $totalCourses }}</div>
                <div class="stat-label">Total Courses</div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon icon-programmes">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="stat-number">{{ $totalProgrammes }}</div>
                <div class="stat-label">Programmes</div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="section-title">
        <i class="fas fa-bolt me-2"></i>Quick Actions
    </div>
    <div class="quick-actions mb-4">
        <a href="{{ route('admin.courses.create') }}" class="quick-action-btn">
            <i class="fas fa-plus-circle"></i>
            <span>Add New Course</span>
        </a>
        <a href="{{ route('admin.courses.index') }}" class="quick-action-btn">
            <i class="fas fa-book-open"></i>
            <span>Manage Courses</span>
        </a>
        <a href="{{ route('admin.programmes.create') }}" class="quick-action-btn">
            <i class="fas fa-plus-circle"></i>
            <span>Add New Programme</span>
        </a>
    </div>

    {{-- Pending Registrations Section --}}
    <div class="pending-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="section-title mb-0">
                <i class="fas fa-clock me-2"></i>Pending Registration Approvals
            </div>
            @if($recentRegistrations > 0)
                <span class="badge badge-glass-warning">
                    <i class="fas fa-bolt me-1"></i> {{ $recentRegistrations }} new this week
                </span>
            @endif        
            </div>

        @forelse($pendingRegistrations as $reg)
            <div class="registration-item">
                <div class="student-info">
                    <div class="student-name">
                        {{ $reg->student->user->name ?? 'Unknown Student' }}
                        <span class="text-muted" style="font-size: 0.85rem;">({{ $reg->student_id }})</span>
                    </div>
                    <div class="course-info">
                        <i class="fas fa-book me-1"></i>
                        {{ $reg->section->course->course_id ?? 'N/A' }} - {{ $reg->section->course->course_name ?? 'N/A' }}
                        <span class="mx-2">|</span>
                        <i class="fas fa-calendar me-1"></i>
                        {{ \Carbon\Carbon::parse($reg->registered_at)->format('M d, Y h:i A') }}
                    </div>
                </div>

                <div class="action-btns">
                    <form action="{{ route('admin.registration.approve', $reg->registration_id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-approve btn-sm-custom" onclick="return confirm('Approve this registration?')">
                            <i class="fas fa-check me-1"></i>Approve
                        </button>
                    </form>

                    <form action="{{ route('admin.registration.reject', $reg->registration_id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-reject btn-sm-custom" onclick="return confirm('Reject this registration?')">
                            <i class="fas fa-times me-1"></i>Reject
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-check-circle"></i>
                <p class="mb-0">No pending registrations at the moment</p>
            </div>
        @endforelse
    </div>

</div>
@endsection