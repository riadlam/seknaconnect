<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Support\Facades\Storage;

class ProjectImageController extends Controller
{
    public function store(Request $request, $projectId)
    {
        $request->validate([
            'image' => 'required|image|max:2048'
        ]);

        $project = Project::findOrFail($projectId);

        // Ensure ownership
        if ($project->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $path = $request->file('image')->store('public/project-images');

        $image = ProjectImage::create([
            'project_id' => $projectId,
            'image_path' => Storage::url($path)
        ]);

        return response()->json($image, 201);
    }

    public function destroy(Request $request, $id)
    {
        $image = ProjectImage::findOrFail($id);

        $project = $image->project;

        if ($project->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        Storage::delete(str_replace('/storage/', 'public/', $image->image_path));
        $image->delete();

        return response()->json(['message' => 'Image deleted']);
    }
}
