<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date = $this->faker->dateTimeBetween('now', '+2 month');

        return [
            'date' => $date,
            'doctor_id'=>  Doctor::factory(),
            'status' => Booking::STATUS_CONFIRMED,
            'user_id' => User::factory(),
        ];
    }
}
