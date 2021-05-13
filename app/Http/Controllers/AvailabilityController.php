<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Http\Resources\AvailabilitieCollection;

class AvailabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \App\Http\Resources\AvailabilitieCollection
     */
    public function index(Request $request, $id)
    {
        $availabilities =  Doctor::find($id)->availabilities;

        return new AvailabilitieCollection($availabilities);
    }
}
