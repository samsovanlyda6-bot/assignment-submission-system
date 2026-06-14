@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="admin-dashboard">
    <!-- Welcome Section (refined) -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="welcome-card">
                <div class="welcome-content">
                    <h2 class="welcome-title">
                        <i class="fas fa-crown me-2"></i> Welcome back, {{ Auth::user()->full_name }}!
                    </h2>
                    <p class="welcome-text">
                        Here's your complete overview of the Assignment Submission System.
                    </p>
                </div>
                <div class="welcome-icon">
                    <i class="fas fa-chalkboard-user"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards - Row 1 -->
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-card-icon purple">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-card-info">
                    <h6 class="stat-label">Total Users</h6>
                    <h2 class="stat-number">{{ $totalUsers }}</h2>
                    <span class="stat-trend up">
                        <i class="fas fa-arrow-up me-1"></i> +{{ $newUsersThisMonth }} this month
                    </span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-card-icon green">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="stat-card-info">
                    <h6 class="stat-label">Total Students</h6>
                    <h2 class="stat-number">{{ $totalStudents }}</h2>
                    <span class="stat-trend neutral">
                        <i class="fas fa-user-graduate me-1"></i> Active learners
                    </span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-card-icon blue">
                    <i class="fas fa-chalkboard-user"></i>
                </div>
                <div class="stat-card-info">
                    <h6 class="stat-label">Total Teachers</h6>
                    <h2 class="stat-number">{{ $totalTeachers }}</h2>
                    <span class="stat-trend neutral">
                        <i class="fas fa-chalkboard-user me-1"></i> Educators
                    </span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-card-icon orange">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stat-card-info">
                    <h6 class="stat-label">Active Courses</h6>
                    <h2 class="stat-number">{{ $totalCourses }}</h2>
                    <span class="stat-trend neutral">
                        <i class="fas fa-book me-1"></i> Available
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards - Row 2 -->
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-card-icon red">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="stat-card-info">
                    <h6 class="stat-label">Total Assignments</h6>
                    <h2 class="stat-number">{{ $totalAssignments }}</h2>
                    <span class="stat-trend neutral">Created</span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-card-icon teal">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <div class="stat-card-info">
                    <h6 class="stat-label">Total Submissions</h6>
                    <h2 class="stat-number">{{ $totalSubmissions }}</h2>
                    <span class="stat-trend up">
                        <i class="fas fa-check-circle me-1"></i> {{ $gradedSubmissions }} graded
                    </span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-card-icon yellow">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div class="stat-card-info">
                    <h6 class="stat-label">Pending Grading</h6>
                    <h2 class="stat-number">{{ $pendingGrading }}</h2>
                    <span class="stat-trend neutral">Awaiting review</span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-card-icon indigo">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-card-info">
                    <h6 class="stat-label">Average Score</h6>
                    <h2 class="stat-number">{{ round($averageScore) }}%</h2>
                    <span class="stat-trend neutral">Overall performance</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-5">
        <div class="col-lg-6">
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">
                        <i class="fas fa-chart-bar me-2 text-primary"></i> Submissions by Course
                    </h5>
                </div>
                <div class="chart-body">
                    <canvas id="submissionsChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">
                        <i class="fas fa-chart-pie me-2 text-success"></i> Grade Distribution
                    </h5>
                </div>
                <div class="chart-body">
                    <canvas id="gradesChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Row -->
    <div class="row g-4 mb-5">
        <div class="col-lg-6">
            <div class="activity-card">
                <div class="activity-header">
                    <h5 class="activity-title">
                        <i class="fas fa-users me-2 text-primary"></i> Recent Users
                    </h5>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="activity-body">
                    @forelse($recentUsers as $user)
                        <div class="activity-item">
                            <div class="activity-avatar" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div class="activity-info">
                                <h6 class="activity-name">{{ $user->full_name }}</h6>
                                <span class="activity-meta">{{ $user->email }} • {{ ucfirst($user->role->role_name ?? 'User') }}</span>
                            </div>
                            <span class="activity-time">{{ $user->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">No recent users</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="activity-card">
                <div class="activity-header">
                    <h5 class="activity-title">
                        <i class="fas fa-clock me-2 text-warning"></i> Recent Submissions
                    </h5>
                    <a href="{{ route('submissions.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="activity-body">
                    @forelse($recentSubmissions as $submission)
                        <div class="activity-item">
                            <div class="activity-avatar" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                                <i class="fas fa-paper-plane text-white"></i>
                            </div>
                            <div class="activity-info">
                                <h6 class="activity-name">{{ $submission->assignment->title ?? 'N/A' }}</h6>
                                <span class="activity-meta">by {{ $submission->student->full_name ?? 'Student' }} • {{ $submission->created_at->diffForHumans() }}</span>
                            </div>
                            <div>
                                @if($submission->grade)
                                    <span class="badge bg-success">Graded</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">No recent submissions</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Grade Distribution Details -->
    <div class="row">
        <div class="col-12">
            <div class="details-card">
                <div class="details-header">
                    <h5 class="details-title">
                        <i class="fas fa-chart-simple me-2 text-info"></i> Grade Distribution Details
                    </h5>
                </div>
                <div class="details-body">
                    <div class="row g-4">
                        @foreach($gradeLabels as $index => $grade)
                            @php
                                $total = $gradeData->sum();
                                $percentage = $total > 0 ? ($gradeData[$index] / $total) * 100 : 0;
                                $colors = ['success', 'info', 'warning', 'orange', 'danger'];
                                $color = $colors[$index] ?? 'secondary';
                            @endphp
                            <div class="col-md-6 mb-3">
                                <div class="grade-item">
                                    <div class="grade-label">
                                        <span class="fw-bold">Grade {{ $grade }}</span>
                                        <span class="text-muted">{{ $gradeData[$index] }} students ({{ round($percentage) }}%)</span>
                                    </div>
                                    <div class="progress mt-1" style="height: 8px;">
                                        <div class="progress-bar bg-{{ $color }}" style="width: {{ $percentage }}%;"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Submissions by Course Chart
    const ctx1 = document.getElementById('submissionsChart').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: @json($courseLabels),
            datasets: [{
                label: 'Number of Submissions',
                data: @json($submissionData),
                backgroundColor: 'rgba(102, 126, 234, 0.8)',
                borderRadius: 8,
                barPercentage: 0.6,
                categoryPercentage: 0.8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { position: 'top', labels: { font: { size: 12 } } },
                tooltip: { backgroundColor: '#1e293b', titleColor: '#f1f5f9', bodyColor: '#cbd5e1' }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: '#e2e8f0' }, ticks: { stepSize: 1 } },
                x: { grid: { display: false } }
            }
        }
    });

    // Grade Distribution Chart
    const ctx2 = document.getElementById('gradesChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: @json($gradeLabels),
            datasets: [{
                data: @json($gradeData),
                backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#f97316', '#ef4444'],
                borderWidth: 0,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { position: 'bottom', labels: { font: { size: 12 } } },
                tooltip: { backgroundColor: '#1e293b' }
            },
            cutout: '65%'
        }
    });
});
</script>
@endpush

<style>
/* Admin Dashboard Custom Styles */
.admin-dashboard {
    max-width: 1400px;
    margin: 0 auto;
}

/* Welcome Card */
.welcome-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 28px;
    padding: 28px 32px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: white;
    box-shadow: 0 12px 24px -8px rgba(102, 126, 234, 0.3);
}

.welcome-title {
    font-size: 1.6rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.welcome-text {
    font-size: 0.9rem;
    opacity: 0.9;
    margin-bottom: 0;
}

.welcome-icon i {
    font-size: 4rem;
    opacity: 0.5;
}

/* Stat Cards */
.stat-card {
    background: white;
    border-radius: 24px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    transition: all 0.3s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    border: 1px solid #f0f2f5;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 30px -12px rgba(0,0,0,0.12);
    border-color: transparent;
}

.stat-card-icon {
    width: 56px;
    height: 56px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    color: white;
}

.stat-card-icon.purple { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.stat-card-icon.green { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
.stat-card-icon.blue { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
.stat-card-icon.orange { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
.stat-card-icon.red { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
.stat-card-icon.teal { background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%); }
.stat-card-icon.yellow { background: linear-gradient(135deg, #eab308 0%, #ca8a04 100%); }
.stat-card-icon.indigo { background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); }

.stat-card-info {
    flex: 1;
}

.stat-label {
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
    color: #94a3b8;
    margin-bottom: 4px;
}

.stat-number {
    font-size: 28px;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 4px;
}

.stat-trend {
    font-size: 0.7rem;
    font-weight: 500;
}

.stat-trend.up { color: #10b981; }
.stat-trend.neutral { color: #64748b; }

/* Chart & Activity Cards */
.chart-card, .activity-card, .details-card {
    background: white;
    border-radius: 24px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    border: 1px solid #f0f2f5;
    overflow: hidden;
    transition: all 0.2s ease;
}

.chart-card:hover, .activity-card:hover, .details-card:hover {
    box-shadow: 0 8px 20px rgba(0,0,0,0.06);
}

.chart-header, .activity-header, .details-header {
    padding: 16px 20px;
    border-bottom: 1px solid #f0f2f5;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}

.chart-title, .activity-title, .details-title {
    font-size: 1rem;
    font-weight: 700;
    margin-bottom: 0;
    color: #1e293b;
}

.chart-body, .activity-body, .details-body {
    padding: 20px;
}

/* Activity Items */
.activity-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 12px 0;
    border-bottom: 1px solid #f0f2f5;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-avatar {
    width: 42px;
    height: 42px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.activity-info {
    flex: 1;
}

.activity-name {
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 4px;
    color: #1e293b;
}

.activity-meta {
    font-size: 0.7rem;
    color: #64748b;
}

.activity-time {
    font-size: 0.7rem;
    color: #94a3b8;
    white-space: nowrap;
}

/* Grade Item */
.grade-item {
    background: #f8fafc;
    border-radius: 16px;
    padding: 12px 16px;
}

.grade-label {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
    font-size: 0.8rem;
}

.progress {
    background: #e2e8f0;
    border-radius: 20px;
}

.progress-bar {
    border-radius: 20px;
}

/* Buttons */
.btn-outline-primary {
    border-radius: 30px;
    border-color: #4f46e5;
    color: #4f46e5;
    font-size: 0.75rem;
    padding: 6px 14px;
    transition: all 0.2s;
}
.btn-outline-primary:hover {
    background: #4f46e5;
    color: white;
    border-color: #4f46e5;
    transform: translateY(-1px);
}

/* Badges */
.badge {
    font-weight: 500;
    padding: 6px 12px;
    border-radius: 30px;
}

/* Responsive */
@media (max-width: 768px) {
    .welcome-card { padding: 20px; flex-direction: column; text-align: center; gap: 16px; }
    .welcome-icon i { font-size: 3rem; }
    .welcome-title { font-size: 1.3rem; }
    .stat-card { padding: 16px; }
    .stat-number { font-size: 22px; }
    .chart-header, .activity-header { flex-direction: column; align-items: stretch; }
    .activity-item { flex-wrap: wrap; gap: 8px; }
    .activity-time { margin-left: 56px; }
}
</style>
