@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Grades Management</h5>
                    <a href="{{ route('grades.create') }}" class="btn btn-primary btn-sm">Add New Grade</a>
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
                                    <th>Course</th>
                                    <th>Marks Obtained</th>
                                    <th>Grade</th>
                                    <th>Graded By</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($grades as $grade)
                                <td>
                                    <td>{{ $grade->grade_id }}</td>
                                    <td>{{ $grade->submission->student->full_name ?? 'N/A' }}</td>
                                    <td>{{ $grade->submission->assignment->title ?? 'N/A' }}</td>
                                    <td>{{ $grade->submission->assignment->course->course_name ?? 'N/A' }}</td>
                                    <td>
                                        <strong>{{ $grade->marks_obtained }}</strong> / 
                                        {{ $grade->submission->assignment->total_marks ?? 'N/A' }}
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $grade->grade == 'A' ? 'success' : ($grade->grade == 'F' ? 'danger' : 'warning') }}">
                                            {{ $grade->grade }}
                                        </span>
                                    </td>
                                    <td>{{ $grade->grader->full_name ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('grades.show', $grade->grade_id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('grades.edit', $grade->grade_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('grades.destroy', $grade->grade_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this grade?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No grades found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        {{ $grades->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection