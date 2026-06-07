<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $submission_id = $request->get('submission_id');
        
        $grades = Grade::with('submission.assignment', 'submission.student', 'grader')
            ->when($submission_id, function ($query, $submission_id) {
                return $query->where('submission_id', $submission_id);
            })
            ->orderBy('graded_at', 'desc')
            ->paginate(10);
        
        return view('grades.index', compact('grades'));
    }

    public function create($submissionId)
    {
        $submission = Submission::with('assignment')->findOrFail($submissionId);
        
        if ($submission->grade) {
            return redirect()->route('grades.edit', $submission->grade->grade_id)
                ->with('info', 'Grade already exists. You can edit it.');
        }
        
        return view('grades.create', compact('submission'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'submission_id' => 'required|exists:submissions,submission_id',
            'marks_obtained' => 'required|numeric|min:0'
        ]);
        
        $submission = Submission::with('assignment')->findOrFail($request->submission_id);
        
        if ($submission->grade) {
            return redirect()->back()->with('error', 'Grade already exists for this submission.');
        }
        
        if ($request->marks_obtained > $submission->assignment->total_marks) {
            return redirect()->back()->with('error', 'Marks obtained cannot exceed total marks.')->withInput();
        }
        
        $gradeLetter = Grade::calculateGrade($request->marks_obtained, $submission->assignment->total_marks);
        
        Grade::create([
            'submission_id' => $request->submission_id,
            'marks_obtained' => $request->marks_obtained,
            'grade' => $gradeLetter,
            'graded_by' => Auth::id(),
            'graded_at' => now()
        ]);
        
        $submission->update(['status' => 'Graded']);
        
        return redirect()->route('grades.index')->with('success', 'Grade assigned successfully.');
    }

    public function show($id)
    {
        $grade = Grade::with('submission.assignment', 'submission.student', 'grader')->findOrFail($id);
        return view('grades.show', compact('grade'));
    }

    public function edit($id)
    {
        $grade = Grade::with('submission.assignment')->findOrFail($id);
        $submission = $grade->submission;
        return view('grades.edit', compact('grade', 'submission'));
    }

    public function update(Request $request, $id)
    {
        $grade = Grade::findOrFail($id);
        
        $request->validate([
            'marks_obtained' => 'required|numeric|min:0'
        ]);
        
        $totalMarks = $grade->submission->assignment->total_marks;
        
        if ($request->marks_obtained > $totalMarks) {
            return redirect()->back()->with('error', 'Marks obtained cannot exceed total marks.')->withInput();
        }
        
        $gradeLetter = Grade::calculateGrade($request->marks_obtained, $totalMarks);
        
        $grade->update([
            'marks_obtained' => $request->marks_obtained,
            'grade' => $gradeLetter,
            'graded_by' => Auth::id(),
            'graded_at' => now()
        ]);
        
        return redirect()->route('grades.index')->with('success', 'Grade updated successfully.');
    }

    public function destroy($id)
    {
        $grade = Grade::findOrFail($id);
        $submission = $grade->submission;
        
        $grade->delete();
        $submission->update(['status' => 'Submitted']);
        
        return redirect()->route('grades.index')->with('success', 'Grade deleted successfully.');
    }
}