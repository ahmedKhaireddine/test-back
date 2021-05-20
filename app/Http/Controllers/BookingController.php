<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookingCollection;
use App\Http\Resources\BookingResource;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use Exception;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\BookingCollection
     */
    public function index(Request $request)
    {
        $user = $request->user();

        return new BookingCollection($user->bookings);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBookingRequest  $request
     * @return \App\Http\Resources\BookingResource
     */
    public function store(StoreBookingRequest $request)
    {
        try {
            $data = $request->validated();

            $booking = new Booking;
            $booking->date = $data['attributes']['date'];
            $booking->doctor_id = $data['doctor_id'];
            $booking->status = Booking::STATUS_CONFIRMED;
            $booking->user_id = $request->user()->id;
            $booking->save();

            return new BookingResource($booking);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
