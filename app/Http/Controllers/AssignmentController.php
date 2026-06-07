<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    public function index(Request $request)
    {
        $course_id = $request->get('course_id');
        $status = $request->get('status');

        // Load assignments with course, creator, and submissions count
        $assignments = Assignment::with(['course', 'creator'])
            ->withCount('submissions')
            ->when($course_id, function ($query, $course_id) {
                return $query->where('course_id', $course_id);
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('due_date', 'asc')
            ->paginate(10);

        $courses = Course::orderBy('course_name', 'asc')->get();

        return view('assignments.index', compact('assignments', 'courses'));
    }

    public function show($id)
    {
        // Load assignment with ALL relationships
        $assignment = Assignment::with([
            'course',
            'creator',
            'submissions.student',
            'submissions.grade'
        ])->findOrFail($id);

        return view('assignments.show', compact('assignment'));
    }
}
