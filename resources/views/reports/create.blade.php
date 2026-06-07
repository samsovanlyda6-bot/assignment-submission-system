@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Generate Report</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('reports.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="report_type" class="form-label">Report Type *</label>
                            <select name="report_type" id="report_type" class="form-select @error('report_type') is-invalid @enderror" required>
                                <option value="">Select Report Type</option>
                                <option value="Submission" {{ old('report_type') == 'Submission' ? 'selected' : '' }}>Submission Report</option>
                                <option value="Grade" {{ old('report_type') == 'Grade' ? 'selected' : '' }}>Grade Report</option>
                                <option value="Student Performance" {{ old('report_type') == 'Student Performance' ? 'selected' : '' }}>Student Performance Report</option>
                            </select>
                            @error('report_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="report_date" class="form-label">Report Date *</label>
                                <input type="date" name="report_date" id="report_date" class="form-control @error('report_date') is-invalid @enderror" value="{{ old('report_date', date('Y-m-d')) }}" required>
                                @error('report_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="course_id" class="form-label">Filter by Course (Optional)</label>
                                <select name="course_id" id="course_id" class="form-select">
                                    <option value="">All Courses</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->course_id }}" {{ old('course_id') == $course->course_id ? 'selected' : '' }}>
                                            {{ $course->course_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> The report will be generated in PDF format.
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('reports.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Generate Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection