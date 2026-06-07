@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $course->course_name }}</h1>
    <p><strong>Code:</strong> {{ $course->course_code }}</p>
    <p><strong>Teacher:</strong> {{ $course->creator->full_name ?? 'N/A' }}</p>
    <p><strong>Description:</strong> {{ $course->description }}</p>
    <p><strong>Status:</strong> {{ $course->status }}</p>
    <p><strong>Enrolled Students:</strong> {{ $course->enrollments->count() }}</p>
    <p><strong>Total Assignments:</strong> {{ $course->assignments->count() }}</p>

    <h3>Assignments</h3>
    @forelse($course->assignments as $assignment)
        <div>
            <strong>{{ $assignment->title }}</strong> - Due: {{ $assignment->due_date }}
        </div>
    @empty
        <p>No assignments yet.</p>
    @endforelse

    <a href="{{ route('courses.index') }}">Back to Courses</a>
    <a href="{{ route('courses.edit', $course->course_id) }}">Edit Course</a>
</div>
@endsection
