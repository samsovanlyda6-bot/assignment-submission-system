<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Assignment System - @yield('title', 'Dashboard')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .nav-link {
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            transform: translateY(-2px);
            color: #667eea !important;
        }

        .dropdown-menu {
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            border: none;
        }

        .dropdown-item {
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateX(5px);
        }

        .btn-logout {
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            transform: translateX(3px);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .role-badge {
            font-size: 0.7rem;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 600;
        }

        .role-badge.admin {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .role-badge.teacher {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .role-badge.student {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/dashboard') }}">
                <i class="fas fa-graduation-cap me-2"></i>
                Assignment System
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/dashboard') }}">
                            <i class="fas fa-chart-line me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/courses') }}">
                            <i class="fas fa-book me-1"></i> Courses
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/assignments') }}">
                            <i class="fas fa-tasks me-1"></i> Assignments
                        </a>
                    </li>

                    @if(Auth::check() && Auth::user()->role_id == 1)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-crown me-1"></i> Admin
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('/admin/users') }}">
                                <i class="fas fa-users me-2"></i> Manage Users
                            </a></li>
                            <li><a class="dropdown-item" href="{{ url('/admin/roles') }}">
                                <i class="fas fa-key me-2"></i> Manage Roles
                            </a></li>
                            <li><a class="dropdown-item" href="{{ url('/admin/reports') }}">
                                <i class="fas fa-chart-bar me-2"></i> Reports
                            </a></li>
                        </ul>
                    </li>
                    @endif

                    <!-- User Dropdown -->
                    <li class="nav-item dropdown ms-3">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <div class="user-avatar me-2">
                                {{ strtoupper(substr(Auth::user()->full_name ?? 'U', 0, 1)) }}
                            </div>
                            <div class="text-start">
                                <div class="fw-bold" style="font-size: 0.9rem;">
                                    {{ Auth::user()->full_name ?? 'User' }}
                                </div>
                                <div>
                                    @php
                                        $role = Auth::user()->role->role_name ?? 'user';
                                    @endphp
                                    <span class="role-badge {{ $role }}">
                                        <i class="fas
                                            @if($role == 'admin') fa-crown
                                            @elseif($role == 'teacher') fa-chalkboard-user
                                            @else fa-user-graduate
                                            @endif me-1"></i>
                                        {{ ucfirst($role) }}
                                    </span>
                                </div>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ url('/profile') }}">
                                <i class="fas fa-user-circle me-2"></i> My Profile
                            </a></li>
                            <li><a class="dropdown-item" href="{{ url('/notifications') }}">
                                <i class="fas fa-bell me-2"></i> Notifications
                                @if(isset($unreadNotifications) && $unreadNotifications > 0)
                                    <span class="badge bg-danger rounded-pill ms-2">{{ $unreadNotifications }}</span>
                                @endif
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        @if(session('success'))
            <div class="container">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="container">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                let alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    let bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>

    @stack('scripts')
</body>
</html>
