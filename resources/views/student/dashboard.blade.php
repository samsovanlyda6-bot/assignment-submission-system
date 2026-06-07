<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - Assignment System</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; }
        .header { background: #4CAF50; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
        .container { max-width: 1200px; margin: 20px auto; padding: 0 20px; }
        .welcome-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; border-radius: 10px; margin-bottom: 30px; }
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center; }
        .stat-number { font-size: 32px; font-weight: bold; color: #4CAF50; }
        .section { background: white; padding: 20px; border-radius: 10px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .section h3 { margin-bottom: 15px; color: #333; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f0f2f5; }
        .btn { display: inline-block; padding: 8px 15px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px; margin-top: 10px; }
        .course-card { background: #f9f9f9; padding: 15px; margin-bottom: 15px; border-radius: 8px; border-left: 4px solid #4CAF50; }
        .course-title { font-size: 18px; font-weight: bold; margin-bottom: 5px; }
        .course-code { color: #666; font-size: 14px; }
        .nav-links a { color: white; text-decoration: none; margin-left: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <strong>📚 Assignment System</strong>
        </div>
        <div class="nav-links">
            <span>Welcome, {{ Auth::user()->full_name }}</span>
            <a href="{{ url('/dashboard') }}">Dashboard</a>
            <a href="{{ url('/profile') }}">Profile</a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
    </div>

    <div class="container">
        <div class="welcome-card">
            <h1>Welcome, {{ Auth::user()->full_name }}! 👋</h1>
            <p>Track your assignments, submissions, and grades from your student dashboard.</p>
        </div>

        <div class="stats">
            <div class="stat-card">
                <h3>Total Submissions</h3>
                <div class="stat-number">{{ $totalSubmissions }}</div>
            </div>
            <div class="stat-card">
                <h3>Pending Grading</h3>
                <div class="stat-number">{{ $pendingSubmissions }}</div>
            </div>
            <div class="stat-card">
                <h3>Average Grade</h3>
                <div class="stat-number">{{ round($averageGrade) }}%</div>
            </div>
            <div class="stat-card">
                <h3>Enrolled Courses</h3>
                <div class="stat-number">{{ $myCourses->count() }}</div>
            </div>
        </div>

        <div class="section">
            <h3>📖 My Enrolled Courses</h3>
            @forelse($myCourses as $course)
                <div class="course-card">
                    <div class="course-title">{{ $course->course_name }}</div>
                    <div class="course-code">{{ $course->course_code }}</div>
                    <p>Teacher: {{ $course->teacher_name }}</p>
                    <p>{{ $course->description }}</p>
                    <a href="{{ url('/courses/' . $course->course_id) }}" class="btn">View Course</a>
                </div>
            @empty
                <p>You are not enrolled in any courses yet.</p>
                <a href="{{ url('/courses') }}" class="btn">Browse Courses</a>
            @endforelse
        </div>

        <div class="section">
            <h3>📝 Recent Submissions</h3>
            <table>
                <thead>
                    <tr><th>Assignment</th><th>Course</th><th>Submitted</th><th>Grade</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse($mySubmissions as $submission)
                    <tr>
                        <td>{{ $submission->assignment->title }}</td>
                        <td>{{ $submission->assignment->course->course_name ?? 'N/A' }}</td>
                        <td>{{ $submission->created_at->diffForHumans() }}</td>
                        <td>
                            @if($submission->grade)
                                {{ $submission->grade->marks_obtained }}/{{ $submission->assignment->total_marks }}
                            @else
                                Pending
                            @endif
                        </td>
                        <td>{{ $submission->status ?? 'Submitted' }}</td>
                    </tr>
                    @empty
                        <tr><td colspan="5">No submissions yet. <a href="{{ url('/assignments') }}">Submit your first assignment</a></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
