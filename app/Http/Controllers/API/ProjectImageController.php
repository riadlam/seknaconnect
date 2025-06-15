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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
            'caption' => 'nullable|string|max:255'
        ]);

        $project = Project::findOrFail($projectId);

        // Ensure ownership
        if ($project->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            $file = $request->file('image');
            
            // Generate a unique filename with timestamp
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Store the file in the public disk
            $path = $file->storeAs('project-images', $filename, 'public');
            
            // Create the image record
            $image = ProjectImage::create([
                'project_id' => $projectId,
                'image_path' => '/storage/' . $path,
                'caption' => $request->input('caption')
            ]);

            return response()->json([
                'message' => 'Image uploaded successfully',
                'data' => $image
            ], 201);
            
        } catch (\Exception $e) {
            \Log::error('Image upload error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to upload image',
                'message' => $e->getMessage()
            ], 500);
        }
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
