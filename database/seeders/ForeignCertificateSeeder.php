<?php

namespace Database\Seeders;

use App\Models\ForeignCertificate;
use App\Models\Nurse;
use Illuminate\Database\Seeder;

class ForeignCertificateSeeder extends Seeder
{
    public function run(): void
    {
        $nurses = Nurse::all();

        // Assign foreign requests to some nurses (~20%)
        foreach ($nurses->random(intval($nurses->count() * 0.2)) as $nurse) {
            ForeignCertificate::factory()->create([
                'nurse_id' => $nurse->id,
            ]);
        }
    }
}
