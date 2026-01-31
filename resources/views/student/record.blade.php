@extends('layouts.app')

@section('title', 'Academic Record')

@push('styles')
<style>
  .page-wrap { width:100%; max-width: 980px; margin: 0 auto; }
  
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

  .accordion-item { border: none; margin-bottom: 15px; border-radius: 12px !important; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.02); }
  .accordion-button { font-weight: 600; background-color: #fff; padding: 1rem 1.25rem; }
  .accordion-button:not(.collapsed) { background-color: #f1f5f9; color: #2d5782; box-shadow: none; }
  .accordion-button:focus { box-shadow: none; }
  
  .grade-badge {
    width: 35px; height: 35px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 50%; font-weight: 700; font-size: 0.85rem;
    background: #f8f9fa; border: 1px solid #dee2e6;
  }
  .grade-A { background-color: #d1e7dd; color: #0f5132; border-color: #badbcc; }
  .grade-B { background-color: #cfe2ff; color: #084298; border-color: #b6d4fe; }
  .grade-C { background-color: #fff3cd; color: #664d03; border-color: #ffecb5; }
  .grade-F { background-color: #f8d7da; color: #842029; border-color: #f5c2c7; }
</style>
@endpush

@section('content')
<div class="page-wrap">

    {{-- Banner --}}
    <div class="page-banner">
        <div>
            <h4 class="mb-1 text-light">Academic Record</h4>
            <p>View your full course history and grade summary.</p>
        </div>
        <div class="d-none d-md-block">
            <i class="fas fa-file-invoice fa-3x opacity-25"></i>
        </div>
    </div>

    {{-- Summary Stats --}}
    <div class="summary-card">
        <div class="stat-box">
            <h3>{{ number_format($student->cgpa ?? 0.00, 2) }}</h3>
            <small>Current CGPA</small>
        </div>
        <div class="stat-box border-start ps-4">
            <h3>{{ $records->flatten()->count() }}</h3>
            <small>Total Courses</small>
        </div>
        <div class="stat-box border-start ps-4">
            <h3>{{ $records->flatten()->sum(fn($r) => $r->section->course->credit_hours ?? 0) }}</h3>
            <small>Credit Earned</small>
        </div>
    </div>

    {{-- Semesters Accordion --}}
    <div class="accordion" id="accordionRecord">
        
        @forelse($records as $semesterName => $courses)
            <div class="accordion-item shadow-sm">
                <h2 class="accordion-header">
                    <button class="accordion-button {{ !$loop->first ? 'collapsed' : '' }}" 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#collapse{{ $loop->index }}">
                        <div class="d-flex justify-content-between w-100 me-3">
                            <span>{{ $semesterName }}</span>
                            <span class="badge bg-white text-primary border rounded-pill px-3">
                                {{ $courses->sum(fn($c) => $c->section->course->credit_hours ?? 0) }} Credits
                            </span>
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
                                        <th class="ps-4" style="width: 120px;">Code</th>
                                        <th>Course Name</th>
                                        <th class="text-center">Credit</th>
                                        <th class="text-center">Grade</th>
                                        <th class="text-end pe-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($courses as $reg)
                                        @php
                                            $grade = $reg->grade ?? '-';
                                            $badgeClass = match(true) {
                                                str_starts_with($grade, 'A') => 'grade-A',
                                                str_starts_with($grade, 'B') => 'grade-B',
                                                str_starts_with($grade, 'C') => 'grade-C',
                                                str_starts_with($grade, 'D') || $grade == 'F' => 'grade-F',
                                                default => ''
                                            };
                                        @endphp
                                        <tr>
                                            <td class="ps-4 fw-bold text-primary">{{ $reg->section->course->course_id }}</td>
                                            <td>
                                                <div class="fw-semibold">{{ $reg->section->course->course_name }}</div>
                                                <div class="small text-muted">Section {{ $reg->section->section_no }}</div>
                                            </td>
                                            <td class="text-center">{{ $reg->section->course->credit_hours }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <span class="grade-badge {{ $badgeClass }}">
                                                        {{ $grade }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-end pe-4">
                                                @if($grade == 'F' || $grade == '-')
                                                    <span class="text-secondary fw-bold small">PENDING</span>
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
            <div class="text-center py-5 bg-white rounded-4 shadow-sm">
                <i class="fas fa-history fa-3x text-light mb-3"></i>
                <p class="text-muted">You don't have any completed semesters yet.</p>
            </div>
        @endforelse

    </div>
</div>
@endsection