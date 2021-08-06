<?php

use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\CountryController;
use App\Http\Controllers\Api\V1\SalonController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\NotificationController;
use App\Http\Controllers\Api\V1\AppointmentController;
use App\Http\Controllers\Api\V1\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['Verifyappkey'], 'namespace' => 'Api\V1'], function () {
    //Define All Routes 
    //Get All categories
    Route::get('category', [CategoryController::class, 'index'])->name('category');
    //Get All Salons
    Route::get('salons', [SalonController::class, 'index'])->name('salons');
    //Salon service
    Route::post('getSalonService', [SalonController::class, 'service'])->name('getSalonService');
    //Salon Gallery

    Route::post('getSalonGallery', [SalonController::class, 'gallery'])->name('getSalonGallery');
    //Salon getServiceByCategory
    Route::post('getServiceByCategory', [SalonController::class, 'getServiceByCategory'])->name('getServiceByCategory');
	Route::post('getSalonCategoriesAndServices',[SalonController::class,'getSalonCategoriesAndServices']);
    Route::post('getCouponBySalon', [SalonController::class, 'getCouponBySalon'])->name('getCouponBySalon');
    Route::get('countries', [CountryController::class, 'index'])->name('countries');
    Route::post('userSignup', [UserController::class, 'signup'])->name('userSignup');
	Route::post('update-user',[UserController::class,'updateUser']);
    Route::post('userLogin', [UserController::class, 'login'])->name('userLogin');
	Route::post('forgetPassword', [UserController::class, 'forgetPassword'])->name('forgetPassword');
	Route::post('getSalonByCity', [SalonController::class, 'getSalonByCity'])->name('getSalonByCity');
	Route::post('verify-account',[UserController::class,'verifyAccount'])->name('verify-account');
	Route::post('verify-login',[UserController::class,'verifyLogin'])->name('verify-login');
	Route::post('salonByGivenService',[SalonController::class,'salonByGivenService'])->name('salonByGivenService');
	Route::post('getSalonsByCountryCityAndServiceType',[SalonController::class,'getSalonsByCountryCityAndServiceType'])->name('getSalonsByCountryCityAndServiceType');
	Route::post('getSalonReview',[ReviewController::class,'getSalonReview']); 
	Route::post('addSalonReview',[ReviewController::class,'addSalonReview']); 
	Route::post('searchSalonByName',[SalonController::class,'searchSalonByName']);
	Route::get('all-sliders',[SalonController::class,'slider']);
	Route::get('about-us',[SalonController::class,'about_us']);
	Route::post('add-appointment',[AppointmentController::class,'store']);
	Route::post('test',[AppointmentController::class,'g']);
	Route::post('get-appointment',[AppointmentController::class,'index']);
	Route::post('getcancel-appointment',[AppointmentController::class,'cancel']);
	Route::post('completed-appointment',[AppointmentController::class,'complete']);
    Route::post('cancel-appointment',[AppointmentController::class,'update']);
	Route::post('check-slot',[AppointmentController::class,'check']);
	Route::get('all-notifications',[NotificationController::class,'index']);
	Route::post('specific-notifications',[NotificationController::class,'specific']);
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
