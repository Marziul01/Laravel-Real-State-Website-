<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomePropertyController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyInquiryController;
use App\Http\Controllers\PropertyTypeController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserBookingController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-us', [HomeController::class, 'about'])->name('about');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/all-properties', [HomeController::class, 'rent'])->name('rent');
Route::get('/buy-properties', [HomeController::class, 'property'])->name('property');
Route::get('/contact-us', [HomeController::class, 'contact'])->name('contact');
Route::get('view/rent/property/{slug}',[HomePropertyController::class,'viewRentProperty'])->name('view.rent.property');
Route::get('view/buy/property/{slug}',[HomePropertyController::class,'viewBuyProperty'])->name('view.buy.property');
Route::get('booking/invoice/show/{id}',[HomeController::class,'showInvoice'])->name('booking.invoice.show');
Route::post('/property/inquiry/{id}', [HomeController::class, 'propertyInquiry'])->name('property.inquiries');
Route::get('/property/print/{id}', [HomePropertyController::class, 'printProperty'])->name('property.print');
Route::get('/property/overview', [HomeController::class, 'about'])->name('property.overview');
Route::get('/property/renovation', [HomeController::class, 'services'])->name('property.renovation');
Route::get('/property/color', [HomeController::class, 'rent'])->name('property.color');
Route::get('/property/interior', [HomeController::class, 'property'])->name('property.interior');
Route::get('/property/valuation', [HomeController::class, 'contact'])->name('property.valuation');
Route::get('/property/development', [HomeController::class, 'contact'])->name('property.development');
Route::post('/properties/filter', [HomeController::class, 'filter'])->name('properties.filter');

Route::get('/collect-district/all', [HomeController::class, 'getDistricts'])->name('collect.districts');
Route::get('/collect-upazilas/{district}', [HomeController::class, 'getUpazilas'])->name('collect.upazilas');
Route::get('/collect-states/{country}', [HomeController::class, 'getStates'])->name('collect.states');
Route::get('/get-cities-by-upazila/{upazila}', [HomeController::class, 'getCitiesByUpazila'])->name('collect.cities.upazila');
Route::get('/get-cities-by-state/{state}', [HomeController::class, 'getCitiesByState'])->name('collect.cities.state');


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
    Route::get('/booking/rent/property',[UserBookingController::class,'booking'])->name('user.booking.rent');
    Route::post('/property/booking/checkout/', [UserBookingController::class, 'checkout'])->name('booking.store');
    Route::post('/booking/coupon/apply/', [UserBookingController::class, 'applyCoupon'])->name('coupon.apply');
    Route::post('/update-profile', [UserDashboardController::class, 'updateProfile'])->name('user.updateProfile');
    Route::post('/submit-review', [UserDashboardController::class, 'submitReview'])->name('user.submitReview');
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
        Route::resource('coupon', CouponController::class)->names('coupon');
        Route::resource('payment_method', PaymentMethodController::class)->names('payment_method');
        Route::get('/bookings/pending', [AdminBookingController::class, 'bookingPending'])->name('booking.pending');
        Route::get('/bookings/active', [AdminBookingController::class, 'bookingActive'])->name('booking.active');
        Route::get('/bookings/visited', [AdminBookingController::class, 'bookingVisit'])->name('booking.visit');
        Route::get('/bookings/canceled', [AdminBookingController::class, 'bookingCancel'])->name('booking.cancel');
        Route::get('/bookings/{id}', [AdminBookingController::class, 'show'])->name('booking.show');
        Route::post('/bookings/{id}/confirm', [AdminBookingController::class, 'confirm'])->name('booking.confirm');
        Route::post('/bookings/{id}/cancel', [AdminBookingController::class, 'cancel'])->name('booking.canceled');
        Route::post('/bookings/{id}/visitedBooking', [AdminBookingController::class, 'visitedBooking'])->name('booking.visitedBooking');
        Route::post('/bookings/{id}/pendingBooking', [AdminBookingController::class, 'pendingBooking'])->name('booking.pendingBooking');
        Route::get('/bookings/create/manually', [AdminBookingController::class, 'creates'])->name('admin.booking.create');
        Route::get('/booking/edits/manually/{id}', [AdminBookingController::class, 'editing'])->name('admin.bookings.edits');
        Route::post('/bookings/delete/{id}', [AdminBookingController::class, 'delete'])->name('booking.delete');
        Route::get('/bookings/property/{id}/dates', [AdminBookingController::class, 'getBookedDates'])->name('admin.bookings.propertyDates');
        Route::post('/booking/coupon/apply/', [AdminBookingController::class, 'applyCoupon'])->name('admin.coupon.apply');
        Route::post('/booking/store/', [AdminBookingController::class, 'store'])->name('admin.bookings.store');
        Route::post('/booking/update/{id}', [AdminBookingController::class, 'update'])->name('admin.bookings.update');
        Route::get('/rent/property/inquiry', [PropertyInquiryController::class, 'rentPropertyInquiry'])->name('rent.property.inquiry');
        Route::get('/sell/property/inquiry', [PropertyInquiryController::class, 'sellPropertyInquiry'])->name('sell.property.inquiry');
        Route::get('/admin/inquiries/show', [PropertyInquiryController::class, 'show'])->name('admin.inquiries.show');
        Route::post('/admin/inquiries/update-status', [PropertyInquiryController::class, 'updateStatus'])->name('admin.inquiries.updateStatus');
        Route::post('/admin/inquiries/delete/{id}', [PropertyInquiryController::class, 'delete'])->name('admin.inquiries.delete');
    });
});


