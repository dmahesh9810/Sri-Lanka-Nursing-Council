<?php

namespace Database\Factories;

use App\Models\ForeignCertificate;
use App\Models\Nurse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ForeignCertificate>
 */
class ForeignCertificateFactory extends Factory
{
    protected $model = ForeignCertificate::class;

    public function definition(): array
    {
        return [
            'nurse_id' => Nurse::factory(),
            'certificate_type' => fake()->randomElement([
                'Verification', 'Good Standing', 'Confirmation', 'Additional Verification'
            ]),
            'country' => fake()->country(),
            'apply_date' => fake()->date('Y-m-d', 'now'),
            'certificate_sealed' => false,
            'issue_date' => null,
            'certificate_printed' => false,
            'printed_at' => null,
            'certificate_number' => null,
        ];
    }

    /**
     * Sealed and issued – ready for printing.
     */
    public function readyForPrint(): static
    {
        return $this->state(fn(array $attrs) => [
        'certificate_sealed' => true,
        'issue_date' => fake()->date('Y-m-d', 'now'),
        ]);
    }

    /**
     * Already printed.
     */
    public function printed(): static
    {
        return $this->state(fn(array $attrs) => [
        'certificate_sealed' => true,
        'issue_date' => fake()->date('Y-m-d', 'now'),
        'certificate_printed' => true,
        'printed_at' => now(),
        'certificate_number' => 'SLNC-CERT-' . now()->year . '-0001',
        ]);
    }
}
