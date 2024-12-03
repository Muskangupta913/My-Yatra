<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FlightController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\CityController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/clear-cache', function() {
  Artisan::call('cache:clear');
  Artisan::call('config:clear');
  Artisan::call('config:cache');
  Artisan::call('view:clear');
  Artisan::call('route:clear');

  return "All cache has been cleared!";
});

Route::get('/kashmir', function () {
  return view('kashmir'); // Replace 'kashmir' with the actual Blade file name without the .blade.php extension.
})->name('kashmir');
Route::get('/rishikesh', function () {
  return view('rishikesh'); // Replace 'rishikesh' with the actual Blade file name without the .blade.php extension.
})->name('rishikesh');

Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get('/home', function(){
//   return view('frontend.home');
// });

Route::get('/goa-section', function () {
  return view('goa-section'); // Assuming the view file is goa-section.blade.php
});
Route::get('/delhi-section', function () {
  return view('delhi-section'); // Assuming the view file is delhi-section.blade.php
});
Route::get('/manali-section', function () {
  return view('manali-section'); // Assuming the view file is manali-section.blade.php
});
Route::get('/mussoorie-section', function () {
  return view('mussoorie-section'); // Assuming the view file is mussoorie-section.blade.php
});
Route::get('/kerela-section', function () {
  return view('kerela-section'); // Assuming the view file is kerela-section.blade.php
});

Route::get('/coimbatore-section', function () {
  return view('coimbatore-section'); // Assuming the view file is kerela-section.blade.php
});


Route::get('/flight-booking', [FlightController::class, 'index'])->name('flight.booking');
Route::post('/search-flights', [FlightController::class, 'search'])->name('flight.search');

Route::get('/holidays/{slug}', [HomeController::class, 'packages'])->name('packages');

Route::get('/holidays/{destinationSlug}/{packageSlug}', action: [HomeController::class, 'packagesDetails'])->name('packagesDetails');
Route::post('/book-package', action: [HomeController::class, 'store'])->name('book.package');

// Register route
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Login route
Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Forgot password routes
Route::get('/forgot-password', [AuthController::class, 'forgotView'])->name('forgot.password');
Route::post('/forgot-password', [AuthController::class, 'forgot']);

// Reset password routes
Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordView'])->name('reset.password');
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Password updated confirmation
Route::get('/password-updated', [AuthController::class, 'passwordUpdated'])->name('passwordUpdated');


// filter holiday packages
Route::post('holidays/{slug}', [HomeController::class, 'filterPackages'])->name('filter.packages');

Route::get('tour-category/{slug?}', [HomeController::class, 'tourTypeData'])->name('tour.type');
Route::get('tour-category/{newSlug}/{itemSlug}', [HomeController::class, 'showTour'])->name('tour.show');


// holiday-packages
Route::get('/holiday-packages/{slug}', [HomeController::class,  'packageDetails'])->name('packageDetails');

// Route::get('/test',  function(){
//   return view('frontend.test');
// });


// Booking Search Engine
Route::get('/search-destination', [HomeController::class, 'search'])->name('search.destination');
// web.php (Route file)
Route::get('/fetch-all-states', [HomeController::class, 'fetchAllStates'])->name('fetch.all.states');

Route::get('/search/cities', [HomeController::class, 'searchCities'])->name('search.cities');

// Searching Packages
Route::get('/search-packages', [HomeController::class, 'searchPackages'])->name('searchPackages');


// packages sidebar filters

Route::get('/filter-packages/{slug}', [HomeController::class, 'tourfilterPackages']);
Route::get('/filter-tour-packages/{slug}', [HomeController::class, 'tourTypefilterPackages']);



// Pages of website
Route::get('/about-us', [HomeController::class, 'aboutUs'])->name('aboutUs');
Route::get('/our-services', [HomeController::class, 'services'])->name('services');
Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('contactUs');
Route::post('/contact-us', [HomeController::class, 'contactApplied']); 
Route::get('/membership', [HomeController::class, 'membership'])->name('membership');
Route::get('/career', [HomeController::class, 'career'])->name('career');
Route::get('/career-apply', [HomeController::class, 'careerApply'])->name('careerApply');
Route::get('/terms-and-conditions', [HomeController::class, 'termsCondition'])->name('termsCondition');

Route::post('/job-apply', [HomeController::class, 'jobApply'])->name('jobApply');
// Add this to web.php





Route::get('/payment',[HomeController::class, 'payment'])->name('payment');
Route::get('/blog',[HomeController::class, 'ourblog'])->name('blog');

Route::fallback(function () {
  return response()->view('errors.404', [], 404);  // Match the path of your error view
});


Route::group(['middleware' => ['isAuthenticated']], function(){
Route::get('/register', [AuthController::class, "registerView"])->name('registerView');
Route::post('/register', [AuthController::class, "register"])->name('register');
Route::get('/login', [AuthController::class, "loginView"])->name('loginView');
Route::post('/login', [AuthController::class, "login"])->name('login');
Route::get('/forgot-password', [AuthController::class, 'forgotView'])->name('forgotView');
Route::post('/forgot-password', [AuthController::class, 'forgot'])->name('forgot.password');

Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordView'])->name('resetPasswordView');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('resetPassword');
Route::get('/password-update', [AuthController::class, 'passwordUpdated'])->name('passwordUpdated');
Route::get('/verify/{token}', [AuthController::class, 'verify'])->name('verify');


});


 // use authenticate middle 
//  Route::get('/addtocart/{id}', [HomeController::class, 'addtocart'])
//  ->name('addtocart')
//  ->middleware('auth');  


 Route::middleware(['auth'])->group(function () {
  Route::post('/addtocart/{id}', [HomeController::class, 'addtocart'])->name('addtocart');
  Route::get('/cart/count', [HomeController::class, 'getCartCount'])->name('cart.count');
  Route::get('/cart/items', [HomeController::class, 'getCartItems']);
  Route::delete('/cart/remove/{id}', [HomeController::class, 'removeFromCart']);
  Route::post('/cart/update/{id}', [HomeController::class, 'updateCartItem']);
  Route::get('/booking/{bookingId}', [HomeController::class, 'book'])->name('booking');
  Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout');

});

// User Dashboard Route
// Route::group(["middleware" => ['onlyAuthenticated']], function(){
//   Route::get('/dashboard', function(){
//     return view('user.dashboard');
//   })->name('user.dashboard');
//   Route::get('/logout', [AdminController::class, 'logout'])->name('user.logout');
// });


Route::prefix('admin')->middleware(['onlyAuthenticated', 'onlyAdmin'])->group(function () {

       Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
       Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
      
        Route::get('/cities/{state_id}', [AdminController::class, 'getCities']);
      
        Route::prefix('tour-type')->group(function(){
        Route::get('/', [AdminController::class, 'tourType'])->name('tourType');
        Route::get('/create', [AdminController::class, 'createTourType'])->name('create_type_type');
        Route::post('/createTour', [AdminController::class, 'createTour'])->name('createTour');
        Route::get('/tour-types/edit/{id}', [AdminController::class, 'editTour'])->name('editTour');
        Route::post('/updateTour', [AdminController::class, 'updateTour'])->name('updateTour');
        Route::post('/deleteTour', [AdminController::class, 'deleteTour'])->name('deleteTour');
     });

    //  city Route
    Route::prefix('city')->group(function(){
      Route::get('/', action: [AdminController::class, 'city'])->name('city');
      Route::post('/', [AdminController::class, 'createCity'])->name('city.create');
      Route::post('/delete', [AdminController::class, 'cityDelete'])->name('cityDelete');
      Route::get('/edit/{id}', [AdminController::class, 'cityEdit'])->name('cityEdit');
      Route::post('/update', [AdminController::class, 'updateCity'])->name('updateCity');
    });

       Route::prefix('destination')->group(function(){
       Route::get('/', [AdminController::class, 'destination'])->name('destination');
       Route::get('/create', [AdminController::class, 'create_destination'])->name('create_destination');
       Route::post('/create', [AdminController::class, 'destinationCreate'])->name('destination.create');
       Route::get('/edit/{id}', [AdminController::class, 'destinationEdit'])->name('destination.edit');
       Route::put('/update/{id}', [AdminController::class, 'destinationUpdate'])->name('destination.update');
       Route::post('/delete}', [AdminController::class, 'destinationDelete'])->name('destination.delete');
       
      });

    Route::prefix('package')->group(function(){
     Route::get('/', [AdminController::class, 'package'])->name('package');
     Route::get('/create', [AdminController::class, 'create_package'])->name('create_package');
     Route::post('/create', [AdminController::class, 'createPackage'])->name('package.create');
     Route::get('/edit/{id}', [AdminController::class, 'EditPackage'])->name('package.edit');
     Route::put('/udpate/{id}', [AdminController::class, 'updatePackage'])->name('package.update');
     Route::post('/delete', [AdminController::class, 'deletePackage'])->name('package.delete');

     Route::get('/photo/{id}', [AdminController::class, 'packagePhoto'])->name('package.photo');
     Route::get('/video/{id}', [AdminController::class, 'packageVideo'])->name('package.video');
     Route::post('/photos/{id}', [AdminController::class, 'packagePhotos'])->name('package.photos');
     Route::post('/videos/{id}', [AdminController::class, 'packageVideos'])->name('package.videos');
     Route::post('/photo/delete', [AdminController::class, 'packagePhotoDelete'])->name('package.photo.delete');

    });

    Route::prefix('booking')->group(function(){
          Route::get('/', [AdminController::class, 'booking'])->name('booking');
          Route::get('/booking-details/{id}', [AdminController::class, 'bookingShow'])->name('booking.show');
          Route::get('/booking-edit/{id}', [AdminController::class, 'bookingEdit'])->name('booking.edit');
          Route::put('/booking-update/{id}', [AdminController::class, 'bookingUpdate'])->name('booking.update');
          Route::post('/passengers/{id}', [AdminController::class, 'passengers'])->name('passengers');
          Route::delete('/passengers/delete', [AdminController::class, 'delete'])->name('passengers.delete');
        });


        // Website Job Applied Route

        Route::prefix('website')->group(function(){
        Route::get('/manage-jobs-data', [AdminController::class, 'jobData'])->name('jobData');
        Route::get('/manage-contact-data', [AdminController::class, 'contactData'])->name('contactData');
       
        });

        Route::get('/festivals', function () {
          $festivalRegions = [
              [
                  'name' => 'North India',
                  'image' => 'north-india.jpg',
                  'festivals' => ['Diwali', 'Holi', 'Lohri'],
                  'significance' => 'Cultural hub',
                  'best_places' => ['Delhi', 'Jaipur', 'Amritsar']
              ],
              // More regions...
          ];
      
          return view('festivals', compact('festivalRegions'));
      });

      // Hotel Route
Route::get('/search-hotels', [HotelController::class, 'searchHotels'])->name('searchHotels');
//city
Route::get('/fetch-all-cities', [CityController::class, 'fetchAllCities'])->name('fetch.all.cities');
Route::get('/search-cities', [CityController::class, 'searchCities'])->name('search.cities');
      

// top destination 
Route::get('/delhi', [CityController::class, 'delhi'])->name('delhi');
Route::get('/goa-tour', [CityController::class, 'goaTour'])->name('goaTour');
Route::get('/manali', [CityController::class, 'manali'])->name('manali');
Route::post('/kerala', [CityController::class, 'kerala'])->name('kerala'); 
Route::get('/coimbatore', [CityController::class, 'coimbatore'])->name('coimbatore');
Route::get('/mussoorie', [CityController::class, 'mussoorie'])->name('mussoorie');

});