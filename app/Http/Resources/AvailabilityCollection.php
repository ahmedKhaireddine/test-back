<?php

namespace App\Http\Resources;

use App\Http\Resources\AvailabilityResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AvailabilityCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return AvailabilityResource::collection($this);
    }

    /**
    * Get additional data that should be returned with the resource array.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
   public function with($request)
   {
       return [
           'links' => [
               'self' => $request->url(),
            ],
       ];
   }
}
