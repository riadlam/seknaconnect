<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

/**
 * @OA\Tag(
 *     name="Project Filters",
 *     description="API Endpoints for filtering projects"
 * )
 */
class ProjectFilterController extends Controller
{
    /**
     * Filter projects based on multiple criteria
     *
     * @OA\Get(
     *     path="/api/projects/filter",
     *     summary="Filter projects by multiple criteria",
     *     tags={"Project Filters"},
     *     @OA\Parameter(
     *         name="housing_type",
     *         in="query",
     *         description="Filter by housing type (e.g., apartment, villa)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="num_units_min",
     *         in="query",
     *         description="Minimum number of units",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="num_units_max",
     *         in="query",
     *         description="Maximum number of units",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="location",
     *         in="query",
     *         description="Filter by location (partial match)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="delivery_date_min",
     *         in="query",
     *         description="Minimum delivery date",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="delivery_date_max",
     *         in="query",
     *         description="Maximum delivery date",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
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
     *     @OA\Parameter(
     *         name="surface_area_min",
     *         in="query",
     *         description="Minimum surface area",
     *         required=false,
     *         @OA\Schema(type="number", format="float")
     *     ),
     *     @OA\Parameter(
     *         name="surface_area_max",
     *         in="query",
     *         description="Maximum surface area",
     *         required=false,
     *         @OA\Schema(type="number", format="float")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of filtered projects",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="count", type="integer"),
     *             @OA\Property(property="filters", type="object"),
     *             @OA\Property(
     *                 property="projects",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Project")
     *             )
     *         )
     *     )
     * )
     */
    public function filter(Request $request)
    {
        // Validate input parameters
        $validated = $request->validate([
            'search' => 'nullable|string|max:255',
            'housing_type' => 'nullable|string|max:100',
            'num_units_min' => 'nullable|integer|min:1',
            'num_units_max' => 'nullable|integer|min:1',
            'bedrooms_min' => 'nullable|numeric|min:0',
            'bedrooms_max' => 'nullable|numeric|min:0',
            'bathrooms_min' => 'nullable|numeric|min:0',
            'bathrooms_max' => 'nullable|numeric|min:0',
            'location' => 'nullable|string',
            'wilaya' => 'nullable|string',
            'commune' => 'nullable|string',
            'daira' => 'nullable|string',
            'delivery_date_min' => 'nullable|date|before_or_equal:delivery_date_max',
            'delivery_date_max' => 'nullable|date|after_or_equal:delivery_date_min',
            'price_min' => 'nullable|numeric|min:0',
            'price_max' => 'nullable|numeric|min:0',
            'surface_area_min' => 'nullable|numeric|min:0',
            'surface_area_max' => 'nullable|numeric|min:0',
            'f1_count_min' => 'nullable|integer|min:0',
            'f1_count_max' => 'nullable|integer|min:0',
            'f2_count_min' => 'nullable|integer|min:0',
            'f2_count_max' => 'nullable|integer|min:0',
            'f3_count_min' => 'nullable|integer|min:0',
            'f3_count_max' => 'nullable|integer|min:0',
            'f4_count_min' => 'nullable|integer|min:0',
            'f4_count_max' => 'nullable|integer|min:0'
        ], [
            'delivery_date_min.before_or_equal' => 'Delivery date min must be before or equal to delivery date max',
            'delivery_date_max.after_or_equal' => 'Delivery date max must be after or equal to delivery date min'
        ]);

        // Initialize query with eager loading and filter for verified users
        $query = Project::query()->with(['images', 'user'])
            ->whereHas('user', function($q) {
                $q->where('is_verified', 1);
            });

        // Apply search filter
        if ($validated['search'] ?? null) {
            $searchTerm = $validated['search'];
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('location', 'like', "%{$searchTerm}%");
            });
        }

        // Apply filters
        if ($validated['housing_type'] ?? null) {
            $query->where('housing_type', $validated['housing_type']);
        }

        if ($validated['num_units_min'] ?? null) {
            $query->where('num_units', '>=', $validated['num_units_min']);
        }

        if ($validated['num_units_max'] ?? null) {
            $query->where('num_units', '<=', $validated['num_units_max']);
        }

        if (($validated['wilaya'] ?? null) || ($validated['commune'] ?? null) || ($validated['daira'] ?? null)) {
            $query->where(function($q) use ($validated) {
                if ($validated['wilaya'] ?? null) {
                    $q->where('location', 'like', '%"wilaya":"' . $validated['wilaya'] . '"%');
                }
                if ($validated['commune'] ?? null) {
                    $q->where('location', 'like', '%"commune":"' . $validated['commune'] . '"%');
                }
                if ($validated['daira'] ?? null) {
                    $q->where('location', 'like', '%"daira":"' . $validated['daira'] . '"%');
                }
            });
        } elseif ($validated['location'] ?? null) {
            // Fallback to the old location search if no specific location components are provided
            $query->where('location', 'like', "%{$validated['location']}%");
        }

        if ($validated['delivery_date_min'] ?? null) {
            $query->where('delivery_date', '>=', $validated['delivery_date_min']);
        }

        if ($validated['delivery_date_max'] ?? null) {
            $query->where('delivery_date', '<=', $validated['delivery_date_max']);
        }

        if ($validated['price_min'] ?? null) {
            $query->where('price', '>=', $validated['price_min']);
        }

        if ($validated['price_max'] ?? null) {
            $query->where('price', '<=', $validated['price_max']);
        }

        if ($validated['surface_area_min'] ?? null) {
            $query->where('surface_area', '>=', $validated['surface_area_min']);
        }

        if ($validated['surface_area_max'] ?? null) {
            $query->where('surface_area', '<=', $validated['surface_area_max']);
        }

        if ($validated['bedrooms_min'] ?? null) {
            $query->where('bedrooms', '>=', $validated['bedrooms_min']);
        }

        if ($validated['bedrooms_max'] ?? null) {
            $query->where('bedrooms', '<=', $validated['bedrooms_max']);
        }

        if ($validated['bathrooms_min'] ?? null) {
            $query->where('bathrooms', '>=', $validated['bathrooms_min']);
        }

        if ($validated['bathrooms_max'] ?? null) {
            $query->where('bathrooms', '<=', $validated['bathrooms_max']);
        }

        // Apply F1-F4 filters (for apartments)
        // If any F type is selected, filter for projects that have at least 1 of any selected type (OR logic)
        $hasF1Filter = isset($validated['f1_count_min']) && $validated['f1_count_min'] >= 1;
        $hasF2Filter = isset($validated['f2_count_min']) && $validated['f2_count_min'] >= 1;
        $hasF3Filter = isset($validated['f3_count_min']) && $validated['f3_count_min'] >= 1;
        $hasF4Filter = isset($validated['f4_count_min']) && $validated['f4_count_min'] >= 1;
        
        if ($hasF1Filter || $hasF2Filter || $hasF3Filter || $hasF4Filter) {
            $query->where(function($q) use ($hasF1Filter, $hasF2Filter, $hasF3Filter, $hasF4Filter) {
                $first = true;
                if ($hasF1Filter) {
                    $q->where('f1_count', '>=', 1);
                    $first = false;
                }
                if ($hasF2Filter) {
                    if ($first) {
                        $q->where('f2_count', '>=', 1);
                        $first = false;
                    } else {
                        $q->orWhere('f2_count', '>=', 1);
                    }
                }
                if ($hasF3Filter) {
                    if ($first) {
                        $q->where('f3_count', '>=', 1);
                        $first = false;
                    } else {
                        $q->orWhere('f3_count', '>=', 1);
                    }
                }
                if ($hasF4Filter) {
                    if ($first) {
                        $q->where('f4_count', '>=', 1);
                    } else {
                        $q->orWhere('f4_count', '>=', 1);
                    }
                }
            });
        }

        // Execute query and get all results (no pagination)
        $projects = $query->get();
        $count = $projects->count();

        // Build filter details message
        $filterDetails = [];
        if ($validated['housing_type'] ?? null) {
            $filterDetails[] = "type: {$validated['housing_type']}";
        }
        if (($validated['num_units_min'] ?? null) || ($validated['num_units_max'] ?? null)) {
            $min = $validated['num_units_min'] ?? '';
            $max = $validated['num_units_max'] ?? '';
            $filterDetails[] = "units: {$min}-{$max}";
        }
        if ($validated['location'] ?? null) {
            $filterDetails[] = "location: '{$validated['location']}'";
        }
        if (($validated['delivery_date_min'] ?? null) || ($validated['delivery_date_max'] ?? null)) {
            $min = $validated['delivery_date_min'] ?? '';
            $max = $validated['delivery_date_max'] ?? '';
            $filterDetails[] = "delivery: {$min} to {$max}";
        }
        if (($validated['price_min'] ?? null) || ($validated['price_max'] ?? null)) {
            $min = $validated['price_min'] ? number_format($validated['price_min']) : '';
            $max = $validated['price_max'] ? number_format($validated['price_max']) : '';
            $filterDetails[] = "price: {$min}-{$max}";
        }
        if (($validated['surface_area_min'] ?? null) || ($validated['surface_area_max'] ?? null)) {
            $min = $validated['surface_area_min'] ?? '';
            $max = $validated['surface_area_max'] ?? '';
            $filterDetails[] = "area: {$min}-{$max} sqm";
        }

        $filterText = !empty($filterDetails) ? ' with ' . implode(', ', $filterDetails) : '';

        if ($count === 0) {
            return response()->json([
                'message' => "No projects found{$filterText}",
                'count' => 0,
                'filters' => $validated,
                'projects' => []
            ], 200);
        }

        return response()->json([
            'message' => "Found {$count} projects{$filterText}",
            'count' => $count,
            'filters' => $validated,
            'projects' => $projects
        ]);
    }
}
