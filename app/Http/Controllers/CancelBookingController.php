<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Exception;
use Illuminate\Http\Request;

class CancelBookingController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \App\Http\Resources\BookingResource
     */
    public function __invoke(Request $request, $id)
    {
        try {
            $booking = Booking::find($id);

            $this->authorize('update-booking', $booking->user_id);
    
            $booking->markAsCanceled();

            return new BookingResource($booking);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
