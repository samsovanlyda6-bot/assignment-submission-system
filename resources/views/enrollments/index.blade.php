@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Feedback Management</h5>
                    <a href="{{ route('feedback.create') }}" class="btn btn-primary btn-sm">Add Feedback</a>
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
                                    <th>Teacher</th>
                                    <th>Comment</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($feedback as $item)
                                <tr>
                                    <td>{{ $item->feedback_id }}</td>
                                    <td>{{ $item->submission->student->full_name ?? 'N/A' }}</td>
                                    <td>{{ $item->submission->assignment->title ?? 'N/A' }}</td>
                                    <td>{{ $item->teacher->full_name ?? 'N/A' }}</td>
                                    <td>{{ Str::limit($item->comment, 50) }}</td>
                                    <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('feedback.show', $item->feedback_id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('feedback.edit', $item->feedback_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('feedback.destroy', $item->feedback_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this feedback?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No feedback found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        {{ $feedback->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection