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
    public const ROLE_REGISTRATION_OFFICER = 2; // User1: Temp Reg + Reports + Perm Reg
    public const ROLE_REGISTRATION_MANAGER = 3; // User2: Temp + Perm Reg + Reports
    public const ROLE_CERTIFICATE_OFFICER = 4; // User3: Perm Reg + Cert Print + Reports
    public const ROLE_QUALIFICATION_OFFICER = 5; // User4: Add Qual + Perm Reg + Reports
    public const ROLE_FOREIGN_CERTIFICATE_OFFICER = 6; // User5: Foreign Cert + Perm Reg + Reports

    public const ROLE_MAP = [
        'Admin' => self::ROLE_ADMIN,
        'User1' => self::ROLE_REGISTRATION_OFFICER,
        'User2' => self::ROLE_REGISTRATION_MANAGER,
        'User3' => self::ROLE_CERTIFICATE_OFFICER,
        'User4' => self::ROLE_QUALIFICATION_OFFICER,
        'User5' => self::ROLE_FOREIGN_CERTIFICATE_OFFICER,
    ];

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
        $roleIds = array_map(function($role) {
            return is_string($role) && isset(self::ROLE_MAP[$role]) ? self::ROLE_MAP[$role] : $role;
        }, $roles);
        
        return in_array($this->role, $roleIds);
    }
}
