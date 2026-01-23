@extends('layouts.app')

@section('title', 'Edit Lecturer Profile')

@push('styles')
<style>
    body { font-size: .85rem; }
    
    /* Container & Wrapper */
    .profile-wrapper {
        min-height: calc(100vh - 80px);
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding-top: 60px;
    }
    .profile-wrapper .container { max-width: 620px !important; }

    /* Card */
    .card { border-radius: 12px; border: 1px solid rgba(0,0,0,.1); }
    .card-header { padding: .65rem .9rem; font-size: .95rem; background-color: #fff; font-weight: 600; }
    .card-body { padding: 1.5rem; }

    /* Form Elements */
    .form-label { font-size: .8rem; margin-bottom: .25rem; font-weight: 500; }
    .form-control, .form-select { font-size: .85rem; padding: .45rem .65rem; }
    .text-muted { font-size: .75rem; }
    .mb-3 { margin-bottom: 1rem !important; }
    
    /* Button */
    .btn-dark { font-size: .8rem; padding: .5rem 1rem; border-radius: 6px; }

    /* Alerts */
    .alert { font-size: .8rem; padding: .5rem .75rem; border-radius: 8px; }
</style>
@endpush

@section('content')
<div class="profile-wrapper">
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header">
                <i class="fas fa-user-tie me-2"></i>Edit Lecturer Profile
            </div>
            
            <div class="card-body">

                {{-- Success/Error Messages --}}
                @if(session('success'))
                    <div class="alert alert-success mb-3">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger mb-3">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('lecturer.profile.update') }}">
                    @csrf
                    @method('PATCH')

                    {{-- 1. Name (Read Only) --}}
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input class="form-control bg-light" value="{{ $user->name }}" readonly>
                        <small class="text-muted">Your full name.</small>
                    </div>

                    {{-- 2. Staff No (Optional) --}}
                    <div class="mb-3">
                        <label class="form-label">Staff No</label>
                        <input name="staff_no" 
                               type="text" 
                               class="form-control @error('staff_no') is-invalid @enderror" 
                               value="{{ old('staff_no', $lecturer->staff_no) }}" 
                               placeholder="e.g. S1234 (Optional)">
                        @error('staff_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- 3. Department (Dropdown) --}}
                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <select name="department" class="form-select @error('department') is-invalid @enderror">
                            <option value="" disabled>Select Department</option>
                            @php
                                $dept = old('department', $lecturer->department);
                            @endphp
                            <option value="Software Engineering" {{ $dept == 'Software Engineering' ? 'selected' : '' }}>Software Engineering</option>
                            <option value="Network & Security" {{ $dept == 'Network & Security' ? 'selected' : '' }}>Network & Security</option>
                            <option value="Data Engineering" {{ $dept == 'Data Engineering' ? 'selected' : '' }}>Data Engineering</option>
                            <option value="Computing" {{ $dept == 'Computing' ? 'selected' : '' }}>Computing (General)</option>
                        </select>
                        @error('department')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- 4. Phone No (Optional) --}}
                    <div class="mb-3">
                        <label class="form-label">Phone No</label>
                        <input name="phone_no" 
                               type="text" 
                               class="form-control @error('phone_no') is-invalid @enderror" 
                               value="{{ old('phone_no', $lecturer->phone_no ?? '') }}"
                               placeholder="012-3456789">
                         @error('phone_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('lecturer.dashboard') }}" class="btn btn-light border">Cancel</a>
                        <button type="submit" class="btn btn-dark px-4">Save Changes</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection