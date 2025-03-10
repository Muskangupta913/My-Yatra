<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
use App\Models\PackagePhoto;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\PackageVideo;
use App\Models\Destination;
use App\Models\State;
use App\Models\City;
use Illuminate\Support\Str; // Import Str helper
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\JobApplication;
use App\Models\Contact;
use App\Models\Passenger;
use Carbon\Carbon;
use App\Models\VisitPlace;

class SalesController extends Controller
{

    public function dashboardsales(){
         // Fetch all states and their related cities
         $states = State::with('cities')->get();
         $places = VisitPlace::with(['state', 'city'])->get();
        $packageCount = DB::table('package')->count();
        $destinationCount = DB::table('destination')->count();
        $bookingCount = DB::table('bookings')->count();
        $cardDetailsCount = DB::table('cardpays')->count();

        $bookings = DB::table('bookings')
            ->whereDate('created_at', Carbon::today())
            ->count();

        $jobs = DB::table('job_applications')->count();
         // Fetch tour types from the database
    $tourTypes = DB::table('tour_type')->get();
       
        return view('sales.dashboard', compact('states','tourTypes','packageCount', 'destinationCount','bookingCount', 'bookings', 'cardDetailsCount', 'jobs', 'places'));
    }
    public function logout()
    {
        auth()->logout();
        return redirect()->route('loginView');
    }
    
    public function cardDetails()
{
    // Retrieve card payment details
    $cardDetails = DB::table('cardpays')
        ->select('name', 'email', 'mobile_no', 'total_amount', 'created_at')
        ->orderBy('created_at', 'desc') // Show latest payments first
        ->get();

    // Pass data to the view
    return view('sales.cardDetails', compact('cardDetails'));
}
   
    public function getCities($state_id)
{
    $cities = City::where('state_id', $state_id)->get();
    return response()->json($cities);
}
    // tour type section start
    public function tourType(){
       $tourtype = DB::table('tour_type')->get();
        return  view('sales.tour-type', compact('tourtype'));
    }

    public function createTour(Request $request){
        $request->validate([
            'tour' => 'required',
        ]);

        $checkTour =  DB::table('tour_type')->where('name', $request->tour)->first();
        if($checkTour){
            return redirect()->back()->with('error', 'Tour Type Name Already Exists!');
        }else{
            DB::table('tour_type')->insert([
                'name' => $request->tour,
            ]);
            return redirect()->back()->with('success', 'Tour Type Added Successfully');  
        }
    }

    public function updateTour(Request $request){
        $request->validate([
            'tour' => 'required',
        ]);

        DB::table('tour_type')->where('id', $request->id)->update([
            'name' => $request->tour,
        ]);
        return redirect()->back()->with('success', 'Tour Type Updated Successfully');
    }

    public function city(){
        $states = State::get();
        $cities = City::with('destination')->get();
       
        // dd($cities);

        return view('sales.city', compact('states', 'cities'));
    }

    public function createCity(Request $request){
        // dd($request->all());
        $request->validate([
            'city' => 'required',
            'state' => 'required',
        ]);
         
    $city = new City();
    $city->state_id = $request->state;
    $city->city_name = $request->city;
    $city->save();
    return redirect()->back()->with('success', 'City Added Successfully');
    
    }

    public function updateCity(Request $request){

         $request->validate([
            'city' => 'required',
        ]);

        DB::table('cities')->where('id', $request->id)->update([
            'city_name' => $request->city,
        ]);
        return redirect()->back()->with('success', 'City Updated Successfully');
    }

    public function cityDelete(Request $request){
        DB::table('cities')->where('id', $request->id)->delete();
        return redirect()->back()->with('success', 'City Deleted Successfully');
    }

    // destination section start
    public function destination(){
        $destinations = Destination::get();
        return view("sales.destination", compact('destinations'));
    }

    public function create_destination(){
       
        $states = State::all();
        return view('sales.destination-create', compact('states'));
    }

    //add destination
    public function destinationCreate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'destination_id' => 'required',
            'slug' => 'required|string|max:255|unique:destination,slug',
            'heading' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp'
        ]);
        // dd($request->all());

      // Check if destination_id already exists
    $existingDestination = Destination::where('destination_id', $request->destination_id)->first();
    if ($existingDestination) {
        return redirect()->back()->withErrors(['destination_id' => 'This destination ID already exists.'])->withInput();
    }

        $slug = Str::slug($request->slug);
        $destination = new Destination();
        $destination->destination_name = $request->name;
        $destination->destination_id = $request->destination_id;
        $destination->slug = $slug;
        $destination->heading = $request->heading;
        $destination->short_description = $request->short_description;
        $destination->package_heading = $request->package_heading;
        $destination->package_subheading = $request->package_subheading;
        $destination->detail_heading = $request->detail_heading;
        $destination->detail_subheading = $request->detail_subheading;
    
        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time().'.'.$extenstion;
            $file->move('uploads/destination/', $filename);
            $destination->photo = $filename;
        }

        $destination->introduction = $request->introduction;
        $destination->experience = $request->experience;
        $destination->weather = $request->weather;
        $destination->hotel = $request->hotel;
        $destination->transportation = $request->transportation;
        $destination->culture = $request->culture;
        $destination->title = $request->seo_title;
        $destination->meta_description = $request->seo_meta_description;
        $destination->status = $request->status;
        $destination->save();
        
    
        return redirect()->back()->with('success', 'Destination Added Successfully');
    }
    
    public function destinationUpdate(Request $request, $id){
    
        // dd($request->file('image'));
        // Find the package
        $destination = Destination::find($id);
    
        $slug = Str::slug($request->slug);
        $slug = $this->getUniqueSlug($slug, $id);
    
        $destination->destination_name = $request->name;
        $destination->slug = $slug;
        $destination->heading = $request->heading;
        $destination->short_description = $request->short_description;
        $destination->package_heading = $request->package_heading;
        $destination->package_subheading = $request->package_subheading;
        $destination->detail_heading = $request->detail_heading;
        $destination->detail_subheading = $request->detail_subheading;
    
        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time().'.'.$extenstion;
            $file->move('uploads/destination/', $filename);
            $destination->photo = $filename;
        }

        $destination->introduction = $request->introduction;
        $destination->experience = $request->experience;
        $destination->weather = $request->weather;
        $destination->hotel = $request->hotel;
        $destination->transportation = $request->transportation;
        $destination->culture = $request->culture;
        $destination->title = $request->seo_title;
        $destination->meta_description = $request->seo_meta_description;
        $destination->status = $request->status;
        $destination->update();
    
        return redirect()->back()->with('success', 'Destination Updated Successfully');

    }

    public function destinationDelete(Request $request){
        $destination = Destination::find($request->id);
        $destination->delete();
        return redirect()->back()->with('success', 'The package has been Deleted');

    }
    // package section
    public function package(){
          
        $packages = Package::with('destination')->get();

        return view('sales.package', compact('packages'));
    }

    public function create_package(){
        $states = State::all();
        $tourType = DB::table('tour_type')->get();
        // dd($states);
        return view('sales.package-create', compact('states', 'tourType'));
    }
    // add packages
    public function createPackage(Request $request){

        // dd($request->all());

         // Generate and assign SEO-friendly slug
  $slug = Str::slug($request->slug);
    // $slug = $this->getUniqueSlug($slug, $id);

        $request->validate([
            'destination_id' => 'required',
            'city_id' => 'required',
            'tour_type' => 'required',
            'name' => 'required',
            'slug' => 'required',
            'duration' => 'required',
            'ragular_price' => 'required',
            'offer_price' => 'required',
            'image' => 'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'status'=>'required'
        ]);
        $package = new Package();
        $package->destination_id = $request->destination_id;
        $package->tour_type_id = $request->tour_type;
        $package->city_id = $request->city_id;
        $package->package_name = $request->name;
        $package->slug = $slug;
        $package->duration = $request->duration;
        $package->ragular_price = $request->ragular_price;
        $package->offer_price = $request->offer_price;

        // $package->photo = $request->image;
        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time().'.'.$extenstion;
            $file->move('uploads/packages/', $filename);
            $package->photo = $filename;
        }

        $package->start_date = $request->start_date;
        $package->end_date = $request->end_date;
        $package->last_booking = $request->last_date;
        $package->map = $request->map;
        $package->short_description = $request->short_description;
        $package->description = $request->description;
        $package->location = $request->location;
        $package->itinerary = $request->itinerary;
        $package->policy = $request->policy;
        $package->terms = $request->terms;
        $package->title = $request->seo_title;
        $package->meta_description = $request->seo_meta_description;    
        $package->status = $request->status;  
        $package->save();
        return redirect()->back()->with('success', 'Package created successfully');
    
    }
    // updated packages
    public function updatePackage(Request $request, $id){
   
        $request->validate([
            'destination_id' => 'required',
            'city_id' => 'required',
            'tour_type' => 'required'
        ]);
      
        // Find the package
        $package = Package::find($id);
    
        if (!$package) {
            return redirect()->back()->with('error', 'Package not found');
        }
    
         // Generate and assign SEO-friendly slug
    $slug = Str::slug($request->slug);
    $slug = $this->getUniqueSlug($slug, $id);


        // Update package attributes
        $package->destination_id = $request->destination_id;
        $package->city_id = $request->city_id;
        $package->tour_type_id = $request->tour_type;
        $package->package_name = $request->name;
        $package->slug = $slug;
        $package->duration = $request->duration;
        $package->ragular_price = $request->ragular_price; // Corrected spelling
        $package->offer_price = $request->offer_price;
        
        // Handle file upload
       if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time().'.'.$extenstion;
            $file->move('uploads/packages/', $filename);
            $package->photo = $filename;
        }
    
        $package->start_date = $request->start_date;
        $package->end_date = $request->end_date;
        $package->last_booking = $request->last_date;
        $package->map = $request->map;
        $package->short_description = $request->short_description;
        $package->description = $request->description;
        $package->location = $request->location;
        $package->itinerary = $request->itinerary;
        $package->policy = $request->policy;
        $package->terms = $request->terms;
        $package->title = $request->seo_title;
        $package->meta_description = $request->seo_meta_description;
        $package->status = $request->status;
        // Save the changes
        $package->save(); // Using save() to persist the changes
    
        return redirect()->back()->with('success', 'Package Updated successfully');
    }
    // Method to ensure unique slugs
protected function getUniqueSlug($slug, $id)
{
    $originalSlug = $slug;
    $counter = 1;

    while (Package::where('slug', $slug)->where('id', '!=', $id)->exists()) {
        $slug = $originalSlug . '-' . $counter;
        $counter++;
    }

    return $slug;
}


public function packagePhotoDelete(Request $request){

    DB::table('package_photos')->where('id', $request->id)->delete();
    return redirect()->back()->with('success', 'The Photo has been Deleted');
}

    // upload package photos 
    public function packagePhoto($id){

         $package = Package::select('id', 'package_name')->find($id);
         $photos = PackagePhoto::where('package_id', $id)->get();

       //  dd($photos);
        return view("sales.package-photos", compact('package', 'photos'));
    }

    public function packageVideo($id){
        $package = Package::select('id', 'package_name')->find($id);
        $videos = PackageVideo::where('package_id', $id)->get();
        return view('sales.package-video', compact('package', 'videos'));
    }

public function packagePhotos(Request $request, $id){
        $photo = new PackagePhoto();
        $photo->package_id = $id;
        if($request->hasfile('photo'))
        {
            $file = $request->file('photo');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time().'.'.$extenstion;
            $file->move('uploads/packages/', $filename);
            $photo->photo = $filename;
        }
        $photo->save();
        return redirect()->back()->with('success', 'Photo uploaded successfully');

    }

    public function packageVideos(Request $request, $id){
    
        $video = new PackageVideo();
        $video->package_id = $id;
        $video->video_id = $request->video_youtube_id;
        $video->save();
        return redirect()->back()->with('success', 'Video uploaded successfully');
                
    }
  

    // Manage Booking 
    public function bookingsales(){
        // i want fetch all records from booking table
        $bookings = Booking::orderBy('created_at', 'desc')->get();
        //dd($bookings);
        return view('sales.booking', compact('bookings'));
    }

    public function bookingShow($id){
        $booking = Booking::with(['package.destination', 'package.city', 'package.tourType'])->find($id);
        //dd($booking->package);
        $passengers = Passenger::where('booking_id', $id)->get();
      //  dd($passengers);
        return view('sales.booking-show', compact('booking', 'passengers'));
    }



    public function bookingUpdate(Request $request, $id){
        // Validate the incoming request
    $request->validate([
        'full_name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'required|string|max:15',
        'adults' => 'required|integer|min:1',
        'children' => 'nullable|integer|min:0',
        'travel_date' => 'required|date',
    ]);

    // Find the booking by its ID
    $booking = Booking::findOrFail($id);

    // Update the booking with the form data
    $booking->full_name = $request->full_name;
    $booking->email = $request->email;
    $booking->phone = $request->phone;
    $booking->adults = $request->adults;
    $booking->children = $request->children;
    $booking->travel_date = $request->travel_date;

    // Save the updated booking to the database
    $booking->save();

    // Redirect or return a response
    return redirect()->back()->with('success', 'Booking updated successfully!');
    }


    // ppassengers addon

    public function passengers(Request $request, $id){
         // Create the booking
   
        //  dd($request->$id);
    // Store adult passengers
    $i = 1;
    while ($request->input('adult_name_' . $i)) {
        Passenger::create([
            'booking_id' => $id,
            'name' => $request->input('adult_name_' . $i),
            'age' => $request->input('adult_age_' . $i),
            'type' => 'adult',
        ]);
        $i++;
    }

    // Store child passengers
    $i = 1;
    while ($request->input('child_name_' . $i)) {
        Passenger::create([
            'booking_id' => $id,
            'name' => $request->input('child_name_' . $i),
            'age' => $request->input('child_age_' . $i),
            'type' => 'child',
        ]);
        $i++;
    }

    return redirect()->back()->with('success', 'Booking updated successfully!');

    }

    // delete passengers

public function delete(Request $request)
{
    $passenger = Passenger::find($request->id);

    if ($passenger) {
        $passenger->delete();

        return response()->json([
            'success' => true,
            'message' => 'Passenger deleted successfully!'
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Passenger not found.'
    ]);
}

// Manage Website Data Applied;
public function jobData(){
    $jobApplications = JobApplication::latest()->get(); 
    return view('sales.manage-job-data', compact('jobApplications'));
}
public function contactData(){
    $contactApplication = Contact::latest()->get(); 
    return view('sales.manage-contact-data', compact('contactApplication'));
}
   
public function store(Request $request)
{
    // Validate the request
    $validated = $request->validate([
        'travel_mode' => 'required',
        'departure' => 'required',
        'destination' => 'required',
        'departure_date' => 'required|date',
        'return_date' => 'nullable|date|after:departure_date',
        'adults' => 'required|integer|min:1',
        'children' => 'nullable|integer|min:0',
        'class' => 'required|in:economy,business,first',
        'special_requests' => 'nullable|string'
    ]);

    // Process the travel booking
    // Add your booking logic here

    return response()->json([
        'success' => true,
        'message' => 'Travel details submitted successfully'
    ]);
}

public function getVisitPlaces(Request $request)
{
    $state_id = $request->state_id;
    $city_id = $request->city_id;

    $visitPlaces = VisitPlace::where('state_id', $state_id)
        ->where('city_id', $city_id)
        ->get();

    return response()->json($visitPlaces);
}
}


