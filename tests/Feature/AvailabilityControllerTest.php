<?php

namespace Tests\Feature;

use App\Models\Doctor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Exceptions\UrlGenerationException;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AvailabilityControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     * @return void
     */
    public function test_can_get_availabilities_of_doctors_when_doctor_id_parameter_is_not_supplied_returns_exeption()
    {
        // Exception
        $this->expectException(UrlGenerationException::class);

        // Action
        $response = $this->json('GET', route('doctor_availabilities.index'));
    }

    /**
     *
     * @return void
     */
    public function test_can_get_availabilities_of_doctors_when_his_aganda_in_database_return_code_200_with_Json_structure_exact()
    {
        // Arrange
        $doctor = Doctor::factory(1)->hasAvailabilities(3)->create()[0];

        // Action
        $response = $this->json('GET', route('doctor_availabilities.index', $doctor->id));

        // Assert
        $response->assertOk()
            ->assertJsonStructure([
              'data' => [
                '*' => [
                    'type',
                    'id',
                    'attributes' => [
                        'created_at',
                        'end',
                        'start',
                        'updated_at',
                    ],
                    'relationships' => [
                        'doctor' => [
                            'data' => [
                                'type',
                                'id',
                            ],
                        ],
                    ]
                ],
              ],
              'links' => [
                'self',
              ],
            ]);
    }

    /**
     *
     * @return void
     */
    public function test_can_get_availabilities_of_doctors_when_his_aganda_in_doctolib_return_code_200_with_Json_structure_exact()
    {
        // Arrange
        $doctor = Doctor::factory(1)->withAgenda(Doctor::AGENDA_DOCTOLIB)->create()[0];

        // Action
        $response = $this->json('GET', route('doctor_availabilities.index', $doctor->id));

        // Assert
        $response->assertOk()
            ->assertJsonStructure([
              'data' => [
                '*' => [
                    'type',
                    'id',
                    'attributes' => [
                        'created_at',
                        'end',
                        'start',
                        'updated_at',
                    ],
                    'relationships' => [
                        'doctor' => [
                            'data',
                        ],
                    ]
                ],
              ],
              'links' => [
                'self',
              ],
            ]);
    }

    /**
     *
     * @return void
     */
    public function test_can_get_availabilities_of_doctors_when_his_aganda_in_clicrdv_return_code_200_with_Json_structure_exact()
    {
        // Arrange
        $doctor = Doctor::factory(1)->withAgenda(Doctor::AGENDA_CLICRDV)->create()[0];

        // Action
        $response = $this->json('GET', route('doctor_availabilities.index', $doctor->id));

        // Assert
        $response->assertOk()
            ->assertJsonStructure([
              'data' => [
                '*' => [
                    'type',
                    'id',
                    'attributes' => [
                        'created_at',
                        'end',
                        'start',
                        'updated_at',
                    ],
                    'relationships' => [
                        'doctor' => [
                            'data',
                        ],
                    ]
                ],
              ],
              'links' => [
                'self',
              ],
            ]);
    }
}
