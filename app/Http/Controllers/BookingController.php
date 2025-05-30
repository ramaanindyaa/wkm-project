<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\StoreCheckBookingRequest;
use App\Models\BookingTransaction;
use App\Models\Workshop;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function booking(Workshop $workshop)
    {
        return view('booking.booking', compact('workshop'));
    }

    public function bookingStore(StoreBookingRequest $request, Workshop $workshop)
    {
        $validated = $request->validated();
        $validated['workshop_id'] = $workshop->id;

        // Debug: Log the validated data
        Log::info('Booking Store Validated Data:', $validated);

        try {
            $this->bookingService->storeBooking($validated);
            
            // Change this line to use the absolute URL
            return redirect('/booking/payment');
            
            // Or you can use URL generation with the full path
            // return redirect(url('/booking/payment'));
        } catch (\Exception $e) {
            Log::error('Booking store failed: ' . $e->getMessage());
            Log::error('Exception trace: ' . $e->getTraceAsString());
            
            return redirect()->back()->withErrors([
                'error' => 'Unable to create booking: ' . $e->getMessage()
            ])->withInput();
        }
    }

    public function payment()
    {
        if (!$this->bookingService->isBookingSessionAvailable()) {
            return redirect()->route('front.index');
        }

        $data = $this->bookingService->getBookingDetails();

        // dd($data);

        if (!$data) {
            return redirect()->route('front.index');
        }

        return view('booking.payment', $data);
    }

    public function paymentStore(StorePaymentRequest $request)
    {
        $validated = $request->validated();

        try {
            $bookingTransactionId = $this->bookingService->finalizeBookingAndPayment($validated);
            return redirect()->route('front.booking_finished', $bookingTransactionId);
        } catch (\Exception $e) {
            Log::error('Payment storage failed: ' . $e->getMessage());
            return redirect()->back()->withErrors([
                'error' => 'Unable to store payment details. Please try again.' . $e->getMessage()
            ]);
        }
    }

    public function bookingFinished(BookingTransaction $bookingTransaction)
    {
        return view('booking.booking_finished', compact('bookingTransaction')); 
    }

    public function checkBooking()
    {
        return view('booking.my_booking');
    }

    public function checkBookingDetails(StoreCheckBookingRequest $request)
    {
        $validated = $request->validated();

        $myBookingDetails = $this->bookingService->getMyBookingDetails($validated);

        if ($myBookingDetails) {

            $subTotalAmount =  $myBookingDetails->workshop->price * $myBookingDetails->quantity;

            $taxRate = 0.11; // 11% tax rate
            $totalTax = $subTotalAmount * $taxRate;

            $totalAmount = $subTotalAmount + $totalTax;

            return view('booking.my_booking_details', compact('myBookingDetails', 'totalTax', 'subTotalAmount'));
        }

        return redirect()->route('front.check_booking')->withErrors(['error' => 'Transaction not found']);
    }
}

