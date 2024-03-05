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
                'surname' => 'Master',
                'description' => 'master',
            ],
            [
                'name' => 'Admin',
                'surname' => 'Admin',
                'description' => 'admin',
            ],
            [
                'name' => 'ClubMaster',
                'surname' => 'Clube Master',
                'description' => 'ClubMaster',
            ],
            [
                'name' => 'ClubAdmin',
                'surname' => 'Clube Admin',
                'description' => 'ClubAdmin',
            ],
            [
                'name' => 'User',
                'surname' => 'Usuário',
                'description' => 'User',
            ],
        ];

        foreach ($roles as $role) {
            \App\Models\Role::create($role);
        }
    }
}
