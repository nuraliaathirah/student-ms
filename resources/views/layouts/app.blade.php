<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Student Management System')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Bootswatch Lux --}}
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.0/dist/lux/bootstrap.min.css" rel="stylesheet">
    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    {{-- Extra CSS from pages --}}
    <style>
        body {
        background-color: #f8f9fa;
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;       
        line-height: 1.5;
    }
    h1 { font-size: 1.6rem; font-weight: 600; }
    h2 { font-size: 1.4rem; font-weight: 600; }
    h3 { font-size: 1.25rem; font-weight: 600; }
    h4 { font-size: 1.1rem; font-weight: 600; }
    h5 { font-size: 1rem; font-weight: 500; }
    .sidebar {
      background-color: #212529; 
      color: #dee2e6; 
      height: 100vh;
      position: fixed;
      left: 0;
      top: 0;
      padding-top: 20px;
      box-shadow: 2px 0 5px rgba(0,0,0,0.2);
      z-index: 1000;
      width: 250px;
      font-size: 0.85rem;
    }

    .sidebar .nav-link {
        color: #adb5bd;
        border-radius: 0.375rem;
        margin: 5px 15px;
        padding: 8px 18px;
        transition: all 0.2s;
        white-space: nowrap; 
        overflow: hidden;
        text-overflow: ellipsis; 
        
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background-color: #343a40;
      color: #fff;
    }

    .sidebar .nav-link i {
      margin-right: 10px;
      color: #adb5bd;
    }

    .sidebar .nav-link:hover i,
    .sidebar .nav-link.active i {
      color: #fff;
    }

    .sidebar .text-primary {
      color: #dee2e6 !important;
    }

  .main-content {
    margin-left: 250px;
    padding: 20px;
  }

      .dropdown-menu {
        font-size: 0.85rem;
        border-radius: 10px;
    }

    .dropdown-header {
        font-weight: 600;
        padding: 10px 16px;
    }

    .dropdown-item i {
        width: 16px;
    }

    .avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        border: 2px solid white;

        display: flex;
        align-items: center;
        justify-content: center;
    }

  </style>
    @stack('styles')
</head>

<body>
    <div class="sidebar d-flex flex-column">
        <div class="text-center mb-4">
            <i class="fas fa-graduation-cap fa-3x mb-3"></i>
            <h5 class="text-light">{{ ucfirst(auth()->user()->role) }} Portal</h5>
        </div>

        <ul class="nav flex-column">
            @if(auth()->user()->role == 'student')
            <li class="nav-item">
            <a href="{{ route('student.dashboard') }}"
                class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('student.record') }}" 
                class="nav-link {{ request()->routeIs('student.record') ? 'active' : '' }}">
                    <i class="fas fa-graduation-cap me-2"></i>Academic Record
                </a>
            </li>

            <li class="nav-item">
            <a href="{{ route('student.registration.index') }}"
                class="nav-link {{ request()->routeIs('student.registration.*') ? 'active' : '' }}">
                <i class="fas fa-pen me-2"></i>Registration
            </a>
            </li>

            <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-bell me-2"></i>Notifications
            </a>
            </li>
            @endif

            @if(auth()->user()->role == 'lecturer')
            <li class="nav-item">
                <a href="{{ route('lecturer.dashboard') }}" class="nav-link {{ request()->routeIs('lecturer.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chalkboard-teacher me-2"></i>Dashboard
                </a>
            </li>
            @endif

            <li class="nav-item mt-auto">

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
            </li>
        </ul>
        </div>


    <div class="main-content">
        <div class="d-flex align-items-center mb-4">
            <div class="ms-auto d-flex align-items-center">
                <div class="me-3 text-end">
                    <div class="fw-semibold">
                        {{ auth()->user()->name }}
                    </div>
                    <small class="text-muted">{{ ucfirst(auth()->user()->role) }}</small>
                </div>        
                <div class="dropdown">
                    <div class="avatar dropdown-toggle"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-user-graduate"></i>
                    </div>

                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li class="dropdown-header">
                            {{ auth()->user()->name }}
                            <br>
                            <small class="text-muted">{{ ucfirst(auth()->user()->role) }}</small>
                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <a class="dropdown-item" href="{{ route(auth()->user()->role . '.profile.edit') }}">
                                <i class="fas fa-user-edit me-2"></i>Edit Profile
                            </a>
                        </li>

                        <li>
                        <a href="{{ route('logout') }}"
                            class="dropdown-item text-danger"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                        </form>
                    </ul>
                </div>
            </div>
        </div>
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Extra JS from pages --}}
    @stack('scripts')
</body>
</html>
