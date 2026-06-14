@extends('layouts.app')

@section('title', 'Feedback Details')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Header Section -->
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 45px; height: 45px; background: #0D6EFD;">
                    <i class="fas fa-comment fa-lg text-white"></i>
                </div>
                <div>
                    <h1 class="fw-bold mb-0" style="color: #1a1a2e; font-size: 1.75rem;">Feedback Details</h1>
                    <p class="text-muted mt-1 mb-0" style="font-size: 0.875rem;">View feedback information</p>
                </div>
            </div>

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-primary text-white rounded-top-4 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i> Feedback Information
                    </h5>
                    <div>
                        @if(auth()->user()->isTeacher() || auth()->user()->isAdmin())
                            <a href="{{ route('feedbacks.edit', $feedback->feedback_id) }}" class="btn btn-warning btn-sm rounded-pill me-1">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                        @endif
                        <a href="{{ route('feedbacks.index') }}" class="btn btn-secondary btn-sm rounded-pill">
                            <i class="fas fa-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Feedback ID -->
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold text-primary">Feedback ID:</div>
                        <div class="col-md-9">{{ $feedback->feedback_id }}</div>
                    </div>

                    <!-- Submission Link -->
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold text-primary">Submission:</div>
                        <div class="col-md-9">
                            <a href="{{ route('submissions.show', $feedback->submission_id) }}" class="text-decoration-none">
                                Submission #{{ $feedback->submission_id }}
                            </a>
                        </div>
                    </div>

                    <!-- Student (null-safe) -->
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold text-primary">Student:</div>
                        <div class="col-md-9">
                            <i class="fas fa-user-graduate me-1"></i>
                            {{ optional(optional($feedback->submission)->student)->full_name ?? 'N/A' }}
                        </div>
                    </div>

                    <!-- Assignment (null-safe) -->
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold text-primary">Assignment:</div>
                        <div class="col-md-9">
                            <i class="fas fa-tasks me-1"></i>
                            {{ optional(optional($feedback->submission)->assignment)->title ?? 'N/A' }}
                        </div>
                    </div>

                    <!-- Course (null-safe) – additional useful info -->
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold text-primary">Course:</div>
                        <div class="col-md-9">
                            <i class="fas fa-book me-1"></i>
                            {{ optional(optional(optional($feedback->submission)->assignment)->course)->course_name ?? 'N/A' }}
                        </div>
                    </div>

                    <!-- Teacher -->
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold text-primary">Teacher:</div>
                        <div class="col-md-9">
                            <i class="fas fa-chalkboard-user me-1"></i>
                            {{ $feedback->teacher->full_name ?? 'N/A' }}
                        </div>
                    </div>

                    <!-- Comment -->
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold text-primary">Comment:</div>
                        <div class="col-md-9">
                            <div class="bg-light p-3 rounded-3">
                                {{ $feedback->comment }}
                            </div>
                        </div>
                    </div>

                    <!-- Grade information (if available) -->
                    @php
                        $grade = optional(optional($feedback->submission)->grade);
                    @endphp
                    @if($grade->exists)
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold text-primary">Grade:</div>
                        <div class="col-md-9">
                            <span class="badge bg-success">{{ $grade->grade }}</span>
                            ({{ $grade->marks_obtained }} / {{ optional(optional($feedback->submission)->assignment)->total_marks ?? 'N/A' }})
                        </div>
                    </div>
                    @endif

                    <!-- Timestamps -->
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold text-primary">Created At:</div>
                        <div class="col-md-9">
                            <i class="fas fa-calendar-alt me-1"></i>
                            {{ $feedback->created_at ? $feedback->created_at->format('F d, Y H:i') : 'N/A' }}
                        </div>
                    </div>

                    @if($feedback->updated_at && $feedback->updated_at != $feedback->created_at)
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold text-primary">Last Updated:</div>
                        <div class="col-md-9">
                            <i class="fas fa-edit me-1"></i>
                            {{ $feedback->updated_at->format('F d, Y H:i') }}
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Optional footer actions -->
                <div class="card-footer bg-transparent text-end p-3">
                    @if(auth()->user()->isStudent() && optional($feedback->submission)->submission_id)
                        <a href="{{ route('submissions.show', $feedback->submission_id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye me-1"></i> View Full Submission
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .card {
        border-radius: 12px;
    }
    .badge {
        font-weight: 500;
    }
    @media (max-width: 768px) {
        .container {
            padding-left: 16px;
            padding-right: 16px;
        }
        h1 {
            font-size: 1.5rem !important;
        }
    }
</style>
@endsection
