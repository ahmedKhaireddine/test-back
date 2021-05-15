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
            $booking = Booking::where('id', $id)->get()[0];

            $this->authorize('update-booking', $booking->user_id);

            $booking->status = 'canceled';
            $booking->save();

            return new BookingResource($booking);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
