@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Grade</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('grades.update', $grade->grade_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Student</label>
                            <input type="text" class="form-control" value="{{ $grade->submission->student->full_name ?? 'N/A' }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Assignment</label>
                            <input type="text" class="form-control" value="{{ $grade->submission->assignment->title ?? 'N/A' }}" disabled>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="marks_obtained" class="form-label">Marks Obtained *</label>
                                <input type="number" step="0.01" name="marks_obtained" id="marks_obtained" class="form-control @error('marks_obtained') is-invalid @enderror" value="{{ old('marks_obtained', $grade->marks_obtained) }}" required>
                                @error('marks_obtained')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="grade_letter" class="form-label">Grade *</label>
                                <select name="grade" id="grade_letter" class="form-select @error('grade') is-invalid @enderror" required>
                                    <option value="">Select Grade</option>
                                    <option value="A" {{ old('grade', $grade->grade) == 'A' ? 'selected' : '' }}>A (Excellent)</option>
                                    <option value="B" {{ old('grade', $grade->grade) == 'B' ? 'selected' : '' }}>B (Good)</option>
                                    <option value="C" {{ old('grade', $grade->grade) == 'C' ? 'selected' : '' }}>C (Average)</option>
                                    <option value="D" {{ old('grade', $grade->grade) == 'D' ? 'selected' : '' }}>D (Poor)</option>
                                    <option value="F" {{ old('grade', $grade->grade) == 'F' ? 'selected' : '' }}>F (Fail)</option>
                                </select>
                                @error('grade')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('grades.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Grade</button>
                        </