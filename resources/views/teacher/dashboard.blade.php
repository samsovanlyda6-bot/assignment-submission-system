@extends('layouts.app')

@section('title', 'Teacher Dashboard')

@section('content')
<div class="dashboard-container">
    <div class="dashboard-layout">
        <!-- Sidebar (unchanged) -->
        <aside class="dashboard-sidebar">
            <div class="sidebar-header">
                <div class="avatar-circle">
                    {{ strtoupper(substr(Auth::user()->full_name, 0, 1)) }}
                </div>
                <h5 class="mt-3 mb-0">{{ Auth::user()->full_name }}</h5>
                <span class="badge role-badge teacher mt-2">
                    <i class="fas fa-chalkboard-user me-1"></i> Teacher
                </span>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('teacher.dashboard') }}" class="nav-item active">
                    <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
                </a>
                <a href="{{ route('courses.index') }}" class="nav-item">
                    <i class="fas fa-book-open"></i> <span>My Courses</span>
                </a>
                <a href="{{ route('assignments.index') }}" class="nav-item">
                    <i class="fas fa-list-check"></i> <span>Assignments</span>
                </a>
                <a href="{{ route('submissions.index') }}" class="nav-item">
                    <i class="fas fa-paper-plane"></i> <span>Submissions</span>
                </a>
                <a href="{{ route('grades.index') }}" class="nav-item">
                    <i class="fas fa-star"></i> <span>Grading</span>
                </a>
                <a href="{{ route('enrollments.index') }}" class="nav-item">
                    <i class="fas fa-users"></i> <span>Enrollments</span>
                </a>
                <hr class="mx-3 my-2">
                <a href="{{ route('profile.index') }}" class="nav-item">
                    <i class="fas fa-user-circle"></i> <span>Profile</span>
                </a>
                <a href="{{ route('notifications.index') }}" class="nav-item">
                    <i class="fas fa-bell"></i> <span>Notifications</span>
                    @if(isset($unreadNotifications) && $unreadNotifications > 0)
                        <span class="badge bg-danger">{{ $unreadNotifications }}</span>
                    @endif
                </a>
                <a href="{{ route('logout') }}" class="nav-item text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <hr class="mx-3">
                <div class="px-3 pb-3">
                    <div class="small text-muted">
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-chalkboard-user me-1"></i> Role:</span>
                            <span class="fw-bold text-primary">Teacher</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span><i class="fas fa-calendar-week me-1"></i> Since:</span>
                            <span class="fw-bold">{{ Auth::user()->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="dashboard-main">
            <!-- Welcome Banner (unchanged) -->
            <div class="welcome-banner mb-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="fw-bold mb-2">
                            <i class="fas fa-hand-peace me-2"></i> Welcome back, {{ Auth::user()->full_name }}!
                        </h2>
                        <p class="mb-0">Manage your courses, assignments, and track student progress from your teacher dashboard.</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <i class="fas fa-chalkboard-user fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>

            <!-- Stats Cards (unchanged) -->
            <div class="stats-grid mb-4">
                <div class="stat-card">
                    <div class="stat-icon bg-primary"><i class="fas fa-book-open"></i></div>
                    <div><h3 class="stat-number">{{ $myCourses->count() }}</h3><p class="stat-label">My Courses</p></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-success"><i class="fas fa-list-check"></i></div>
                    <div><h3 class="stat-number">{{ $totalAssignments }}</h3><p class="stat-label">Assignments</p></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-info"><i class="fas fa-paper-plane"></i></div>
                    <div><h3 class="stat-number">{{ $totalSubmissions }}</h3><p class="stat-label">Submissions</p></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-warning"><i class="fas fa-hourglass-half"></i></div>
                    <div><h3 class="stat-number">{{ $pendingGrading }}</h3><p class="stat-label">Pending Grading</p></div>
                </div>
            </div>

            <!-- IMPROVED MY COURSES SECTION -->
            <div class="section-card mb-4">
                <div class="section-header">
                    <h5><i class="fas fa-book-open me-2 text-primary"></i> My Courses</h5>
                    <a href="{{ route('courses.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i> New Course
                    </a>
                </div>
                <div class="row g-4">
                    @forelse($myCourses as $course)
                        @php
                            $totalAssignments = $course->assignments->count();
                            $publishedAssignments = $course->assignments->where('status', 'Published')->count();
                            $enrolledCount = $course->enrollments->count();
                            $progress = $totalAssignments > 0 ? round(($publishedAssignments / $totalAssignments) * 100) : 0;
                        @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="course-card h-100">
                                <div class="course-card-header">
                                    <div class="course-icon">
                                        <i class="fas fa-chalkboard"></i>
                                    </div>
                                    <div class="course-status">
                                        @if($course->status === 'Active')
                                            <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Active</span>
                                        @else
                                            <span class="badge bg-secondary"><i class="fas fa-pause me-1"></i> Inactive</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="course-card-body">
                                    <h6 class="course-title">{{ $course->course_name }}</h6>
                                    <div class="course-code">{{ $course->course_code }}</div>
                                    <p class="course-description">{{ Str::limit($course->description ?? 'No description', 80) }}</p>
                                    <div class="course-stats">
                                        <div class="stat-item">
                                            <i class="fas fa-users"></i>
                                            <span>{{ $enrolledCount }} students</span>
                                        </div>
                                        <div class="stat-item">
                                            <i class="fas fa-tasks"></i>
                                            <span>{{ $totalAssignments }} assignments</span>
                                        </div>
                                    </div>
                                    @if($totalAssignments > 0)
                                        <div class="progress-wrapper mt-2">
                                            <div class="progress-label">
                                                <small>Published</small>
                                                <small>{{ $progress }}%</small>
                                            </div>
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-primary" style="width: {{ $progress }}%"></div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="course-card-footer">
                                    <a href="{{ route('courses.show', $course->course_id) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i> View
                                    </a>
                                    <a href="{{ route('assignments.index', ['course_id' => $course->course_id]) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-tasks me-1"></i> Tasks
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-book fa-3x text-muted mb-3 opacity-25"></i>
                            <p class="text-muted">No courses yet</p>
                            <a href="{{ route('courses.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i> Create Course
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- The rest of the dashboard (Recent Assignments, Submissions, Deadlines) remains unchanged -->
            <!-- Recent Activity Row -->
            <div class="row g-4 mb-4">
                <div class="col-lg-6">
                    <div class="section-card">
                        <div class="section-header">
                            <h5><i class="fas fa-clock me-2 text-info"></i> Recent Assignments</h5>
                            <a href="{{ route('assignments.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                        @forelse($myAssignments as $assignment)
                            <div class="activity-item">
                                <div>
                                    <strong>{{ $assignment->title }}</strong>
                                    <div class="small text-muted">
                                        <i class="fas fa-calendar-alt me-1"></i> Due: {{ $assignment->due_date->format('M d, Y') }}
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-info rounded-pill">
                                        <i class="fas fa-paper-plane me-1"></i> {{ $assignment->submissions_count ?? $assignment->submissions->count() }} subs
                                    </span>
                                    <div class="small text-warning">
                                        {{ $assignment->submissions()->whereDoesntHave('grade')->count() }} pending
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted text-center py-3">No assignments created yet</p>
                        @endforelse
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="section-card">
                        <div class="section-header">
                            <h5><i class="fas fa-paper-plane me-2 text-warning"></i> Recent Submissions</h5>
                            <a href="{{ route('submissions.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                        @forelse($recentSubmissions as $submission)
                            <div class="activity-item">
                                <div>
                                    <strong>{{ $submission->assignment->title ?? 'N/A' }}</strong>
                                    <div class="small text-muted">
                                        <i class="fas fa-user-graduate me-1"></i> {{ $submission->student->full_name ?? 'Student' }} • {{ $submission->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                @if($submission->grade)
                                    <span class="badge bg-success rounded-pill">
                                        <i class="fas fa-check-circle me-1"></i> Graded
                                    </span>
                                @else
                                    <a href="{{ route('grades.create') }}?submission_id={{ $submission->submission_id }}" class="btn btn-sm btn-primary rounded-pill">
                                        <i class="fas fa-star me-1"></i> Grade
                                    </a>
                                @endif
                            </div>
                        @empty
                            <p class="text-muted text-center py-3">No submissions yet</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Upcoming Deadlines -->
            <div class="section-card">
                <div class="section-header">
                    <h5><i class="fas fa-calendar-alt me-2 text-danger"></i> Upcoming Deadlines</h5>
                    <a href="{{ route('assignments.index') }}" class="btn btn-sm btn-outline-primary">Manage</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th><i class="fas fa-file-alt me-1"></i> Assignment</th>
                                <th><i class="fas fa-book me-1"></i> Course</th>
                                <th><i class="fas fa-calendar me-1"></i> Due Date</th>
                                <th><i class="fas fa-paper-plane me-1"></i> Submissions</th>
                                <th><i class="fas fa-hourglass-half me-1"></i> Pending</th>
                                <th><i class="fas fa-cog me-1"></i> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($upcomingDeadlines as $assignment)
                                @php
                                    $daysLeft = now()->diffInDays($assignment->due_date, false);
                                    $roundedDays = floor(abs($daysLeft));

                                    if ($daysLeft < 0) {
                                        $rowClass = 'table-danger';
                                        $statusText = 'Overdue';
                                        $badgeClass = 'danger';
                                    } elseif ($daysLeft == 0) {
                                        $rowClass = 'table-danger';
                                        $statusText = 'Due today';
                                        $badgeClass = 'danger';
                                    } elseif ($daysLeft == 1) {
                                        $rowClass = 'table-warning';
                                        $statusText = 'Tomorrow';
                                        $badgeClass = 'warning';
                                    } elseif ($daysLeft <= 3) {
                                        $rowClass = 'table-danger';
                                        $statusText = $roundedDays . ' days left';
                                        $badgeClass = 'danger';
                                    } elseif ($daysLeft <= 7) {
                                        $rowClass = 'table-warning';
                                        $statusText = $roundedDays . ' days left';
                                        $badgeClass = 'warning';
                                    } else {
                                        $rowClass = '';
                                        $statusText = $roundedDays . ' days left';
                                        $badgeClass = 'success';
                                    }
                                @endphp
                                <tr class="{{ $rowClass }}">
                                    <td class="fw-bold">{{ $assignment->title }}</td>
                                    <td>{{ $assignment->course->course_name ?? 'N/A' }}</td>
                                    <td>
                                        <i class="fas fa-calendar-alt me-1"></i> {{ $assignment->due_date->format('M d, H:i') }}
                                        <br>
                                        <span class="badge bg-{{ $badgeClass }} mt-1">{{ $statusText }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info rounded-pill">{{ $assignment->submissions_count ?? $assignment->submissions->count() }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-warning rounded-pill">{{ $assignment->submissions()->whereDoesntHave('grade')->count() }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('grades.by-assignment', $assignment->assignment_id) }}" class="btn btn-sm btn-primary rounded-pill">
                                            <i class="fas fa-star me-1"></i> Grade
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="fas fa-calendar-check fa-2x mb-2 opacity-25 d-block"></i>
                                        No upcoming deadlines
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<style>
/* ========== GLOBAL DASHBOARD STYLES ========== */
.dashboard-container {
    min-height: calc(100vh - 56px);
}

.dashboard-layout {
    display: flex;
    background: #f8fafc;
    min-height: calc(100vh - 56px);
}

/* Sidebar (unchanged) */
.dashboard-sidebar {
    width: 280px;
    background: #ffffff;
    display: flex;
    flex-direction: column;
    position: sticky;
    top: 56px;
    height: calc(100vh - 56px);
    border-right: 1px solid #e2e8f0;
    box-shadow: 2px 0 12px rgba(0, 0, 0, 0.02);
}

.sidebar-header {
    padding: 28px 20px;
    text-align: center;
    border-bottom: 1px solid #edf2f7;
}

.avatar-circle {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    font-weight: 700;
    color: white;
    margin: 0 auto;
    box-shadow: 0 6px 14px rgba(79, 70, 229, 0.25);
}

.role-badge {
    padding: 5px 16px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.role-badge.teacher { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: white; }

.sidebar-nav {
    flex: 1;
    padding: 20px 12px;
}

.nav-item {
    display: flex;
    align-items: center;
    padding: 10px 16px;
    margin: 4px 0;
    color: #334155;
    text-decoration: none;
    border-radius: 14px;
    transition: all 0.2s ease;
    font-size: 0.9rem;
    font-weight: 500;
}

.nav-item i {
    width: 24px;
    font-size: 1.1rem;
    margin-right: 12px;
}

.nav-item:hover {
    background: #f1f5f9;
    color: #4f46e5;
    transform: translateX(4px);
}

.nav-item.active {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
}

.nav-item.active i,
.nav-item.active span {
    color: white;
}

.nav-item .badge {
    margin-left: auto;
    background: #ef4444;
}

.sidebar-footer {
    border-top: 1px solid #edf2f7;
    padding: 12px 0;
}

/* Main Content */
.dashboard-main {
    flex: 1;
    padding: 28px 32px;
    overflow-y: auto;
}

/* Welcome Banner */
.welcome-banner {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    border-radius: 24px;
    padding: 28px 32px;
    color: white;
    box-shadow: 0 8px 20px rgba(79, 70, 229, 0.2);
}

/* Stats Cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

.stat-card {
    background: white;
    border-radius: 24px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    transition: all 0.3s ease;
    border: 1px solid #f0f2f5;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.08);
    border-color: transparent;
}

.stat-icon {
    width: 55px;
    height: 55px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: white;
}

.stat-icon.bg-primary { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); }
.stat-icon.bg-success { background: #10b981; }
.stat-icon.bg-info { background: #06b6d4; }
.stat-icon.bg-warning { background: #f59e0b; }

.stat-number {
    font-size: 32px;
    font-weight: 800;
    margin-bottom: 4px;
    color: #1e293b;
}

.stat-label {
    color: #64748b;
    font-size: 11px;
    margin-bottom: 0;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    font-weight: 600;
}

/* Section Card (generic) */
.section-card {
    background: white;
    border-radius: 24px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    border: 1px solid #f0f2f5;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 1px solid #edf2f7;
}

.section-header h5 {
    margin-bottom: 0;
    font-weight: 700;
    font-size: 1rem;
    color: #1e293b;
}

/* ========== IMPROVED COURSE CARDS ========== */
.course-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    border: 1px solid #f0f2f5;
    display: flex;
    flex-direction: column;
}

.course-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 30px -12px rgba(0,0,0,0.12);
    border-color: transparent;
}

.course-card-header {
    padding: 16px 16px 8px 16px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.course-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.4rem;
    box-shadow: 0 6px 12px rgba(79, 70, 229, 0.2);
}

.course-status .badge {
    font-size: 0.7rem;
    padding: 5px 10px;
    border-radius: 30px;
}

.course-card-body {
    padding: 8px 16px 12px;
    flex: 1;
}

.course-title {
    font-size: 1rem;
    font-weight: 700;
    margin-bottom: 4px;
    color: #1e293b;
}

.course-code {
    font-size: 0.7rem;
    font-family: monospace;
    background: #f1f5f9;
    display: inline-block;
    padding: 2px 8px;
    border-radius: 20px;
    color: #4f46e5;
    margin-bottom: 10px;
}

.course-description {
    font-size: 0.8rem;
    color: #64748b;
    line-height: 1.4;
    margin-bottom: 12px;
}

.course-stats {
    display: flex;
    gap: 16px;
    margin-bottom: 12px;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.75rem;
    color: #475569;
    background: #f8fafc;
    padding: 4px 12px;
    border-radius: 30px;
}

.stat-item i {
    font-size: 0.75rem;
    color: #4f46e5;
}

.progress-wrapper {
    margin-top: 8px;
}

.progress-label {
    display: flex;
    justify-content: space-between;
    font-size: 0.65rem;
    color: #64748b;
    margin-bottom: 4px;
}

.course-card-footer {
    padding: 12px 16px 16px;
    display: flex;
    gap: 10px;
    border-top: 1px solid #f0f2f5;
    background: #fafbfc;
}

.course-card-footer .btn {
    flex: 1;
    font-size: 0.75rem;
    padding: 6px 0;
    border-radius: 30px;
}

/* Activity items (unchanged) */
.activity-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 0;
    border-bottom: 1px solid #f0f2f5;
}
.activity-item:last-child { border-bottom: none; }

/* Table styles (unchanged) */
.table th {
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    font-weight: 700;
    color: #475569;
    padding: 12px 8px;
}
.table td {
    vertical-align: middle;
    padding: 12px 8px;
    font-size: 0.85rem;
}

/* Button improvements */
.btn-primary {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    border: none;
    font-weight: 500;
    padding: 6px 14px;
    border-radius: 30px;
    transition: all 0.2s ease;
}
.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
}
.btn-outline-primary {
    border-radius: 30px;
    border-color: #4f46e5;
    color: #4f46e5;
}
.btn-outline-primary:hover {
    background: #4f46e5;
    color: white;
    border-color: #4f46e5;
}

/* Responsive */
@media (max-width: 992px) {
    .dashboard-sidebar { width: 80px; }
    .sidebar-header h5, .sidebar-header .role-badge, .nav-item span, .sidebar-footer { display: none; }
    .nav-item i { margin-right: 0; }
    .nav-item { justify-content: center; }
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 768px) {
    .dashboard-layout { flex-direction: column; }
    .dashboard-sidebar { width: 100%; height: auto; position: relative; top: 0; flex-direction: row; flex-wrap: wrap; padding: 10px; align-items: center; }
    .sidebar-header { display: none; }
    .sidebar-nav { display: flex; flex-wrap: wrap; justify-content: center; padding: 0; }
    .nav-item { padding: 8px 12px; margin: 4px; border-radius: 40px; }
    .nav-item span { display: inline; margin-left: 8px; }
    .dashboard-main { padding: 20px; }
    .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 15px; }
    .welcome-banner h2 { font-size: 1.3rem; }
    .welcome-banner { padding: 20px; }
}
</style>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
@endsection
