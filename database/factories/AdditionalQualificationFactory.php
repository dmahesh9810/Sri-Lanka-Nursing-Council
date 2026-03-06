<?php

namespace Database\Factories;

use App\Models\AdditionalQualification;
use App\Models\Nurse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AdditionalQualification>
 */
class AdditionalQualificationFactory extends Factory
{
    protected $model = AdditionalQualification::class;

    public function definition(): array
    {
        return [
            'nurse_id' => Nurse::factory(),
            'qualification_type' => fake()->randomElement(['B.Sc Nursing', 'Post Basic', 'Diploma', 'Masters']),
            'qualification_number' => 'QUAL-' . fake()->unique()->numerify('#####'),
            'qualification_date' => fake()->date('Y-m-d'),
            'certificate_printed' => false,
            'certificate_posted' => false,
        ];
    }
}
