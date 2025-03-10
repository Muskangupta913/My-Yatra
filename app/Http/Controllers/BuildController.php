<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;
use App\Models\TourPlace;

class BuildController extends Controller
{
    /**
     * Show the build page with state and cities
     */
    public function index($state_id)
    {
        // Get the state
        $state = State::findOrFail($state_id);
        
        // Get all cities in the state
        $cities = City::where('state_id', $state_id)->get();
        
        return view('frontend.build', compact('state', 'cities'));
    }
    
    /**
     * API endpoint to get tour places by city
     */
    public function getTourPlacesByCity($city_id)
    {
        // Get all tour places for the given city
        $tourPlaces = TourPlace::where('city_id', $city_id)->get();
        
        return response()->json($tourPlaces);
    }
}