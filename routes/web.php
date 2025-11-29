<?php

use App\Http\Controllers\AboutPageController;
use App\Http\Controllers\AdminAccessController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\AdminServiceController;
use App\Http\Controllers\AgentPageController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CarrerController;
use App\Http\Controllers\ClientPropertySubmission;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomePropertyController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyInquiryController;
use App\Http\Controllers\PropertyTypeController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\ServiceInquiryController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserBookingController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserManagmentController;
use App\Models\Notification;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-us', [HomeController::class, 'about'])->name('about');
Route::get('/services', [HomeController::class, 'service'])->name('services');
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
Route::post('/service/inquiries', [FormController::class, 'propertyInquiry'])->name('service.inquiries');
Route::get('/send/your/property/', [FormController::class, 'sendyourproperty'])->name('sendyourproperty');
Route::post('/client/properties/submit', [FormController::class, 'clientProperties'])->name('client.properties');
Route::get('/our/servies/{slug}', [HomeController::class, 'services'])->name('home.serives');
Route::get('/all/blogs', [HomeController::class, 'blog'])->name('all.blogs');
Route::get('/view/blog/{slug}', [HomeController::class, 'blogDetails'])->name('blog.details');
Route::get('/all/careers', [HomeController::class, 'carrer'])->name('careers.all');
Route::get('/show/careers/details/{id}', [HomeController::class, 'carrershow'])->name('careers.show');
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
Route::get('/be/agents', [HomeController::class, 'Agents'])->name('agents');
Route::get('/document/services', [HomeController::class, 'documentServices'])->name('document.services');
Route::get('/sitemap.xml', [SeoController::class, 'sitemap']);
Route::get('/teams/appointment/{id}', [HomeController::class, 'teamsAppointment'])->name('teams.appointment');
Route::post('/team/appointment/submit/{id}', [HomeController::class, 'appointmentSubmit'])->name('team.appointment.submit');


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
        Route::get('/rent/property/submission', [ClientPropertySubmission::class, 'rentSubmission'])->name('rent.submission');
        Route::get('/sell/property/submission', [ClientPropertySubmission::class, 'sellSubmission'])->name('sell.submission');
        Route::get('/admin/submission/show', [ClientPropertySubmission::class, 'show'])->name('admin.submission.show');
        Route::post('/admin/submission/update-status', [ClientPropertySubmission::class, 'updateStatus'])->name('admin.submission.updateStatus');
        Route::post('/admin/submission/delete/{id}', [ClientPropertySubmission::class, 'delete'])->name('admin.submission.delete');
        Route::get('/our/clients', [ClientPropertySubmission::class, 'clients'])->name('clients.confirmed');
        Route::get('/clients/data', [ClientPropertySubmission::class, 'getClients'])->name('clients.data');
        Route::get('/all/services/managment', [AdminServiceController::class, 'services'])->name('admin.services');
        Route::post('/admin/services/store', [AdminServiceController::class, 'store'])->name('admin.services.store');
        Route::get('/admin/services/data', [AdminServiceController::class, 'getData'])->name('admin.services.data');
        Route::get('/admin/services/{id}/edit', [AdminServiceController::class, 'edit'])->name('admin.services.edit');
        Route::post('/admin/services/{id}', [AdminServiceController::class, 'update'])->name('admin.services.update');
        Route::post('/admin/services/delete/{id}', [AdminServiceController::class, 'delete'])->name('admin.services.delete');

        Route::get('/all/teams/managment', [TeamController::class, 'teams'])->name('admin.teams');
        Route::post('/admin/teams/store', [TeamController::class, 'store'])->name('admin.teams.store');
        Route::get('/admin/teams/data', [TeamController::class, 'getData'])->name('admin.teams.data');
        Route::get('/admin/teams/{id}/edit', [TeamController::class, 'edit'])->name('admin.teams.edit');
        Route::post('/admin/teams/{id}', [TeamController::class, 'update'])->name('admin.teams.update');
        Route::post('/admin/teams/delete/{id}', [TeamController::class, 'delete'])->name('admin.teams.delete');

        Route::get('/about/page/managment', [AboutPageController::class, 'aboutPage'])->name('admin.about.page');
        Route::post('/admin/about/update', [AboutPageController::class, 'update'])->name('admin.about.update');

        Route::get('/all/reviews/managment', [ReviewsController::class, 'reviews'])->name('admin.reviews');
        Route::post('/admin/reviews/store', [ReviewsController::class, 'store'])->name('admin.reviews.store');
        Route::get('/admin/reviews/data', [ReviewsController::class, 'getData'])->name('admin.reviews.data');
        Route::get('/admin/reviews/{id}/edit', [ReviewsController::class, 'edit'])->name('admin.reviews.edit');
        Route::post('/admin/reviews/{id}', [ReviewsController::class, 'update'])->name('admin.reviews.update');
        Route::post('/admin/reviews/delete/{id}', [ReviewsController::class, 'delete'])->name('admin.reviews.delete');

        Route::get('/all/home/slider/managment', [PagesController::class, 'homepage'])->name('admin.homeslider');
        Route::post('/admin/home/slider/store', [PagesController::class, 'store'])->name('admin.homeslider.store');
        Route::get('/admin/home/slider/data', [PagesController::class, 'getData'])->name('admin.homeslider.data');
        Route::get('/admin/home/slider/{id}/edit', [PagesController::class, 'edit'])->name('admin.homeslider.edit');
        Route::post('/admin/home/slider/{id}', [PagesController::class, 'update'])->name('admin.homeslider.update');
        Route::post('/admin/home/slider/delete/{id}', [PagesController::class, 'delete'])->name('admin.homeslider.delete');
        Route::post('/admin/homepage/update', [PagesController::class, 'homeupdate'])->name('admin.homepage.update');

        Route::resource('blogs', BlogController::class)->names('blogs');
        Route::get('/get/blogs/data', [BlogController::class, 'getData'])->name('admin.blogs.data');
        Route::resource('careers', CarrerController::class)->names('careers');
        Route::get('/get/careers/data', [CarrerController::class, 'getData'])->name('admin.careers.data');

        Route::get('gallery', [GalleryController::class, 'index'])->name('gallery.index');
        Route::post('gallery/upload', [GalleryController::class, 'store'])->name('admin.gallery.store');
        Route::delete('gallery/{id}', [GalleryController::class, 'destroy'])->name('admin.gallery.destroy');

        Route::get('/agent/page/managment', [AgentPageController::class, 'index'])->name('admin.agent.page');
        Route::post('/admin/agent/update', [AgentPageController::class, 'update'])->name('admin.agent.update');

        Route::get('/all/users/managment', [UserManagmentController::class, 'users'])->name('admin.users');
        Route::get('/admin/users/data', [UserManagmentController::class, 'getData'])->name('admin.users.data');
        Route::post('/admin/users/{id}/{status}', [UserManagmentController::class, 'updateStatus'])->name('admin.users.update');
        Route::post('/users/delete/{id}', [UserManagmentController::class, 'delete'])->name('admin.users.deleted');

        Route::get('/control/panel/admins', [AdminAccessController::class, 'admins'])->name('admin.control.panel');
        Route::post('/control/panel/store', [AdminAccessController::class, 'store'])->name('admin.control.store');
        Route::post('/control/panel/{id}/status', [AdminAccessController::class, 'status'])->name('admin.control.status');
        Route::post('/control/panel/{id}', [AdminAccessController::class, 'update'])->name('admin.control.update');
        Route::post('/control/panel/delete/{id}', [AdminAccessController::class, 'delete'])->name('admin.control.delete');
        Route::get('/seo/settings', [SeoController::class, 'edit'])->name('admin.seo.settings');
        Route::post('/seo/settings/update', [SeoController::class, 'update'])->name('admin.seo.settings.update');
        
        Route::get('/notifications/dropdown', [NotificationController::class, 'dropdown'])->name('notifications.dropdown');
        Route::post('/notifications/mark-read', [NotificationController::class, 'markRead'])->name('notifications.markRead');
        Route::get('/notifications/view-all', [NotificationController::class, 'viewAll'])->name('notifications.all');

        Route::get('/services/inquiry', [ServiceInquiryController::class, 'servicesInquiry'])->name('admin.services.inquiry');
        Route::get('/admin/services/inquiry/show', [ServiceInquiryController::class, 'show'])->name('admin.services.inquiry.show');
        Route::post('/admin/services/inquiry/update-status', [ServiceInquiryController::class, 'updateStatus'])->name('admin.services.inquiry.updateStatus');
        Route::post('/admin/services/inquiry/delete/{id}', [ServiceInquiryController::class, 'delete'])->name('admin.services.inquiry.delete');

        Route::get('/team/appointment/submission', [AppointmentController::class, 'appointments'])->name('appointment.index');
        Route::get('/admin/appointment/show', [AppointmentController::class, 'show'])->name('admin.appointment.show');
        Route::post('/admin/appointment/update-status', [AppointmentController::class, 'updateStatus'])->name('admin.appointment.updateStatus');
        Route::post('/admin/appointment/delete/{id}', [AppointmentController::class, 'delete'])->name('admin.appointment.delete');


    });
});


