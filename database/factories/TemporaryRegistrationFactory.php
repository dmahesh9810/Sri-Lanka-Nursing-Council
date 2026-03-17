<?php

namespace Database\Factories;

use App\Models\Nurse;
use App\Models\TemporaryRegistration;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TemporaryRegistration>
 */
class TemporaryRegistrationFactory extends Factory
{
    protected $model = TemporaryRegistration::class;

    public function definition(): array
    {
        return [
            'nurse_id' => Nurse::factory(),
            'temp_registration_no' => 'TEMP-' . fake()->unique()->numerify('#####'),
            'temp_registration_date' => fake()->date('Y-m-d'),
            'address' => fake()->address(),
            'batch' => fake()->numerify('20##-20##'),
            'school_university' => fake()->randomElement(['School of Nursing Colombo', 'School of Nursing Kandy', 'University of Peradeniya', 'KAATU Nursing School']),
            'birth_date' => fake()->date('Y-m-d', '-20 years'),
        ];
    }
}
