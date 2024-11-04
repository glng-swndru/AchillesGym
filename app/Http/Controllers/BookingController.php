<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\SubscribePackage;
use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    //
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function booking(SubscribePackage $subscribePackage)
    {
        $tax = 0.11;
        $totalTaxAmount = $tax * $subscribePackage->price;
        $grandTotalAmount = $subscribePackage->price + $totalTaxAmount;

        return view('booking.checkout', compact('subscribePackage', 'totalTaxAmount', 'grandTotalAmount'));
    }

    public function bookingStore(SubscribePackage $subscribePackage, StoreBookingRequest $request)
    {
        $validated = $request->validated();

        try {
            $this->bookingService->storeBookingInSession($subscribePackage, $validated);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to store booking. Please try again.']);
        }
        return redirect()->route('front.payment');
    }
}
