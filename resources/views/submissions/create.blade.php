@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Submit Assignment</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('submissions.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="assignment_id" class="form-label">Assignment *</label>
                            <select name="assignment_id" id="assignment_id" class="form-select @error('assignment_id') is-invalid @enderror" required>
                                <option value="">Select Assignment</option>
                                @foreach($assignments as $assignment)
                                    <option value="{{ $assignment->assignment_id }}" {{ request('assignment_id') == $assignment->assignment_id ? 'selected' : '' }}>
                                        {{ $assignment->title }} - {{ $assignment->course->course_name }}
                                        (Due: {{ \Carbon\Carbon::parse($assignment->due_date)->format('d/m/Y H:i') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('assignment_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="submission_text" class="form-label">Submission Text</label>
                            <textarea name="submission_text" id="submission_text" rows="6" class="form-control @error('submission_text') is-invalid @enderror">{{ old('submission_text') }}</textarea>
                            @error('submission_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="files" class="form-label">Upload Files</label>
                            <input type="file" name="files[]" id="files" class="form-control @error('files') is-invalid @enderror" multiple>
                            <small class="text-muted">Allowed formats: PDF, DOC, DOCX, ZIP (Max: 10MB each)</small>
                            @error('files')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Please ensure your submission is complete. Late submissions may be penalized.
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('submissions.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success">Submit Assignment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection