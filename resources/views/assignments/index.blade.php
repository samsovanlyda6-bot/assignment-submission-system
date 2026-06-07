@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Assignments</h1>
    <a href="{{ route('assignments.create') }}" class="btn btn-primary">Create Assignment</a>

    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Course</th>
                <th>Teacher (Created By)</th>
                <th>Total Marks</th>
                <th>Due Date</th>
                <th>Submissions</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assignments as $assignment)
            <tr>
                <td>{{ $assignment->title }}</td>
                <td>{{ $assignment->course->course_name ?? 'N/A' }}</td>
                <td>{{ $assignment->creator->full_name ?? 'N/A' }}</td>
                <td>{{ $assignment->total_marks }}</td>
                <td>{{ $assignment->due_date->format('M d, Y H:i') }}</td>
                <td>{{ $assignment->submissions_count }}</td>
                <td>{{ $assignment->status }}</td>
                <td>
                    <a href="{{ route('assignments.show', $assignment->assignment_id) }}">View</a>
                    <a href="{{ route('assignments.edit', $assignment->assignment_id) }}">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $assignments->links() }}
</div>
@endsection
