<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Feature Tests – Report Generation RBAC
 *
 * Verifies that:
 *  - Unauthenticated users are redirected to login
 *  - Each role can only access the report index and generate permitted modules
 *  - Any attempt to generate a disallowed module returns 403
 */
class ReportTest extends TestCase
{
    use RefreshDatabase;

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /** Create a User with the given role constant. */
    private function userWithRole(int $role): User
    {
        return User::factory()->create(['role' => $role]);
    }

    // -------------------------------------------------------------------------
    // Authentication guard
    // -------------------------------------------------------------------------

    /** @test */
    public function unauthenticated_user_is_redirected_from_reports_index(): void
    {
        $this->get(route('reports.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthenticated_user_is_redirected_from_reports_generate(): void
    {
        $this->post(route('reports.generate'), [
            'module'      => 'temporary',
            'period'      => 'daily',
            'report_date' => now()->toDateString(),
        ])->assertRedirect(route('login'));
    }

    // -------------------------------------------------------------------------
    // Reports index access (GET /reports)
    // -------------------------------------------------------------------------

    /**
     * @test
     * @dataProvider allRolesProvider
     */
    public function all_roles_can_access_the_reports_index(int $role): void
    {
        $this->actingAs($this->userWithRole($role))
            ->get(route('reports.index'))
            ->assertOk()
            ->assertViewIs('reports.index');
    }

    public static function allRolesProvider(): array
    {
        return [
            'Admin (1)'  => [User::ROLE_ADMIN],
            'User1 (2)'  => [User::ROLE_USER1],
            'User2 (3)'  => [User::ROLE_USER2],
            'User3 (4)'  => [User::ROLE_USER3],
            'User4 (5)'  => [User::ROLE_USER4],
            'User5 (6)'  => [User::ROLE_USER5],
        ];
    }

    // -------------------------------------------------------------------------
    // Allowed modules visible in the view
    // -------------------------------------------------------------------------

    /** @test */
    public function admin_sees_all_four_modules_in_the_view(): void
    {
        $user = $this->userWithRole(User::ROLE_ADMIN);

        $this->actingAs($user)
            ->get(route('reports.index'))
            ->assertViewHas('allowedModules', function (array $modules) {
                return array_keys($modules) === ['temporary', 'permanent', 'qualifications', 'foreign'];
            });
    }

    /** @test */
    public function user1_sees_only_temporary_module_in_the_view(): void
    {
        $user = $this->userWithRole(User::ROLE_USER1);

        $this->actingAs($user)
            ->get(route('reports.index'))
            ->assertViewHas('allowedModules', function (array $modules) {
                return array_keys($modules) === ['temporary'];
            });
    }

    /** @test */
    public function user2_sees_temporary_and_permanent_in_the_view(): void
    {
        $user = $this->userWithRole(User::ROLE_USER2);

        $this->actingAs($user)
            ->get(route('reports.index'))
            ->assertViewHas('allowedModules', function (array $modules) {
                return array_keys($modules) === ['temporary', 'permanent'];
            });
    }

    /** @test */
    public function user3_sees_only_permanent_in_the_view(): void
    {
        $user = $this->userWithRole(User::ROLE_USER3);

        $this->actingAs($user)
            ->get(route('reports.index'))
            ->assertViewHas('allowedModules', function (array $modules) {
                return array_keys($modules) === ['permanent'];
            });
    }

    /** @test */
    public function user4_sees_permanent_and_qualifications_in_the_view(): void
    {
        $user = $this->userWithRole(User::ROLE_USER4);

        $this->actingAs($user)
            ->get(route('reports.index'))
            ->assertViewHas('allowedModules', function (array $modules) {
                return array_keys($modules) === ['permanent', 'qualifications'];
            });
    }

    /** @test */
    public function user5_sees_permanent_and_foreign_in_the_view(): void
    {
        $user = $this->userWithRole(User::ROLE_USER5);

        $this->actingAs($user)
            ->get(route('reports.index'))
            ->assertViewHas('allowedModules', function (array $modules) {
                return array_keys($modules) === ['permanent', 'foreign'];
            });
    }

    // -------------------------------------------------------------------------
    // Backend 403 on unauthorized module POST (security hardening tests)
    // -------------------------------------------------------------------------

    /** @test */
    public function user1_gets_403_when_generating_permanent_report(): void
    {
        $this->actingAs($this->userWithRole(User::ROLE_USER1))
            ->post(route('reports.generate'), [
                'module'      => 'permanent',
                'period'      => 'daily',
                'report_date' => now()->toDateString(),
            ])->assertForbidden();
    }

    /** @test */
    public function user1_gets_403_when_generating_qualifications_report(): void
    {
        $this->actingAs($this->userWithRole(User::ROLE_USER1))
            ->post(route('reports.generate'), [
                'module'      => 'qualifications',
                'period'      => 'daily',
                'report_date' => now()->toDateString(),
            ])->assertForbidden();
    }

    /** @test */
    public function user1_gets_403_when_generating_foreign_report(): void
    {
        $this->actingAs($this->userWithRole(User::ROLE_USER1))
            ->post(route('reports.generate'), [
                'module'      => 'foreign',
                'period'      => 'daily',
                'report_date' => now()->toDateString(),
            ])->assertForbidden();
    }

    /** @test */
    public function user2_gets_403_when_generating_qualifications_report(): void
    {
        $this->actingAs($this->userWithRole(User::ROLE_USER2))
            ->post(route('reports.generate'), [
                'module'      => 'qualifications',
                'period'      => 'daily',
                'report_date' => now()->toDateString(),
            ])->assertForbidden();
    }

    /** @test */
    public function user2_gets_403_when_generating_foreign_report(): void
    {
        $this->actingAs($this->userWithRole(User::ROLE_USER2))
            ->post(route('reports.generate'), [
                'module'      => 'foreign',
                'period'      => 'daily',
                'report_date' => now()->toDateString(),
            ])->assertForbidden();
    }

    /** @test */
    public function user3_gets_403_when_generating_temporary_report(): void
    {
        $this->actingAs($this->userWithRole(User::ROLE_USER3))
            ->post(route('reports.generate'), [
                'module'      => 'temporary',
                'period'      => 'daily',
                'report_date' => now()->toDateString(),
            ])->assertForbidden();
    }

    /** @test */
    public function user3_gets_403_when_generating_foreign_report(): void
    {
        $this->actingAs($this->userWithRole(User::ROLE_USER3))
            ->post(route('reports.generate'), [
                'module'      => 'foreign',
                'period'      => 'daily',
                'report_date' => now()->toDateString(),
            ])->assertForbidden();
    }

    /** @test */
    public function user4_gets_403_when_generating_temporary_report(): void
    {
        $this->actingAs($this->userWithRole(User::ROLE_USER4))
            ->post(route('reports.generate'), [
                'module'      => 'temporary',
                'period'      => 'daily',
                'report_date' => now()->toDateString(),
            ])->assertForbidden();
    }

    /** @test */
    public function user4_gets_403_when_generating_foreign_report(): void
    {
        $this->actingAs($this->userWithRole(User::ROLE_USER4))
            ->post(route('reports.generate'), [
                'module'      => 'foreign',
                'period'      => 'daily',
                'report_date' => now()->toDateString(),
            ])->assertForbidden();
    }

    /** @test */
    public function user5_gets_403_when_generating_temporary_report(): void
    {
        $this->actingAs($this->userWithRole(User::ROLE_USER5))
            ->post(route('reports.generate'), [
                'module'      => 'temporary',
                'period'      => 'daily',
                'report_date' => now()->toDateString(),
            ])->assertForbidden();
    }

    /** @test */
    public function user5_gets_403_when_generating_qualifications_report(): void
    {
        $this->actingAs($this->userWithRole(User::ROLE_USER5))
            ->post(route('reports.generate'), [
                'module'      => 'qualifications',
                'period'      => 'daily',
                'report_date' => now()->toDateString(),
            ])->assertForbidden();
    }

    /** @test */
    public function any_role_gets_403_for_a_completely_invalid_module_name(): void
    {
        $this->actingAs($this->userWithRole(User::ROLE_ADMIN))
            ->post(route('reports.generate'), [
                'module'      => 'hacked_module',
                'period'      => 'daily',
                'report_date' => now()->toDateString(),
            ])->assertForbidden();
    }

    // -------------------------------------------------------------------------
    // Report log audit trail
    // -------------------------------------------------------------------------

    /** @test */
    public function report_log_records_user_id_on_successful_generation(): void
    {
        // We can't easily stream PDFs in tests, so we'll test the log directly
        // by mocking Pdf facade to avoid the actual PDF generation.
        \Barryvdh\DomPDF\Facade\Pdf::shouldReceive('loadView')->andReturnSelf();
        \Barryvdh\DomPDF\Facade\Pdf::shouldReceive('setPaper')->andReturnSelf();
        \Barryvdh\DomPDF\Facade\Pdf::shouldReceive('stream')->andReturn(
            response('', 200, ['Content-Type' => 'application/pdf'])
        );

        $user = $this->userWithRole(User::ROLE_ADMIN);

        $this->actingAs($user)
            ->post(route('reports.generate'), [
                'module'      => 'temporary',
                'period'      => 'daily',
                'report_date' => now()->toDateString(),
            ]);

        $this->assertDatabaseHas('report_logs', [
            'user_id' => $user->id,
            'module'  => 'temporary',
            'period'  => 'daily',
        ]);
    }
}
