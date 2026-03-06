<?php

namespace Tests\Feature;

use App\Models\AdditionalQualification;
use App\Models\ForeignCertificate;
use App\Models\Nurse;
use App\Models\PermanentRegistration;
use App\Models\TemporaryRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

/**
 * Feature Tests – Admin Dashboard
 *
 * Verifies that all statistics displayed on the dashboard
 * correctly match the actual counts in the database.
 */
class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

    /** @test */
    public function it_displays_the_dashboard_page(): void
    {
        $this->get(route('dashboard'))
            ->assertOk()
            ->assertViewIs('dashboard.index');
    }

    /** @test */
    public function dashboard_shows_zero_counts_on_empty_database(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertOk();
        $response->assertViewHas('stats', function ($stats) {
            return $stats['total_nurses'] === 0
            && $stats['total_temporary'] === 0
            && $stats['total_permanent'] === 0
            && $stats['total_qualifications'] === 0
            && $stats['total_foreign_certificates'] === 0
            && $stats['total_printed'] === 0;
        });
    }

    /** @test */
    public function dashboard_shows_correct_total_nurse_count(): void
    {
        Nurse::factory()->count(5)->create();

        $response = $this->get(route('dashboard'));

        $response->assertViewHas('stats', function ($stats) {
            return $stats['total_nurses'] === 5;
        });
    }

    /** @test */
    public function dashboard_shows_correct_temporary_registration_count(): void
    {
        TemporaryRegistration::factory()->count(3)->create();

        $response = $this->get(route('dashboard'));

        $response->assertViewHas('stats', function ($stats) {
            return $stats['total_temporary'] === 3;
        });
    }

    /** @test */
    public function dashboard_shows_correct_permanent_registration_count(): void
    {
        PermanentRegistration::factory()->count(2)->create();

        $response = $this->get(route('dashboard'));

        $response->assertViewHas('stats', function ($stats) {
            return $stats['total_permanent'] === 2;
        });
    }

    /** @test */
    public function dashboard_shows_correct_additional_qualification_count(): void
    {
        AdditionalQualification::factory()->count(4)->create();

        $response = $this->get(route('dashboard'));

        $response->assertViewHas('stats', function ($stats) {
            return $stats['total_qualifications'] === 4;
        });
    }

    /** @test */
    public function dashboard_shows_correct_foreign_certificate_count(): void
    {
        ForeignCertificate::factory()->count(6)->create();

        $response = $this->get(route('dashboard'));

        $response->assertViewHas('stats', function ($stats) {
            return $stats['total_foreign_certificates'] === 6;
        });
    }

    /** @test */
    public function dashboard_shows_correct_printed_certificate_count(): void
    {
        // 3 printed, 2 not printed
        ForeignCertificate::factory()->count(3)->create(['printed_at' => now()]);
        ForeignCertificate::factory()->count(2)->create(['printed_at' => null]);

        $response = $this->get(route('dashboard'));

        $response->assertViewHas('stats', function ($stats) {
            return $stats['total_printed'] === 3
            && $stats['total_foreign_certificates'] === 5;
        });
    }

    /** @test */
    public function dashboard_counts_update_after_creating_new_records(): void
    {
        $response = $this->get(route('dashboard'));
        $response->assertViewHas('stats', fn($s) => $s['total_nurses'] === 0);

        Nurse::factory()->count(2)->create();

        $response = $this->get(route('dashboard'));
        $response->assertViewHas('stats', fn($s) => $s['total_nurses'] === 2);
    }

    /** @test */
    public function dashboard_counts_update_after_deleting_records(): void
    {
        $nurses = Nurse::factory()->count(4)->create();

        $response = $this->get(route('dashboard'));
        $response->assertViewHas('stats', fn($s) => $s['total_nurses'] === 4);

        $nurses->first()->delete();

        $response = $this->get(route('dashboard'));
        $response->assertViewHas('stats', fn($s) => $s['total_nurses'] === 3);
    }

    /** @test */
    public function dashboard_reflects_all_statistics_accurately(): void
    {
        // Seed a complete dataset
        $nurses = Nurse::factory()->count(3)->create();

        foreach ($nurses as $nurse) {
            TemporaryRegistration::factory()->create(['nurse_id' => $nurse->id]);
            PermanentRegistration::factory()->create(['nurse_id' => $nurse->id]);
        }

        AdditionalQualification::factory()->count(5)->create(['nurse_id' => $nurses->first()->id]);
        ForeignCertificate::factory()->count(4)->create(['nurse_id' => $nurses->first()->id]);
        ForeignCertificate::factory()->count(2)->create([
            'nurse_id' => $nurses->first()->id,
            'printed_at' => now(),
        ]);

        $response = $this->get(route('dashboard'));

        $response->assertViewHas('stats', function ($stats) {
            return $stats['total_nurses'] === 3
            && $stats['total_temporary'] === 3
            && $stats['total_permanent'] === 3
            && $stats['total_qualifications'] === 5
            && $stats['total_foreign_certificates'] === 6
            && $stats['total_printed'] === 2;
        });
    }

    /** @test */
    public function root_url_redirects_to_dashboard(): void
    {
        $this->get('/')->assertRedirect(route('dashboard'));
    }
}
