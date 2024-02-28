<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Master',
                'description' => 'master',
            ],
            [
                'name' => 'Admin',
                'description' => 'admin',
            ],
            [
                'name' => 'ClubMaster',
                'description' => 'ClubMaster',
            ],
            [
                'name' => 'ClubAdmin',
                'description' => 'ClubAdmin',
            ],
            [
                'name' => 'User',
                'description' => 'User',
            ],
        ];

        foreach ($roles as $role) {
            \App\Models\Role::create($role);
        }
    }
}
