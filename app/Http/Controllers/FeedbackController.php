<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $submission_id = $request->get('submission_id');
        
        $feedbacks = Feedback::with('submission', 'teacher')
            ->when($submission_id, function ($query, $submission_id) {
                return $query->where('submission_id', $submission_id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('feedbacks.index', compact('feedbacks'));
    }

    public function create($submissionId)
    {
        $submission = Submission::with('student', 'assignment')->findOrFail($submissionId);
        return view('feedbacks.create', compact('submission'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'submission_id' => 'required|exists:submissions,submission_id',
            'comment' => 'required|string'
        ]);
        
        Feedback::create([
            'submission_id' => $request->submission_id,
            'teacher_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        
        return redirect()->route('feedbacks.index')->with('success', 'Feedback added successfully.');
    }

    public function show($id)
    {
        $feedback = Feedback::with('submission.student', 'submission.assignment', 'teacher')->findOrFail($id);
        return view('feedbacks.show', compact('feedback'));
    }

    public function edit($id)
    {
        $feedback = Feedback::findOrFail($id);
        return view('feedbacks.edit', compact('feedback'));
    }

    public function update(Request $request, $id)
    {
        $feedback = Feedback::findOrFail($id);
        
        $request->validate([
            'comment' => 'required|string'
        ]);
        
        $feedback->update(['comment' => $request->comment]);
        
        return redirect()->route('feedbacks.index')->with('success', 'Feedback updated successfully.');
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();
        
        return redirect()->route('feedbacks.index')->with('success', 'Feedback deleted successfully.');
    }
}