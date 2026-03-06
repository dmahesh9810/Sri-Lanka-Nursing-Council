<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Nurse;
use App\Models\TemporaryRegistration;
use App\Models\PermanentRegistration;
use App\Models\AdditionalQualification;
use App\Models\ForeignCertificate;
use Carbon\Carbon;

class ManualQaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create 5 Nurses (Realistic Sri Lankan data context)
        $nurses = [
            ['name' => 'Samanthi Perera', 'nic' => '851234567V', 'date_of_birth' => '1985-05-15', 'phone' => '0771234567', 'address' => 'Colombo 03'],
            ['name' => 'Kamal Silva', 'nic' => '901987654V', 'date_of_birth' => '1990-10-20', 'phone' => '0719876543', 'address' => 'Kandy'],
            ['name' => 'Nadeesha Fernando', 'nic' => '885432109V', 'date_of_birth' => '1988-02-12', 'phone' => '0701122334', 'address' => 'Galle'],
            ['name' => 'Dilanthi Rajapaksa', 'nic' => '925678901V', 'date_of_birth' => '1992-08-30', 'phone' => '0789988776', 'address' => 'Negombo'],
            ['name' => 'Amila Bandara', 'nic' => '951112223V', 'date_of_birth' => '1995-12-05', 'phone' => '0723344556', 'address' => 'Kurunegala'],
        ];

        $insertedNurses = [];
        foreach ($nurses as $nurseData) {
            $insertedNurses[] = Nurse::create($nurseData);
        }

        // 2. Create 3 Temporary Registrations (For first 3 nurses)
        $tempRegNurses = array_slice($insertedNurses, 0, 3);
        foreach ($tempRegNurses as $index => $nurse) {
            TemporaryRegistration::create([
                'nurse_id' => $nurse->id,
                'temp_registration_no' => 'TEMP-' . (20000 + $index),
                'temp_registration_date' => Carbon::now()->subYears(2)->addMonths($index),
            ]);
        }

        // 3. Create 2 Permanent Registrations (Must have temp registration: Use nurses 0 and 1)
        $permRegNurses = array_slice($tempRegNurses, 0, 2);
        foreach ($permRegNurses as $index => $nurse) {
            PermanentRegistration::create([
                'nurse_id' => $nurse->id,
                'perm_registration_no' => 'PERM-' . (10000 + $index),
                'perm_registration_date' => Carbon::now()->subMonths(6)->addDays($index * 10),
                'appointment_date' => Carbon::now()->subMonths(5),
                'grade' => 'Nursing Officer Grade ' . ($index + 1),
                'present_workplace' => 'Base Hospital ' . ['Panadura', 'Gampaha'][$index],
                'slmc_no' => 'SLMC-' . (30000 + $index),
                'slmc_date' => Carbon::now()->subMonths(7),
            ]);
        }

        // 4. Create 3 Additional Qualifications (Must have permanent registration: Use nurses 0 and 1)
        AdditionalQualification::create([
            'nurse_id' => $permRegNurses[0]->id,
            'qualification_type' => 'B.Sc Nursing',
            'qualification_number' => 'QUAL-BSC-001',
            'qualification_date' => Carbon::now()->subYears(1),
            'certificate_printed' => true,
        ]);

        AdditionalQualification::create([
            'nurse_id' => $permRegNurses[0]->id,
            'qualification_type' => 'Diploma in Midwifery',
            'qualification_number' => 'QUAL-MID-002',
            'qualification_date' => Carbon::now()->subMonths(3),
            'certificate_printed' => false,
        ]);

        AdditionalQualification::create([
            'nurse_id' => $permRegNurses[1]->id,
            'qualification_type' => 'Post Basic in ICU',
            'qualification_number' => 'QUAL-ICU-001',
            'qualification_date' => Carbon::now()->subMonths(2),
            'certificate_printed' => true,
        ]);

        // 5. Create 2 Foreign Certificate Requests (Use any fully registered nurse, say nurses 0 and 1)
        ForeignCertificate::create([
            'nurse_id' => $permRegNurses[0]->id,
            'certificate_type' => 'Good Standing',
            'country' => 'United Kingdom',
            'apply_date' => Carbon::now()->subDays(10),
        ]);

        ForeignCertificate::create([
            'nurse_id' => $permRegNurses[1]->id,
            'certificate_type' => 'Verification',
            'country' => 'Australia',
            'apply_date' => Carbon::now()->subDays(20),
            'issue_date' => Carbon::now()->subDays(2),
            'certificate_printed' => true,
            'certificate_sealed' => true,
            'printed_at' => Carbon::now()->subDays(1),
            'certificate_number' => 'FC-VER-24-001',
        ]);
    }
}
