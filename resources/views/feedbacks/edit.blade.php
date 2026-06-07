@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Feedback</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('feedback.update', $feedback->feedback_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Student</label>
                            <input type="text" class="form-control" value="{{ $feedback->submission->student->full_name ?? 'N/A' }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Assignment</label>
                            <input type="text" class="form-control" value="{{ $feedback->submission->assignment->title ?? 'N/A' }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="comment" class="form-label">Comment *</label>
                            <textarea name="comment" id="comment" rows="6" class="form-control @error('comment') is-invalid @enderror" required>{{ old('comment', $feedback->comment) }}</textarea>
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('feedback.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Feedback</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection