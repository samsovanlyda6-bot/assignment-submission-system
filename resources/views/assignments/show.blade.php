@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $assignment->title }}</h5>
                    <div>
                        @if(auth()->user()->isTeacher() || auth()->user()->isAdmin())
                            <a href="{{ route('assignments.edit', $assignment->assignment_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        @endif
                        <a href="{{ route('assignments.index') }}" class="btn btn-secondary btn-sm">Back</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Course:</div>
                        <div class="col-md-9">{{ $assignment->course->course_name ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Description:</div>
                        <div class="col-md-9">{{ $assignment->description ?? 'No description' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Total Marks:</div>
                        <div class="col-md-9">{{ $assignment->total_marks }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Start Date:</div>
                        <div class="col-md-9">{{ \Carbon\Carbon::parse($assignment->start_date)->format('d/m/Y H:i') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Due Date:</div>
                        <div class="col-md-9">
                            {{ \Carbon\Carbon::parse($assignment->due_date)->format('d/m/Y H:i') }}
                            @if(now() > $assignment->due_date)
                                <span class="badge bg-danger">Passed</span>
                            @else
                                <span class="badge bg-success">{{ now()->diffInDays($assignment->due_date) }} days left</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Allow Late Submission:</div>
                        <div class="col-md-9">{{ $assignment->allow_late_submission ? 'Yes' : 'No' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Status:</div>
                        <div class="col-md-9">
                            <span class="badge bg-{{ $assignment->status == 'Published' ? 'success' : ($assignment->status == 'Draft' ? 'warning' : 'danger') }}">
                                {{ $assignment->status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            @if($assignment->files && $assignment->files->count() > 0)
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Assignment Files</h6>
                </div>
                <div class="card-body">
                    @foreach($assignment->files as $file)
                        <div class="mb-2">
                            <a href="{{ asset($file->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary w-100">
                                <i class="fas fa-download"></i> {{ $file->file_name }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if(auth()->user()->isStudent())
                @php
                    $existingSubmission = $assignment->submissions->where('student_id', auth()->id())->first();
                @endphp
                
                @if($existingSubmission)
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">Your Submission</h6>
                        </div>
                        <div class="card-body">
                            <p><strong>Submitted:</strong> {{ \Carbon\Carbon::parse($existingSubmission->submitted_at)->format('d/m/Y H:i') }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge bg-{{ $existingSubmission->status == 'Graded' ? 'success' : 'warning' }}">
                                    {{ $existingSubmission->status }}
                                </span>
                            </p>
                            <a href="{{ route('submissions.show', $existingSubmission->submission_id) }}" class="btn btn-info btn-sm w-100">View Submission</a>
                        </div>
                    </div>
                @else
                    @if($assignment->status == 'Published' && (now() <= $assignment->due_date || $assignment->allow_late_submission))
                        <div class="card mb-3">
                            <div class="card-body">
                                <a href="{{ route('submissions.create', ['assignment_id' => $assignment->assignment_id]) }}" class="btn btn-success w-100">
                                    <i class="fas fa-upload"></i> Submit Assignment
                                </a>
                            </div>
                        </div>
                    @endif
                @endif
            @endif
        </div>
    </div>

    @if((auth()->user()->isTeacher() || auth()->user()->isAdmin()) && $assignment->submissions && $assignment->submissions->count() > 0)
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Student Submissions ({{ $assignment->submissions->count() }})</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Submitted At</th>
                                    <th>Status</th>
                                    <th>Grade</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assignment->submissions as $submission)
                                <tr>
                                    <td>{{ $submission->student->full_name ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($submission->submitted_at)->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $submission->status == 'Graded' ? 'success' : 'warning' }}">
                                            {{ $submission->status }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($submission->grade)
                                            {{ $submission->grade->marks_obtained }} / {{ $assignment->total_marks }}
                                        @else
                                            <span class="text-muted">Not graded</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('submissions.show', $submission->submission_id) }}" class="btn btn-info btn-sm">View</a>
                                        @if(!$submission->grade)
                                            <a href="{{ route('grades.create', ['submission_id' => $submission->submission_id]) }}" class="btn btn-primary btn-sm">Grade</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection