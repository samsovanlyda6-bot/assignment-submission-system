@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Add Feedback for Submission</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('feedback.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="submission_id" class="form-label">Select Submission *</label>
                            <select name="submission_id" id="submission_id" class="form-select @error('submission_id') is-invalid @enderror" required>
                                <option value="">Choose Submission</option>
                                @foreach($submissions as $submission)
                                    <option value="{{ $submission->submission_id }}" {{ old('submission_id') == $submission->submission_id ? 'selected' : '' }}>
                                        {{ $submission->student->full_name }} - {{ $submission->assignment->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('submission_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="comment" class="form-label">Feedback Comment *</label>
                            <textarea name="comment" id="comment" rows="6" class="form-control @error('comment') is-invalid @enderror" required>{{ old('comment') }}</textarea>
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('feedback.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Submit Feedback</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection