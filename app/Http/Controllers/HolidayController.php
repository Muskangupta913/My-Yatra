<?php
use App\Models\State; // Assuming you're using the State model for destinations
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    // Method to search for destinations (states)
    public function searchDestinations(Request $request)
    {
        $query = $request->get('query'); // Get the search query from the request
        $destinations = State::where('destination_name', 'LIKE', '%' . $query . '%')->get(['id', 'destination_name']);

        return response()->json($destinations);
    }
}
