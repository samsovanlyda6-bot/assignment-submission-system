@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Add New Assignment</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('assignments.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="course_id" class="form-label">Course *</label>
                            <select name="course_id" id="course_id" class="form-select @error('course_id') is-invalid @enderror" required>
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->course_id }}" {{ old('course_id') == $course->course_id ? 'selected' : '' }}>
                                        {{ $course->course_code }} - {{ $course->course_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Title *</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="total_marks" class="form-label">Total Marks *</label>
                                <input type="number" step="0.01" name="total_marks" id="total_marks" class="form-control @error('total_marks') is-invalid @enderror" value="{{ old('total_marks') }}" required>
                                @error('total_marks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="allow_late_submission" class="form-label">Allow Late Submission</label>
                                <select name="allow_late_submission" id="allow_late_submission" class="form-select">
                                    <option value="0" {{ old('allow_late_submission') == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ old('allow_late_submission') == '1' ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Start Date *</label>
                                <input type="datetime-local" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="due_date" class="form-label">Due Date *</label>
                                <input type="datetime-local" name="due_date" id="due_date" class="form-control @error('due_date') is-invalid @enderror" value="{{ old('due_date') }}" required>
                                @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status *</label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                                <option value="Published" {{ old('status') == 'Published' ? 'selected' : '' }}>Published</option>
                                <option value="Closed" {{ old('status') == 'Closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="files" class="form-label">Assignment Files</label>
                            <input type="file" name="files[]" id="files" class="form-control" multiple>
                            <small class="text-muted">You can upload multiple files</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('assignments.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Assignment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection