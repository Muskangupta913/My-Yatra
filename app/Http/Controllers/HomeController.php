<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Destination;
use App\Models\Package;
use App\Models\State;
use App\Models\City;
use App\Models\TourType;
use App\Models\JobApplication;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class HomeController extends Controller
{
    public function index(){

         $destinations = DB::table('destination')
        ->join('states', 'destination.destination_id', '=', 'states.id') // Join the states table
        ->select('destination.destination_id', 'destination.slug', 'destination.photo', 'destination.status', 'states.destination_name as state_name') // Select fields from both tables
        ->get();

        // fetch by tourType
        $tourTypes = TourType::select('id', 'name')
        ->whereHas('packages') // Only fetch tour types that have related packages
        ->with(['packages' => function($query) {
            $query->select('id', 'tour_type_id', 'photo', 'package_name'); // Fetch the latest single package
        }])->get();

       // dd($tourTypes);

        // Get Packages  Data

       $tourpackages = Package::with('destination')->orderBy('id', 'desc')->limit(12)->get();

       // dd($tourpackages);
        //dd($destinations);
        return view('frontend.index', compact('destinations', 'tourTypes', 'tourpackages'));
    }

    public function packages(Request $request, $slug){

        $destinations = Destination::where('slug', $slug)->first();
        $packages = Package::where('destination_id', $destinations->destination_id)->get();
     //   dd($packages);



        return view('frontend.packages', compact('destinations', 'packages'));
    }

    public function packagesDetails($destinationSlug, $packageSlug)
    {
        // Use the $destinationSlug and $packageSlug as needed
    // dd($packageSlug); 
    $destination = Destination::where('slug', $destinationSlug)->first();

    $package = Package::with(['photos', 'tourType'])
    ->where('slug', $packageSlug)
    ->first();
    
    // dd($package);
        
        return view('frontend.packageDetails', compact('package'));
    }

    public function packageDetails($slug){

        $package = Package::with(['photos', 'tourType'])
        ->where('slug', $slug)
        ->first();
    return view('frontend.holidayPackages', compact('package'));
    }

    // Tour Type Category
    public function tourTypeData($slug){

        //dd($slug);

        function slugToTitle($slug) {
            $title = str_replace('-', ' ', $slug);
            $title = ucwords($title);
            return $title;
        }
        $title = slugToTitle($slug);
        
        $newSlug  = $slug;

        $tourTypes = TourType::whereRaw('LOWER(name) = ?', [strtolower($title)])->first();
        $packages = Package::where('tour_type_id', $tourTypes->id)->get();
       return view('frontend.tourType', compact('packages', 'tourTypes', 'newSlug'));
    }


    public function showTour($newSlug, $slug){
        // dd($slug);

        $package = Package::where('slug', $slug)->firstOrFail();

       // dd($packages->package_name);

       return view('frontend.touTypeDeatils', compact('package'));
        
    }

// booking Functions
    public function store(Request $request)
    {
        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'package_id' => 'required',
                'full_name' => 'required|string|max:255',
                'phone' => [
                    'required',
                    'string',
                    'regex:/^[0-9]{10}$/',
                    function($attribute, $value, $fail) {
            // Add custom logic to prevent invalid phone numbers
            $invalidNumbers = [
                '0000000000',
                '1111111111',
                '2222222222',
                '3333333333',
                '4444444444',
                '5555555555',
                '6666666666',
                '7777777777',
                '8888888888',
                '9999999999',
            ];

            if (in_array($value, $invalidNumbers)) {
                $fail('The phone number entered is invalid.');
            }
        }
    ], // Proper phone validation
                'email' => 'required|email|max:255',
                'adults' => 'required|integer|min:1',
                'children' => 'required|integer|min:0',
                'travel_date' => 'required|date|after:today',
                'terms' => 'required|boolean'
            ]);

            // If validation passes, store the booking in the database
            Booking::create([
                'package_id' => $validatedData['package_id'],
                'full_name' => $validatedData['full_name'],
                'phone' => $validatedData['phone'],
                'email' => $validatedData['email'],
                'adults' => $validatedData['adults'],
                'children' => $validatedData['children'],
                'travel_date' => $validatedData['travel_date'],
                'terms_accepted' => $validatedData['terms'],
            ]);

            return response()->json(['success' => 'Booking confirmed successfully!']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Catch validation errors and return them to the frontend
            return response()->json([
                'errors' => $e->validator->getMessageBag()
            ], 422);
        } catch (\Exception $e) {
            // Catch any other exception
            return response()->json(['error' => 'There was an error processing your booking.'], 500);
        }
    }


// filter data
// public function filterPackages(Request $request, $slug)
// {
//     // Get the filter inputs
//     $prices = $request->input('prices');
//     $durations = $request->input('durations');

//     // Start query for filtering packages
//     $query = Package::query();

//     // Filter by price ranges
//     if ($prices) {
//         $query->where(function($q) use ($prices) {
//             foreach ($prices as $price) {
//                 if ($price == 10000) {
//                     $q->orWhere('price', '<', 10000);
//                 } elseif ($price == 20000) {
//                     $q->orWhereBetween('price', [10000, 20000]);
//                 } elseif ($price == 35000) {
//                     $q->orWhereBetween('price', [20000, 35000]);
//                 } elseif ($price == 35001) {
//                     $q->orWhere('price', '>', 35000);
//                 }
//             }
//         });
//     }

//     // Filter by durations
//     if ($durations) {
//         $query->whereIn('duration', $durations); // Assuming duration is stored in a field 'duration'
//     }

//     // Get the filtered results
//     $packages = $query->get();

//     // Return the filtered packages as a response
//     return view('frontend.packages', compact('packages'));
// }

public function filterPackages(Request $request, $slug)
{

     dd($request->input('prices'));

    $prices = $request->input('prices');
    $durations = $request->input('durations');

    // Apply filter logic based on prices and durations
    $packages = Package::when($prices, function ($query) use ($prices) {
        return $query->whereIn('offer_price', $prices);
    })
    ->when($durations, function ($query) use ($durations) {
        return $query->whereIn('duration', $durations);
    })
    ->get();

    // dd($packages);

    // Return the filtered package list as HTML (a partial view)
    return view('frontend.packages', compact('packages'));
}

// Search Engine
public function search(Request $request)
{
    $searchTerm = $request->input('query');

    // Fetch matching destinations from the database
    $destinations = State::where('destination_name', 'LIKE', "{$searchTerm}%")->get();

    // Return only the relevant data
    return response()->json($destinations);
}

public function fetchAllStates()
{
    $states = DB::table('states')->get();  // Fetch all states from the 'states' table
    return response()->json($states);  // Return the result as a JSON response
}

public function searchCities(Request $request)
{
    $stateId = $request->input('state_id');
    $cities = City::where('state_id', $stateId)->get();

    return response()->json($cities);
}

public function searchPackages(Request $request)
{

    $destination = $request->input('searchDestination');
    $city = $request->input('searchCity');
    $travelDate = $request->input('travel_date');


    // Convert travelDate to the correct format if needed
    if (!empty($travelDate)) {
        $travelDate = date('Y-m-d', strtotime($travelDate));  // Ensures the date is in 'YYYY-MM-DD' format
    }

    // Fetch the destination by name
    $state = State::where('destination_name', 'like', '%' . $destination . '%')->first();

    // dd($state->state_slug);
   

    // Initialize an empty package query
    $packages = Package::query();

    // Filter by destination if found
    if ($state) {
        $packages->where('destination_id', $state->id);
    }

    // Only filter by city if a city was provided
    if (!empty($city)) {
        $city = City::where('city_name', 'like', '%' . $city . '%')->first();
        if ($city) {
            $packages->where('city_id', $city->id);
        }
    }

    // Filter by travel date if provided
    if (!empty($travelDate)) {
        $packages->where('start_date', '<=', $travelDate)
                 ->where('end_date', '>=', $travelDate);
    }

    // Get the final package results
    $packages = $packages->get();

  //  dd($packages);

    return view('frontend.package_list', compact('packages', 'state'));
}

// addon static pages section

public function aboutUs(){
    return view('frontend.about');
}
public function services(){
    return view('frontend.service');
}

public function contactUs(){
    return view('frontend.contact');
}

public function membership(){
    return view('frontend.membership');
}
public function career(){
    return view('frontend.career');
}


public function termsCondition(){
    return view('frontend.terms-and-conditions');
}

public function tourfilterPackages(Request $request, $slug)
{
    // Fetch the destination based on the slug
    $destinations = Destination::where('slug', $slug)->firstOrFail();

    $packagesFilter = []; // Set an empty array as a default value

    // Get the filter inputs
    $price = $request->input('price', []);  // Default to an empty array
    $duration = $request->input('duration', []);  // Default to an empty array
    $type = $request->input('type', []);  // Default to an empty array

    // Query the packages based on the destination
    $query = DB::table('package')
            ->where('destination_id', $destinations->destination_id);

    // Apply price filter
    if (!empty($price)) {
        $query->where(function($q) use ($price) {
            foreach ($price as $p) {
                if ($p == 10000) {
                    $q->orWhere('offer_price', '<=', 10000);
                } elseif ($p == 20000) {
                    $q->orWhereBetween('offer_price', [10001, 20000]);
                } elseif ($p == 35000) {
                    $q->orWhereBetween('offer_price', [20001, 35000]);
                } else {
                    $q->orWhere('offer_price', '>', 35000);
                }
            }
        });
    }

    // Apply duration filter
    if (!empty($duration)) {
        $query->whereIn('duration', $duration);
    }

    // Apply type filter
    if (!empty($type)) {
        $query->whereIn('tour_type_id', $type);
    }

    // Fetch the filtered packages
    $packagesFilter = $query->get();

    //dd($packagesFilter);

    // Return the filtered data as a view
    //return view('frontend.packages', compact('packagesFilter', 'destinations'));
    // Return JSON response instead of a view
    return response()->json([
        'packagesFilter' => $packagesFilter,
        'destinations' => $destinations
    ]);
}




// Tour type Filter 
public function tourTypefilterPackages(Request $request, $slug){

   
    function slugToTitles($slug) {
        $title = str_replace('-', ' ', $slug);
        $title = ucwords($title);
        return $title;
    }
    $title = slugToTitles($slug);
    
   $newSlug  = $slug;

    $tourTypes = TourType::whereRaw('LOWER(name) = ?', [strtolower($title)])->first();
  //  $packages = Package::where('tour_type_id', $tourTypes->id)->get();



    $packagesFilter = []; // Set an empty array as a default value

    // Get the filter inputs
    $price = $request->input('price', []);  // Default to an empty array
    $duration = $request->input('duration', []);  // Default to an empty array
    $type = $request->input('type', []);  // Default to an empty array

    // Query the packages based on the destination
    $query = DB::table('package')
            ->where('tour_type_id', $tourTypes->id);

    // Apply price filter
    if (!empty($price)) {
        $query->where(function($q) use ($price) {
            foreach ($price as $p) {
                if ($p == 10000) {
                    $q->orWhere('offer_price', '<=', 10000);
                } elseif ($p == 20000) {
                    $q->orWhereBetween('offer_price', [10001, 20000]);
                } elseif ($p == 35000) {
                    $q->orWhereBetween('offer_price', [20001, 35000]);
                } else {
                    $q->orWhere('offer_price', '>', 35000);
                }
            }
        });
    }

    // Apply duration filter
    if (!empty($duration)) {
        $query->whereIn('duration', $duration);
    }

    // Apply type filter
    if (!empty($type)) {
        $query->whereIn('tour_type_id', $type);
    }

    // Fetch the filtered packages
    $packagesFilter = $query->get();

    //dd($packagesFilter);

    // Return the filtered data as a view
    //return view('frontend.packages', compact('packagesFilter', 'destinations'));
    // Return JSON response instead of a view
    return response()->json([
        'packagesFilter' => $packagesFilter,
        'tourTypes' => $tourTypes,
        'newSlug' => $newSlug
       
    ]);

}






public function careerApply(){
    return view('frontend.career-form');
}


public function jobApply(Request $request)
{
   // Validate the request data
$request->validate([
    'name' => 'required|string|max:255',
    'phone' => ['required', 'regex:/^[6-9]\d{9}$/', 'unique:job_applications,phone'],  // Mobile number must start with 6-9 and be 10 digits
    'email' => 'required|email|unique:job_applications,email',
    'adhar-number' => 'required|digits:12', // Aadhaar must be exactly 12 digits
 'dob' => 'required|date|before:' . now()->subYears(18)->format('Y-m-d') . '|after:' . now()->subYears(45)->format('Y-m-d'), // Age must be between 16 and 45 
    'pincode' => 'required|digits:6', // Pincode must be exactly 6 digits
    'category' => 'required|string',
    'state' => 'required|string',
    'photo' => 'nullable|file|mimes:jpg,png,jpeg|max:1048', // 2MB max
    'certificate' => 'nullable|file|mimes:pdf,jpg,png|max:1048', // 2MB max
],
[
    'dob.before' => 'You must be at least 18 years old.',
    'dob.after' => 'You must be younger than 45 years old.',
]
);

    // Handle file uploads
    $photoPath = $request->file('photo') ? $request->file('photo')->store('uploads/photos', 'public') : null;
    $certificatePath = $request->file('certificate') ? $request->file('certificate')->store('uploads/certificates', 'public') : null;

    // Create new job application
    JobApplication::create([
        'name' => $request->input('name'),
        'phone' => $request->input('phone'),
        'email' => $request->input('email'),
        'adhar_number' => $request->input('adhar-number'),
        'dob' => $request->input('dob'),
        'pincode' => $request->input('pincode'),
        'category' => $request->input('category'),
        'state' => $request->input('state'),
        'photo' => $photoPath,
        'certificate' => $certificatePath,
    ]);

    return back()->with('success', 'Application submitted successfully!');
}

public function contactApplied(Request $request){

    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => ['required', 'regex:/^[6-9]\d{9}$/', 'unique:contact,phone'], // Mobile number must start with 6-9 and be 10 digits
        'email' => 'required|email|unique:contact,email',
    ],
    ['phone' => 'Mobile number should be 10 Digits']
);

    $contact = new Contact;

    $contact->name =  $request->name;
    $contact->email =  $request->email;
    $contact->phone =  $request->phone;
    $contact->message =  $request->message;
    $contact->save();

    return back()->with('success', 'Thank You, Our Team will connect you soon!');

}

public function addtocard()
{
    // Add any logic needed for the checkout page
    return view('frontend.checkout'); // Ensure you have a 'checkout.blade.php' view
}

public function  payment()
{
    return view('frontend.payment');
}
public function ourblog(){
    return view('frontend.our-blog');
}

}

