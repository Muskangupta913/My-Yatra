<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

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


Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get('/home', function(){
//   return view('frontend.home');
// });

Route::get('/holidays/{slug}', [HomeController::class, 'packages'])->name('packages');

Route::get('/holidays/{destinationSlug}/{packageSlug}', action: [HomeController::class, 'packagesDetails'])->name('packagesDetails');
Route::post('/book-package', action: [HomeController::class, 'store'])->name('book.package');

// filter holiday packages
Route::post('holidays/{slug}', [HomeController::class, 'filterPackages'])->name('filter.packages');

Route::get('tour-category/{slug?}', [HomeController::class, 'tourTypeData'])->name('tour.type');
Route::get('tour-category/{newSlug}/{itemSlug}', [HomeController::class, 'showTour'])->name('tour.show');


// holiday-packages
Route::get('/holiday-packages/{slug}', [HomeController::class,  'packageDetails'])->name('packageDetails');
 

//add to card controllerr



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
Route::get('/checkout', [HomeController::class, 'addtocard'])->name('checkout');
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

// User Dashboard Route
Route::group(["middleware" => ['onlyAuthenticated']], function(){
  Route::get('/dashboard', function(){
    return view('user.dashboard');
  })->name('user.dashboard');
  Route::get('/logout', [AdminController::class, 'logout'])->name('user.logout');
});


Route::prefix('admin')->middleware(['onlyAuthenticated', 'onlyAdmin'])->group(function () {

       Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
       Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
      
        Route::get('/cities/{state_id}', [AdminController::class, 'getCities']);
      
        Route::prefix('tour-type')->group(function(){
        Route::get('/', [AdminController::class, 'tourType'])->name('tourType');
        Route::get('/create', [AdminController::class, 'createTourType'])->name('create_type_type');
        Route::post('/createTour', [AdminController::class, 'createTour'])->name('createTour');
        Route::get('/editTour/{id}', [AdminController::class, 'editTour'])->name('editTour');
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

});

