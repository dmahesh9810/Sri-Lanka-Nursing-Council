<?php

namespace Tests\Feature;

use App\Models\Nurse;
use App\Models\PermanentRegistration;
use App\Models\TemporaryRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

/**
 * Feature Tests – Permanent Registration Module
 *
 * Covers: list, show, create (success + validation + business rules), update, delete.
 * Business rule: a nurse must have a temporary registration before permanent.
 */
class PermanentRegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

    /**
     * Helper: create a nurse who already has a temporary registration.
     */
    private function nurseWithTemp(): Nurse
    {
        $nurse = Nurse::factory()->create();
        TemporaryRegistration::factory()->create(['nurse_id' => $nurse->id]);
        return $nurse;
    }

    // ──────────────────────────────────────────────────────────────────────────
    // INDEX
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_displays_the_permanent_registrations_index_page(): void
    {
        $this->get(route('permanent-registrations.index'))->assertOk()->assertViewIs('permanent_registrations.index');
    }

    /** @test */
    public function it_lists_permanent_registrations(): void
    {
        $reg = PermanentRegistration::factory()->create();

        $this->get(route('permanent-registrations.index'))
            ->assertOk()
            ->assertSee($reg->perm_registration_no);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // SHOW
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_shows_a_single_permanent_registration(): void
    {
        $reg = PermanentRegistration::factory()->create();

        $this->get(route('permanent-registrations.show', $reg))
            ->assertOk()
            ->assertViewIs('permanent_registrations.show')
            ->assertSee($reg->perm_registration_no);
    }

    /** @test */
    public function it_returns_404_for_non_existent_permanent_registration(): void
    {
        $this->get(route('permanent-registrations.show', 9999))->assertNotFound();
    }

    // ──────────────────────────────────────────────────────────────────────────
    // CREATE FORM
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_displays_the_create_form(): void
    {
        $this->get(route('permanent-registrations.create'))->assertOk()->assertViewIs('permanent_registrations.create');
    }

    /** @test */
    public function it_redirects_with_error_if_nurse_has_no_temporary_registration(): void
    {
        $nurse = Nurse::factory()->create(); // no temp registration

        $response = $this->get(route('permanent-registrations.create', ['nic' => $nurse->nic]));

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    /** @test */
    public function it_redirects_with_error_if_nurse_already_has_permanent_registration(): void
    {
        $nurse = $this->nurseWithTemp();
        PermanentRegistration::factory()->create(['nurse_id' => $nurse->id]);

        $response = $this->get(route('permanent-registrations.create', ['nic' => $nurse->nic]));

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    // ──────────────────────────────────────────────────────────────────────────
    // STORE
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_creates_a_permanent_registration_with_valid_data(): void
    {
        $nurse = $this->nurseWithTemp();

        $response = $this->post(route('permanent-registrations.store'), [
            'nurse_id' => $nurse->id,
            'perm_registration_no' => 'PERM-10001',
            'perm_registration_date' => '2024-03-01',
            'appointment_date' => '2024-04-01',
            'grade' => 'Grade I',
            'present_workplace' => 'General Hospital Kandy',
            'slmc_no' => 'SLMC-12345',
            'slmc_date' => '2024-03-15',
        ]);

        $response->assertRedirect(route('permanent-registrations.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('permanent_registrations', [
            'nurse_id' => $nurse->id,
            'perm_registration_no' => 'PERM-10001',
        ]);
    }

    /** @test */
    public function it_creates_permanent_registration_with_only_required_fields(): void
    {
        $nurse = $this->nurseWithTemp();

        $response = $this->post(route('permanent-registrations.store'), [
            'nurse_id' => $nurse->id,
            'perm_registration_no' => 'PERM-MIN01',
            'perm_registration_date' => '2024-03-01',
        ]);

        $response->assertRedirect(route('permanent-registrations.index'));
        $this->assertDatabaseHas('permanent_registrations', ['perm_registration_no' => 'PERM-MIN01']);
    }

    /** @test */
    public function it_fails_when_nurse_id_is_missing(): void
    {
        $this->post(route('permanent-registrations.store'), [
            'perm_registration_no' => 'PERM-FL001',
            'perm_registration_date' => '2024-03-01',
        ])->assertSessionHasErrors('nurse_id');
    }

    /** @test */
    public function it_fails_when_perm_registration_no_is_missing(): void
    {
        $nurse = $this->nurseWithTemp();

        $this->post(route('permanent-registrations.store'), [
            'nurse_id' => $nurse->id,
            'perm_registration_date' => '2024-03-01',
        ])->assertSessionHasErrors('perm_registration_no');
    }

    /** @test */
    public function it_fails_when_perm_registration_date_is_missing(): void
    {
        $nurse = $this->nurseWithTemp();

        $this->post(route('permanent-registrations.store'), [
            'nurse_id' => $nurse->id,
            'perm_registration_no' => 'PERM-FL002',
        ])->assertSessionHasErrors('perm_registration_date');
    }

    /** @test */
    public function it_fails_when_perm_registration_date_is_invalid(): void
    {
        $nurse = $this->nurseWithTemp();

        $this->post(route('permanent-registrations.store'), [
            'nurse_id' => $nurse->id,
            'perm_registration_no' => 'PERM-FL003',
            'perm_registration_date' => 'not-a-date',
        ])->assertSessionHasErrors('perm_registration_date');
    }

    /** @test */
    public function it_fails_with_duplicate_nurse_id(): void
    {
        $nurse = $this->nurseWithTemp();
        PermanentRegistration::factory()->create(['nurse_id' => $nurse->id, 'perm_registration_no' => 'PERM-EXIST1']);

        $this->post(route('permanent-registrations.store'), [
            'nurse_id' => $nurse->id,
            'perm_registration_no' => 'PERM-DUP01',
            'perm_registration_date' => '2024-05-01',
        ])->assertSessionHasErrors('nurse_id');
    }

    /** @test */
    public function it_fails_with_duplicate_registration_number(): void
    {
        $nurse1 = $this->nurseWithTemp();
        PermanentRegistration::factory()->create(['nurse_id' => $nurse1->id, 'perm_registration_no' => 'PERM-DUPNO']);

        $nurse2 = $this->nurseWithTemp();

        $this->post(route('permanent-registrations.store'), [
            'nurse_id' => $nurse2->id,
            'perm_registration_no' => 'PERM-DUPNO',
            'perm_registration_date' => '2024-05-01',
        ])->assertSessionHasErrors('perm_registration_no');
    }

    /** @test */
    public function it_fails_with_empty_form_submission(): void
    {
        $this->post(route('permanent-registrations.store'), [])
            ->assertSessionHasErrors(['nurse_id', 'perm_registration_no', 'perm_registration_date']);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // EDIT FORM
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_displays_the_edit_form(): void
    {
        $reg = PermanentRegistration::factory()->create();

        $this->get(route('permanent-registrations.edit', $reg))
            ->assertOk()
            ->assertViewIs('permanent_registrations.edit');
    }

    // ──────────────────────────────────────────────────────────────────────────
    // UPDATE
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_updates_a_permanent_registration(): void
    {
        $nurse = $this->nurseWithTemp();
        $reg = PermanentRegistration::factory()->create(['nurse_id' => $nurse->id]);

        $response = $this->put(route('permanent-registrations.update', $reg), [
            'nurse_id' => $nurse->id,
            'perm_registration_no' => 'PERM-UPDATED',
            'perm_registration_date' => '2024-07-01',
            'grade' => 'Grade II',
        ]);

        $response->assertRedirect(route('permanent-registrations.show', $reg));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('permanent_registrations', ['id' => $reg->id, 'perm_registration_no' => 'PERM-UPDATED']);
    }

    /** @test */
    public function it_fails_update_when_required_fields_are_missing(): void
    {
        $reg = PermanentRegistration::factory()->create();

        $this->put(route('permanent-registrations.update', $reg), [])
            ->assertSessionHasErrors(['nurse_id', 'perm_registration_no', 'perm_registration_date']);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // DELETE
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_deletes_a_permanent_registration(): void
    {
        $reg = PermanentRegistration::factory()->create();

        $response = $this->delete(route('permanent-registrations.destroy', $reg));

        $response->assertRedirect(route('permanent-registrations.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('permanent_registrations', ['id' => $reg->id]);
    }
}
