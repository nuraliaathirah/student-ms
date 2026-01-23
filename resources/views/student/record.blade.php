@extends('layouts.app')

@section('title', 'Academic Record')

@push('styles')
<style>
  .page-wrap { width:100%; max-width: 980px; margin: 0 auto; }
  
  /* Matches your other pages */
  .page-banner {
    background: linear-gradient(135deg, #262d34ff, #2d5782ff);
    color: white;
    border-radius: 15px;
    padding: 30px;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .page-banner h4 { font-weight: 700; margin: 0; font-size: 1.25rem; }
  .page-banner p { opacity: 0.9; margin: 0; font-size: 0.9rem; }

  /* Summary Card for CGPA */
  .summary-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    margin-bottom: 25px;
    display: flex;
    gap: 30px;
  }
  .stat-box h3 { font-weight: 700; color: #2d5782; margin: 0; }
  .stat-box small { color: #6c757d; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; }

  /* Accordion Styling */
  .accordion-item { border: none; margin-bottom: 15px; border-radius: 12px !important; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.02); }
  .accordion-button { font-weight: 600; background-color: #fff; padding: 1rem 1.25rem; }
  .accordion-button:not(.collapsed) { background-color: #f1f5f9; color: #2d5782; box-shadow: none; }
  .accordion-button:focus { box-shadow: none; }
  
  /* Grade Badges */
  .grade-badge {
    width: 35px; height: 35px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 50%; font-weight: 700; font-size: 0.85rem;
    background: #f8f9fa; border: 1px solid #dee2e6;
  }
  .grade-A { background-color: #d1e7dd; color: #0f5132; border-color: #badbcc; } /* Green */
  .grade-B { background-color: #cfe2ff; color: #084298; border-color: #b6d4fe; } /* Blue */
  .grade-C { background-color: #fff3cd; color: #664d03; border-color: #ffecb5; } /* Yellow */
  .grade-F { background-color: #f8d7da; color: #842029; border-color: #f5c2c7; } /* Red */
</style>
@endpush

@section('content')
<div class="page-wrap">

    {{-- 1. Banner --}}
    <div class="page-banner">
        <div>
            <h4 class="mb-1 text-light">Academic Record</h4>
            <p>View your course history and examination results.</p>
        </div>
    </div>

    {{-- 2. CGPA Summary Box (Optional but recommended) --}}
    <div class="summary-card">
        <div class="stat-box">
            <h3>{{ number_format($student->cgpa ?? 3.50, 2) }}</h3>
            <small>Current CGPA</small>
        </div>
        <div class="stat-box border-start ps-4">
            <h3>{{ $records->flatten()->count() }}</h3>
            <small>Total Courses</small>
        </div>
        <div class="stat-box border-start ps-4">
            <h3>{{ $records->flatten()->sum(fn($r) => $r->course->credit_hours ?? 3) }}</h3>
            <small>Credit Earned</small>
        </div>
    </div>

    {{-- 3. Accordion for Semesters --}}
    <div class="accordion" id="accordionRecord">
        
        @forelse($records as $semesterName => $courses)
            <div class="accordion-item">
                <h2 class="accordion-header">
                    {{-- Open the first item by default using $loop->first --}}
                    <button class="accordion-button {{ !$loop->first ? 'collapsed' : '' }}" 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#collapse{{ $loop->index }}">
                        <div class="d-flex justify-content-between w-100 me-3">
                            <span>{{ $semesterName }}</span>
                            <span class="badge bg-secondary rounded-pill" style="font-weight: 500;">
                                GPA: {{ number_format(3.00, 2) }} </span>
                        </div>
                    </button>
                </h2>
                <div id="collapse{{ $loop->index }}" 
                     class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" 
                     data-bs-parent="#accordionRecord">
                    
                    <div class="accordion-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr class="small text-uppercase text-muted">
                                        <th class="ps-4">Code</th>
                                        <th>Course Name</th>
                                        <th class="text-center">Credit</th>
                                        <th class="text-center">Grade</th>
                                        <th class="text-end pe-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($courses as $reg)
                                        @php
                                            // Determine Badge Color based on Grade
                                            $grade = $reg->grade ?? '-'; // Ensure 'grade' column exists in registration table
                                            $badgeClass = '';
                                            if(str_starts_with($grade, 'A')) $badgeClass = 'grade-A';
                                            elseif(str_starts_with($grade, 'B')) $badgeClass = 'grade-B';
                                            elseif(str_starts_with($grade, 'C')) $badgeClass = 'grade-C';
                                            elseif(str_starts_with($grade, 'D') || $grade == 'F') $badgeClass = 'grade-F';
                                        @endphp
                                        <tr>
                                            <td class="ps-4 fw-semibold">{{ $reg->course->course_id }}</td>
                                            <td>
                                                {{ $reg->course->course_name }}
                                                @if($reg->section)
                                                    <div class="small text-muted">Section {{ $reg->section->section_no }}</div>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $reg->course->credit_hours }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <span class="grade-badge {{ $badgeClass }}">
                                                        {{ $grade }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-end pe-4">
                                                @if($grade == 'F' || $grade == '-')
                                                    <span class="text-danger fw-bold small">FAIL</span>
                                                @else
                                                    <span class="text-success fw-bold small">PASS</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                <p class="text-muted">No academic records found.</p>
            </div>
        @endforelse

    </div>
</div>
@endsection