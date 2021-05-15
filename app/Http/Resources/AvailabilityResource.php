<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AvailabilityResource extends JsonResource
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
            'type' => 'availabilities',
            'id' => $this->id,
            'attributes' => [
                'created_at' => $this->created_at->toDateTimeString(),
                'end' => $this->end,
                'start' => $this->start,
                'updated_at' => $this->updated_at->toDateTimeString(),
            ],
            'relationships' => [
                'doctor' => [
                    'data' => $this->doctor()->exists() ? [
                        'type' => 'doctors',
                        'id'   => $this->doctor->id,
                    ] : null,
                ],
            ]
        ];
    }
}
