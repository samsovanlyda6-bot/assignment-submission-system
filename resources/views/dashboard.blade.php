@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-8">

    <!-- Welcome Section -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
            Welcome back, {{ Auth::user()->full_name }}! 👋
        </h1>
        <p class="text-gray-500 mt-2">Here's what's happening with your learning journey today.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Courses Card -->
        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <span class="text-3xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors">{{ $totalCourses }}</span>
                </div>
                <h3 class="text-gray-600 font-semibold text-lg mb-1">Active Courses</h3>
                <p class="text-sm text-gray-400">{{ $totalCourses > 0 ? 'Available for enrollment' : 'No courses yet' }}</p>
                <div class="mt-4 w-full bg-gray-100 rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-400 to-blue-600 h-2 rounded-full" style="width: {{ min(100, ($totalCourses / 20) * 100) }}%"></div>
                </div>
            </div>
        </div>

        <!-- Assignments Card -->
        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-gradient-to-br from-green-400 to-emerald-600 rounded-xl shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <span class="text-3xl font-bold text-gray-800 group-hover:text-green-600 transition-colors">{{ $totalAssignments }}</span>
                </div>
                <h3 class="text-gray-600 font-semibold text-lg mb-1">Assignments</h3>
                <p class="text-sm text-gray-400">{{ $upcomingDeadlines->count() }} due this week</p>
                <div class="mt-4 w-full bg-gray-100 rounded-full h-2">
                    <div class="bg-gradient-to-r from-green-400 to-emerald-600 h-2 rounded-full" style="width: {{ $totalAssignments > 0 ? min(100, ($totalSubmissions / $totalAssignments / 10) * 100) : 0 }}%"></div>
                </div>
            </div>
        </div>

        <!-- Submissions Card -->
        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-3xl font-bold text-gray-800 group-hover:text-purple-600 transition-colors">{{ $totalSubmissions }}</span>
                </div>
                <h3 class="text-gray-600 font-semibold text-lg mb-1">Submissions</h3>
                <p class="text-sm text-gray-400">{{ $gradedSubmissions }} graded, {{ $pendingGrading }} pending</p>
                <div class="mt-4 w-full bg-gray-100 rounded-full h-2">
                    <div class="bg-gradient-to-r from-purple-400 to-purple-600 h-2 rounded-full" style="width: {{ $totalSubmissions > 0 ? ($gradedSubmissions / $totalSubmissions) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>

        <!-- Average Score Card -->
        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-gradient-to-br from-orange-400 to-red-600 rounded-xl shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <span class="text-3xl font-bold text-gray-800 group-hover:text-orange-600 transition-colors">{{ round($averageScore) }}%</span>
                </div>
                <h3 class="text-gray-600 font-semibold text-lg mb-1">Average Score</h3>
                <p class="text-sm text-gray-400">Overall class performance</p>
                <div class="mt-4 w-full bg-gray-100 rounded-full h-2">
                    <div class="bg-gradient-to-r from-orange-400 to-red-600 h-2 rounded-full" style="width: {{ $averageScore }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Submissions -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">📝 Recent Submissions</h2>
            <div class="space-y-4">
                @forelse($recentSubmissions as $submission)
                <div class="flex items-center p-3 bg-gradient-to-r from-blue-50 to-transparent rounded-lg hover:shadow-md transition-shadow">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <span class="text-blue-600 font-bold">{{ strtoupper(substr($submission->student->full_name ?? 'S', 0, 2)) }}</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-700">{{ $submission->assignment->title ?? 'N/A' }}</h3>
                        <p class="text-sm text-gray-500">by {{ $submission->student->full_name ?? 'Student' }} • {{ $submission->created_at->diffForHumans() }}</p>
                    </div>
                    <span class="text-blue-600 font-semibold">→</span>
                </div>
                @empty
                <div class="text-center text-gray-500 py-8">
                    <p>No submissions yet</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Upcoming Deadlines -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">⏰ Upcoming Deadlines</h2>
            <div class="space-y-4">
                @forelse($upcomingDeadlines as $assignment)
                @php
                    $daysLeft = now()->diffInDays($assignment->due_date, false);
                    $urgentClass = $daysLeft <= 2 ? 'from-red-50' : ($daysLeft <= 5 ? 'from-yellow-50' : 'from-green-50');
                    $textColor = $daysLeft <= 2 ? 'text-red-600' : ($daysLeft <= 5 ? 'text-yellow-600' : 'text-green-600');
                @endphp
                <div class="flex items-center justify-between p-3 bg-gradient-to-r {{ $urgentClass }} to-transparent rounded-lg">
                    <div>
                        <h3 class="font-semibold text-gray-700">{{ $assignment->title }}</h3>
                        <p class="text-sm text-gray-500">{{ $assignment->course->course_name ?? 'N/A' }}</p>
                    </div>
                    <span class="{{ $textColor }} font-semibold text-sm">
                        @if($daysLeft <= 0)
                            Overdue
                        @elseif($daysLeft == 1)
                            Due tomorrow
                        @else
                            Due in {{ $daysLeft }} days
                        @endif
                    </span>
                </div>
                @empty
                <div class="text-center text-gray-500 py-8">
                    <p>No upcoming deadlines</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Grade Distribution Chart -->
    <div class="mt-6 bg-white rounded-2xl shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">📊 Grade Distribution</h2>
        <div class="space-y-3">
            @foreach($gradeLabels as $index => $grade)
            @php
                $total = $gradeData->sum();
                $percentage = $total > 0 ? ($gradeData[$index] / $total) * 100 : 0;
                $colors = ['bg-green-500', 'bg-blue-500', 'bg-yellow-500', 'bg-orange-500', 'bg-red-500'];
            @endphp
            <div>
                <div class="flex justify-between mb-1">
                    <span class="font-semibold">{{ $grade }}</span>
                    <span class="text-gray-600">{{ $gradeData[$index] }} students ({{ round($percentage) }}%)</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="{{ $colors[$index] }} h-3 rounded-full" style="width: {{ $percentage }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
