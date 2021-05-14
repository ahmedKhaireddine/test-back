<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\BookingCollection;

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
}
