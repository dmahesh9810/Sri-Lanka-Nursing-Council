<?php

namespace Database\Seeders;

use App\Models\PermanentRegistration;
use App\Models\ForeignCertificate;
use Illuminate\Database\Seeder;

class CertificateSeeder extends Seeder
{
    public function run(): void
    {
        // Mark some permanent registrations as printed
        $perms = PermanentRegistration::all();
        if ($perms->count() > 0) {
            foreach ($perms->random(min($perms->count(), 10)) as $perm) {
                $perm->update([
                    'certificate_printed' => true,
                    'certificate_posted' => fake()->boolean(),
                ]);
            }
        }

        // Mark some foreign certificates as printed
        $foreigns = ForeignCertificate::all();
        if ($foreigns->count() > 0) {
            foreach ($foreigns->random(min($foreigns->count(), 5)) as $foreign) {
                $foreign->update([
                    'certificate_sealed' => true,
                    'issue_date' => now()->subDays(10),
                    'certificate_printed' => true,
                    'printed_at' => now()->subDays(2),
                    'certificate_number' => 'SLNC-FC-' . fake()->unique()->numerify('####'),
                ]);
            }
        }
    }
}
