<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    // List all projects with filters
    public function index(Request $request)
    {
        $query = Project::with('images');

        if ($request->has('housing_type')) {
            $query->where('housing_type', $request->housing_type);
        }

        if ($request->has('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->has('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->has('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        return $query->latest()->get();
    }

    // Show single project
    public function show($id)
    {
        $project = Project::with(['images', 'user'])->findOrFail($id);
        return response()->json($project);
    }

    // Create new project
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'housing_type' => 'required',
            'num_units' => 'required|integer',
            'location' => 'required',
            'delivery_date' => 'required|date',
            'price' => 'required|numeric',
            'surface_area' => 'required|numeric',
            'description' => 'nullable'
        ]);

        $project = $request->user()->projects()->create($validated);

        return response()->json($project, 201);
    }

    // Update project
    public function update(Request $request, $id)
    {
        $project = $request->user()->projects()->findOrFail($id);

        $project->update($request->all());

        return response()->json($project);
    }

    // Delete project
    public function destroy(Request $request, $id)
    {
        $project = $request->user()->projects()->findOrFail($id);
        $project->delete();

        return response()->json(['message' => 'Project deleted']);
    }
}
