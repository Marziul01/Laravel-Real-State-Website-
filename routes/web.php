<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomePropertyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyTypeController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-us', [HomeController::class, 'about'])->name('about');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/rent-properties', [HomeController::class, 'rent'])->name('rent');
Route::get('/buy-properties', [HomeController::class, 'property'])->name('property');
Route::get('/contact-us', [HomeController::class, 'contact'])->name('contact');
Route::get('view/rent/property/{slug}',[HomePropertyController::class,'viewRentProperty'])->name('view.rent.property');
Route::get('view/buy/property/{slug}',[HomePropertyController::class,'viewBuyProperty'])->name('view.buy.property');


Route::get('/get-time', function () {
    return response()->json([
        'time' => now()->setTimezone('Asia/Dhaka')->format('Y-m-d H:i:s')
    ]);
})->name('get.time');


//User Auth
Route::post('/user/signup', [UserAuthController::class, 'register'])->name('user.register');
Route::get('/user/login', [UserAuthController::class, 'login'])->name('user.login');
Route::get('/user/forget/pass', [UserAuthController::class, 'forgotPass'])->name('user.forgotPass');
Route::post('/user/login/auth', [UserAuthController::class, 'authenticate'])->name('user.authenticate');
Route::post('user.verifyEmail',[UserAuthController::class,'verifyEmail'])->name('user.verifyEmail');
Route::post('/user/password/send-code', [UserAuthController::class, 'sendCode'])->name('password.sendCode');
Route::post('/user/password/verify-code', [UserAuthController::class, 'verifyCode'])->name('password.verifyCode');
Route::post('/user/password/reset', [UserAuthController::class, 'reset'])->name('user.password.reset');


// User routes (only for role = 1)
Route::middleware(['auth', 'user'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/logout', [UserAuthController::class, 'logout'])->name('user.logout');
});


Route::prefix('admin')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        //Admin Auth 
        Route::get('/login', [AdminAuthController::class, 'login'])->name('login');
        Route::get('/forget/pass', [AdminAuthController::class, 'forgotPass'])->name('forgotPass');
        Route::post('/login/auth', [AdminAuthController::class, 'authenticate'])->name('admin.authenticate');

        Route::post('/password/send-code', [AdminAuthController::class, 'sendResetCode'])->name('password.send.code');
        Route::post('/password/verify-code', [AdminAuthController::class, 'verifyCode'])->name('password.verify.code');
        Route::post('/password/reset', [AdminAuthController::class, 'updatePassword'])->name('password.reset.update');
    });

    // Admin routes (only for role = 0)
    Route::middleware(['auth:admin', 'admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
        Route::get('/site/settings', [ProfileController::class, 'siteSettings'])->name('siteSettings');
        Route::post('/site/settings/update', [ProfileController::class, 'updateSiteSettings'])->name('admin.site-settings.update');
        Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('admin.profile.update');
        Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
        Route::resource('property', PropertyController::class)->names('property');
        Route::get('/sell/property',[PropertyController::class,'sell'])->name('property.sell');
        Route::get('/get-states',[PropertyController::class, 'getStates'])->name('get-states');
        Route::resource('property-types', PropertyTypeController::class)->names('property-types');
        Route::get('/get-states', [PropertyController::class, 'getStates'])->name('get.states');
        Route::get('/get-districts', [PropertyController::class, 'getDistricts'])->name('get.districts');
        Route::get('/get-upazillas', [PropertyController::class, 'getUpazillas'])->name('get.upazillas');
        Route::post('/property/gallery-image/{id}', [PropertyController::class, 'deleteGalleryImage'])->name('property.gallery.delete');
        Route::get('/create/sell/property', [PropertyController::class, 'sellcreate'])->name('sellcreate');
    });
});


