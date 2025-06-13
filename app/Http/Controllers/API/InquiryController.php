<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inquiry;
use App\Models\Project;

class InquiryController extends Controller
{
    // Public sends an inquiry
    public function store(Request $request, $projectId)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string'
        ]);

        $project = Project::findOrFail($projectId);

        $inquiry = Inquiry::create([
            'project_id' => $project->id,
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message
        ]);

        return response()->json($inquiry, 201);
    }

    // Professional views inquiries for their projects
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'professional') {
            return response()->json(['error' => 'Only professionals can view inquiries'], 403);
        }

        $inquiries = Inquiry::whereHas('project', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with('project')->latest()->get();

        return response()->json($inquiries);
    }
}
