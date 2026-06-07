@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Grade Details</h5>
                    <div>
                        @if(auth()->user()->isTeacher() || auth()->user()->isAdmin())
                            <a href="{{ route('grades.edit', $grade->grade_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        @endif
                        <a href="{{ route('grades.index') }}" class="btn btn-secondary btn-sm">Back</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Grade ID:</div>
                        <div class="col-md-9">{{ $grade->grade_id }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Student:</div>
                        <div class="col-md-9">{{ $grade->submission->student->full_name ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Assignment:</div>
                        <div class="col-md-9">{{ $grade->submission->assignment->title ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Course:</div>
                        <div class="col-md-9">{{ $grade->submission->assignment->course->course_name ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Marks Obtained:</div>
                        <div class="col-md-9">
                            <strong>{{ $grade->marks_obtained }}</strong> / {{ $grade->submission->assignment->total_marks ?? 'N/A' }}
                            @php
                                $percentage = ($grade->marks_obtained / ($grade->submission->assignment->total_marks ?? 1)) * 100;
                            @endphp
                            <span class="badge bg-{{ $percentage >= 80 ? 'success' : ($percentage >= 60 ? 'info' : ($percentage >= 40 ? 'warning' : 'danger')) }}">
                                {{ round($percentage) }}%
                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Grade:</div>
                        <div class="col-md-9">
                            <span class="badge bg-{{ $grade->grade == 'A' ? 'success' : ($grade->grade == 'F' ? 'danger' : 'warning') }}">
                                {{ $grade->grade }}
                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Graded By:</div>
                        <div class="col-md-9">{{ $grade->grader->full_name ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Graded At:</div>
                        <div class="col-md-9">{{ \Carbon\Carbon::parse($grade->graded_at)->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection