<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookingControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \App\Models\User
     */
    protected $user;

    /**
     * @var \App\Models\Doctor
     */
    protected $doctor;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory(1)->hasBookings(2)->create()[0];

        $this->doctor = Doctor::factory(1)->create()[0];
    }

    /**
     *
     * @return void
     */
    public function test_can_get_bookings_when_user_is_not_authenticated_returns_401_Unauthorized()
    {
        // Action
        $response = $this->json('GET', route('bookings.index'));

        // Assert
        $response->assertStatus(401);
    }

    /**
     *
     * @return void
     */
    public function test_can_get_bookings_when_user_is_authenticated_returns_200()
    {
        // Action
        $response = $this->actingAs($this->user, 'api')
            ->json('GET', route('bookings.index'));

        // Assert
        $response->assertOk();
    }

    /**
     *
     * @return void
     */
    public function test_can_get_bookings_when_user_is_authenticated_returns_Json_Structure_exact()
    {
        // Action
        $response = $this->actingAs($this->user, 'api')
            ->json('GET', route('bookings.index'));

        // Assert
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                     'type',
                     'id',
                     'attributes' => [
                       'created_at',
                       "date",
                       'status',
                       'updated_at',
                     ],
                     'links' => [
                         'canceled'
                     ],
                     'relationships' => [
                         'doctor' => [
                             'data' => [
                                 'type',
                                 'id',
                             ],
                         ],
                         'user' => [
                             'data' => [
                                 'type',
                                 'id',
                             ],
                         ]
                     ],
                ]
            ],
            'links' => [
                'self',
            ]
        ]);
    }

    /**
     *
     * @return void
     */
    public function test_can_create_booking_when_user_is_not_authenticated_returns_401_Unauthorized()
    {
        // Arrange
        $data = [
          'attributes' => [
             'date' => "2021-10-12 12:15"
          ],
          'doctor_id' => $this->doctor->id,
        ];

        // Action
        $response = $this->json('POST', route('bookings.store'), $data);

        // Assert
        $response->assertStatus(401);
    }

    /**
     *
     * @return void
     */
    public function test_can_create_booking_when_data_not_exists_returns_422_Unprocessable_Entity()
    {
        // Action
        $response = $this->actingAs($this->user, 'api')
            ->json('POST', route('bookings.store'));

        // Assert
        $response->assertStatus(422)
            ->assertExactJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "attributes" => [
                        "The attributes field is required."
                    ],
                    "doctor_id" => [
                        "The doctor id field is required."
                    ]
                ]
            ]);
    }

    /**
     *
     * @return void
     */
    public function test_can_create_booking_with_data_returns_201_returns_response_Json()
    {
        // Arrange
        $data = [
          'attributes' => [
             'date' => "2021-10-12 12:15"
          ],
          'doctor_id' => $this->doctor->id,
        ];

        // Action
        $response = $this->actingAs($this->user, 'api')
            ->json('POST', route('bookings.store'), $data);

        // Assert
        $response->assertStatus(201)
            ->assertExactJson([
                "data" => [
                    "type" => "bookings",
                    "id" => 13,
                    "attributes" => [
                        "created_at" => date('Y-m-d H:i:s', strtotime(now())),
                        "date" => "2021-10-12 12:15",
                        "status" => "confirmed",
                        "updated_at" => date('Y-m-d H:i:s', strtotime(now()))
                    ],
                    "links" => [
                        "canceled" => "http://test-back.test/api/bookings/13/cancel"
                    ],
                    "relationships" => [
                        "doctor" => [
                            "data" => [
                                "type" => "doctors",
                                "id" => $this->doctor->id
                            ],
                        ],
                        "user" => [
                            "data" => [
                                "type" => "users",
                                "id" => $this->user->id
                            ],
                        ]
                    ]
                ]
            ]);
    }
}
