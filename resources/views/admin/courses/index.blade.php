@extends('layouts.app')

@section('title', 'Manage Courses')

@push('styles')
<style>
    .page-wrap {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
    }

    .page-header {
        background: linear-gradient(135deg, #d32f2f, #f44336);
        color: white;
        border-radius: 15px;
        padding: 25px 30px;
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-header h4 {
        margin: 0;
        font-weight: 700;
        font-size: 1.25rem;
    }

    .table-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .table {
        font-size: 0.85rem;
        margin-bottom: 0;
    }

    .table thead {
        background: #f8f9fa;
    }

    /* UPDATED: Compact Table Headers */
    .table thead th {
        border-bottom: 2px solid #dee2e6;
        font-weight: 700;
        color: #495057;
        padding: 12px;
        white-space: nowrap; 
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table tbody td {
        padding: 12px;
        vertical-align: middle;
    }

    .badge-credit {
        background: #e3f2fd;
        color: #1976d2;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-students {
        background: #f3e5f5;
        color: #7b1fa2;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* UPDATED: Smaller, Transparent Action Buttons */
    .btn-action {
        width: 28px;               /* Reduced from 32px */
        height: 28px;              /* Reduced from 32px */
        padding: 0;
        font-size: 0.65rem;        /* Smaller icon size */
        border-radius: 6px;        /* Slightly sharper radius for smaller box */
        margin: 0 2px;             /* Horizontal gap to prevent overlap */
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid transparent;
        transition: all 0.2s;
    }

    /* Transparent Warning (Edit) */
    .btn-edit-trans {
        background: rgba(255, 193, 7, 0.15); /* More transparent */
        color: #856404;
        border-color: rgba(255, 193, 7, 0.1);
    }

    .btn-edit-trans:hover {
        background: rgba(255, 193, 7, 0.25);
        color: #856404;
    }

    /* Transparent Danger (Delete) */
    .btn-delete-trans {
        background: rgba(220, 53, 69, 0.15); /* More transparent */
        color: #dc3545;
        border-color: rgba(220, 53, 69, 0.1);
    }

    .btn-delete-trans:hover {
        background: rgba(220, 53, 69, 0.25);
        color: #dc3545;
    }

    .btn-add {
        background: rgba(255, 255, 255, 0.2); 
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.4);
        padding: 8px 20px;
        border-radius: 50px; 
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        backdrop-filter: blur(4px);
    }

    .btn-add:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        transform: translateY(-2px);
    }

    .search-box {
        position: relative;
        margin-bottom: 20px;
    }

    .search-box input {
        padding-left: 40px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .search-box i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
    }

    .course-id {
        font-weight: 700;
        color: #d32f2f;
        font-size: 0.75rem;
        white-space: nowrap;
        background: rgba(211, 47, 47, 0.05);
        padding: 2px 6px;
        border-radius: 4px;
        font-family: monospace;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.3;
    }
</style>
@endpush

@section('content')
<div class="page-wrap">

    <div class="page-header">
        <div>
            <h4 class="text-light">Course Management</h4>
            <small class="opacity-75">View, add, edit, and delete courses</small>
        </div>
        <a href="{{ route('admin.courses.create') }}" class="btn-add">
            <i class="fas fa-plus-circle"></i>
            <span>Add New Course</span>
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-card">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" class="form-control" placeholder="Search by course ID or name...">
        </div>

        @if($courses->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover" id="coursesTable">
                    <thead>
                        <tr>
                            <th style="width: 120px;">Course ID</th>
                            <th>Course Name</th>
                            <th>Programme</th>
                            <th class="text-center">Credit Hours</th>
                            <th class="text-center">Max Students</th>
                            <th class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                        <tr>
                            <td><span class="course-id">{{ $course->course_id }}</span></td>
                            <td>{{ $course->course_name }}</td>
                            <td><small class="text-muted">{{ $course->programme->program_name ?? 'N/A' }}</small></td>
                            <td class="text-center"><span class="badge-credit">{{ $course->credit_hours }} Credits</span></td>
                            <td class="text-center"><span class="badge-students">{{ $course->max_students }} Students</span></td>
                            <td class="text-center">
                                {{-- Compact Edit --}}
                                <a href="{{ route('admin.courses.edit', $course->course_id) }}" 
                                   class="btn-action btn-edit-trans" 
                                   title="Edit Course">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- Compact Delete --}}
                                <form action="{{ route('admin.courses.destroy', $course->course_id) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Delete this course?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete-trans" title="Delete Course">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">Showing {{ $courses->firstItem() }} to {{ $courses->lastItem() }} of {{ $courses->total() }} courses</small>
                {{ $courses->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-book-open"></i>
                <h5>No Courses Found</h5>
                <a href="{{ route('admin.courses.create') }}" class="btn-add" style="background: #d32f2f; border: none;">
                    <i class="fas fa-plus-circle"></i>
                    <span>Add New Course</span>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('#coursesTable tbody tr');

        tableRows.forEach(row => {
            const courseId = row.cells[0].textContent.toLowerCase();
            const courseName = row.cells[1].textContent.toLowerCase();
            if (courseId.includes(searchValue) || courseName.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endpush