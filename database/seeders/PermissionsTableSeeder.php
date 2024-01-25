<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $actions = [
            'create',
            'read',
            'update',
            'delete',
        ];
        $userTypes = [
            'Master',
            'Admin',
            'ClubMaster',
            'ClubAdmin',
            'User',
        ];

        foreach($userTypes as $userType) {
            foreach($actions as $action) {
                \App\Models\Permission::create([
                    'name' => $action . '-' . $userType,
                ]);
            }
        }
    }
}
