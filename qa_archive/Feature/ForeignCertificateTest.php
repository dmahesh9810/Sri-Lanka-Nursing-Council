<?php

namespace Tests\Feature;

use App\Models\ForeignCertificate;
use App\Models\Nurse;
use App\Models\PermanentRegistration;
use App\Models\TemporaryRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

/**
 * Feature Tests – Foreign Certificate Module
 *
 * Covers: list, show, create (success + validation + enum types), update,
 * delete, and certificate printing (mark as printed).
 */
class ForeignCertificateTest extends TestCase
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
    public function it_displays_the_foreign_certificates_index_page(): void
    {
        $this->get(route('foreign-certificates.index'))
            ->assertOk()
            ->assertViewIs('foreign_certificates.index');
    }

    /** @test */
    public function it_lists_foreign_certificates(): void
    {
        $cert = ForeignCertificate::factory()->create();

        $this->get(route('foreign-certificates.index'))
            ->assertOk()
            ->assertSee($cert->country);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // SHOW
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_shows_a_single_foreign_certificate(): void
    {
        $cert = ForeignCertificate::factory()->create();

        $this->get(route('foreign-certificates.show', $cert))
            ->assertOk()
            ->assertViewIs('foreign_certificates.show')
            ->assertSee($cert->country);
    }

    /** @test */
    public function it_returns_404_for_non_existent_certificate(): void
    {
        $this->get(route('foreign-certificates.show', 9999))->assertNotFound();
    }

    // ──────────────────────────────────────────────────────────────────────────
    // CREATE FORM
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_displays_the_create_form(): void
    {
        $this->get(route('foreign-certificates.create'))
            ->assertOk()
            ->assertViewIs('foreign_certificates.create');
    }

    /** @test */
    public function it_redirects_with_error_if_nurse_lacks_permanent_registration(): void
    {
        $nurse = Nurse::factory()->create(); // no permanent registration

        $response = $this->get(route('foreign-certificates.create', ['nic' => $nurse->nic]));

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    // ──────────────────────────────────────────────────────────────────────────
    // STORE
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_creates_a_foreign_certificate_request_with_valid_data(): void
    {
        $nurse = $this->nurseWithPermanent();

        $response = $this->post(route('foreign-certificates.store'), [
            'nurse_id' => $nurse->id,
            'certificate_type' => 'Verification',
            'country' => 'Australia',
            'apply_date' => '2024-01-10',
        ]);

        $response->assertRedirect(route('foreign-certificates.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('foreign_certificates', [
            'nurse_id' => $nurse->id,
            'certificate_type' => 'Verification',
            'country' => 'Australia',
        ]);
    }

    /** @test */
    public function it_creates_a_good_standing_certificate_request(): void
    {
        $nurse = $this->nurseWithPermanent();

        $response = $this->post(route('foreign-certificates.store'), [
            'nurse_id' => $nurse->id,
            'certificate_type' => 'Good Standing',
            'country' => 'Canada',
            'apply_date' => '2024-02-01',
            'issue_date' => '2024-02-15',
        ]);

        $response->assertRedirect(route('foreign-certificates.index'));
        $this->assertDatabaseHas('foreign_certificates', ['certificate_type' => 'Good Standing']);
    }

    /** @test */
    public function it_creates_a_confirmation_certificate_request(): void
    {
        $nurse = $this->nurseWithPermanent();

        $this->post(route('foreign-certificates.store'), [
            'nurse_id' => $nurse->id,
            'certificate_type' => 'Confirmation',
            'country' => 'UK',
            'apply_date' => '2024-03-01',
        ])->assertRedirect(route('foreign-certificates.index'));

        $this->assertDatabaseHas('foreign_certificates', ['certificate_type' => 'Confirmation']);
    }

    /** @test */
    public function it_creates_an_additional_verification_certificate_request(): void
    {
        $nurse = $this->nurseWithPermanent();

        $this->post(route('foreign-certificates.store'), [
            'nurse_id' => $nurse->id,
            'certificate_type' => 'Additional Verification',
            'country' => 'UAE',
            'apply_date' => '2024-04-01',
        ])->assertRedirect(route('foreign-certificates.index'));

        $this->assertDatabaseHas('foreign_certificates', ['certificate_type' => 'Additional Verification']);
    }

    /** @test */
    public function it_fails_with_invalid_certificate_type(): void
    {
        $nurse = $this->nurseWithPermanent();

        $this->post(route('foreign-certificates.store'), [
            'nurse_id' => $nurse->id,
            'certificate_type' => 'InvalidType',
            'country' => 'Germany',
            'apply_date' => '2024-01-10',
        ])->assertSessionHasErrors('certificate_type');
    }

    /** @test */
    public function it_fails_when_nurse_id_is_missing(): void
    {
        $this->post(route('foreign-certificates.store'), [
            'certificate_type' => 'Verification',
            'country' => 'Australia',
            'apply_date' => '2024-01-10',
        ])->assertSessionHasErrors('nurse_id');
    }

    /** @test */
    public function it_fails_when_country_is_missing(): void
    {
        $nurse = $this->nurseWithPermanent();

        $this->post(route('foreign-certificates.store'), [
            'nurse_id' => $nurse->id,
            'certificate_type' => 'Verification',
            'apply_date' => '2024-01-10',
        ])->assertSessionHasErrors('country');
    }

    /** @test */
    public function it_fails_when_apply_date_is_missing(): void
    {
        $nurse = $this->nurseWithPermanent();

        $this->post(route('foreign-certificates.store'), [
            'nurse_id' => $nurse->id,
            'certificate_type' => 'Verification',
            'country' => 'Japan',
        ])->assertSessionHasErrors('apply_date');
    }

    /** @test */
    public function it_fails_when_issue_date_is_before_apply_date(): void
    {
        $nurse = $this->nurseWithPermanent();

        $this->post(route('foreign-certificates.store'), [
            'nurse_id' => $nurse->id,
            'certificate_type' => 'Verification',
            'country' => 'Japan',
            'apply_date' => '2024-06-01',
            'issue_date' => '2024-05-01', // before apply_date
        ])->assertSessionHasErrors('issue_date');
    }

    /** @test */
    public function it_fails_with_empty_form_submission(): void
    {
        $this->post(route('foreign-certificates.store'), [])
            ->assertSessionHasErrors(['nurse_id', 'certificate_type', 'country', 'apply_date']);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // EDIT FORM
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_displays_the_edit_form(): void
    {
        $cert = ForeignCertificate::factory()->create();

        $this->get(route('foreign-certificates.edit', $cert))
            ->assertOk()
            ->assertViewIs('foreign_certificates.edit');
    }

    // ──────────────────────────────────────────────────────────────────────────
    // UPDATE
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_updates_a_foreign_certificate_request(): void
    {
        $cert = ForeignCertificate::factory()->create(['country' => 'Old Country', 'apply_date' => '2024-01-01']);

        $response = $this->put(route('foreign-certificates.update', $cert), [
            'certificate_type' => 'Good Standing',
            'country' => 'New Zealand',
            'apply_date' => '2024-03-01',
        ]);

        $response->assertRedirect(route('foreign-certificates.show', $cert));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('foreign_certificates', [
            'id' => $cert->id,
            'country' => 'New Zealand',
        ]);
    }

    /** @test */
    public function it_marks_certificate_sealed_and_issued_on_update(): void
    {
        $cert = ForeignCertificate::factory()->create([
            'apply_date' => '2024-01-01',
            'certificate_sealed' => false,
        ]);

        $this->put(route('foreign-certificates.update', $cert), [
            'certificate_type' => $cert->certificate_type,
            'country' => $cert->country,
            'apply_date' => '2024-01-01',
            'issue_date' => '2024-02-01',
            'certificate_sealed' => '1',
        ]);

        $this->assertDatabaseHas('foreign_certificates', [
            'id' => $cert->id,
            'certificate_sealed' => 1,
        ]);
    }

    /** @test */
    public function it_fails_update_with_invalid_certificate_type(): void
    {
        $cert = ForeignCertificate::factory()->create(['apply_date' => '2024-01-01']);

        $this->put(route('foreign-certificates.update', $cert), [
            'certificate_type' => 'NotValid',
            'country' => 'France',
            'apply_date' => '2024-01-01',
        ])->assertSessionHasErrors('certificate_type');
    }

    /** @test */
    public function it_fails_update_when_required_fields_are_missing(): void
    {
        $cert = ForeignCertificate::factory()->create();

        $this->put(route('foreign-certificates.update', $cert), [])
            ->assertSessionHasErrors(['certificate_type', 'country', 'apply_date']);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // DELETE
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_deletes_a_foreign_certificate_request(): void
    {
        $cert = ForeignCertificate::factory()->create();

        $response = $this->delete(route('foreign-certificates.destroy', $cert));

        $response->assertRedirect(route('foreign-certificates.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('foreign_certificates', ['id' => $cert->id]);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // CERTIFICATE PRINTING
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_redirects_with_error_when_certificate_is_not_sealed(): void
    {
        $cert = ForeignCertificate::factory()->create([
            'certificate_sealed' => false,
            'issue_date' => null,
        ]);

        $response = $this->get(route('certificates.print', $cert->id));

        $response->assertRedirect(route('foreign-certificates.show', $cert));
        $response->assertSessionHas('error');
    }

    /** @test */
    public function it_redirects_with_error_when_issue_date_is_null(): void
    {
        $cert = ForeignCertificate::factory()->create([
            'certificate_sealed' => true,
            'issue_date' => null,
        ]);

        $response = $this->get(route('certificates.print', $cert->id));

        $response->assertRedirect(route('foreign-certificates.show', $cert));
        $response->assertSessionHas('error');
    }

    /** @test */
    public function it_marks_certificate_as_printed_and_generates_pdf(): void
    {
        $nurse = $this->nurseWithPermanent();
        $cert = ForeignCertificate::factory()->state([
            'nurse_id' => $nurse->id,
            'certificate_sealed' => true,
            'issue_date' => '2024-02-01',
            'certificate_type' => 'Verification',
        ])->create();

        $response = $this->get(route('certificates.print', $cert->id));

        // PDF is returned as a stream (200 OK with PDF content-type)
        $response->assertOk();
        $this->assertStringContainsString('pdf', strtolower($response->headers->get('Content-Type') ?? ''));

        $this->assertDatabaseHas('foreign_certificates', [
            'id' => $cert->id,
            'certificate_printed' => 1,
        ]);

        $refreshed = ForeignCertificate::find($cert->id);
        $this->assertNotNull($refreshed->printed_at);
        $this->assertNotEmpty($refreshed->certificate_number);
        $this->assertStringStartsWith('SLNC-CERT-', $refreshed->certificate_number);
    }

    /** @test */
    public function it_reuses_existing_certificate_number_on_reprint(): void
    {
        $nurse = $this->nurseWithPermanent();
        $cert = ForeignCertificate::factory()->state([
            'nurse_id' => $nurse->id,
            'certificate_sealed' => true,
            'issue_date' => '2024-02-01',
            'certificate_type' => 'Verification',
            'certificate_number' => 'SLNC-CERT-2024-0001',
        ])->create();

        $this->get(route('certificates.print', $cert->id));

        $refreshed = ForeignCertificate::find($cert->id);
        $this->assertEquals('SLNC-CERT-2024-0001', $refreshed->certificate_number);
    }

    /** @test */
    public function it_returns_pdf_download_when_action_is_download(): void
    {
        $nurse = $this->nurseWithPermanent();
        $cert = ForeignCertificate::factory()->state([
            'nurse_id' => $nurse->id,
            'certificate_sealed' => true,
            'issue_date' => '2024-02-01',
            'certificate_type' => 'Good Standing',
        ])->create();

        $response = $this->get(route('certificates.print', $cert->id) . '?action=download');

        $response->assertOk();
        $this->assertStringContainsString('attachment', strtolower($response->headers->get('Content-Disposition') ?? ''));
    }

    /** @test */
    public function it_returns_404_when_printing_non_existent_certificate(): void
    {
        $this->get(route('certificates.print', 9999))->assertNotFound();
    }
}
