<?php

namespace Database\Seeders;

use App\Models\Nurse;
use Illuminate\Database\Seeder;

class NurseSeeder extends Seeder
{
    public function run(): void
    {
        Nurse::factory()->count(50)->create();
    }
}
