<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\SubmissionFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubmissionFileController extends Controller
{
    public function store(Request $request, $submissionId)
    {
        $submission = Submission::findOrFail($submissionId);
        
        $request->validate([
            'file' => 'required|file|max:10240'
        ]);
        
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('submissions/' . $submissionId . '/additional', $fileName, 'public');
        
        SubmissionFile::create([
            'submission_id' => $submissionId,
            'file_name' => $fileName,
            'file_path' => $filePath,
            'uploaded_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'File uploaded successfully.');
    }
    
    public function destroy($id)
    {
        $file = SubmissionFile::findOrFail($id);
        
        Storage::disk('public')->delete($file->file_path);
        $file->delete();
        
        return redirect()->back()->with('success', 'File deleted successfully.');
    }
    
    // public function download($id)
    // {
    //     $file = SubmissionFile::findOrFail($id);
    //     return Storage::disk('public')->download($file->file_path, $file->file_name);
    // }
}