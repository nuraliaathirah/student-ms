@extends('layouts.app')

@section('title', 'Course Registration')

@push('styles')
<style>
  .page-wrap {
    width: 100%;
    max-width: 980px; 
    margin: 0 auto;
  }

 
  .page-banner {
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

 
  .card {
    border-radius: 14px;
  }
  .card-header {
    padding: .75rem 1rem;
  }
  .card-body {
    padding: 1rem;
  }

  
  .table th, .table td {
    padding: .75rem .9rem;
  }

  /* Plus button style */
  .btn-plus {
    width: 28px;
    height: 28px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-size: 0.95rem;
    font-weight: 400;
    line-height: 1;
    border: 2px solid;
  }

  /* Compact drop button */
  .btn-drop {
    padding: 0.35rem 0.5rem;
    font-size: 0.875rem;
    border: none;
    background: transparent;
    color: #dc3545;
    transition: all 0.2s;
  }

  .btn-drop:hover {
    color: #bb2d3b;
    background: transparent;
  }

  /* Status badges */
  .badge-status {
    font-weight: 500;
    font-size: 0.8rem;
    padding: 0.35rem 0.65rem;
  }

  /* Transparent status badges */
  .badge-transparent {
    background-color: transparent !important;
    border: 1.5px solid;
    font-weight: 500;
  }

  .badge-transparent.bg-warning {
    color: #ffc107;
    border-color: #ffc107;
  }

  .badge-transparent.bg-secondary {
    color: #6c757d;
    border-color: #6c757d;
  }

  /* Status text styles - no badges, just colored text */
  .text-approved {
    color: #28a745 !important;
    font-weight: 500;
    font-size: 0.8rem;
  }

  .text-pending {
    color: #ffc107 !important;
    font-weight: 500;
    font-size: 0.8rem;
  }

  .text-cancelled {
    color: #dc3545 !important;
    font-weight: 500;
    font-size: 0.8rem;
  }
</style>
@endpush

@section('content')
  <div class="page-wrap">

    <div class="page-banner">
        <div>
            <h4 class="mb-1">Registration</h4>

            <div class="small-muted mb-2">
            Year/Semester: <strong>{{ $currentSemester->year }} / S{{ $currentSemester->session }}</strong>
            </div>

            <div class="small-muted">
            {{ $student->name }} • {{ $student->matric_no }} • {{ $student->program_code }}
            </div>
        </div>
    </div>
    
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show">
        {{ $errors->first() }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="card mb-3">
        <div class="card-header d-flex align-items-center justify-content-between bg-white">
            <span class="fw-semibold">Available Course Offered</span>

            <div style="max-width: 420px; width:100%;">
                <input 
                    type="text" 
                    id="courseSearch" 
                    class="form-control form-control-sm"
                    placeholder="Search course code or name..."
                    value="{{ request('q') }}"
                >
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                <tr class="small text-uppercase">
                    <th style="width:140px;">Code</th>
                    <th>Course</th>
                    <th style="width:120px;" class="text-center">Section</th>
                    <th style="width:80px;" class="text-center">Action</th>
                </tr>
                </thead>

                <tbody id="courseTableBody">
                @forelse($offeredSections as $sec)
                    @php
                    $max = $sec->course->max_students ?? 0;
                    $used = $sec->registrations_count ?? 0;
                    $left = max($max - $used, 0);
                    $isFull = $max > 0 && $used >= $max;
                    $isRegistered = in_array($sec->section_id, $registeredSectionIds ?? []);
                    $isCourseRegistered = in_array($sec->course->course_id, $registeredCourseIds ?? []);

                    $credit = $sec->course->credit_hours ?? $sec->course->credit_hour ?? '-';
                    @endphp

                    <tr data-course-code="{{ $sec->course->course_id }}"
                        data-course-name="{{ $sec->course->course_name }}">
                    <td class="fw-semibold">{{ $sec->course->course_id }}</td>

                    <td>
                        <div class="fw-semibold">{{ $sec->course->course_name }}</div>
                        <div class="text-muted small">Programme: {{ $student->program_code }}</div>
                    </td>

                    <td class="fw-semibold text-center">{{ $sec->section_no }}</td>

                    <td class="text-center">
                        <button
                            type="button"
                            class="btn btn-primary btn-sm btn-plus"
                            data-bs-toggle="modal"
                            data-bs-target="#regModal"
                            data-section-id="{{ $sec->section_id }}"
                            data-code="{{ $sec->course->course_id }}"
                            data-name="{{ $sec->course->course_name }}"
                            data-section="{{ $sec->section_no }}"
                            data-credit="{{ $credit }}"
                            data-lecturer="{{ $sec->lecturer->name ?? '-' }}"
                            data-schedule="{{ $sec->schedule ?? '-' }}"
                            data-venue="{{ $sec->venue ?? '-' }}"
                            data-used="{{ $used }}"
                            data-max="{{ $max }}"
                            data-left="{{ $left }}"
                            data-is-registered="{{ $isRegistered ? '1' : '0' }}"
                            data-is-course-registered="{{ $isCourseRegistered ? '1' : '0' }}"
                            title="Register"
                            {{ $isFull ? 'disabled' : '' }}
                        >
                            <i class="fas fa-plus"></i>
                        </button>
                    </td>
                    </tr>

                @empty
                    <tr id="noResultsRow">
                    <td colspan="4" class="text-center text-muted py-4">
                        No course offerings found.
                    </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            </div>
        </div>
    </div>

    <div class="card">
      <div class="card-header fw-semibold bg-white">
        Registered Courses
      </div>

      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr class="small text-uppercase">
                <th style="width:120px;">Code</th>
                <th>Course</th>
                <th style="width:80px;" class="text-center">Section</th>
                <th style="width:80px;" class="text-center">Status</th>
                <th style="width:80px;" class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse($registrations as $reg)
                <tr>
                  <td class="fw-semibold">{{ $reg->section->course->course_id }}</td>
                  <td>{{ $reg->section->course->course_name }}</td>
                  <td class="text-center">{{ $reg->section->section_no }}</td>
                  <td>
                    @php
                      $statusClass = match($reg->status) {
                        'approved' => 'text-approved',
                        'pending' => 'text-pending',
                        'cancelled' => 'text-cancelled',
                        default => ''
                      };
                    @endphp
                    <span class="{{ $statusClass }}">{{ strtoupper($reg->status) }}</span>
                  </td>
                  <td class="text-center">
                    <form method="POST" action="{{ route('student.registration.drop', $reg->registration_id) }}" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-drop"
                              onclick="return confirm('Cancel this registration?')"
                              title="Drop Course">
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center text-muted py-4">
                    No registered courses yet.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="modal fade" id="regModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:14px;">
        <div class="modal-header">
            <h6 class="modal-title fw-semibold">Confirm Course Registration</h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="mb-2">
            <div class="text-muted small">Course</div>
            <div class="fw-semibold">
                <span id="mCode"></span> - <span id="mName"></span>
            </div>
            </div>

            <div class="row g-2 small">
            <div class="col-6">
                <div class="text-muted">Section</div>
                <div class="fw-semibold" id="mSection"></div>
            </div>
            <div class="col-6">
                <div class="text-muted">Credit</div>
                <div class="fw-semibold" id="mCredit"></div>
            </div>

            <div class="col-12">
                <div class="text-muted">Lecturer</div>
                <div class="fw-semibold" id="mLecturer"></div>
            </div>

            <div class="col-12">
                <div class="text-muted">Schedule</div>
                <div class="fw-semibold" id="mSchedule"></div>
            </div>

            <div class="col-12">
                <div class="text-muted">Venue</div>
                <div class="fw-semibold" id="mVenue"></div>
            </div>

            <div class="col-12 mt-2">
                <div class="text-muted">Capacity</div>
                <div class="fw-semibold">
                <span id="mUsed"></span> / <span id="mMax"></span>
                <span class="text-muted"> (Left: <span id="mLeft"></span>)</span>
                </div>
            </div>
            </div>

            <hr class="my-3">

            <form method="POST" action="{{ route('student.registration.store') }}" id="confirmRegForm">
            @csrf
            <input type="hidden" name="section_id" id="mSectionId">
            <button class="btn btn-primary btn-sm w-100">Confirm Register</button>
            </form>
        </div>
        </div>
    </div>
    </div>

  </div>

@push('scripts')
    <script>
    const regModal = document.getElementById('regModal');
    const confirmForm = document.getElementById('confirmRegForm');
    
    regModal.addEventListener('show.bs.modal', function (event) {
        const btn = event.relatedTarget;
        const isRegistered = btn.getAttribute('data-is-registered') === '1';
        const isCourseRegistered = btn.getAttribute('data-is-course-registered') === '1';

        document.getElementById('mSectionId').value = btn.getAttribute('data-section-id');
        document.getElementById('mCode').textContent = btn.getAttribute('data-code');
        document.getElementById('mName').textContent = btn.getAttribute('data-name');
        document.getElementById('mSection').textContent = btn.getAttribute('data-section');
        document.getElementById('mCredit').textContent = btn.getAttribute('data-credit');
        document.getElementById('mLecturer').textContent = btn.getAttribute('data-lecturer');
        document.getElementById('mSchedule').textContent = btn.getAttribute('data-schedule');
        document.getElementById('mVenue').textContent = btn.getAttribute('data-venue');
        document.getElementById('mUsed').textContent = btn.getAttribute('data-used');
        document.getElementById('mMax').textContent = btn.getAttribute('data-max');
        document.getElementById('mLeft').textContent = btn.getAttribute('data-left');

        confirmForm.setAttribute('data-is-registered', isRegistered);
        confirmForm.setAttribute('data-is-course-registered', isCourseRegistered);
    });

    confirmForm.addEventListener('submit', function(e) {
        const isRegistered = this.getAttribute('data-is-registered') === 'true';
        const isCourseRegistered = this.getAttribute('data-is-course-registered') === 'true';
        
        if (isRegistered) {
            e.preventDefault();
            alert('You have already registered for this section.');
            return false;
        }
        
        if (isCourseRegistered) {
            e.preventDefault();
            alert('You have already registered for this course in a different section. You cannot register for the same course twice.');
            return false;
        }
    });

    const searchInput = document.getElementById('courseSearch');
    const tableBody = document.getElementById('courseTableBody');
    
    if (searchInput && tableBody) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase().trim();
            const rows = tableBody.querySelectorAll('tr:not(#noResultsRow)');
            let visibleCount = 0;

            rows.forEach(row => {
                const courseCode = row.getAttribute('data-course-code')?.toLowerCase() || '';
                const courseName = row.getAttribute('data-course-name')?.toLowerCase() || '';
                
                if (courseCode.includes(searchTerm) || courseName.includes(searchTerm)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            let noResultsRow = document.getElementById('noResultsRow');
            if (visibleCount === 0 && rows.length > 0) {
                if (!noResultsRow) {
                    noResultsRow = document.createElement('tr');
                    noResultsRow.id = 'noResultsRow';
                    noResultsRow.innerHTML = '<td colspan="4" class="text-center text-muted py-4">No courses match your search.</td>';
                    tableBody.appendChild(noResultsRow);
                } else {
                    noResultsRow.style.display = '';
                }
            } else if (noResultsRow) {
                noResultsRow.style.display = 'none';
            }
        });
    }
    </script>
@endpush

@endsection