<?php

namespace Database\Seeders;

use App\Models\AdditionalQualification;
use App\Models\Nurse;
use Illuminate\Database\Seeder;

class AdditionalQualificationSeeder extends Seeder
{
    public function run(): void
    {
        $nurses = Nurse::all();

        // Assign qualifications to ~40% of nurses
        foreach ($nurses->random(intval($nurses->count() * 0.4)) as $nurse) {
            AdditionalQualification::factory()->count(fake()->numberBetween(1, 2))->create([
                'nurse_id' => $nurse->id,
            ]);
        }
    }
}
