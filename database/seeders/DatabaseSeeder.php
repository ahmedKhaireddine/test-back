<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Doctor::factory(5)->hasAvailabilities(10)->create();
        Doctor::factory(5)->withAgenda(Doctor::AGENDA_DOCTOLIB)->create();
        Doctor::factory(5)->withAgenda(Doctor::AGENDA_CLICRDV)->create();
        User::factory(1)->create();
    }
}
