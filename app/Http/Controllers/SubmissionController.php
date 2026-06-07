<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    public function mySubmissions()
    {
        // Load student's submissions with assignment and grade relationships
        $submissions = Submission::with(['assignment.course', 'grade'])
            ->where('student_id', Auth::user()->user_id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('student.submissions', compact('submissions'));
    }
}
