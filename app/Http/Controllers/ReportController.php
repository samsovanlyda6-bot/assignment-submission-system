<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Submission;
use App\Models\Grade;
use App\Models\Assignment;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::orderBy('created_at', 'desc')->paginate(10);
        return view('reports.index', compact('reports'));
    }

    public function generateSubmissionsReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);
        
        $submissions = Submission::with(['student', 'assignment'])
            ->whereBetween('submitted_at', [$request->start_date, $request->end_date])
            ->get();
        
        $content = "Submission Report\n";
        $content .= "Period: {$request->start_date} to {$request->end_date}\n";
        $content .= "Generated: " . now() . "\n\n";
        $content .= "Student,Assignment,Submitted At,Status\n";
        
        foreach ($submissions as $submission) {
            $content .= "\"{$submission->student->full_name}\",";
            $content .= "\"{$submission->assignment->title}\",";
            $content .= "{$submission->submitted_at},";
            $content .= "{$submission->status}\n";
        }
        
        $fileName = 'submissions_report_' . date('Y-m-d_His') . '.csv';
        $filePath = 'reports/' . $fileName;
        Storage::disk('public')->put($filePath, $content);
        
        Report::create([
            'title' => 'Submissions Report',
            'generated_by' => Auth::id(),
            'data' => json_encode($request->only(['start_date', 'end_date'])),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        return redirect()->route('reports.index')->with('success', 'Report generated successfully.');
    }

    public function destroy($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();
        
        return redirect()->route('reports.index')->with('success', 'Report deleted successfully.');
    }
}