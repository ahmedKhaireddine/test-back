<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CancelBookingControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \App\Models\User
     */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory(1)->hasBookings(2)->create()[0];
    }

    /**
     *
     * @return void
     */
    public function test_can_canceled_booking_when_user_is_not_authenticated_returns_401_Unauthorized()
    {
      // Arrange
      $booking = $this->user->bookings[0];

      // Action
      $response = $this->json('GET', route('booking_canceled', $booking->id));

      // Assert
      $response->assertStatus(401);
    }

    /**
     *
     * @return void
     */
    public function test_can_canceled_booking_by_another_user_is_authenticated_returns_403_Forbidden()
    {
      // Arrange
      $anotherUser = User::factory(1)->create()[0];

      $booking = $this->user->bookings[0];

      // Action
      $response = $this->actingAs($anotherUser, 'api')
          ->json('GET', route('booking_canceled', $booking->id));

      // Assert
      $response->assertForbidden();
    }

    /**
     *
     * @return void
     */
    public function test_can_canceled_booking_when_user_creator_is_authenticated_returns_200_Ok()
    {
      // Arrange
      $booking = $this->user->bookings[0];

      // Action
      $response = $this->actingAs($this->user, 'api')
          ->json('GET', route('booking_canceled', $booking->id));

      // Assert
      $response->assertOk();
    }

    /**
     *
     * @return void
     */
    public function test_can_canceled_booking_when_user_is_authenticated_returns_Json_response_exact()
    {
      // Arrange
      $booking = $this->user->bookings[0];

      // Action
      $response = $this->actingAs($this->user, 'api')
          ->json('GET', route('booking_canceled', $booking->id));

      // Assert
      $response->assertOk()
          ->assertExactJson([
               "data" => [
                   "type" => "bookings",
                   "id" => $booking->id,
                   "attributes" => [
                       "created_at" => $booking->created_at->toDateTimeString(),
                       "date" => $booking->date,
                       "status" => "canceled",
                       "updated_at" => $booking->updated_at->toDateTimeString()
                   ],
                   "relationships" => [
                       "doctor" => [
                           "data" => [
                               "type" => "doctors",
                               "id" => $booking->doctor->id
                           ],
                       ],
                       "user" => [
                           "data" => [
                               "type" => "users",
                               "id" => $booking->user->id
                           ],
                       ]
                   ]
               ]
           ]);
     }
}
