@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Courses</h1>
    <a href="{{ route('courses.create') }}" class="btn btn-primary">Create Course</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Course Name</th>
                <th>Course Code</th>
                <th>Teacher (Creator)</th>
                <th>Total Assignments</th>
                <th>Enrolled Students</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
            <tr>
                <td>{{ $course->course_id }}</td>
                <td>{{ $course->course_name }}</td>
                <td>{{ $course->course_code }}</td>
                <td>
                    {{ $course->creator->full_name ?? 'N/A' }}
                    <br>
                    <small>{{ $course->creator->email ?? '' }}</small>
                </td>
                <td>{{ $course->assignments->count() }}</td>
                <td>{{ $course->enrollments->count() }}</td>
                <td>
                    <a href="{{ route('courses.show', $course->course_id) }}">View</a>
                    <a href="{{ route('courses.edit', $course->course_id) }}">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $courses->links() }}
</div>
@endsection
