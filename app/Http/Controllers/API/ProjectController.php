<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * Search projects by name (partial match)
     *
     * @OA\Get(
     *     path="/api/projects/search",
     *     summary="Search projects by name",
     *     tags={"Projects"},
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         description="Search string for project name",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of matching projects",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Project"))
     *     )
     * )
     */
    public function searchByName(Request $request)
    {
        $q = $request->input('q');
        if (!$q) {
            return response()->json(['error' => 'Missing q parameter'], 422);
        }
        $projects = \App\Models\Project::with(['images', 'user', 'inquiries'])
            ->where('name', 'like', "%{$q}%")
            ->whereHas('user', function($query) {
                $query->where('is_verified', 1);
            })
            ->get();

        $result = $projects->map(function ($project) {
            return [
                'id' => $project->id,
                'name' => $project->name,
                'location' => $project->location,
                'price' => $project->price,
                'images' => $project->images->map(function ($img) {
                    return [
                        'id' => $img->id,
                        'image_path' => $img->image_path,
                        'caption' => $img->caption
                    ];
                }),
                'surface_area' => $project->surface_area,
                'housing_type' => $project->housing_type,
                'description' => $project->description,
                'delivery_date' => $project->delivery_date,
                'bedrooms' => $project->bedrooms ?? null,
                'bathrooms' => $project->bathrooms ?? null,
                'featured' => $project->featured ?? false,
                'user' => $project->user,
            ];
        });
        return response()->json($result);
    }

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
        $query = Project::with(['images', 'user'])
            ->whereHas('user', function($q) {
                $q->where('is_verified', 1);
            });

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
        // Prepare request data: convert empty strings to null for nullable fields
        $requestData = $request->all();
        $nullableFields = ['price', 'surface_area', 'bedrooms', 'bathrooms', 'rent_or_buy', 'delivery_date', 
                          'description', 'payment_plan', 'project_timeline', 'additional_housing_types',
                          'f1_count', 'f2_count', 'f3_count', 'f4_count', 'num_units'];
        
        foreach ($nullableFields as $field) {
            if (isset($requestData[$field]) && $requestData[$field] === '') {
                $requestData[$field] = null;
            }
        }
        
        // Merge cleaned data back into request
        $request->merge($requestData);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'housing_type' => 'required|string|max:100',
            'location' => 'required|array',
            'location.wilaya' => 'required|string|max:255',
            'location.commune' => 'required|string|max:255',
            'location.daira' => 'required|string|max:255',
            'delivery_date' => 'nullable|date',
            'price' => 'nullable|numeric|min:0',
            'surface_area' => 'nullable|numeric|min:0',
            'bedrooms' => 'nullable|string|max:50',
            'bathrooms' => 'nullable|numeric|min:0',
            'rent_or_buy' => 'nullable|in:rent,buy',
            'payment_plan' => 'nullable|string',
            'project_timeline' => 'nullable|string',
            'description' => 'nullable|string',
            'additional_housing_types' => 'nullable|string',
            'f1_count' => 'nullable|integer|min:0',
            'f2_count' => 'nullable|integer|min:0',
            'f3_count' => 'nullable|integer|min:0',
            'f4_count' => 'nullable|integer|min:0',
            'num_units' => 'nullable|integer|min:0',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120', // Max 5MB per image
            'captions' => 'nullable|array',
            'captions.*' => 'nullable|string|max:255'
        ]);

        // Validate and process payment plan
        if (isset($validated['payment_plan']) && !empty($validated['payment_plan'])) {
            $paymentPlanData = json_decode($validated['payment_plan'], true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json([
                    'message' => 'Invalid payment plan JSON format'
                ], 422);
            }

            // Validate payment plan structure
            if (!isset($paymentPlanData['paymentMethod']) || !in_array($paymentPlanData['paymentMethod'], ['cash', 'bank'])) {
                return response()->json([
                    'message' => 'Payment method must be either "cash" or "bank"'
                ], 422);
            }

            // Validate based on payment method
            if ($paymentPlanData['paymentMethod'] === 'cash') {
                if (!isset($paymentPlanData['cashAmount']) || !is_numeric($paymentPlanData['cashAmount']) || $paymentPlanData['cashAmount'] < 0) {
                    return response()->json([
                        'message' => 'Cash amount is required and must be a positive number'
                    ], 422);
                }
            } elseif ($paymentPlanData['paymentMethod'] === 'bank') {
                if (!isset($paymentPlanData['bankFullAmount']) || !is_numeric($paymentPlanData['bankFullAmount']) || $paymentPlanData['bankFullAmount'] < 0) {
                    return response()->json([
                        'message' => 'Bank full amount is required and must be a positive number'
                    ], 422);
                }
                if (!isset($paymentPlanData['bankDownPayment']) || !is_numeric($paymentPlanData['bankDownPayment']) || $paymentPlanData['bankDownPayment'] < 0) {
                    return response()->json([
                        'message' => 'Bank down payment is required and must be a positive number'
                    ], 422);
                }
            }

            // Store as JSON string (will be cast to array by model)
            $validated['payment_plan'] = json_encode($paymentPlanData);
        }

        // Process additional_housing_types if provided
        if (isset($validated['additional_housing_types']) && !empty($validated['additional_housing_types'])) {
            $additionalTypes = json_decode($validated['additional_housing_types'], true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($additionalTypes)) {
                // Filter out empty values - handle both old format (strings) and new format (objects)
                $filtered = array_filter($additionalTypes, function($item) {
                    if (is_string($item)) {
                        return !empty($item);
                    }
                    if (is_array($item) || is_object($item)) {
                        $item = (array)$item;
                        return !empty($item['type']);
                    }
                    return false;
                });
                $validated['additional_housing_types'] = json_encode(array_values($filtered)); // Re-index array
            } else {
                unset($validated['additional_housing_types']);
            }
        }

        // Convert location array to JSON string for storage
        $validated['location'] = json_encode($validated['location']);

        // Create the project
        $project = $request->user()->projects()->create($validated);

        // Handle image uploads if any
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                // Generate a unique filename with timestamp
                $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                
                // Store the file directly in public/storage/project-images
                $publicPath = public_path('storage/project-images');
                if (!file_exists($publicPath)) {
                    mkdir($publicPath, 0777, true);
                }
                $image->move($publicPath, $filename);
                $caption = isset($validated['captions'][$index]) 
                    ? $validated['captions'][$index] 
                    : null;
                $project->images()->create([
                    'image_path' => '/storage/project-images/' . $filename,
                    'caption' => $caption
                ]);
            }
        }

        // Load the images relationship for the response
        $project->load('images');

        return response()->json($project, 201);
    }

    /**
     * Update the specified project
     *
     * @OA\Put(
     *     path="/api/projects/{id}",
     *     summary="Update a project",
     *     tags={"Projects"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Project ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="name", type="string", example="Updated Project Name"),
     *                 @OA\Property(property="housing_type", type="string", example="villa"),
     *                 @OA\Property(property="num_units", type="integer", example=10),
     *                 @OA\Property(property="location", type="string", example="Updated Location"),
     *                 @OA\Property(property="delivery_date", type="string", format="date", example="2024-12-31"),
     *                 @OA\Property(property="price", type="number", format="float", example=5000000),
     *                 @OA\Property(property="surface_area", type="number", format="float", example=250.5),
     *                 @OA\Property(property="description", type="string", nullable=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Project updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Project")
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Project not found")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $project = $request->user()->projects()->findOrFail($id);

        // Prepare request data: convert empty strings to null for nullable fields
        $requestData = $request->all();
        $nullableFields = ['price', 'surface_area', 'bedrooms', 'bathrooms', 'rent_or_buy', 'delivery_date', 
                          'description', 'payment_plan', 'project_timeline', 'additional_housing_types',
                          'f1_count', 'f2_count', 'f3_count', 'f4_count', 'num_units'];
        
        foreach ($nullableFields as $field) {
            if (isset($requestData[$field]) && $requestData[$field] === '') {
                $requestData[$field] = null;
            }
        }
        
        // Merge cleaned data back into request
        $request->merge($requestData);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'housing_type' => 'sometimes|required|string|max:100',
            'location' => 'sometimes|required|array',
            'location.wilaya' => 'required_with:location|string|max:255',
            'location.commune' => 'required_with:location|string|max:255',
            'location.daira' => 'required_with:location|string|max:255',
            'delivery_date' => 'nullable|date',
            'price' => 'nullable|numeric|min:0',
            'surface_area' => 'nullable|numeric|min:0',
            'bedrooms' => 'nullable|string|max:50',
            'bathrooms' => 'nullable|numeric|min:0',
            'rent_or_buy' => 'nullable|in:rent,buy',
            'payment_plan' => 'nullable|string',
            'project_timeline' => 'nullable|string',
            'description' => 'nullable|string',
            'additional_housing_types' => 'nullable|string',
            'f1_count' => 'nullable|integer|min:0',
            'f2_count' => 'nullable|integer|min:0',
            'f3_count' => 'nullable|integer|min:0',
            'f4_count' => 'nullable|integer|min:0',
            'num_units' => 'nullable|integer|min:0',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120', // Max 5MB per image
            'captions' => 'nullable|array',
            'captions.*' => 'nullable|string|max:255'
        ]);

        // Validate and process payment plan
        if (isset($validated['payment_plan']) && !empty($validated['payment_plan'])) {
            $paymentPlanData = json_decode($validated['payment_plan'], true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json([
                    'message' => 'Invalid payment plan JSON format'
                ], 422);
            }

            // Validate payment plan structure
            if (!isset($paymentPlanData['paymentMethod']) || !in_array($paymentPlanData['paymentMethod'], ['cash', 'bank'])) {
                return response()->json([
                    'message' => 'Payment method must be either "cash" or "bank"'
                ], 422);
            }

            // Validate based on payment method
            if ($paymentPlanData['paymentMethod'] === 'cash') {
                if (!isset($paymentPlanData['cashAmount']) || !is_numeric($paymentPlanData['cashAmount']) || $paymentPlanData['cashAmount'] < 0) {
                    return response()->json([
                        'message' => 'Cash amount is required and must be a positive number'
                    ], 422);
                }
            } elseif ($paymentPlanData['paymentMethod'] === 'bank') {
                if (!isset($paymentPlanData['bankFullAmount']) || !is_numeric($paymentPlanData['bankFullAmount']) || $paymentPlanData['bankFullAmount'] < 0) {
                    return response()->json([
                        'message' => 'Bank full amount is required and must be a positive number'
                    ], 422);
                }
                if (!isset($paymentPlanData['bankDownPayment']) || !is_numeric($paymentPlanData['bankDownPayment']) || $paymentPlanData['bankDownPayment'] < 0) {
                    return response()->json([
                        'message' => 'Bank down payment is required and must be a positive number'
                    ], 422);
                }
            }

            // Store as JSON string (will be cast to array by model)
            $validated['payment_plan'] = json_encode($paymentPlanData);
        }

        // Process additional_housing_types if provided
        if (isset($validated['additional_housing_types']) && !empty($validated['additional_housing_types'])) {
            $additionalTypes = json_decode($validated['additional_housing_types'], true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($additionalTypes)) {
                // Filter out empty values - handle both old format (strings) and new format (objects)
                $filtered = array_filter($additionalTypes, function($item) {
                    if (is_string($item)) {
                        return !empty($item);
                    }
                    if (is_array($item) || is_object($item)) {
                        $item = (array)$item;
                        return !empty($item['type']);
                    }
                    return false;
                });
                $validated['additional_housing_types'] = json_encode(array_values($filtered)); // Re-index array
            } else {
                unset($validated['additional_housing_types']);
            }
        }

        // Convert location array to JSON string if present
        if (isset($validated['location'])) {
            $validated['location'] = json_encode($validated['location']);
        }

        $project->update($validated);

        // Handle image uploads if any new images are provided
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                // Generate a unique filename with timestamp
                $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                
                // Store the file directly in public/storage/project-images
                $publicPath = public_path('storage/project-images');
                if (!file_exists($publicPath)) {
                    mkdir($publicPath, 0777, true);
                }
                $image->move($publicPath, $filename);
                
                // Get caption if provided
                $caption = isset($validated['captions'][$index]) 
                    ? $validated['captions'][$index] 
                    : null;
                
                // Create new image record
                $project->images()->create([
                    'image_path' => '/storage/project-images/' . $filename,
                    'caption' => $caption
                ]);
            }
        }

        // Load the images relationship for the response
        $project->load(['images', 'user']);

        return response()->json($project);
    }

    // Delete project
    public function destroy(Request $request, $id)
    {
        $project = $request->user()->projects()->findOrFail($id);
        $project->delete();

        return response()->json(['message' => 'Project deleted']);
    }

    /**
     * Get all projects for the authenticated user
     *
     * @OA\Get(
     *     path="/api/user/projects",
     *     summary="Get all projects for the authenticated user",
     *     tags={"User Projects"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of user's projects",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Project")
     *         )
     *     )
     * )
     */
    public function userProjects(Request $request)
    {
        $projects = $request->user()
            ->projects()
            ->with(['images', 'user'])
            ->latest()
            ->get();

        return response()->json($projects);
    }
}
