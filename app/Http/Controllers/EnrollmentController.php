<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function index()
    {
        // Load enrollments with course and student relationships
        $enrollments = Enrollment::with(['course', 'student'])
            ->orderBy('enrollment_id', 'desc')
            ->paginate(10);

        return view('enrollments.index', compact('enrollments'));
    }

    public function myCourses()
    {
        // Get student's enrolled courses with teacher info
        $studentId = Auth::user()->user_id;
        $enrollments = Enrollment::with(['course.creator'])
            ->where('student_id', $studentId)
            ->get();

        return view('student.courses', compact('enrollments'));
    }
}
