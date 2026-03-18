<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 1;
    public const ROLE_USER1 = 2; // Temp Reg
    public const ROLE_USER2 = 3; // Temp + Perm Reg
    public const ROLE_USER3 = 4; // Perm Reg + Cert Print
    public const ROLE_USER4 = 5; // Add Qual + Perm Reg
    public const ROLE_USER5 = 6; // Foreign Cert + Perm Reg

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function hasRole(...$roles): bool
    {
        return in_array($this->role, $roles);
    }

    /**
     * Return the list of report module slugs this user is permitted to generate.
     * This is the single source of truth for report-level RBAC.
     *
     * @return array<string>
     */
    public function allowedReportModules(): array
    {
        return match ($this->role) {
            self::ROLE_ADMIN  => ['temporary', 'permanent', 'qualifications', 'foreign'],
            self::ROLE_USER1  => ['temporary'],
            self::ROLE_USER2  => ['temporary', 'permanent'],
            self::ROLE_USER3  => ['permanent'],
            self::ROLE_USER4  => ['permanent', 'qualifications'],
            self::ROLE_USER5  => ['permanent', 'foreign'],
            default           => [],
        };
    }
}
