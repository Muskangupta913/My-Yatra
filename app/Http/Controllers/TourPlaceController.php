<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;
use App\Models\TourPlace;

class TourPlaceController extends Controller
{
    public function index()
    {
        $tourPlaces = TourPlace::all();
        return view('admin.tour-place-index', compact('tourPlaces'));
    }

    public function create()
    {
        $states = State::all();
        return view('admin.tour-place-create', compact('states'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video' => 'nullable|string'
        ]);
    
        // Store image with the original filename
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $originalName = $file->getClientOriginalName(); // Get the original filename
    
            // Save the file in the 'public/uploads/tour_places/' directory with the original name
            $filePath = $file->storeAs('public/uploads/tour_places', $originalName);
        }
    
        // Save data in the database
        TourPlace::create([
            'name' => $request->name,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'price' => $request->price,
            'description' => $request->description,
            'photo' => $originalName, // Store the original filename in the database
            'video' => $request->video
        ]);
    
        return redirect()->route('tourPlace')->with('success', 'Tour Place added successfully!');
    }
    
    public function edit($id)
    {
        $tourPlace = TourPlace::findOrFail($id);
        $states = State::all();
        $cities = City::where('state_id', $tourPlace->state_id)->get();
        return view('admin.tour-place-edit', compact('tourPlace', 'states', 'cities'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|string|max:255',
        ]);

        $tourPlace = TourPlace::findOrFail($id);
        $tourPlace->state_id = $request->state_id;
        $tourPlace->city_id = $request->city_id;
        $tourPlace->name = $request->name;
        $tourPlace->description = $request->description;
        $tourPlace->price = $request->price;
        if ($request->hasFile('photo')) {
            $tourPlace->photo = $request->file('photo')->store('tour-places');
        }
        $tourPlace->video = $request->video;
        $tourPlace->save();

        return redirect()->route('tourPlace')->with('success', 'Tour Place updated successfully');
    }

    public function getTourPlacesByCity($cityId)
    {
        $tourPlaces = TourPlace::where('city_id', $cityId)->get();
        return response()->json($tourPlaces);
    }
    
}
