<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_officer_can_access_dashboard()
    {
        $user = User::factory()->create([
            'role' => User::ROLE_REGISTRATION_OFFICER, // Role 2
        ]);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk();
    }

    public function test_other_roles_can_access_dashboard()
    {
        $roles = [3, 4, 5, 6];

        foreach ($roles as $role) {
            $user = User::factory()->create(['role' => $role]);

            $this->actingAs($user)
                ->get(route('dashboard'))
                ->assertOk();
        }
    }
}
