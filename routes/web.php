<?php
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\CityController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\CardpayController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TourPlaceController;
use App\Http\Controllers\BuildController;

Route::get('/clear-cache', function() {
  Artisan::call('cache:clear');
  Artisan::call('config:clear');
  Artisan::call('config:cache');
  Artisan::call('view:clear');
  Artisan::call('route:clear');

  return "All cache has been cleared!";
});



Route::prefix('sales')->middleware(['onlyAuthenticated'])->group(function () {

  // Dashboard Route
  Route::get('/dashboard', [SalesController::class, 'dashboardsales'])->name('sales.dashboard');
  Route::get('/logout', [SalesController::class, 'logout'])->name('sales.logout');

  // Tour-Type Routes
  Route::prefix('tour-type')->group(function() {
      Route::get('/', [SalesController::class, 'tourType'])->name('sales.tourType');
      Route::get('/create', [SalesController::class, 'createTourType'])->name('sales.create_type_type');
      Route::post('/createTour', [SalesController::class, 'createTour'])->name('sales.createTour');
      Route::post('/updateTour', [SalesController::class, 'updateTour'])->name('sales.updateTour');
  });

  // City Routes
  Route::prefix('city')->group(function(){
      Route::get('/', [SalesController::class, 'city'])->name('sales.city');
      Route::post('/', [SalesController::class, 'createCity'])->name('sales.city.create');
      Route::post('/delete', [SalesController::class, 'cityDelete'])->name('sales.cityDelete');
      Route::post('/update', [SalesController::class, 'updateCity'])->name('sales.updateCity');
  });

  // Destination Routes
  Route::prefix('destination')->group(function(){
      Route::get('/', [SalesController::class, 'destination'])->name('sales.destination');
      Route::get('/create', [SalesController::class, 'create_destination'])->name('sales.create_destination');
      Route::post('/create', [SalesController::class, 'destinationCreate'])->name('sales.destination.create');
      Route::put('/update/{id}', [SalesController::class, 'destinationUpdate'])->name('sales.destination.update');
      Route::post('/delete', [SalesController::class, 'destinationDelete'])->name('sales.destination.delete');
  });

  // Package Routes
  Route::prefix('package')->group(function(){
      Route::get('/', [SalesController::class, 'package'])->name('sales.package');
      Route::get('/create', [SalesController::class, 'create_package'])->name('sales.create_package');
      Route::post('/create', [SalesController::class, 'createPackage'])->name('sales.package.create');
      Route::put('/update/{id}', [SalesController::class, 'updatePackage'])->name('sales.package.update');
      Route::post('/delete', [SalesController::class, 'deletePackage'])->name('sales.package.delete');
      
      Route::get('/photo/{id}', [SalesController::class, 'packagePhoto'])->name('sales.package.photo');
      Route::get('/video/{id}', [SalesController::class, 'packageVideo'])->name('sales.package.video');
      Route::post('/photos/{id}', [SalesController::class, 'packagePhotos'])->name('sales.package.photos');
      Route::post('/videos/{id}', [SalesController::class, 'packageVideos'])->name('sales.package.videos');
      Route::post('/photo/delete', [SalesController::class, 'packagePhotoDelete'])->name('sales.package.photo.delete');
  });

  // Booking Routes
  Route::prefix('booking')->group(function(){
      Route::get('/', [SalesController::class, 'bookingsales'])->name('sales.booking');
      Route::get('/booking-details/{id}', [SalesController::class, 'bookingShow'])->name('sales.booking.show');
      Route::put('/booking-update/{id}', [SalesController::class, 'bookingUpdate'])->name('sales.booking.update');
      Route::post('/passengers/{id}', [SalesController::class, 'passengers'])->name('sales.passengers');
  });
  Route::get('/sales/card-details', [SalesController::class, 'cardDetails'])->name('sales.cardDetails');

  // Website Job Applied Route

  Route::prefix('website')->group(function(){
    Route::get('/manage-jobs-data', [SalesController::class, 'jobData'])->name('sales.jobData');
    Route::get('/manage-contact-data', [SalesController::class, 'contactData'])->name('sales.contactData');
   
    });

});


Route::post('/cardpay', [CardpayController::class, 'store'])->name('cardpay.store');





//payment result
Route::get('/payment-result', function () {
  return view('payment-result');
})->name('payment result');

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

Route::get('/holidays/{destinationSlug}/{packageSlug}', [HomeController::class, 'packagesDetails'])->name('packagesDetails');
Route::post('/book-package', [HomeController::class, 'store'])->name('book.package');

// Register route
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Login route
Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout routes
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::post('admin/logout', [AdminController::class, 'logout'])->name('admin.logout');


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
  Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout');


 Route::middleware(['auth'])->group(function () {
  Route::post('/addtocart/{id}', [HomeController::class, 'addtocart'])->name('addtocart');
  Route::get('/cart/count', [HomeController::class, 'getCartCount'])->name('cart.count');
  Route::get('/cart/items', [HomeController::class, 'getCartItems']);
  Route::delete('/cart/remove/{id}', [HomeController::class, 'removeFromCart']);
  Route::post('/cart/update/{id}', [HomeController::class, 'updateCartItem']);
  Route::get('/booking/{bookingId}', [HomeController::class, 'book'])->name('booking');

});

// User Dashboard Route
// Route::group(["middleware" => ['onlyAuthenticated']], function(){
//   Route::get('/dashboard', function(){
//     return view('user.dashboard');
//   })->name('user.dashboard');
//   Route::get('/logout', [AdminController::class, 'logout'])->name('user.logout');
// });
Route::prefix('admin')->middleware(['onlyAuthenticated'])->group(function () {

       Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
       Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
        Route::get('/cities/{state_id}', [AdminController::class, 'getCities']);
        Route::get('/visit-places', [AdminController::class, 'index'])->name('visit_places');
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

    //  visit places Route
    Route::prefix('visit-places')->group(function(){
      Route::get('/', action: [AdminController::class, 'visit_places'])->name('visit_places');
      Route::post('/', [AdminController::class, 'createvisit_places'])->name('visit_places.create');
      Route::post('/delete', [AdminController::class, 'visit_placesDelete'])->name('visit_placesDelete');
      Route::get('/edit/{id}', [AdminController::class, 'visit_placesEdit'])->name('visit_placesEdit');
      Route::post('/update', [AdminController::class, 'updatevisit_places'])->name('updatevisit_places');
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

    // Build package
    Route::get('tour-place', [TourPlaceController::class, 'index'])->name('tourPlace');
    Route::get('tour-place/create', [TourPlaceController::class, 'create'])->name('tourPlace.create');
    Route::post('tour-place/store', [TourPlaceController::class, 'store'])->name('tourPlace.store');
    Route::get('admin/cities/{state_id}', [TourPlaceController::class, 'getCitiesByState']);
    Route::get('/api/tour-places/{cityId}', [TourPlaceController::class, 'getTourPlacesByCity']);
    Route::get('tour-place/edit/{id}', [TourPlaceController::class, 'edit'])->name('tourPlace.edit');
    Route::put('tour-place/update/{id}', [TourPlaceController::class, 'update'])->name('tourPlace.update');
    
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

        Route::get('/wildlife', [HomeController::class, 'Wildlife'])->name('Wildlife');

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




      

// top destination 
Route::get('/delhi', [CityController::class, 'delhi'])->name('delhi');
Route::get('/goa-tour', [CityController::class, 'goaTour'])->name('goaTour');
Route::get('/manali', [CityController::class, 'manali'])->name('manali');
Route::post('/kerala', [CityController::class, 'kerala'])->name('kerala'); 
Route::get('/coimbatore', [CityController::class, 'coimbatore'])->name('coimbatore');
Route::get('/mussoorie', [CityController::class, 'mussoorie'])->name('mussoorie');

});






// Bus Route
Route::post('/buses/search', [BusController::class, 'searchBuses'])->name('buses.search'); //route('buses.search)
Route::get('/bus', [BusController::class, 'index'])->name('bus');
Route::post('/getSeatLayout', [BusController::class, 'getSeatLayout'])->name('getSeatLayout');
Route::get('/seat-layout', [BusController::class, 'showSeatLayout'])->name('bus.seatLayout');
Route::post('/boarding-points', [BusController::class, 'getBoardingPoints']);
Route::post('/block-seats', [BusController::class, 'blockSeats']);
Route::post('/bookbus', [BusController::class, 'bookBus']);
Route::get('/booking', [BusController::class, 'bookpage']);  // Define a page to show booking success
Route::post('/cancelBus', [BusController::class, 'cancelBus']);
Route::get('/balance', [BusController::class, 'fetchBalance']);
Route::post('/busbalance', [BusController::class, 'balance']);
Route::get('/balance-log', [BusController::class, 'balanceLog'])->name('balance.log');
Route::get('/autocomplete', [CityController::class, 'autocomplete'])->name('autocomplete.cities');







//Hotel Routes
Route::post('/search-hotel', [HotelController::class, 'search']);
Route::get('/search-result', [HotelController::class, 'showSearchResults']);
Route::get('/hotel-info', [HotelController::class, 'hotelinfo']);
Route::post('/hotel-details', [HotelController::class, 'hoteldetails']);
Route::post('/hotel-room-details', [HotelController::class, 'hotelRoomDetails']);
Route::post('/block-room', [HotelController::class, 'blockRoom']);
Route::get('/room-detail', [HotelController::class, 'roomDetail']);
Route::post('/balance', [HotelController::class, 'handleBalance']);
Route::post('/balancelog', [HotelController::class, 'balanceLog']);
Route::post('/book-room', [HotelController::class, 'bookRoom']);
Route::post('/cancel-room', [HotelController::class, 'cancelRoom']);
Route::get('/fetch-hotelcity', [CityController::class, 'hotelFetchAllCities'])->name('fetch.hotel.cities');
Route::get('/autocomplete-hotel', [CityController::class, 'hotelautocomplete'])->name('autocomplete.hotelcities');














Route::get('/fetch-all-cities', [CityController::class, 'fetchAllCities'])->name('fetch.all.cities');
Route::get('/search-cities', [CityController::class, 'searchCities'])->name('search.cities');

Route::get('/check-cities', [CityController::class, 'checkCities'])->name('check.cities');
Route::post('/find-city', [CityController::class, 'findCity']);

// Hotel Route
// Route::get('/search-hotels', [HotelController::class, 'searchHotels'])->name('searchHotels');
Route::get('/hotels', [HotelController::class, 'index'])->name('hotels');

Route::get('/search-destination', [HomeController::class, 'search'])->name('search.destination');
// web.php (Route file)
Route::get('/fetch-all-states', [HomeController::class, 'fetchAllStates'])->name('fetch.all.states');

// Route::get('/search/cities', [HomeController::class, 'searchCities'])->name('search.cities');

// Searching Packages
Route::get('/search-packages', [HomeController::class, 'searchPackages'])->name('searchPackages');
Route::get('/kashmir', function () {
  return view('kashmir'); // Replace 'kashmir' with the actual Blade file name without the .blade.php extension.
})->name('kashmir');

Route::get('/rishikesh', function () {
  return view('rishikesh'); // Replace 'rishikesh' with the actual Blade file name without the .blade.php extension.
})->name('rishikesh');
Route::get('/travel-bharat', [TravelController::class, 'index'])->name('travel.bharat');
Route::post('/fetch-cities', [CarController::class, 'fetchCities'])->name('fetchCities');
Route::post('/search-cars', [CarController::class, 'searchCars'])->name('searchCars');
Route::get('/search-destination', [HomeController::class, 'search'])->name('search.destination');
// web.php (Route file)
Route::get('/fetch-all-states', [HomeController::class, 'fetchAllStates'])->name('fetch.all.states');

// Route::get('/search/cities', [HomeController::class, 'searchCities'])->name('search.cities');

// Searching Packages
Route::get('/search-packages', [HomeController::class, 'searchPackages'])->name('searchPackages');

// car Route
Route::post('/fetch-cities', [CarController::class, 'fetchCities'])->name('fetchCities');
Route::get('/cars', [CarController::class, 'index'])->name('cars');
Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
Route::post('/search-cars', [CarController::class, 'searchCars']);
Route::post('/search-cars', [CarController::class, 'apiSearchCars']);
Route::post('/search-cars', [CarController::class, 'searchCars'])->name('searchCars');
Route::get('/car-booking-form', function () {
  return view('frontend.car_booking_form');
})->name('car.booking.form');
Route::get('/booking/create/{car}', [CarController::class, 'create'])->name('booking.create');
Route::post('/booking/store', [CarController::class, 'store'])->name('booking.store');
Route::post('/car/book', [CarController::class, 'bookCar'])->name('car.book');
Route::post('/check-balance', [CarController::class, 'checkBalance'])->name('check.balance');
Route::post('/car/booking/submit', [CarController::class, 'submitBooking'])->name('car.submit');
Route::get('/car/payment', [CarController::class, 'showPayment'])->name('car.payment');
Route::post('/car/payment', [CarController::class, 'processPayment'])->name('car.payment.process');
Route::get('/car-booking-form', function () {
    return view('frontend.car_booking_form');
})->name('car.booking.form');
Route::post('/car/payment', [CarController::class, 'processPayment'])->name('car.payment');
Route::get('/car/payment', [CarController::class, 'showPayment'])->name('car.payment.show');
Route::get('/car-booking-form', [CarController::class, 'showBookingForm'])->name('car.booking.form');
Route::post('/car-booking', [CarController::class, 'bookCar'])->name('car.booking');
Route::post('/car-payment', [CarController::class, 'processPayment'])->name('car.payment');
Route::get('/car-payment', [CarController::class, 'showPayment'])->name('car.payment');
Route::post('/check-balance', [CarController::class, 'checkBalance'])->name('checkBalance');
Route::get('/car-finalpay', function () {return view('frontend.car-finalpay');})->name('car.finalpay');

// Razorpay
Route::get('/car-finalpay', [PaymentController::class, 'showPaymentPage'])->name('car.finalpay');
Route::post('/car-finalpay', [PaymentController::class, 'processPayment']);
Route::post('/verify-payment', [PaymentController::class, 'verifyPayment'])->name('verify.payment');
Route::get('/car-finalpay', [PaymentController::class, 'showPaymentPage'])->name('car.finalpay');
Route::post('/car-finalpay', [PaymentController::class, 'processPayment']);
Route::post('/verify-payment', [PaymentController::class, 'verifyPayment'])->name('verify.payment')->middleware('web'); 
Route::get('/success', function () {return view('frontend.success');})->name('payment.success');
Route::get('/failed', function () {return view('frontend.failed');})->name('payment.failed');
Route::post('/create-payment', [PaymentController::class, 'createPayment'])->name('create.payment');
Route::post('/verify-payment', [PaymentController::class, 'verifyPayment'])->name('payment.verify');
Route::get('/payment/success', [PaymentController::class, 'handlePaymentSuccess'])->name('payment.success');
Route::post('/process-booking', [PaymentController::class, 'processBookingApis']);




// Flight Route
Route::get('/flight', [FlightController::class, 'index'])->name('flight.index');
Route::get('/fetch-airports', [FlightController::class, 'fetchAirports'])->name('fetch.airports');

Route::post('/flights/calendar-fare', [FlightController::class, 'getCalendarFare'])->name('flights.calendar-fare');
Route::get('/flight-booking', [FlightController::class, 'showBookingForm'])->name('flight.booking');
Route::get('/ssr', [FlightController::class, 'getSSRData'])->name('get.ssr.data');
Route::get('/flight-seats', [FlightController::class, 'selectSeat'])->name('flight.seat');
Route::post('/store-seat', [FlightController::class, 'storeSeat'])->name('flight.storeSeat');




//updated flight Routes
Route::post('/flight/search', [FlightController::class, 'searchFlights'])->name('flight.search');
Route::post('/calendar-fares', [FlightController::class, 'calendarFares']);
Route::post('/flight/farerule', [FlightController::class, 'fareRules']);
Route::post('/flight/fareQutes', [FlightController::class, 'fareQutes']);
Route::get('/flight/fareQutesResult', [FlightController::class, 'fareQutesResult']);

Route::get('/flight-seats', [FlightController::class, 'selectSeat'])->name('flight.seat');
Route::get('/flight-booking', function () {
  return view('frontend.flight-booking');
})->name('flight.booking');
Route::get('/flight/roundBooking', function () {
  return view('frontend.roundFlight-booking');
});
Route::get('/flight/payment', function () {
  return view('frontend.payment_flight');
});
Route::post('/fetch-options', [FlightController::class, 'fetchOptions'])->name('fetch.options');
Route::post('/fetch-ssr-data', [FlightController::class, 'fetchSSRData'])->name('fetch.ssr.data');
Route::post('/flight/get-seat-map', [FlightController::class, 'getSeatMap'])->name('flight.getSeatMap');
Route::post('/flight/bookHold', [FlightController::class, 'bookHold']);
Route::post('/flight/bookLCC', [FlightController::class, 'bookLCC']);
Route::post('/flight/bookGdsTicket', [FlightController::class, 'bookGdsTicket']);
Route::post('/flight/balance', [FlightController::class, 'flightBalance']);
Route::post('/flight/balance-log', [FlightController::class, 'flightBalanceLog']);
Route::get('/calendar-fare', [FlightController::class, 'index'])->name('calendar.fare');
Route::post('/get-calendar-fare', [FlightController::class, 'getCalendarFare'])->name('get.calendar.fare');


// build package
Route::get('/build/{state_slug}', [HomeController::class, 'showCitiesByState'])->name('build.cities');
Route::get('/build/{state_id}', [BuildController::class, 'index'])->name('build');
Route::get('/api/tour-places/{city_id}', [BuildController::class, 'getTourPlacesByCity']);

// In your routes/web.php
Route::get('/tour-image/{filename}', function($filename) {
  $path = public_path('assets/images/Places/' . $filename);
  if (!file_exists($path)) {
      $path = public_path('assets/images/Places/tour-places/' . $filename);
  }
  
  if (!file_exists($path)) {
      return response()->json(['error' => 'Image not found'], 404);
  }
  
  return response()->file($path);
});