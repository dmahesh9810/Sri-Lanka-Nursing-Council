<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password');

        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@admin.com',
                'password' => $password,
                'role' => User::ROLE_ADMIN,
            ],
            [
                'name' => 'Registration Officer',
                'email' => 'user1@admin.com',
                'password' => $password,
                'role' => User::ROLE_REGISTRATION_OFFICER,
            ],
            [
                'name' => 'Registration Manager',
                'email' => 'user2@admin.com',
                'password' => $password,
                'role' => User::ROLE_REGISTRATION_MANAGER,
            ],
            [
                'name' => 'Certificate Officer',
                'email' => 'user3@admin.com',
                'password' => $password,
                'role' => User::ROLE_CERTIFICATE_OFFICER,
            ],
            [
                'name' => 'Qualification Officer',
                'email' => 'user4@admin.com',
                'password' => $password,
                'role' => User::ROLE_QUALIFICATION_OFFICER,
            ],
            [
                'name' => 'Foreign Certificate Officer',
                'email' => 'user5@admin.com',
                'password' => $password,
                'role' => User::ROLE_FOREIGN_CERTIFICATE_OFFICER,
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(['email' => $userData['email']], $userData);
        }
    }
}
