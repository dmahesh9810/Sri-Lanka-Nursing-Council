<?php

namespace Tests\Feature;

use App\Models\AdditionalQualification;
use App\Models\Nurse;
use App\Models\PermanentRegistration;
use App\Models\TemporaryRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

/**
 * Feature Tests – Additional Qualification Module
 *
 * Covers: list, show, create (success + validation + business rules), update, delete.
 * Business rule: nurse must have a permanent registration before adding qualifications.
 */
class AdditionalQualificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

    /**
     * Helper: create a nurse with both temporary and permanent registrations.
     */
    private function nurseWithPermanent(): Nurse
    {
        $nurse = Nurse::factory()->create();
        TemporaryRegistration::factory()->create(['nurse_id' => $nurse->id]);
        PermanentRegistration::factory()->create(['nurse_id' => $nurse->id]);
        return $nurse;
    }

    // ──────────────────────────────────────────────────────────────────────────
    // INDEX
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_displays_the_additional_qualifications_index_page(): void
    {
        $this->get(route('additional-qualifications.index'))
            ->assertOk()
            ->assertViewIs('additional_qualifications.index');
    }

    /** @test */
    public function it_lists_additional_qualifications(): void
    {
        $qualification = AdditionalQualification::factory()->create();

        $this->get(route('additional-qualifications.index'))
            ->assertOk()
            ->assertSee($qualification->qualification_number);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // SHOW
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_shows_a_single_additional_qualification(): void
    {
        $qual = AdditionalQualification::factory()->create();

        $this->get(route('additional-qualifications.show', $qual))
            ->assertOk()
            ->assertViewIs('additional_qualifications.show')
            ->assertSee($qual->qualification_number);
    }

    /** @test */
    public function it_returns_404_for_non_existent_qualification(): void
    {
        $this->get(route('additional-qualifications.show', 9999))->assertNotFound();
    }

    // ──────────────────────────────────────────────────────────────────────────
    // CREATE FORM
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_displays_the_create_form(): void
    {
        $this->get(route('additional-qualifications.create'))
            ->assertOk()
            ->assertViewIs('additional_qualifications.create');
    }

    /** @test */
    public function it_redirects_with_error_when_nurse_has_no_permanent_registration(): void
    {
        $nurse = Nurse::factory()->create(); // no permanent registration

        $response = $this->get(route('additional-qualifications.create', ['nic' => $nurse->nic]));

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    /** @test */
    public function it_prefills_form_when_nurse_with_permanent_registration_found(): void
    {
        $nurse = $this->nurseWithPermanent();

        $this->get(route('additional-qualifications.create', ['nic' => $nurse->nic]))
            ->assertOk()
            ->assertSee($nurse->name);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // STORE
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_creates_an_additional_qualification_with_valid_data(): void
    {
        $nurse = $this->nurseWithPermanent();

        $response = $this->post(route('additional-qualifications.store'), [
            'nurse_id' => $nurse->id,
            'qualification_type' => 'B.Sc Nursing',
            'qualification_number' => 'QUAL-10001',
            'qualification_date' => '2023-05-10',
        ]);

        $response->assertRedirect(route('additional-qualifications.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('additional_qualifications', [
            'nurse_id' => $nurse->id,
            'qualification_number' => 'QUAL-10001',
        ]);
    }

    /** @test */
    public function it_stores_qualification_with_certificate_flags(): void
    {
        $nurse = $this->nurseWithPermanent();

        $response = $this->post(route('additional-qualifications.store'), [
            'nurse_id' => $nurse->id,
            'qualification_type' => 'Post Basic',
            'qualification_number' => 'QUAL-FLAGS01',
            'qualification_date' => '2023-06-01',
            'certificate_printed' => '1',
            'certificate_posted' => '1',
        ]);

        $response->assertRedirect(route('additional-qualifications.index'));
        $this->assertDatabaseHas('additional_qualifications', [
            'nurse_id' => $nurse->id,
            'certificate_printed' => 1,
            'certificate_posted' => 1,
        ]);
    }

    /** @test */
    public function it_fails_when_nurse_id_is_missing(): void
    {
        $this->post(route('additional-qualifications.store'), [
            'qualification_type' => 'B.Sc Nursing',
            'qualification_number' => 'QUAL-FAIL01',
            'qualification_date' => '2023-05-10',
        ])->assertSessionHasErrors('nurse_id');
    }

    /** @test */
    public function it_fails_when_qualification_type_is_missing(): void
    {
        $nurse = $this->nurseWithPermanent();

        $this->post(route('additional-qualifications.store'), [
            'nurse_id' => $nurse->id,
            'qualification_number' => 'QUAL-FAIL02',
            'qualification_date' => '2023-05-10',
        ])->assertSessionHasErrors('qualification_type');
    }

    /** @test */
    public function it_fails_when_qualification_number_is_missing(): void
    {
        $nurse = $this->nurseWithPermanent();

        $this->post(route('additional-qualifications.store'), [
            'nurse_id' => $nurse->id,
            'qualification_type' => 'B.Sc Nursing',
            'qualification_date' => '2023-05-10',
        ])->assertSessionHasErrors('qualification_number');
    }

    /** @test */
    public function it_fails_when_qualification_date_is_missing(): void
    {
        $nurse = $this->nurseWithPermanent();

        $this->post(route('additional-qualifications.store'), [
            'nurse_id' => $nurse->id,
            'qualification_type' => 'B.Sc Nursing',
            'qualification_number' => 'QUAL-FAIL03',
        ])->assertSessionHasErrors('qualification_date');
    }

    /** @test */
    public function it_fails_with_empty_form_submission(): void
    {
        $this->post(route('additional-qualifications.store'), [])
            ->assertSessionHasErrors(['nurse_id', 'qualification_type', 'qualification_number', 'qualification_date']);
    }

    /** @test */
    public function it_fails_when_qualification_number_is_duplicate_for_same_nurse(): void
    {
        $nurse = $this->nurseWithPermanent();
        AdditionalQualification::factory()->create(['nurse_id' => $nurse->id, 'qualification_number' => 'QUAL-DUP01']);

        $this->post(route('additional-qualifications.store'), [
            'nurse_id' => $nurse->id,
            'qualification_type' => 'Masters',
            'qualification_number' => 'QUAL-DUP01',
            'qualification_date' => '2023-05-10',
        ])->assertSessionHasErrors('qualification_number');
    }

    /** @test */
    public function it_allows_same_qualification_number_for_different_nurses(): void
    {
        $nurse1 = $this->nurseWithPermanent();
        $nurse2 = $this->nurseWithPermanent();
        AdditionalQualification::factory()->create(['nurse_id' => $nurse1->id, 'qualification_number' => 'QUAL-CROSS01']);

        $response = $this->post(route('additional-qualifications.store'), [
            'nurse_id' => $nurse2->id,
            'qualification_type' => 'Masters',
            'qualification_number' => 'QUAL-CROSS01',
            'qualification_date' => '2023-05-10',
        ]);

        $response->assertRedirect(route('additional-qualifications.index'));
        $this->assertDatabaseCount('additional_qualifications', 2);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // EDIT FORM
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_displays_the_edit_form(): void
    {
        $qual = AdditionalQualification::factory()->create();

        $this->get(route('additional-qualifications.edit', $qual))
            ->assertOk()
            ->assertViewIs('additional_qualifications.edit');
    }

    // ──────────────────────────────────────────────────────────────────────────
    // UPDATE
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_updates_an_additional_qualification(): void
    {
        $qual = AdditionalQualification::factory()->create(['qualification_type' => 'Old Type']);

        $response = $this->put(route('additional-qualifications.update', $qual), [
            'qualification_type' => 'Updated Type',
            'qualification_number' => $qual->qualification_number,
            'qualification_date' => '2024-01-01',
        ]);

        $response->assertRedirect(route('additional-qualifications.show', $qual));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('additional_qualifications', [
            'id' => $qual->id,
            'qualification_type' => 'Updated Type',
        ]);
    }

    /** @test */
    public function it_fails_update_when_required_fields_are_missing(): void
    {
        $qual = AdditionalQualification::factory()->create();

        $this->put(route('additional-qualifications.update', $qual), [])
            ->assertSessionHasErrors(['qualification_type', 'qualification_number', 'qualification_date']);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // DELETE
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_deletes_an_additional_qualification(): void
    {
        $qual = AdditionalQualification::factory()->create();

        $response = $this->delete(route('additional-qualifications.destroy', $qual));

        $response->assertRedirect(route('additional-qualifications.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('additional_qualifications', ['id' => $qual->id]);
    }
}
