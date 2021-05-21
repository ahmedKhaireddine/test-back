<?php

namespace Tests\Unit;

use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookingModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     * @return void
     */
    public function test_can_mark_booking_canceled()
    {
        // Arrange
        $booking = Booking::factory(1)->create()[0];

        // Action
        $booking->markAsCanceled();

        // Assert
        $this->assertEquals('canceled', $booking->status);
    }
}
