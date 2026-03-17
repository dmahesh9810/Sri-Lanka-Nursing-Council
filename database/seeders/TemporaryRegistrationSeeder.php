<?php

namespace Database\Seeders;

use App\Models\Nurse;
use App\Models\TemporaryRegistration;
use Illuminate\Database\Seeder;

class TemporaryRegistrationSeeder extends Seeder
{
    public function run(): void
    {
        $nurses = Nurse::all();
        
        // Register ~80% of nurses
        foreach ($nurses->random(intval($nurses->count() * 0.8)) as $nurse) {
            TemporaryRegistration::factory()->create([
                'nurse_id' => $nurse->id,
            ]);
        }
    }
}
