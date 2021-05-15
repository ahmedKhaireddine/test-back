<?php

namespace App\Http\Controllers;

use App\Http\Resources\DoctorCollection;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\DoctorCollection
     */
    public function index()
    {
        $doctors = Doctor::all();

        return new DoctorCollection($doctors);
    }
}
