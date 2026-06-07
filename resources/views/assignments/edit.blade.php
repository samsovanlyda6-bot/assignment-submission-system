<!DOCTYPE html>
<html>
<head>
    <title>Edit Assignment</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .container { max-width: 600px; margin: auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #4CAF50; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        .error { color: red; margin-top: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Assignment</h1>
        
        @if ($errors->any())
            <div style="background: #f8d7da; padding: 10px; margin-bottom: 20px;">
                @foreach ($errors->all() as $error)
                    <div class="error">{{ $error }}</div>
                @endforeach
            </div>
        @endif
        
        <form method="POST" action="{{ route('assignments.update', $assignment->assignment_id) }}">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label>Course</label>
                <select name="course_id" required>
                    <option value="">Select Course</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->course_id }}" {{ $assignment->course_id == $course->course_id ? 'selected' : '' }}>
                            {{ $course->course_name }} ({{ $course->course_code }})
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" value="{{ old('title', $assignment->title) }}" required>
            </div>
            
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="5">{{ old('description', $assignment->description) }}</textarea>
            </div>
            
            <div class="form-group">
                <label>Total Marks</label>
                <input type="number" step="0.01" name="total_marks" value="{{ old('total_marks', $assignment->total_marks) }}" required>
            </div>
            
            <div class="form-group">
                <label>Start Date</label>
                <input type="datetime-local" name="start_date" value="{{ old('start_date', $assignment->start_date->format('Y-m-d\TH:i')) }}" required>
            </div>
            
            <div class="form-group">
                <label>Due Date</label>
                <input type="datetime-local" name="due_date" value="{{ old('due_date', $assignment->due_date->format('Y-m-d\TH:i')) }}" required>
            </div>
            
            <div class="form-group">
                <label>
                    <input type="checkbox" name="allow_late_submission" value="1" {{ $assignment->allow_late_submission ? 'checked' : '' }}>
                    Allow Late Submission
                </label>
            </div>
            
            <div class="form-group">
                <label>Status</label>
                <select name="status" required>
                    <option value="Draft" {{ $assignment->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                    <option value="Published" {{ $assignment->status == 'Published' ? 'selected' : '' }}>Published</option>
                    <option value="Closed" {{ $assignment->status == 'Closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>
            
            <button type="submit">Update Assignment</button>
            <a href="{{ route('assignments.index') }}">Cancel</a>
        </form>
    </div>
</body>
</html>