<?php

namespace Database\Seeders;

use App\Models\PermanentRegistration;
use App\Models\TemporaryRegistration;
use Illuminate\Database\Seeder;

class PermanentRegistrationSeeder extends Seeder
{
    public function run(): void
    {
        $temporaryRegistrations = TemporaryRegistration::all();

        // Register ~60% of nurses who have temporary registrations
        foreach ($temporaryRegistrations->random(intval($temporaryRegistrations->count() * 0.6)) as $tempReg) {
            PermanentRegistration::factory()->create([
                'nurse_id' => $tempReg->nurse_id,
            ]);
        }
    }
}
