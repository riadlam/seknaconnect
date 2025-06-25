<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/projects",
     *     summary="Get all projects with optional filtering",
     *     tags={"Projects"},
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of items per page (default: 15)",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="housing_type",
     *         in="query",
     *         description="Filter by housing type",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="location",
     *         in="query",
     *         description="Filter by location (partial match)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="price_min",
     *         in="query",
     *         description="Minimum price",
     *         required=false,
     *         @OA\Schema(type="number", format="float")
     *     ),
     *     @OA\Parameter(
     *         name="price_max",
     *         in="query",
     *         description="Maximum price",
     *         required=false,
     *         @OA\Schema(type="number", format="float")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of projects",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Project")
     *         )
     *     )
     * )
     *
     * Get all projects with optional filtering
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 15);
        
        $query = Project::with(['images', 'user']);

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

        return $query->latest()->paginate($perPage);
    }

    // Show single project
    public function show($id)
    {
        $project = Project::with(['images', 'user'])->findOrFail($id);
        return response()->json($project);
    }

    /**
     * Create a new project with optional images
     *
     * @OA\Post(
     *     path="/api/projects",
     *     summary="Create a new project with optional images",
     *     tags={"Projects"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name", "housing_type", "num_units", "location", "delivery_date", "price", "surface_area"},
     *                 @OA\Property(property="name", type="string", example="Luxury Villa"),
     *                 @OA\Property(property="housing_type", type="string", example="villa"),
     *                 @OA\Property(property="num_units", type="integer", example=10),
     *                 @OA\Property(property="location", type="string", example="City Center"),
     *                 @OA\Property(property="delivery_date", type="string", format="date", example="2024-12-31"),
     *                 @OA\Property(property="price", type="number", format="float", example=5000000),
     *                 @OA\Property(property="surface_area", type="number", format="float", example=250.5),
     *                 @OA\Property(property="description", type="string", nullable=true),
     *                 @OA\Property(
     *                     property="images[]",
     *                     type="array",
     *                     @OA\Items(type="string", format="binary"),
     *                     description="Array of images to upload"
     *                 ),
     *                 @OA\Property(
     *                     property="captions[]",
     *                     type="array",
     *                     @OA\Items(type="string"),
     *                     description="Optional captions for each image"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Project created successfully with images",
     *         @OA\JsonContent(ref="#/components/schemas/Project")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'housing_type' => 'required|string|max:100',
            'num_units' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'delivery_date' => 'required|date|after:today',
            'price' => 'required|numeric|min:0',
            'surface_area' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120', // Max 5MB per image
            'captions' => 'nullable|array',
            'captions.*' => 'nullable|string|max:255'
        ]);

        // Create the project
        $project = $request->user()->projects()->create($validated);

        // Handle image uploads if any
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                // Generate a unique filename with timestamp
                $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                
                // Store the file in the public disk with the desired path
                $path = $image->storeAs('project-images', $filename, 'public');
                
                $caption = isset($validated['captions'][$index]) 
                    ? $validated['captions'][$index] 
                    : null;
                
                $project->images()->create([
                    'image_path' => '/storage/' . $path, // Match the format used in ProjectImageController
                    'caption' => $caption
                ]);
            }
        }

        // Load the images relationship for the response
        $project->load('images');

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
