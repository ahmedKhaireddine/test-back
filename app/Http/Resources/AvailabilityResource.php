<?php

namespace App\Http\Resources;

use App\Models\Availability;
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
            'id' => isset($this->id) ? $this->id : null,
            'attributes' => [
                'created_at' => isset($this->created_at) ? $this->created_at->toDateTimeString() : null,
                'end' => isset($this->end) ? $this->end :  isset($this['end'])  ? Availability::formattedDate($this['end']) : null,
                'start' => isset($this->start) ? $this->start : Availability::formattedDate($this['start']),
                'updated_at' => isset($this->updated_at) ? $this->updated_at->toDateTimeString() : null,
            ],
            'relationships' => [
                'doctor' => [
                    'data' => isset($this->doctor) ? [
                        'type' => 'doctors',
                        'id'   => $this->doctor->id,
                    ] : null,
                ],
            ]
        ];
    }
}
