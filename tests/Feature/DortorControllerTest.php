<?php

namespace Tests\Feature;

use App\Http\Resources\DoctorCollection;
use App\Models\Doctor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DortorControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \App\Models\Doctor
     */
    protected $doctors;

    public function setUp(): void
    {
        parent::setUp();

        $this->doctors = Doctor::factory(2)->hasAvailabilities(2)->create();
    }

    /**
     *
     * @return void
     */
    public function test_can_get_doctors_returns_code_200()
    {
        //  Action
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ])->getJson('/api/doctors');

        // Assert
        $response->assertOk();
    }

    /**
     *
     * @return void
     */
    public function test_can_get_doctors_returns_response_Json_Structure_exact()
    {
        //  Action
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ])->json('GET', '/api/doctors');

        // Assert
        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                         'type',
                         'id',
                         'attributes' => [
                             'agenda',
                             'created_at',
                             'name',
                             'updated_at',
                         ],
                         'relationships' => [
                           'availabilities' => [
                               'data' => [
                                   '*' => [
                                       'type',
                                       'id'
                                   ],
                               ],
                               'links' => [
                                   'related',
                               ],
                           ],
                           'bookings' => [
                               'data',
                           ],
                         ],
                    ]
                ],
                'links' => [
                    'self',
                ]
            ]);
    }
}
