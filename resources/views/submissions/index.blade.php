@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Submissions Management</h5>
                    <a href="{{ route('submissions.create') }}" class="btn btn-primary btn-sm">New Submission</a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Student</th>
                                    <th>Assignment</th>
                                    <th>Submitted At</th>
                                    <th>Status</th>
                                    <th>Late</th>
                                    <th>Grade</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($submissions as $submission)
                                <tr>
                                    <td>{{ $submission->submission_id }}</td>
                                    <td>{{ $submission->student->full_name ?? 'N/A' }}</td>
                                    <td>{{ $submission->assignment->title ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($submission->submitted_at)->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $submission->status == 'Submitted' ? 'primary' : ($submission->status == 'Graded' ? 'success' : 'warning') }}">
                                            {{ $submission->status }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($submission->is_late)
                                            <span class="badge bg-danger">Late</span>
                                        @else
                                            <span class="badge bg-success">On Time</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($submission->grade)
                                            {{ $submission->grade->marks_obtained }} / {{ $submission->assignment->total_marks ?? 'N/A' }}
                                        @else
                                            <span class="text-muted">Not graded</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('submissions.show', $submission->submission_id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('submissions.edit', $submission->submission_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('submissions.destroy', $submission->submission_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this submission?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No submissions found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        {{ $submissions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection