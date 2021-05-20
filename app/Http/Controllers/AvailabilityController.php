<?php

namespace App\Http\Controllers;

use App\Http\Resources\AvailabilityCollection;
use App\Models\Doctor;
use App\Traits\ApiServiceTrait;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    use ApiServiceTrait;
    
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \App\Http\Resources\AvailabilitieCollection
     */
    public function index(Request $request, $id)
    {
        $doctor = Doctor::find($id);

        switch ($doctor->agenda) {
          case Doctor::AGENDA_DOCTOLIB:
            $availabilities = $this->getAvailabilitiesFromDoctolib($doctor->external_agenda_id);
            break;
          case Doctor::AGENDA_CLICRDV:
            $availabilities = $this->getAvailabilitiesFromClicrdv($doctor->external_agenda_id);
            break;
          default:
            $availabilities =  $doctor->availabilities;
            break;
        }

        return new AvailabilityCollection($availabilities);
    }
}
