@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Course</h1>

    <form method="POST" action="{{ route('courses.store') }}">
        @csrf

        <div class="form-group">
            <label>Course Name</label>
            <input type="text" name="course_name" value="{{ old('course_name') }}" required>
            @error('course_name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Course Code</label>
            <input type="text" name="course_code" value="{{ old('course_code') }}" required>
            @error('course_code')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="5">{{ old('description') }}</textarea>
            @error('description')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Create Course</button>
        <a href="{{ route('courses.index') }}">Cancel</a>
    </form>
</div>
@endsection
