<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Assignment System') }} - @yield('title', 'Dashboard')</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.ico') }}">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts: Inter + DM Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ========== DESIGN TOKENS ========== */
        :root {
            --indigo-50:  #EEF2FF;
            --indigo-100: #E0E7FF;
            --indigo-500: #6366F1;
            --indigo-600: #4F46E5;
            --indigo-700: #4338CA;
            --violet-500: #8B5CF6;
            --violet-600: #7C3AED;
            --emerald-500: #10B981;
            --blue-500:   #3B82F6;
            --amber-500:  #F59E0B;
            --red-500:    #EF4444;
            --red-600:    #DC2626;

            --slate-50:  #F8FAFC;
            --slate-100: #F1F5F9;
            --slate-200: #E2E8F0;
            --slate-300: #CBD5E1;
            --slate-400: #94A3B8;
            --slate-500: #64748B;
            --slate-600: #475569;
            --slate-700: #334155;
            --slate-800: #1E293B;
            --slate-900: #0F172A;

            --grad-primary: linear-gradient(135deg, var(--indigo-600) 0%, var(--violet-600) 100%);
            --grad-primary-soft: linear-gradient(135deg, var(--indigo-50) 0%, #EDE9FE 100%);

            --shadow-sm:  0 1px 3px rgba(15,23,42,0.06), 0 1px 2px rgba(15,23,42,0.04);
            --shadow-md:  0 4px 16px rgba(15,23,42,0.08), 0 2px 6px rgba(15,23,42,0.05);
            --shadow-lg:  0 12px 32px rgba(15,23,42,0.10), 0 4px 12px rgba(15,23,42,0.06);
            --shadow-indigo: 0 4px 14px rgba(79, 70, 229, 0.28);

            --radius-sm:  8px;
            --radius-md:  12px;
            --radius-lg:  18px;
            --radius-xl:  24px;

            --header-height: 68px;
            --sidebar-width: 240px;

            --font-display: 'DM Sans', 'Inter', sans-serif;
            --font-body:    'Inter', sans-serif;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: var(--font-body);
            background: var(--slate-50);
            color: var(--slate-800);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
        }

        /* ========== TOPNAV ========== */
        .topnav {
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--slate-200);
            height: var(--header-height);
            position: sticky;
            top: 0;
            z-index: 1040;
            display: flex;
            align-items: center;
        }

        .topnav .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        /* Brand */
        .brand {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.25rem;
            letter-spacing: -0.03em;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--slate-900);
        }

        .brand-icon {
            width: 34px;
            height: 34px;
            border-radius: var(--radius-sm);
            background: var(--grad-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.9rem;
            flex-shrink: 0;
            box-shadow: var(--shadow-indigo);
        }

        .brand span {
            background: var(--grad-primary);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        /* Nav actions */
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-icon-btn {
            width: 38px;
            height: 38px;
            border-radius: var(--radius-sm);
            border: none;
            background: transparent;
            color: var(--slate-500);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.15s, color 0.15s;
            position: relative;
            text-decoration: none;
        }

        .nav-icon-btn:hover {
            background: var(--slate-100);
            color: var(--slate-800);
        }

        .nav-icon-btn .dot {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 7px;
            height: 7px;
            background: var(--red-500);
            border-radius: 50%;
            border: 2px solid white;
        }

        /* User dropdown trigger */
        .user-chip {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 5px 12px 5px 5px;
            border-radius: 40px;
            border: 1.5px solid var(--slate-200);
            background: white;
            cursor: pointer;
            transition: all 0.15s;
            text-decoration: none;
        }

        .user-chip:hover {
            border-color: var(--indigo-500);
            box-shadow: 0 0 0 3px var(--indigo-50);
        }

        .user-chip[aria-expanded="true"] {
            border-color: var(--indigo-500);
            box-shadow: 0 0 0 3px var(--indigo-50);
        }

        /* Avatar */
        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 0.8rem;
            color: white;
            flex-shrink: 0;
            background-size: cover;
            background-position: center;
        }

        .avatar-lg {
            width: 42px;
            height: 42px;
            font-size: 1rem;
        }

        .avatar-ring-admin   { box-shadow: 0 0 0 2px white, 0 0 0 4px var(--red-500); }
        .avatar-ring-teacher { box-shadow: 0 0 0 2px white, 0 0 0 4px var(--emerald-500); }
        .avatar-ring-student { box-shadow: 0 0 0 2px white, 0 0 0 4px var(--blue-500); }

        .user-chip-info {
            display: none;
        }

        @media (min-width: 768px) {
            .user-chip-info {
                display: block;
                line-height: 1;
            }
            .user-chip-info .name {
                font-size: 0.8125rem;
                font-weight: 600;
                color: var(--slate-800);
            }
        }

        /* Role badges */
        .role-pill {
            display: inline-flex;
            align-items: center;
            font-size: 0.625rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            padding: 2px 7px;
            border-radius: 20px;
        }
        .role-pill.admin   { background: #FEE2E2; color: var(--red-600); }
        .role-pill.teacher { background: #D1FAE5; color: #059669; }
        .role-pill.student { background: var(--indigo-100); color: var(--indigo-600); }

        /* Dropdown */
        .topnav .dropdown-menu {
            border: 1px solid var(--slate-200);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            padding: 6px;
            min-width: 220px;
            margin-top: 8px !important;
            animation: dropIn 0.15s ease;
        }

        @keyframes dropIn {
            from { opacity: 0; transform: translateY(-6px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .dropdown-header-card {
            padding: 10px 12px 12px;
            margin-bottom: 4px;
            border-bottom: 1px solid var(--slate-100);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dropdown-header-card .info .name {
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--slate-800);
            line-height: 1.3;
        }

        .topnav .dropdown-item {
            border-radius: var(--radius-sm);
            padding: 9px 12px;
            font-size: 0.8125rem;
            color: var(--slate-700);
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background 0.12s, color 0.12s;
        }

        .topnav .dropdown-item i {
            width: 16px;
            text-align: center;
            color: var(--slate-400);
            transition: color 0.12s;
        }

        .topnav .dropdown-item:hover {
            background: var(--slate-100);
            color: var(--slate-900);
        }

        .topnav .dropdown-item:hover i { color: var(--indigo-500); }

        .topnav .dropdown-item.danger { color: var(--red-500); }
        .topnav .dropdown-item.danger i { color: var(--red-400); }
        .topnav .dropdown-item.danger:hover { background: #FEF2F2; color: var(--red-600); }
        .topnav .dropdown-item.danger:hover i { color: var(--red-500); }

        .topnav .dropdown-divider {
            border-color: var(--slate-100);
            margin: 4px 0;
        }

        /* Guest nav links */
        .guest-link {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--slate-600);
            text-decoration: none;
            padding: 7px 14px;
            border-radius: var(--radius-sm);
            transition: background 0.15s, color 0.15s;
        }
        .guest-link:hover { background: var(--slate-100); color: var(--slate-900); }

        .guest-link-primary {
            font-size: 0.875rem;
            font-weight: 600;
            color: white;
            text-decoration: none;
            padding: 7px 16px;
            border-radius: var(--radius-sm);
            background: var(--grad-primary);
            transition: opacity 0.15s, box-shadow 0.15s;
            box-shadow: var(--shadow-indigo);
        }
        .guest-link-primary:hover { opacity: 0.9; color: white; }

        /* ========== ALERTS ========== */
        .alert-stack {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 1.25rem;
        }

        .alert {
            border: none;
            border-radius: var(--radius-md);
            padding: 0.875rem 1.125rem;
            font-size: 0.875rem;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin: 0;
        }

        .alert-icon {
            flex-shrink: 0;
            width: 20px;
            text-align: center;
            margin-top: 1px;
        }

        .alert-success { background: #ECFDF5; color: #065F46; }
        .alert-success .alert-icon { color: var(--emerald-500); }

        .alert-danger  { background: #FEF2F2; color: #7F1D1D; }
        .alert-danger  .alert-icon { color: var(--red-500); }

        .alert-warning { background: #FFFBEB; color: #78350F; }
        .alert-warning .alert-icon { color: var(--amber-500); }

        .alert .btn-close {
            margin-left: auto;
            flex-shrink: 0;
            opacity: 0.4;
        }
        .alert .btn-close:hover { opacity: 0.7; }

        .alert ul { margin: 6px 0 0 0; padding-left: 1.25rem; }
        .alert ul li { margin-bottom: 2px; }

        /* ========== SIDEBAR ========== */
        .sidebar-wrap {
            position: sticky;
            top: calc(var(--header-height) + 16px);
            height: fit-content;
        }

        .sidebar {
            background: white;
            border: 1px solid var(--slate-200);
            border-radius: var(--radius-xl);
            padding: 12px 0;
            overflow: hidden;
        }

        .sidebar-brand-strip {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 16px 14px;
            border-bottom: 1px solid var(--slate-100);
            margin-bottom: 8px;
        }

        .sidebar-brand-strip .brand-icon { width: 28px; height: 28px; font-size: 0.75rem; }

        .sidebar-brand-strip .label {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: var(--slate-400);
        }

        .sidebar-section { margin-bottom: 4px; }

        .sidebar-section-label {
            font-size: 0.625rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--slate-400);
            padding: 8px 20px 4px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 14px;
            margin: 2px 8px;
            border-radius: var(--radius-md);
            font-size: 0.8125rem;
            font-weight: 500;
            color: var(--slate-600);
            text-decoration: none;
            transition: background 0.12s, color 0.12s, box-shadow 0.12s;
            position: relative;
        }

        .sidebar-link .icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            background: var(--slate-100);
            color: var(--slate-500);
            flex-shrink: 0;
            transition: background 0.12s, color 0.12s;
        }

        .sidebar-link:hover {
            background: var(--slate-50);
            color: var(--slate-900);
        }

        .sidebar-link:hover .icon {
            background: var(--indigo-50);
            color: var(--indigo-600);
        }

        .sidebar-link.active {
            background: var(--grad-primary-soft);
            color: var(--indigo-700);
            font-weight: 600;
        }

        .sidebar-link.active .icon {
            background: var(--grad-primary);
            color: white;
            box-shadow: var(--shadow-indigo);
        }

        .sidebar-link.danger { color: var(--red-500); }
        .sidebar-link.danger .icon { background: #FEE2E2; color: var(--red-500); }
        .sidebar-link.danger:hover { background: #FEF2F2; color: var(--red-600); }
        .sidebar-link.danger:hover .icon { background: #FECACA; }

        .sidebar-divider {
            border: none;
            border-top: 1px solid var(--slate-100);
            margin: 6px 14px;
        }

        /* Mobile sidebar toggle */
        .sidebar-mobile-toggle {
            display: none;
            width: 100%;
            padding: 10px 14px;
            margin-bottom: 10px;
            background: white;
            border: 1.5px solid var(--slate-200);
            border-radius: var(--radius-md);
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--slate-700);
            cursor: pointer;
            align-items: center;
            gap: 8px;
            transition: border-color 0.15s;
        }
        .sidebar-mobile-toggle:hover { border-color: var(--indigo-400); }
        .sidebar-mobile-toggle i { color: var(--indigo-500); }
        .sidebar-mobile-toggle .chevron { margin-left: auto; color: var(--slate-400); transition: transform 0.2s; }
        .sidebar-mobile-toggle.open .chevron { transform: rotate(180deg); }

        /* ========== MAIN LAYOUT ========== */
        main {
            flex: 1;
            padding: 28px 0;
        }

        /* ========== GLOBAL BUTTONS ========== */
        .btn-primary {
            background: var(--grad-primary);
            border: none;
            font-weight: 600;
            border-radius: var(--radius-sm);
            transition: opacity 0.15s, box-shadow 0.15s, transform 0.15s;
            box-shadow: var(--shadow-indigo);
        }
        .btn-primary:hover {
            opacity: 0.92;
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.35);
            transform: translateY(-1px);
        }

        /* ========== FOOTER ========== */
        .footer {
            background: white;
            border-top: 1px solid var(--slate-200);
            padding: 20px 0;
        }
        .footer-text {
            font-size: 0.8125rem;
            color: var(--slate-400);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        .footer-text i { color: var(--indigo-400); }

        /* ========== SCROLLBAR ========== */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--slate-300); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--slate-400); }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .sidebar-mobile-toggle { display: flex; }
            .sidebar { display: none; }
            .sidebar.show { display: block; }
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- ===== TOPNAV ===== -->
    <header class="topnav">
        <div class="container">
            <a class="brand" href="{{ route('dashboard') }}">
                <div class="brand-icon"><i class="fas fa-graduation-cap"></i></div>
                <span>{{ config('app.name', 'Assignment') }}</span>
            </a>

            <div class="nav-actions">
                @auth
                    {{-- Notification bell --}}
                    <a href="{{ route('notifications.index') }}" class="nav-icon-btn" title="Notifications">
                        <i class="fas fa-bell"></i>
                        @if(isset($unreadNotifications) && $unreadNotifications > 0)
                            <span class="dot"></span>
                        @endif
                    </a>

                    {{-- User chip / dropdown --}}
                    @php
                        $user = Auth::user();
                        $hasAvatar = $user->avatar && file_exists(storage_path('app/public/' . $user->avatar));
                        $avatarRingClass = match($user->role_id) {
                            1 => 'avatar-ring-admin',
                            2 => 'avatar-ring-teacher',
                            3 => 'avatar-ring-student',
                            default => '',
                        };
                        $avatarColor = $user->avatar_color ?? match($user->role_id) {
                            1 => 'linear-gradient(135deg, #ef4444, #dc2626)',
                            2 => 'linear-gradient(135deg, #10b981, #059669)',
                            3 => 'linear-gradient(135deg, #6366f1, #4f46e5)',
                            default => 'linear-gradient(135deg, #64748b, #475569)',
                        };
                        $initials = '';
                        foreach (explode(' ', $user->full_name ?? 'U') as $w) {
                            if (!empty($w)) $initials .= strtoupper($w[0]);
                        }
                        $initials = substr($initials, 0, 2);
                        $roleName  = $user->role->role_name ?? 'student';
                        $roleClass = match($roleName) { 'admin' => 'admin', 'teacher' => 'teacher', default => 'student' };
                    @endphp

                    <div class="dropdown">
                        <a class="user-chip" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            @if($hasAvatar)
                                <div class="avatar {{ $avatarRingClass }}" style="background-image: url('{{ asset('storage/' . $user->avatar) }}');"></div>
                            @else
                                <div class="avatar {{ $avatarRingClass }}" style="background: {{ $avatarColor }};">{{ $initials }}</div>
                            @endif
                            <div class="user-chip-info">
                                <div class="name">{{ $user->full_name ?? 'User' }}</div>
                                <span class="role-pill {{ $roleClass }}">{{ ucfirst($roleName) }}</span>
                            </div>
                            <i class="fas fa-chevron-down ms-1" style="font-size:0.65rem; color: var(--slate-400);"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <div class="dropdown-header-card">
                                    @if($hasAvatar)
                                        <div class="avatar avatar-lg {{ $avatarRingClass }}" style="background-image: url('{{ asset('storage/' . $user->avatar) }}');"></div>
                                    @else
                                        <div class="avatar avatar-lg {{ $avatarRingClass }}" style="background: {{ $avatarColor }};">{{ $initials }}</div>
                                    @endif
                                    <div class="info">
                                        <div class="name">{{ $user->full_name ?? 'User' }}</div>
                                        <span class="role-pill {{ $roleClass }}">{{ ucfirst($roleName) }}</span>
                                    </div>
                                </div>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('profile.index') }}"><i class="fas fa-user-circle"></i> My Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('notifications.index') }}">
                                <i class="fas fa-bell"></i> Notifications
                                @if(isset($unreadNotifications) && $unreadNotifications > 0)
                                    <span class="badge bg-danger rounded-pill ms-auto">{{ $unreadNotifications }}</span>
                                @endif
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item danger" style="background:none; border:none; width:100%; text-align:left; cursor:pointer;">
                                        <i class="fas fa-sign-out-alt"></i> Sign out
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a class="guest-link" href="{{ route('login') }}">Sign in</a>
                    <a class="guest-link-primary" href="{{ route('register') }}">Get started</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- ===== MAIN ===== -->
    <main>
        {{-- Alerts --}}
        @if(session('success') || session('error') || $errors->any())
            <div class="container mb-0">
                <div class="alert-stack">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <span class="alert-icon"><i class="fas fa-circle-check"></i></span>
                            <div>{{ session('success') }}</div>
                            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible">
                            <span class="alert-icon"><i class="fas fa-circle-xmark"></i></span>
                            <div>{{ session('error') }}</div>
                            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-warning alert-dismissible">
                            <span class="alert-icon"><i class="fas fa-triangle-exclamation"></i></span>
                            <div>
                                <strong>Please fix these errors:</strong>
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        @auth
            @if(Auth::user()->role_id == 1 && !request()->routeIs('dashboard'))
                {{-- Admin: sidebar + content --}}
                <div class="container-fluid px-3 px-lg-4">
                    <div class="row g-4">
                        <div class="col-md-3 col-xl-2">
                            {{-- Mobile toggle --}}
                            <button class="sidebar-mobile-toggle" id="sidebarToggle" type="button">
                                <i class="fas fa-bars"></i>
                                <span>Navigation</span>
                                <i class="fas fa-chevron-down chevron"></i>
                            </button>

                            {{-- Sidebar --}}
                            <div class="sidebar-wrap">
                                <nav class="sidebar" id="adminSidebar" aria-label="Admin navigation">
                                    <div class="sidebar-brand-strip">
                                        <div class="brand-icon"><i class="fas fa-graduation-cap"></i></div>
                                        <span class="label">Admin Panel</span>
                                    </div>

                                    <div class="sidebar-section">
                                        <div class="sidebar-section-label">Main</div>
                                        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                            <span class="icon"><i class="fas fa-house"></i></span>
                                            Dashboard
                                        </a>
                                        <a href="{{ route('courses.index') }}" class="sidebar-link {{ request()->routeIs('courses.*') ? 'active' : '' }}">
                                            <span class="icon"><i class="fas fa-book-open"></i></span>
                                            Courses
                                        </a>
                                        <a href="{{ route('assignments.index') }}" class="sidebar-link {{ request()->routeIs('assignments.*') ? 'active' : '' }}">
                                            <span class="icon"><i class="fas fa-clipboard-list"></i></span>
                                            Assignments
                                        </a>
                                    </div>

                                    <div class="sidebar-section">
                                        <div class="sidebar-section-label">Manage</div>
                                        <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                            <span class="icon"><i class="fas fa-users"></i></span>
                                            Users
                                        </a>
                                        <a href="{{ route('admin.roles.index') }}" class="sidebar-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                                            <span class="icon"><i class="fas fa-shield-halved"></i></span>
                                            Roles
                                        </a>
                                        <a href="{{ route('admin.reports.index') }}" class="sidebar-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                                            <span class="icon"><i class="fas fa-chart-bar"></i></span>
                                            Reports
                                        </a>
                                    </div>

                                    <hr class="sidebar-divider">

                                    <div class="sidebar-section">
                                        <div class="sidebar-section-label">Account</div>
                                        <a href="{{ route('profile.index') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                                            <span class="icon"><i class="fas fa-user-circle"></i></span>
                                            Profile
                                        </a>
                                        <a href="{{ route('notifications.index') }}" class="sidebar-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
                                            <span class="icon"><i class="fas fa-bell"></i></span>
                                            Notifications
                                            @if(isset($unreadNotifications) && $unreadNotifications > 0)
                                                <span class="ms-auto badge bg-danger rounded-pill" style="font-size:0.65rem;">{{ $unreadNotifications }}</span>
                                            @endif
                                        </a>
                                        <a href="#" class="sidebar-link danger"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                                            Sign out
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
                                    </div>
                                </nav>
                            </div>
                        </div>

                        <div class="col-md-9 col-xl-10">
                            @yield('content')
                        </div>
                    </div>
                </div>
            @else
                <div class="container">
                    @yield('content')
                </div>
            @endif
        @else
            <div class="container">
                @yield('content')
            </div>
        @endauth
    </main>

    <!-- ===== FOOTER ===== -->
    <footer class="footer">
        <div class="container">
            <p class="footer-text mb-0">
                <i class="fas fa-graduation-cap"></i>
                &copy; {{ date('Y') }} {{ config('app.name', 'Assignment System') }} &mdash; All rights reserved.
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Auto-dismiss alerts after 5s
            setTimeout(() => {
                document.querySelectorAll('.alert-dismissible').forEach(el => {
                    try { new bootstrap.Alert(el).close(); } catch(e) {}
                });
            }, 5000);

            // Mobile sidebar toggle
            const toggleBtn = document.getElementById('sidebarToggle');
            const sidebar   = document.getElementById('adminSidebar');
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', () => {
                    const isOpen = sidebar.classList.toggle('show');
                    toggleBtn.classList.toggle('open', isOpen);
                    toggleBtn.querySelector('span').textContent = isOpen ? 'Close menu' : 'Navigation';
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
