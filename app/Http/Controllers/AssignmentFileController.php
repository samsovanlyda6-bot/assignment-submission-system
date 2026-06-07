<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentFileController extends Controller
{
    public function store(Request $request, $assignmentId)
    {
        $assignment = Assignment::findOrFail($assignmentId);
        
        $request->validate([
            'file' => 'required|file|max:10240|mimes:pdf,doc,docx,zip,jpg,png'
        ]);
        
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('assignments/' . $assignmentId, $fileName, 'public');
        
        AssignmentFile::create([
            'assignment_id' => $assignmentId,
            'file_name' => $fileName,
            'file_path' => $filePath,
            'uploaded_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'File uploaded successfully.');
    }
    
    public function destroy($id)
    {
        $file = AssignmentFile::findOrFail($id);
        
        Storage::disk('public')->delete($file->file_path);
        $file->delete();
        
        return redirect()->back()->with('success', 'File deleted successfully.');
    }
    
    public function download($id)
    {
        $file = AssignmentFile::findOrFail($id);
        return Storage::disk('public')->download($file->file_path, $file->file_name);
    }
}