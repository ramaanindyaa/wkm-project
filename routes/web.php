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

Route::get('/event/register/{event?}', [EventController::class, 'registerForm'])->name('event.register');
Route::post('/event/register', [EventController::class, 'register'])->name('event.register.store');
Route::get('/events', [FrontController::class, 'eventsList'])->name('front.events');
Route::get('/event/{event}', [EventController::class, 'showEvent'])->name('event.show');
Route::get('/category/{category:slug}', [FrontController::class, 'category'])->name('front.category');
Route::get('/categories', [FrontController::class, 'allCategories'])->name('front.categories');
