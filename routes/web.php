<?php

use App\Http\Controllers\admin\AdminProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\admin\CityController;
use App\Http\Controllers\admin\CountryController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\SalonController;
use App\Http\Controllers\admin\auth\LoginController;
use App\Http\Controllers\admin\SliderController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\ServiceController as AdminServiceController;
use App\Http\Controllers\salon\auth\LoginController as AuthLoginController;
use App\Http\Controllers\salon\CouponController;
use App\Http\Controllers\salon\NotificationController;
use App\Http\Controllers\salon\DashboardController as SalonDashboardController;
use App\Http\Controllers\salon\GalleryController;
use App\Http\Controllers\salon\AppointmentController;
use App\Http\Controllers\salon\ProfileController;
use App\Http\Controllers\salon\ServiceController;

use App\Http\Controllers\salon\TimeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::post('search-city', [CityController::class, 'search'])->name('search-city');

Route::get('language_switch/{locale}', [LanguageController::class, 'index'])->name('language_switch');
Route::get('admin', [LoginController::class, 'index'])->name('admin');
Route::post('admin', [LoginController::class, 'login'])->name('admin');

Route::get('salon-register', [SalonController::class, 'registershow'])->name('salon.register');
Route::post('salon-register', [SalonController::class, 'salonregister'])->name('salon.register');
Route::post('user-delete', [UserController::class, 'userDelete'])->name('user.delete');
Route::group(['middleware' => ['setlang', 'checkpermission']], function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('admin-logout', [LoginController::class, 'logout'])->name('admin-logout');

    Route::get('/countries', [CountryController::class, 'index'])->name('countries');
    Route::post('/country', [CountryController::class, 'store'])->name('country');
    Route::post('/country_status', [CountryController::class, 'status'])->name('country_status');
    Route::post('updatecountry', [CountryController::class, 'edit'])->name('updatecountry');

    Route::get('admin-profile', [AdminProfileController::class, 'index'])->name('admin.profile');
    Route::post('admin-profile', [AdminProfileController::class, 'update'])->name('admin.profile');
    Route::post('admin-change-password', [AdminProfileController::class, 'change'])->name('admin.change.password');

    Route::get('cities', [CityController::class, 'index'])->name('cities');
    Route::post('city', [CityController::class, 'store'])->name('city');
    Route::post('city_status', [CityController::class, 'status'])->name('city_status');
    Route::post('editcity', [CityController::class, 'edit'])->name('editcity');
    Route::post('citydelete', [CityController::class, 'delete'])->name('citydelete');

    Route::post('salondelete', [SalonController::class, 'delete'])->name('salondelete');
    Route::get('salons', [SalonController::class, 'index'])->name('salons');
    Route::get('add-salon', [SalonController::class, 'salon'])->name('add-salon');
    Route::post('add-salon', [SalonController::class, 'store'])->name('add-salon');
    Route::post('salon-status', [SalonController::class, 'status'])->name('salon-status');
    Route::get('edit-salon/{id}', [SalonController::class, 'edit'])->name('edit.salon');
    Route::post('edit-salon', [SalonController::class, 'update'])->name('edit-salon');
    Route::get('salon-detail/{id}', [SalonController::class, 'detail'])->name('salon-detail');

    Route::get('admin-service', [AdminServiceController::class, 'index'])->name('admin.service');
    Route::post('service-block', [AdminServiceController::class, 'block'])->name('service.block');

    Route::get('category', [CategoryController::class, 'index'])->name('category');
    Route::get('add-category', [CategoryController::class, 'add'])->name('add-category');
    Route::post('add-category', [CategoryController::class, 'store'])->name('add-category');
    Route::post('category-status', [CategoryController::class, 'status'])->name('category-status');
    Route::post('category-delete', [CategoryController::class, 'delete'])->name('category.delete');
	
	Route::get('all-users',[UserController::class,'index'])->name('all.users');
	
	
	Route::get('admin-sliders',[SliderController::class,'index'])->name('admin.sliders');
	Route::post('add-slider',[SliderController::class,'store'])->name('add.slider');
	Route::post('slider-status',[SliderController::class,'status'])->name('slider.status');
	Route::get('admin-aboutus',[SliderController::class,'aboutus'])->name('admin.aboutus');
	Route::post('admin-aboutus',[SliderController::class,'aboutusstore'])->name('admin.aboutus');
	Route::get('admin-setting',[SliderController::class,'setting'])->name('admin.setting');  	
	Route::post('admin-setting-save',[SliderController::class,'settingupdate'])->name('admin.setting.save');  
	   
});

Route::get('salon', [AuthLoginController::class, 'index'])->name('salon');

Route::post('salon', [AuthLoginController::class, 'login'])->name('salon');

Route::group(['middleware' => ['setlang', 'SalonPermission']], function () {
Route::get('/greeting', function () {
    return 'Hello World';
});
Route::get('clear-cache', [SalonDashboardController::class, 'clear_cache'])->name('clear-cache');
    Route::get('salon.dashboard', [SalonDashboardController::class, 'index'])->name('salon.dashboard');
    Route::get('salon-logout', [AuthLoginController::class, 'logout'])->name('salon-logout');
    Route::get('salon-service', [ServiceController::class, 'index'])->name('salon.service');




    Route::get('add-service', [ServiceController::class, 'add'])->name('add.service');
    Route::post('add-service', [ServiceController::class, 'store'])->name('add.service');
    Route::post('service-status', [ServiceController::class, 'status'])->name('service.status');
    Route::post('service-delete', [ServiceController::class, 'delete'])->name('service.delete');
    Route::get('edit-service/{id}', [ServiceController::class, 'edit'])->name('edit.service');
    Route::post('edit-service', [ServiceController::class, 'update'])->name('edit-service');


    Route::get('gallery', [GalleryController::class, 'index'])->name('gallery');
    Route::post('gallery', [GalleryController::class, 'store'])->name('gallery');
    Route::post('gallery-status', [GalleryController::class, 'status'])->name('gallery.status');





    Route::get('coupon', [CouponController::class, 'index'])->name('coupon');
    Route::get('add-coupon', [CouponController::class, 'add'])->name('add.coupon');
    Route::post('add-coupon', [CouponController::class, 'store'])->name('add.coupon');
    Route::get('edit-coupon/{id}', [CouponController::class, 'edit'])->name('edit-coupon');
    Route::post('edit-coupon', [CouponController::class, 'update'])->name('edit.coupon');
    Route::post('coupon-status', [CouponController::class, 'status'])->name('coupon.status');
    Route::get('salon-profile', [ProfileController::class, 'index'])->name('salon.profile');
    Route::post('salon-profile', [ProfileController::class, 'profile'])->name('salon.profile');
    Route::post('salon-change-password', [ProfileController::class, 'change'])->name('salon.change.password');
    Route::get('salon-time', [TimeController::class, 'index'])->name('salon.time');
    Route::post('salon-time', [TimeController::class, 'store'])->name('salon.time');
    Route::get('salon-notification',[NotificationController::class,'index'])->name('salon.notification');
	Route::get('add-notification',[NotificationController::class,'add'])->name('add.notification'); 
  Route::post('send-notification',[NotificationController::class,'store'])->name('send.notification');
 Route::post('resend-notification',[NotificationController::class,'resend'])->name('resend.notification');
    Route::get('salon-setting', [ProfileController::class, 'setting'])->name('salon.setting');
    Route::post('salon-setting', [ProfileController::class, 'updatesetting'])->name('salon.setting');
   Route::post('appointment.complete',[AppointmentController::class,'complete'])->name('appointment.complete');
	Route::post('appointment.confrim',[AppointmentController::class,'confirm'])->name('appointment.confrim');
	Route::get('salon-appointment',[AppointmentController::class,'index'])->name('salon.appointment');
	Route::get('view-appointment/{id}',[AppointmentController::class,'view'])->name('view.appointment');
});
