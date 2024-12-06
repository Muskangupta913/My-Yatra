<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\City;

class CityController extends Controller
{
    public function delhi()
    {
        return view('delhi');
    }

    public function goaTour()
    {
        return view('goaTour');
    }

    public function manali()
    {
        return view('manali');
    }

    public function kerala(Request $request)
    {
        return view('kerala');
    }

    public function coimbatore()
    {
        return view('coimbatore');
    }

    public function mussoorie()
    {
        return view('mussoorie');
    }
    public function fetchAllCities()
    {
        $cities = City::all(); // Ensure 'City' model and table are correctly configured
        return response()->json($cities);
    }
    
     
    public function searchCities(Request $request)
{
    $stateId = $request->input('state_id');
    $cities = City::where('state_id', $stateId)->get();
    return response()->json($cities);
}

}
