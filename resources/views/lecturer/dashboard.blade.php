@extends('layouts.app')

@section('title', 'Lecturer Dashboard')

@push('styles')
<style>
  .page-wrap { width: 100%; max-width: 980px; margin: 0 auto; }
  .page-banner {
    background: linear-gradient(135deg, #1e3c72, #2a5298); /* Different blue for Lecturer */
    color: white; border-radius: 15px; padding: 30px; margin-bottom: 30px;
  }
  .stat-card {
    background: white; border-radius: 12px; padding: 20px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.02); height: 100%;
    border-left: 4px solid #1e3c72;
    transition: transform 0.2s;
  }
  .stat-card:hover { transform: translateY(-3px); }
  .course-badge { background: #e3f2fd; color: #1565c0; padding: 4px 8px; border-radius: 6px; font-size: 0.8rem; font-weight: 600; }
</style>
@endpush

@section('content')
<div class="page-wrap">

    {{-- Banner --}}
    <div class="page-banner d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1 text-light">Welcome, {{ $lecturer->name }}</h4>
            <p class="mb-0 opacity-75">{{ $lecturer->department }} Department</p>
        </div>
        <div class="d-none d-md-block text-end">
            <h2 class="mb-0 text-light">{{ $assignedSections->count() }}</h2>
            <small>Active Classes</small>
        </div>
    </div>

    {{-- Filter Semester --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0 fw-bold">Assigned Courses</h5>
        
        <form method="GET" action="{{ route('lecturer.dashboard') }}">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-white border-end-0"><i class="fas fa-filter text-muted"></i></span>
                <select name="semester_id" class="form-select border-start-0" onchange="this.form.submit()">
                    @foreach($semesters as $sem)
                        <option value="{{ $sem->semester_id }}" {{ $targetSemesterId == $sem->semester_id ? 'selected' : '' }}>
                            {{ $sem->year }} - Sem {{ $sem->session }} {{ $sem->is_current ? '(Current)' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    {{-- Course Grid --}}
    <div class="row g-3">
        @forelse($assignedSections as $section)
        <div class="col-md-6 col-lg-4">
            <div class="stat-card d-flex flex-column">
                <div class="d-flex justify-content-between mb-2">
                    <span class="course-badge">{{ $section->course->course_id }}</span>
                    <small class="text-muted"><i class="fas fa-users me-1"></i> {{ $section->registrations_count }} Students</small>
                </div>
                
                <h6 class="fw-bold mb-1">{{ $section->course->course_name }}</h6>
                <p class="text-muted small mb-3">Section {{ $section->section_no }} • {{ $section->schedule ?? 'TBA' }}</p>

                <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                    <small class="text-muted">{{ $section->venue ?? 'Venue TBA' }}</small>
                    <a href="{{ route('lecturer.section.students', $section->section_id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                        View Student List
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="text-muted">No courses assigned for this semester.</div>
        </div>
        @endforelse
    </div>

</div>
@endsection