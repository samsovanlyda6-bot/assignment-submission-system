@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Submission Details</h5>
                    <a href="{{ route('submissions.index') }}" class="btn btn-secondary btn-sm">Back</a>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Submission ID:</div>
                        <div class="col-md-9">{{ $submission->submission_id }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Student:</div>
                        <div class="col-md-9">{{ $submission->student->full_name ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Assignment:</div>
                        <div class="col-md-9">{{ $submission->assignment->title ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Course:</div>
                        <div class="col-md-9">{{ $submission->assignment->course->course_name ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Submission Text:</div>
                        <div class="col-md-9">{{ $submission->submission_text ?? 'No text provided' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Submitted At:</div>
                        <div class="col-md-9">{{ \Carbon\Carbon::parse($submission->submitted_at)->format('d/m/Y H:i') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Late Submission:</div>
                        <div class="col-md-9">
                            @if($submission->is_late)
                                <span class="badge bg-danger">Yes</span>
                            @else
                                <span class="badge bg-success">No</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Status:</div>
                        <div class="col-md-9">
                            <span class="badge bg-{{ $submission->status == 'Graded' ? 'success' : 'warning' }}">
                                {{ $submission->status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            @if($submission->files && $submission->files->count() > 0)
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Submitted Files</h6>
                </div>
                <div class="card-body">
                    @foreach($submission->files as $file)
                        <div class="mb-2">
                            <a href="{{ asset($file->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary w-100">
                                <i class="fas fa-download"></i> {{ $file->file_name }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if($submission->grade)
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Grade Information</h6>
                </div>
                <div class="card-body">
                    <p><strong>Marks Obtained:</strong> {{ $submission->grade->marks_obtained }} / {{ $submission->assignment->total_marks ?? 'N/A' }}</p>
                    <p><strong>Grade:</strong> 
                        <span class="badge bg-{{ $submission->grade->grade == 'A' ? 'success' : ($submission->grade->grade == 'F' ? 'danger' : 'warning') }}">
                            {{ $submission->grade->grade }}
                        </span>
                    </p>
                    <p><strong>Graded By:</strong> {{ $submission->grade->grader->full_name ?? 'N/A' }}</p>
                    <p><strong>Graded At:</strong> {{ $submission->grade->graded_at ? \Carbon\Carbon::parse($submission->grade->graded_at)->format('d/m/Y H:i') : 'N/A' }}</p>
                </div>
            </div>
            @endif

            @if($submission->feedback && $submission->feedback->count() > 0)
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Feedback</h6>
                </div>
                <div class="card-body">
                    @foreach($submission->feedback as $feedback)
                        <div class="mb-3">
                            <p><strong>{{ $feedback->teacher->full_name ?? 'Teacher' }}:</strong></p>
                            <p>{{ $feedback->comment }}</p>
                            <small class="text-muted">{{ $feedback->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        @if(!$loop->last)
                            <hr>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif

            @if((auth()->user()->isTeacher() || auth()->user()->isAdmin()) && !$submission->grade)
            <div class="card mb-3">
                <div class="card-body">
                    <a href="{{ route('grades.create', ['submission_id' => $submission->submission_id]) }}" class="btn btn-primary w-100">
                        <i class="fas fa-star"></i> Grade Submission
                    </a>
                </div>
            </div>
            @endif

            @if(auth()->user()->isTeacher() || auth()->user()->isAdmin())
            <div class="card mb-3">
                <div class="card-body">
                    <a href="{{ route('feedback.create', ['submission_id' => $submission->submission_id]) }}" class="btn btn-info w-100">
                        <i class="fas fa-comment"></i> Add Feedback
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection