<?php

namespace Database\Factories;

use App\Models\Nurse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Nurse>
 */
class NurseFactory extends Factory
{
    protected $model = Nurse::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'nic' => fake()->unique()->numerify('##########V'),
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'gender' => fake()->randomElement(['Male', 'Female']),
            'date_of_birth' => fake()->date('Y-m-d', '-20 years'),
            'school_or_university' => fake()->company(),
            'batch' => fake()->year(),
        ];
    }
}
