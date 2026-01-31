@extends('layouts.app')

@section('title', 'Grade Entry - ' . $section->course->course_name)

@push('styles')
<style>
    .page-wrap { max-width: 1000px; margin: 0 auto; }
    .grade-table { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
    .grade-select { 
        min-width: 110px; 
        font-size: 0.9rem;
        padding: 6px 30px 6px 12px; /* Added right padding for arrow space */
    }
    .grade-select.has-grade { background-color: #e8f5e9; border-color: #4caf50; }
    .table thead th { background-color: #1e3c72; color: white; font-weight: 500; }
    .student-row:hover { background-color: #f8f9fa; }
    
    /* Custom Badge Styles */
    .badge-custom {
        border-radius: 50px !important;
        padding: 4px 12px;
        font-weight: 500;
    }
    .badge-primary-transparent {
        background-color: rgba(13, 110, 253, 0.1) !important;
        color: #0d6efd !important;
        border: 1px solid rgba(13, 110, 253, 0.2);
    }
    .badge-light-transparent {
        background-color: rgba(108, 117, 125, 0.1) !important;
        color: #495057 !important;
        border: 1px solid rgba(108, 117, 125, 0.2);
    }
    .badge-success-transparent {
        background-color: rgba(25, 135, 84, 0.1) !important;
        color: #198754 !important;
        border: 1px solid rgba(25, 135, 84, 0.2);
    }
    .badge-secondary-transparent {
        background-color: rgba(108, 117, 125, 0.1) !important;
        color: #6c757d !important;
        border: 1px solid rgba(108, 117, 125, 0.2);
    }
    
    /* Rounded Save Button */
    .btn-save {
        border-radius: 20px !important;
        padding: 8px 24px;
    }
</style>
@endpush

@section('content')
<div class="page-wrap">
    {{-- Back Button & Title --}}
    <div class="mb-4">
        <a href="{{ route('lecturer.dashboard') }}" class="text-decoration-none text-muted small mb-2 d-block">
            <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Header --}}
    <div class="bg-white rounded-3 shadow-sm p-4 mb-4">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h5 class="mb-1 fw-bold">Grade Entry</h5>
                <p class="text-muted mb-2">
                    <span class="badge badge-custom badge-primary-transparent">{{ $section->course->course_id }}</span>
                    Section {{ $section->section_no }} • 
                    {{ $section->semester->year }} Semester {{ $section->semester->session }}
                </p>
                <small class="text-muted">
                    <i class="fas fa-calendar me-1"></i>{{ $section->schedule ?? 'TBA' }} • 
                    <i class="fas fa-map-marker-alt me-1"></i>{{ $section->venue ?? 'TBA' }}
                </small>
            </div>
            <div class="text-end">
                <div class="h3 mb-0 text-primary">{{ $students->count() }}</div>
                <small class="text-muted">Students Enrolled</small>
            </div>
        </div>
    </div>

    {{-- Grade Entry Form --}}
    <div class="grade-table">
        <form method="POST" action="{{ route('lecturer.section.update-grades', $section->section_id) }}">
            @csrf
            
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 15%">Matric No</th>
                            <th style="width: 35%">Student Name</th>
                            <th style="width: 20%">Programme</th>
                            <th style="width: 15%">Current Grade</th>
                            <th style="width: 10%">Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $index => $registration)
                        <tr class="student-row">
                            <td class="align-middle">{{ $index + 1 }}</td>
                            <td class="align-middle">
                                <strong>{{ $registration->student->matric_no }}</strong>
                            </td>
                            <td class="align-middle">{{ $registration->student->name }}</td>
                            <td class="align-middle">
                                <span class="badge badge-custom badge-light-transparent">{{ $registration->student->program_code }}</span>
                            </td>
                            <td class="align-middle">
                                @if($registration->grade)
                                    <span class="badge badge-custom badge-success-transparent">{{ $registration->grade }}</span>
                                @else
                                    <span class="badge badge-custom badge-secondary-transparent">Not Graded</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                <select 
                                    name="grades[{{ $registration->registration_id }}]" 
                                    class="form-select form-select-sm grade-select {{ $registration->grade ? 'has-grade' : '' }}">
                                    <option value="">Select</option>
                                    <option value="A" {{ $registration->grade == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="A-" {{ $registration->grade == 'A-' ? 'selected' : '' }}>A-</option>
                                    <option value="B+" {{ $registration->grade == 'B+' ? 'selected' : '' }}>B+</option>
                                    <option value="B" {{ $registration->grade == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="B-" {{ $registration->grade == 'B-' ? 'selected' : '' }}>B-</option>
                                    <option value="C+" {{ $registration->grade == 'C+' ? 'selected' : '' }}>C+</option>
                                    <option value="C" {{ $registration->grade == 'C' ? 'selected' : '' }}>C</option>
                                    <option value="C-" {{ $registration->grade == 'C-' ? 'selected' : '' }}>C-</option>
                                    <option value="D+" {{ $registration->grade == 'D+' ? 'selected' : '' }}>D+</option>
                                    <option value="D" {{ $registration->grade == 'D' ? 'selected' : '' }}>D</option>
                                    <option value="F" {{ $registration->grade == 'F' ? 'selected' : '' }}>F</option>
                                </select>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                No students enrolled in this section.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($students->count() > 0)
            <div class="p-4 border-top bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        <small><i class="fas fa-info-circle me-1"></i>Grade changes will be saved immediately</small>
                    </div>
                    <button type="submit" class="btn btn-primary btn-save">
                        <i class="fas fa-save me-2"></i>Save
                    </button>
                </div>
            </div>
            @endif
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Add visual feedback when grade is selected
    document.querySelectorAll('.grade-select').forEach(select => {
        select.addEventListener('change', function() {
            if (this.value) {
                this.classList.add('has-grade');
            } else {
                this.classList.remove('has-grade');
            }
        });
    });
</script>
@endpush
@endsection