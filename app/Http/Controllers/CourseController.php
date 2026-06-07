<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of courses.
     */
    public function index()
    {
        $courses = Course::with(['creator', 'assignments', 'enrollments'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_name' => 'required|string|max:255',
            'course_code' => 'required|string|max:50|unique:courses,course_code',
            'description' => 'nullable|string',
        ]);

        Course::create([
            'course_name' => $request->course_name,
            'course_code' => $request->course_code,
            'description' => $request->description,
            'created_by' => Auth::user()->user_id,
            'status' => 'active',
        ]);

        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified course.
     */
    public function show($id)
    {
        $course = Course::with(['creator', 'assignments.submissions', 'enrollments.student'])
            ->findOrFail($id);

        return view('courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit($id)
    {
        $course = Course::findOrFail($id);

        // Check permission - only creator or admin can edit
        if (Auth::user()->role_id != 1 && $course->created_by != Auth::user()->user_id) {
            return redirect()->route('courses.index')
                ->with('error', 'You do not have permission to edit this course.');
        }

        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified course in storage.
     */
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        // Check permission
        if (Auth::user()->role_id != 1 && $course->created_by != Auth::user()->user_id) {
            return redirect()->route('courses.index')
                ->with('error', 'You do not have permission to update this course.');
        }

        $request->validate([
            'course_name' => 'required|string|max:255',
            'course_code' => 'required|string|max:50|unique:courses,course_code,' . $id . ',course_id',
            'description' => 'nullable|string',
            'status' => 'nullable|in:active,inactive',
        ]);

        $course->update([
            'course_name' => $request->course_name,
            'course_code' => $request->course_code,
            'description' => $request->description,
            'status' => $request->status ?? 'active',
        ]);

        return redirect()->route('courses.index')
            ->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        // Check permission
        if (Auth::user()->role_id != 1 && $course->created_by != Auth::user()->user_id) {
            return redirect()->route('courses.index')
                ->with('error', 'You do not have permission to delete this course.');
        }

        // Check if course has assignments
        if ($course->assignments()->count() > 0) {
            return redirect()->route('courses.index')
                ->with('error', 'Cannot delete course with existing assignments.');
        }

        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}
