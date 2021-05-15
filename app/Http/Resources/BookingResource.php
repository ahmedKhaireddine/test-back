<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
            'type' => 'bookings',
            'id' => $this->id,
            'attributes' => [
                'created_at' => $this->created_at->toDateTimeString(),
                'date' => $this->date,
                'status' => $this->status,
                'updated_at' => $this->updated_at->toDateTimeString(),
            ],
            $this->mergeWhen($this->isConfirmed(), [
                'links' => [
                    'canceled' => route('booking_canceled', [
                        'bookingId' => $this->id
                    ]),
                ],
            ]),
            'relationships' => [
                'doctor' => [
                    'data' => $this->doctor()->exists() ? [
                        'type' => 'doctors',
                        'id'   => $this->doctor->id,
                    ] : null,
                ],
                'user' => [
                    'data' => $this->user()->exists() ? [
                        'type' => 'users',
                        'id'   => $this->user->id,
                    ] : null,
                ],
            ]
        ];
    }
}
