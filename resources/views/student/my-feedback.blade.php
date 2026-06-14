@extends('layouts.app')

@section('title', 'My Feedback')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-gradient-info text-white rounded-top-4" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <h4 class="mb-0">
                        <i class="fas fa-comment-dots me-2"></i> My Feedback
                    </h4>
                </div>

                <div class="card-body p-4">
                    @if($feedbacks->count() > 0)
                        <div class="row g-4">
                            @foreach($feedbacks as $feedback)
                            <div class="col-md-6">
                                <div class="card h-100 border-0 shadow-sm feedback-card">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="fw-bold mb-1" style="font-size: 0.9rem;">
                                                    {{ optional($feedback->submission->assignment)->title ?? 'N/A' }}
                                                </h6>
                                                <p class="text-muted small mb-0" style="font-size: 0.75rem;">
                                                    <i class="fas fa-chalkboard-user me-1"></i> Teacher: {{ $feedback->teacher->full_name ?? 'N/A' }}
                                                </p>
                                            </div>
                                            <span class="badge bg-light text-muted" style="font-size: 0.7rem;">
                                                {{ $feedback->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        <div class="bg-light p-2 rounded-3 mt-2">
                                            <p class="small mb-0" style="font-size: 0.8rem;">
                                                <i class="fas fa-quote-left text-muted me-1"></i>
                                                {{ Str::limit($feedback->comment, 120) }}
                                            </p>
                                        </div>
                                        <div class="mt-2">
                                            <a href="{{ route('feedbacks.show', $feedback->feedback_id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            {{ $feedbacks->links() }}
                        </div>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-comments fa-3x mb-3"></i>
                            <h5 class="text-muted" style="font-size: 1rem;">No Feedback Yet</h5>
                            <p class="text-muted" style="font-size: 0.875rem;">You haven't received any feedback from teachers yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    .feedback-card {
        transition: all 0.2s ease;
        border-radius: 12px;
    }
    .feedback-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection
