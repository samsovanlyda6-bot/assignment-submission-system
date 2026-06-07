@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Feedback Details</h5>
                    <div>
                        @if(auth()->user()->isTeacher() || auth()->user()->isAdmin())
                            <a href="{{ route('feedback.edit', $feedback->feedback_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        @endif
                        <a href="{{ route('feedback.index') }}" class="btn btn-secondary btn-sm">Back</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Feedback ID:</div>
                        <div class="col-md-9">{{ $feedback->feedback_id }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Student:</div>
                        <div class="col-md-9">{{ $feedback->submission->student->full_name ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Assignment:</div>
                        <div class="col-md-9">{{ $feedback->submission->assignment->title ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Teacher:</div>
                        <div class="col-md-9">{{ $feedback->teacher->full_name ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Comment:</div>
                        <div class="col-md-9">
                            <div class="p-3 bg-light rounded">
                                {{ $feedback->comment }}
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Created At:</div>
                        <div class="col-md-9">{{ $feedback->created_at ? $feedback->created_at->format('d/m/Y H:i') : 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection