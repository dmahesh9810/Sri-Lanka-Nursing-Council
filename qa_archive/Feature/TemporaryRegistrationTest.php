<?php

namespace Tests\Feature;

use App\Models\Nurse;
use App\Models\TemporaryRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

/**
 * Feature Tests – Temporary Registration Module
 *
 * Covers: list, create, store (success + validation + duplicates), update, delete.
 */
class TemporaryRegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

    // ──────────────────────────────────────────────────────────────────────────
    // INDEX / LIST
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_displays_the_temporary_registrations_index_page(): void
    {
        $this->get(route('temporary-registrations.index'))->assertOk()->assertViewIs('temporary_registrations.index');
    }

    /** @test */
    public function it_lists_temporary_registrations(): void
    {
        $reg = TemporaryRegistration::factory()->create();

        $response = $this->get(route('temporary-registrations.index'));

        $response->assertOk();
        $response->assertSee($reg->temp_registration_no);
    }

    /** @test */
    public function it_can_search_by_registration_number(): void
    {
        $target = TemporaryRegistration::factory()->create(['temp_registration_no' => 'TEMP-99999']);
        TemporaryRegistration::factory()->create(['temp_registration_no' => 'TEMP-11111']);

        $response = $this->get(route('temporary-registrations.index', ['search' => 'TEMP-99999']));

        $response->assertOk();
        $response->assertSee('TEMP-99999');
    }

    // ──────────────────────────────────────────────────────────────────────────
    // SHOW
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_shows_a_single_temporary_registration(): void
    {
        $reg = TemporaryRegistration::factory()->create();

        $this->get(route('temporary-registrations.show', $reg))
            ->assertOk()
            ->assertViewIs('temporary_registrations.show')
            ->assertSee($reg->temp_registration_no);
    }

    /** @test */
    public function it_returns_404_for_non_existent_temporary_registration(): void
    {
        $this->get(route('temporary-registrations.show', 9999))->assertNotFound();
    }

    // ──────────────────────────────────────────────────────────────────────────
    // CREATE FORM
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_displays_the_create_form(): void
    {
        $this->get(route('temporary-registrations.create'))->assertOk()->assertViewIs('temporary_registrations.create');
    }

    /** @test */
    public function it_prefills_create_form_with_nurse_when_nic_provided(): void
    {
        $nurse = Nurse::factory()->create(['nic' => 'QUERY_NIC_001']);

        $this->get(route('temporary-registrations.create', ['nic' => 'QUERY_NIC_001']))
            ->assertOk()
            ->assertSee($nurse->name);
    }

    /** @test */
    public function it_redirects_back_with_error_when_nurse_not_found_by_nic(): void
    {
        $response = $this->get(route('temporary-registrations.create', ['nic' => 'NONEXISTENT_NIC']));

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    /** @test */
    public function it_redirects_back_if_nurse_already_has_temporary_registration(): void
    {
        $nurse = Nurse::factory()->create();
        TemporaryRegistration::factory()->create(['nurse_id' => $nurse->id]);

        $response = $this->get(route('temporary-registrations.create', ['nic' => $nurse->nic]));

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    // ──────────────────────────────────────────────────────────────────────────
    // STORE
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_creates_a_temporary_registration_with_valid_data(): void
    {
        $nurse = Nurse::factory()->create();

        $response = $this->post(route('temporary-registrations.store'), [
            'nurse_id' => $nurse->id,
            'temp_registration_no' => 'TEMP-00001',
            'temp_registration_date' => '2024-01-15',
        ]);

        $response->assertRedirect(route('temporary-registrations.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('temporary_registrations', [
            'nurse_id' => $nurse->id,
            'temp_registration_no' => 'TEMP-00001',
        ]);
    }

    /** @test */
    public function it_fails_to_create_when_nurse_id_is_missing(): void
    {
        $response = $this->post(route('temporary-registrations.store'), [
            'temp_registration_no' => 'TEMP-00002',
            'temp_registration_date' => '2024-01-15',
        ]);

        $response->assertSessionHasErrors('nurse_id');
    }

    /** @test */
    public function it_fails_to_create_when_nurse_id_does_not_exist(): void
    {
        $response = $this->post(route('temporary-registrations.store'), [
            'nurse_id' => 9999,
            'temp_registration_no' => 'TEMP-00003',
            'temp_registration_date' => '2024-01-15',
        ]);

        $response->assertSessionHasErrors('nurse_id');
    }

    /** @test */
    public function it_fails_when_registration_number_is_missing(): void
    {
        $nurse = Nurse::factory()->create();

        $response = $this->post(route('temporary-registrations.store'), [
            'nurse_id' => $nurse->id,
            'temp_registration_date' => '2024-01-15',
        ]);

        $response->assertSessionHasErrors('temp_registration_no');
    }

    /** @test */
    public function it_fails_when_registration_date_is_missing(): void
    {
        $nurse = Nurse::factory()->create();

        $response = $this->post(route('temporary-registrations.store'), [
            'nurse_id' => $nurse->id,
            'temp_registration_no' => 'TEMP-00004',
        ]);

        $response->assertSessionHasErrors('temp_registration_date');
    }

    /** @test */
    public function it_fails_when_registration_date_is_invalid(): void
    {
        $nurse = Nurse::factory()->create();

        $response = $this->post(route('temporary-registrations.store'), [
            'nurse_id' => $nurse->id,
            'temp_registration_no' => 'TEMP-00005',
            'temp_registration_date' => 'not-a-date',
        ]);

        $response->assertSessionHasErrors('temp_registration_date');
    }

    /** @test */
    public function it_fails_when_nurse_already_has_temporary_registration_on_store(): void
    {
        $nurse = Nurse::factory()->create();
        TemporaryRegistration::factory()->create(['nurse_id' => $nurse->id]);

        $response = $this->post(route('temporary-registrations.store'), [
            'nurse_id' => $nurse->id,
            'temp_registration_no' => 'TEMP-NEW',
            'temp_registration_date' => '2024-05-01',
        ]);

        $response->assertSessionHasErrors('nurse_id');
        $this->assertDatabaseCount('temporary_registrations', 1);
    }

    /** @test */
    public function it_fails_with_empty_form_submission(): void
    {
        $response = $this->post(route('temporary-registrations.store'), []);

        $response->assertSessionHasErrors(['nurse_id', 'temp_registration_no', 'temp_registration_date']);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // EDIT FORM
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_displays_the_edit_form(): void
    {
        $reg = TemporaryRegistration::factory()->create();

        $this->get(route('temporary-registrations.edit', $reg))
            ->assertOk()
            ->assertViewIs('temporary_registrations.edit');
    }

    // ──────────────────────────────────────────────────────────────────────────
    // UPDATE
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_updates_a_temporary_registration_with_valid_data(): void
    {
        $reg = TemporaryRegistration::factory()->create(['temp_registration_no' => 'OLD-REG']);

        $response = $this->put(route('temporary-registrations.update', $reg), [
            'nurse_id' => $reg->nurse_id,
            'temp_registration_no' => 'UPDATED-REG',
            'temp_registration_date' => '2024-06-01',
        ]);

        $response->assertRedirect(route('temporary-registrations.show', $reg));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('temporary_registrations', [
            'id' => $reg->id,
            'temp_registration_no' => 'UPDATED-REG',
        ]);
    }

    /** @test */
    public function it_fails_update_when_required_fields_are_missing(): void
    {
        $reg = TemporaryRegistration::factory()->create();

        $response = $this->put(route('temporary-registrations.update', $reg), []);

        $response->assertSessionHasErrors(['nurse_id', 'temp_registration_no', 'temp_registration_date']);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // DELETE
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_deletes_a_temporary_registration(): void
    {
        $reg = TemporaryRegistration::factory()->create();

        $response = $this->delete(route('temporary-registrations.destroy', $reg));

        $response->assertRedirect(route('temporary-registrations.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('temporary_registrations', ['id' => $reg->id]);
    }
}
