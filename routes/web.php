<?php
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\EventController; // Add this line
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontController::class, 'index'])->name('front.index');

Route::get('/browse/{category:slug}', [FrontController::class, 'category'])->name('front.category');

Route::get('/details/{workshop:slug}', [FrontController::class, 'details'])->name('front.details');

Route::get('/check-booking', [BookingController::class, 'checkBooking'])->name('front.check_booking');
Route::post('/check-booking/details', [BookingController::class, 'checkBookingDetails'])->name('front.check_booking_details');

Route::get('/booking/payment', [BookingController::class, 'payment'])->name('front.payment');
Route::post('/booking/payment', [BookingController::class, 'paymentStore'])->name('front.payment_store');

Route::get('/booking/{workshop:slug}', [BookingController::class, 'booking'])->name('front.booking');
Route::post('/booking/{workshop:slug}', [BookingController::class, 'bookingStore'])->name('front.booking_store');

Route::get('/booking/finished/{bookingTransaction}', [BookingController::class, 'bookingFinished'])->name('front.booking_finished');

// Event registration routes
Route::get('/event/{event}/register', [EventController::class, 'showRegister'])->name('event.register');
Route::post('/event/register/store', [EventController::class, 'store'])->name('event.register.store');
Route::get('/events', [FrontController::class, 'eventsList'])->name('event.index');
Route::get('/event/{event}', [EventController::class, 'showEvent'])->name('event.show');
Route::get('/category/{category:slug}', [FrontController::class, 'category'])->name('front.category');
Route::get('/categories', [FrontController::class, 'allCategories'])->name('front.categories');
Route::get('/event/{event}/payment', [EventController::class, 'showPayment'])->name('event.payment');
Route::post('/event/payment/store', [EventController::class, 'storePayment'])->name('event.payment.store');
Route::get('/event/payment/success/{participant}', [EventController::class, 'paymentSuccess'])->name('event.payment.success');
