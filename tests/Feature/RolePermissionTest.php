<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RolePermissionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_access_everything()
    {
        $user = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->actingAs($user);

        $this->get(route('dashboard'))->assertOk();
        $this->get(route('temporary-registrations.index'))->assertOk();
        $this->get(route('permanent-registrations.index'))->assertOk();
        $this->get(route('permanent-certificates.index'))->assertOk();
        $this->get(route('additional-qualifications.index'))->assertOk();
        $this->get(route('foreign-certificates.index'))->assertOk();
        $this->get(route('reports.index'))->assertOk();
    }

    /** @test */
    public function user1_registration_officer_access()
    {
        $user = User::factory()->create(['role' => User::ROLE_REGISTRATION_OFFICER]);
        $this->actingAs($user);

        $this->get(route('dashboard'))->assertForbidden();
        $this->get(route('temporary-registrations.index'))->assertOk();
        $this->get(route('permanent-registrations.index'))->assertOk();
        $this->get(route('reports.index'))->assertOk();
        
        $this->get(route('permanent-certificates.index'))->assertForbidden();
        $this->get(route('additional-qualifications.index'))->assertForbidden();
        $this->get(route('foreign-certificates.index'))->assertForbidden();
    }

    /** @test */
    public function user2_registration_manager_access()
    {
        $user = User::factory()->create(['role' => User::ROLE_REGISTRATION_MANAGER]);
        $this->actingAs($user);

        $this->get(route('dashboard'))->assertForbidden();
        $this->get(route('temporary-registrations.index'))->assertOk();
        $this->get(route('permanent-registrations.index'))->assertOk();
        $this->get(route('reports.index'))->assertOk();

        $this->get(route('permanent-certificates.index'))->assertForbidden();
        $this->get(route('additional-qualifications.index'))->assertForbidden();
        $this->get(route('foreign-certificates.index'))->assertForbidden();
    }

    /** @test */
    public function user3_certificate_officer_access()
    {
        $user = User::factory()->create(['role' => User::ROLE_CERTIFICATE_OFFICER]);
        $this->actingAs($user);

        $this->get(route('dashboard'))->assertForbidden();
        $this->get(route('permanent-registrations.index'))->assertOk();
        $this->get(route('permanent-certificates.index'))->assertOk();
        $this->get(route('reports.index'))->assertOk();

        $this->get(route('temporary-registrations.index'))->assertForbidden();
        $this->get(route('additional-qualifications.index'))->assertForbidden();
        $this->get(route('foreign-certificates.index'))->assertForbidden();
    }

    /** @test */
    public function user4_qualification_officer_access()
    {
        $user = User::factory()->create(['role' => User::ROLE_QUALIFICATION_OFFICER]);
        $this->actingAs($user);

        $this->get(route('dashboard'))->assertForbidden();
        $this->get(route('permanent-registrations.index'))->assertOk();
        $this->get(route('additional-qualifications.index'))->assertOk();
        $this->get(route('reports.index'))->assertOk();

        $this->get(route('temporary-registrations.index'))->assertForbidden();
        $this->get(route('permanent-certificates.index'))->assertForbidden();
        $this->get(route('foreign-certificates.index'))->assertForbidden();
    }

    /** @test */
    public function user5_foreign_certificate_officer_access()
    {
        $user = User::factory()->create(['role' => User::ROLE_FOREIGN_CERTIFICATE_OFFICER]);
        $this->actingAs($user);

        $this->get(route('dashboard'))->assertForbidden();
        $this->get(route('permanent-registrations.index'))->assertOk();
        $this->get(route('foreign-certificates.index'))->assertOk();
        $this->get(route('reports.index'))->assertOk();

        $this->get(route('temporary-registrations.index'))->assertForbidden();
        $this->get(route('permanent-certificates.index'))->assertForbidden();
        $this->get(route('additional-qualifications.index'))->assertForbidden();
    }
}
