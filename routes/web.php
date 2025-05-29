<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontController::class, 'index'])->name('front.index');

// Tambahkan route categories (jamak)
Route::get('/categories', [FrontController::class, 'categories'])->name('front.categories');

Route::get('/category/{category}', [FrontController::class, 'category'])->name('front.category');

Route::get('/details/{workshop}', [FrontController::class, 'details'])->name('front.details');

Route::get('/booking/{workshop}', [FrontController::class, 'booking'])->name('front.booking');
Route::post('/booking/save/{workshop}', [FrontController::class, 'booking_save'])->name('front.booking_save');
Route::get('/booking/payment/{bookingTransaction}', [FrontController::class, 'booking_payment'])->name('front.booking_payment');
Route::post('/booking/payment/save', [FrontController::class, 'booking_payment_save'])->name('front.booking_payment_save');
Route::get('/booking/finished/{bookingTransaction:booking_trx_id}', [FrontController::class, 'booking_finished'])->name('front.booking_finished');
Route::get('/check-booking', [FrontController::class, 'check_booking'])->name('front.check_booking');
Route::post('/check-booking/details', [FrontController::class, 'check_booking_details'])->name('front.check_booking_details');

// Event Routes - Updated untuk Transaction System
Route::prefix('event')->name('event.')->group(function () {
    // Public event routes
    Route::get('/', [EventController::class, 'index'])->name('index');
    Route::get('/{event}', [EventController::class, 'show'])->name('show');
    
    // Registration routes dengan transaction system
    Route::get('/{event}/register', [EventController::class, 'showRegister'])->name('register');
    Route::post('/register/store', [EventController::class, 'store'])->name('register.store');
    
    // Payment routes dengan transaction system
    Route::get('/{event}/payment', [EventController::class, 'showPayment'])->name('payment');
    Route::post('/payment/store', [EventController::class, 'storePayment'])->name('payment.store');
    
    // Success page dengan transaction ID
    Route::get('/payment/success/{transaction}', [EventController::class, 'paymentSuccess'])->name('payment.success');
    
    // Document update for competition category
    Route::post('/documents/update/{transaction}', [EventController::class, 'updateDocuments'])->name('documents.update');
});

// Check registration routes untuk event transactions
Route::get('/check-registration', [EventController::class, 'checkRegistration'])->name('event.check_registration');
Route::post('/check-registration/details', [EventController::class, 'checkRegistrationDetails'])->name('event.check_registration_details');
