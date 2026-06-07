@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Course</h1>

    <form method="POST" action="{{ route('courses.update', $course->course_id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Course Name</label>
            <input type="text" name="course_name" value="{{ old('course_name', $course->course_name) }}" required>
            @error('course_name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Course Code</label>
            <input type="text" name="course_code" value="{{ old('course_code', $course->course_code) }}" required>
            @error('course_code')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="5">{{ old('description', $course->description) }}</textarea>
            @error('description')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status">
                <option value="active" {{ $course->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $course->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit">Update Course</button>
        <a href="{{ route('courses.index') }}">Cancel</a>
    </form>
</div>
@endsection
