<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
          'type' => 'doctors',
          'id' => $this->id,
          'attributes' => [
            'agenda' => $this->agenda,
            'created_at' => $this->created_at->toDateTimeString(),
            'name' => $this->name,
            'updated_at' => $this->updated_at->toDateTimeString(),
          ],
          'relationships' => [
            'availabilities' => [
              'data' => $this->availabilities()->exists() ? $this->availabilities->map(function ($availabilitie) {
                return [
                  'type' => 'availabilities',
                  'id' => $availabilitie->id
                ];
              }) : null
            ],
            'bookings' => [
              'data' => $this->bookings()->exists() ?
              $this->bookings->map(function ($booking) {
                return [
                  'type' => 'bookings',
                  'id' => $booking->id
                ];
              }) : null
            ],
          ]
        ];
    }
}
