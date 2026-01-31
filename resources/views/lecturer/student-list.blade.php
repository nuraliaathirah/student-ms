@extends('layouts.app')

@section('title', 'Class List')

@push('styles')
<style>
  .page-wrap { width: 100%; max-width: 980px; margin: 0 auto; }
  .avatar-sm { width: 32px; height: 32px; background: #e9ecef; border-radius: 50%; display:flex; align-items:center; justify-content:center; color: #495057; font-size: 0.8rem; }
  
  /* New Pill Button Style */
  .btn-pill {
      border-radius: 50px !important;
      padding: 0.25rem 1rem;
      font-size: 0.8rem;
      font-weight: 500;
      transition: all 0.2s;
  }
  
  .btn-pill:hover {
      background-color: #f8f9fa;
      border-color: #0d6efd !important;
      color: #0d6efd !important;
      transform: translateY(-1px);
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
        <h4 class="fw-bold mb-1">{{ $section->course->course_name }} ({{ $section->course->course_id }})</h4>
        <p class="text-muted">Section {{ $section->section_no }} • {{ $registrations->count() }} Students Enrolled</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width: 50px;">#</th>
                        <th>Name</th>
                        <th>Matric No</th>
                        <th>Programme</th>
                        <th class="text-end pe-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations as $index => $reg)
                    <tr>
                        <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    {{ substr($reg->student->name, 0, 1) }}
                                </div>
                                <span class="fw-semibold">{{ $reg->student->name }}</span>
                            </div>
                        </td>
                        <td>{{ $reg->student->matric_no }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $reg->student->program_code }}</span></td>
                        <td class="text-end pe-4 text-center">
                            {{-- Adjusted Button: Added btn-pill class --}}
                            <button class="btn btn-pill btn-light border " 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#studentModal"
                                    data-name="{{ $reg->student->name }}"
                                    data-matric="{{ $reg->student->matric_no }}"
                                    data-email="{{ $reg->student->user->email ?? '-' }}"
                                    data-phone="{{ $reg->student->phone_no ?? '-' }}"
                                    data-program="{{ $reg->student->program_code }}">
                                <i class="fas fa-info-circle text-primary me-1"></i> Details
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">No students registered yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- (Modal and Scripts stay the same as your original code) --}}
<div class="modal fade" id="studentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Student Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center pt-4 pb-5">
                <div class="avatar-sm mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem; background: #e3f2fd; color: #1565c0;">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h4 class="fw-bold mb-1" id="mName">Student Name</h4>
                <p class="text-muted mb-4" id="mMatric">A21EC0000</p>
                
                <div class="row g-3 text-start px-3">
                    <div class="col-6">
                        <small class="text-muted d-block">Programme</small>
                        <span class="fw-semibold" id="mProgram">SECJ</span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Phone No</small>
                        <span class="fw-semibold" id="mPhone">012-3456789</span>
                    </div>
                    <div class="col-12">
                        <small class="text-muted d-block">Email Address</small>
                        <span class="fw-semibold" id="mEmail">student@graduate.utm.my</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const studentModal = document.getElementById('studentModal');
    studentModal.addEventListener('show.bs.modal', function (event) {
        const btn = event.relatedTarget;
        document.getElementById('mName').textContent = btn.getAttribute('data-name');
        document.getElementById('mMatric').textContent = btn.getAttribute('data-matric');
        document.getElementById('mEmail').textContent = btn.getAttribute('data-email');
        document.getElementById('mPhone').textContent = btn.getAttribute('data-phone');
        document.getElementById('mProgram').textContent = btn.getAttribute('data-program');
    });
</script>
@endpush
@endsection