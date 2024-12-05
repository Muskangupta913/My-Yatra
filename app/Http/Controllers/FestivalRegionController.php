<?php

namespace App\Http\Controllers;

use App\Models\FestivalRegion; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FestivalRegionController extends Controller
{
    /**
     * Display a listing of festival regions.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            // Method 1: Using get()->toArray()
            $festivalRegions = collect($festivalRegions)->map(function($region) {
                return (object) $region;
            });
            
            // Or if using Eloquent
$festivalRegions = festivalRegions::all();

            // Alternative Method 2: Using collection mapping
            $festivalRegions = YourModel::all()->map(function ($region) {
                return [
                    'name' => $region->name,
                    'image' => $region->image,
                    'festivals' => explode(',', $region->festivals), // If stored as comma-separated string
                    'significance' => $region->significance,
                    'best_places' => explode(',', $region->best_places)
                ];
            })->toArray();

            return response()->json([
                'success' => true,
                'data' => $festivalRegions,
                'total' => count($festivalRegions)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving festival regions',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified festival region.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $region = YourModel::findOrFail($id);

            $regionDetails = [
                'name' => $region->name,
                'image' => $region->image,
                'festivals' => explode(',', $region->festivals),
                'significance' => $region->significance,
                'best_places' => explode(',', $region->best_places)
            ];

            return response()->json([
                'success' => true,
                'data' => $regionDetails
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Festival region not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Store a newly created festival region.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:your_model_table,name',
            'image' => 'nullable|url',
            'festivals' => 'nullable|array',
            'significance' => 'nullable|string',
            'best_places' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $region = new YourModel();
            $region->name = $request->input('name');
            $region->image = $request->input('image');
            $region->festivals = implode(',', $request->input('festivals', []));
            $region->significance = $request->input('significance');
            $region->best_places = implode(',', $request->input('best_places', []));
            $region->save();

            return response()->json([
                'success' => true,
                'message' => 'Festival region created successfully',
                'data' => $region
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating festival region',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified festival region.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255|unique:your_model_table,name,' . $id,
            'image' => 'nullable|url',
            'festivals' => 'nullable|array',
            'significance' => 'nullable|string',
            'best_places' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $region = YourModel::findOrFail($id);

            if ($request->has('name')) {
                $region->name = $request->input('name');
            }
            if ($request->has('image')) {
                $region->image = $request->input('image');
            }
            if ($request->has('festivals')) {
                $region->festivals = implode(',', $request->input('festivals'));
            }
            if ($request->has('significance')) {
                $region->significance = $request->input('significance');
            }
            if ($request->has('best_places')) {
                $region->best_places = implode(',', $request->input('best_places'));
            }

            $region->save();

            return response()->json([
                'success' => true,
                'message' => 'Festival region updated successfully',
                'data' => $region
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating festival region',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    /**
     * Remove the specified festival region.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $region = YourModel::findOrFail($id);
            $region->delete();

            return response()->json([
                'success' => true,
                'message' => 'Festival region deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting festival region',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search festival regions by name or significance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        try {
            $regions = YourModel::where('name', 'LIKE', "%{$query}%")
                ->orWhere('significance', 'LIKE', "%{$query}%")
                ->get()
                ->map(function ($region) {
                    return [
                        'name' => $region->name,
                        'image' => $region->image,
                        'festivals' => explode(',', $region->festivals),
                        'significance' => $region->significance,
                        'best_places' => explode(',', $region->best_places)
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $regions,
                'total' => count($regions)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error searching festival regions',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

// In your controller
$festivalRegions = [
    (object)[
        'name' => 'South India',
        'image' => 'south-india.jpg',
        'festivals' => ['Pongal', 'Onam', 'Diwali'], // Ensure this is an array
        'significance' => 'Rich cultural heritage',
        'best_places' => ['Tamil Nadu', 'Kerala', 'Karnataka']
    ],
    // More regions...
];
