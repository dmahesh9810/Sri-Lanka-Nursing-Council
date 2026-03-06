<?php

namespace Database\Factories;

use App\Models\Nurse;
use App\Models\PermanentRegistration;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PermanentRegistration>
 */
class PermanentRegistrationFactory extends Factory
{
    protected $model = PermanentRegistration::class;

    public function definition(): array
    {
        return [
            'nurse_id' => Nurse::factory(),
            'perm_registration_no' => 'PERM-' . fake()->unique()->numerify('#####'),
            'perm_registration_date' => fake()->date('Y-m-d'),
            'appointment_date' => fake()->date('Y-m-d'),
            'grade' => fake()->randomElement(['Grade I', 'Grade II', 'Grade III']),
            'present_workplace' => fake()->company(),
            'slmc_no' => fake()->numerify('SLMC-#####'),
            'slmc_date' => fake()->date('Y-m-d'),
        ];
    }
}
