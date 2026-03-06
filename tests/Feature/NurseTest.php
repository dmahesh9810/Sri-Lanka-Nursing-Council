<?php

namespace Tests\Feature;

use App\Models\Nurse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

/**
 * Feature Tests – Nurse Module
 *
 * Covers: list, show, create (success + validation), update, delete, search,
 * duplicate NIC, and edge cases.
 */
class NurseTest extends TestCase
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
    public function it_displays_the_nurses_index_page(): void
    {
        $response = $this->get(route('nurses.index'));

        $response->assertOk();
        $response->assertViewIs('nurses.index');
    }

    /** @test */
    public function it_lists_all_nurses_on_the_index_page(): void
    {
        $nurses = Nurse::factory()->count(3)->create();

        $response = $this->get(route('nurses.index'));

        $response->assertOk();
        foreach ($nurses as $nurse) {
            $response->assertSee($nurse->name);
        }
    }

    /** @test */
    public function it_can_search_nurses_by_nic(): void
    {
        $targetNurse = Nurse::factory()->create(['nic' => '987654321V']);
        Nurse::factory()->create(['nic' => '111111111V']);

        $response = $this->get(route('nurses.index', ['search' => '987654321V']));

        $response->assertOk();
        $response->assertSee($targetNurse->name);
        $response->assertSee('987654321V');
    }

    // ──────────────────────────────────────────────────────────────────────────
    // SHOW
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_shows_a_single_nurse_profile(): void
    {
        $nurse = Nurse::factory()->create();

        $response = $this->get(route('nurses.show', $nurse));

        $response->assertOk();
        $response->assertViewIs('nurses.show');
        $response->assertSee($nurse->name);
        $response->assertSee($nurse->nic);
    }

    /** @test */
    public function it_returns_404_for_non_existent_nurse(): void
    {
        $this->get(route('nurses.show', 9999))->assertNotFound();
    }

    // ──────────────────────────────────────────────────────────────────────────
    // CREATE FORM
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_displays_the_create_nurse_form(): void
    {
        $this->get(route('nurses.create'))->assertOk()->assertViewIs('nurses.create');
    }

    // ──────────────────────────────────────────────────────────────────────────
    // STORE
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_creates_a_nurse_with_valid_data(): void
    {
        $data = [
            'name' => 'Amara Silva',
            'nic' => '199501234567',
            'address' => '12/A, Main Street, Colombo',
            'phone' => '0712345678',
            'gender' => 'Female',
            'date_of_birth' => '1995-06-15',
            'school_or_university' => 'National Hospital Colombo',
            'batch' => '2015',
        ];

        $response = $this->post(route('nurses.store'), $data);

        $response->assertRedirect(route('nurses.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('nurses', [
            'name' => 'Amara Silva',
            'nic' => '199501234567',
        ]);
    }

    /** @test */
    public function it_creates_a_nurse_with_only_required_fields(): void
    {
        $data = [
            'name' => 'Minimal Nurse',
            'nic' => '200012345678',
        ];

        $response = $this->post(route('nurses.store'), $data);

        $response->assertRedirect(route('nurses.index'));
        $this->assertDatabaseHas('nurses', ['nic' => '200012345678']);
    }

    /** @test */
    public function it_fails_to_create_nurse_when_name_is_missing(): void
    {
        $response = $this->post(route('nurses.store'), ['nic' => '123456789V']);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseMissing('nurses', ['nic' => '123456789V']);
    }

    /** @test */
    public function it_fails_to_create_nurse_when_nic_is_missing(): void
    {
        $response = $this->post(route('nurses.store'), ['name' => 'Test Nurse']);

        $response->assertSessionHasErrors('nic');
    }

    /** @test */
    public function it_fails_to_create_nurse_with_duplicate_nic(): void
    {
        Nurse::factory()->create(['nic' => 'DUPLICATE_NIC']);

        $response = $this->post(route('nurses.store'), [
            'name' => 'Another Nurse',
            'nic' => 'DUPLICATE_NIC',
        ]);

        $response->assertSessionHasErrors('nic');
        $this->assertDatabaseCount('nurses', 1);
    }

    /** @test */
    public function it_fails_when_nic_exceeds_max_length(): void
    {
        $response = $this->post(route('nurses.store'), [
            'name' => 'Test Nurse',
            'nic' => str_repeat('A', 21),
        ]);

        $response->assertSessionHasErrors('nic');
    }

    /** @test */
    public function it_fails_with_invalid_date_of_birth(): void
    {
        $response = $this->post(route('nurses.store'), [
            'name' => 'Test Nurse',
            'nic' => '112233445V',
            'date_of_birth' => 'not-a-date',
        ]);

        $response->assertSessionHasErrors('date_of_birth');
    }

    /** @test */
    public function it_fails_with_empty_form_submission(): void
    {
        $response = $this->post(route('nurses.store'), []);

        $response->assertSessionHasErrors(['name', 'nic']);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // EDIT FORM
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_displays_the_edit_nurse_form(): void
    {
        $nurse = Nurse::factory()->create();

        $this->get(route('nurses.edit', $nurse))
            ->assertOk()
            ->assertViewIs('nurses.edit')
            ->assertSee($nurse->name);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // UPDATE
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_updates_a_nurse_with_valid_data(): void
    {
        $nurse = Nurse::factory()->create(['name' => 'Old Name']);

        $response = $this->put(route('nurses.update', $nurse), [
            'name' => 'New Name',
            'nic' => $nurse->nic,
        ]);

        $response->assertRedirect(route('nurses.show', $nurse));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('nurses', ['id' => $nurse->id, 'name' => 'New Name']);
    }

    /** @test */
    public function it_allows_updating_nurse_keeping_same_nic(): void
    {
        $nurse = Nurse::factory()->create(['nic' => 'SAME_NIC_001']);

        $response = $this->put(route('nurses.update', $nurse), [
            'name' => 'Updated Name',
            'nic' => 'SAME_NIC_001',
        ]);

        $response->assertRedirect(route('nurses.show', $nurse));
        $this->assertDatabaseHas('nurses', ['id' => $nurse->id, 'name' => 'Updated Name']);
    }

    /** @test */
    public function it_fails_update_when_nic_conflicts_with_another_nurse(): void
    {
        Nurse::factory()->create(['nic' => 'EXISTING_NIC']);
        $nurse = Nurse::factory()->create(['nic' => 'OWN_NIC']);

        $response = $this->put(route('nurses.update', $nurse), [
            'name' => 'Updated Name',
            'nic' => 'EXISTING_NIC',
        ]);

        $response->assertSessionHasErrors('nic');
    }

    /** @test */
    public function it_fails_update_when_name_is_missing(): void
    {
        $nurse = Nurse::factory()->create();

        $response = $this->put(route('nurses.update', $nurse), ['nic' => $nurse->nic]);

        $response->assertSessionHasErrors('name');
    }

    // ──────────────────────────────────────────────────────────────────────────
    // DELETE
    // ──────────────────────────────────────────────────────────────────────────

    /** @test */
    public function it_deletes_a_nurse(): void
    {
        $nurse = Nurse::factory()->create();

        $response = $this->delete(route('nurses.destroy', $nurse));

        $response->assertRedirect(route('nurses.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('nurses', ['id' => $nurse->id]);
    }

    /** @test */
    public function it_returns_404_when_deleting_non_existent_nurse(): void
    {
        $this->delete(route('nurses.destroy', 9999))->assertNotFound();
    }
}
