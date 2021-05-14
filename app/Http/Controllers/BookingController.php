<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\BookingCollection;
use App\Http\Resources\BookingResource;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;

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
        $user = $request->user();

        $data = $request->validated();

        $booking = new Booking;
        $booking->date = $data['attributes']['date'];
        $booking->status = $data['attributes']['status'];
        $booking->user_id = $user->id;
        $booking->doctor_id = $data['doctor_id'];
        $booking->save();

        return new BookingResource($booking);
    }
}
