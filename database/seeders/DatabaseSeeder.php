<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Admin', 'email' => 'admin@admin.com', 'role' => User::ROLE_ADMIN],
            ['name' => 'User 1', 'email' => 'user1@admin.com', 'role' => User::ROLE_USER1],
            ['name' => 'User 2', 'email' => 'user2@admin.com', 'role' => User::ROLE_USER2],
            ['name' => 'User 3', 'email' => 'user3@admin.com', 'role' => User::ROLE_USER3],
            ['name' => 'User 4', 'email' => 'user4@admin.com', 'role' => User::ROLE_USER4],
            ['name' => 'User 5', 'email' => 'user5@admin.com', 'role' => User::ROLE_USER5],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name'     => $u['name'],
                    'password' => bcrypt('password'),
                    'role'     => $u['role']
                ]
            );
        }

        $this->call([
            ManualQaSeeder::class ,
        ]);
    }
}
