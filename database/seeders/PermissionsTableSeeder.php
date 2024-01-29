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
        $roles = [
            'Master',
            'Admin',
            'ClubMaster',
            'ClubAdmin',
            'User',
            'Type', 
            'Model',
            'Caliber',
            'Weapon',
            'Habituality',
            
        ];

        foreach($roles as $role) {
            foreach($actions as $action) {
                \App\Models\Permission::firstOrCreate([
                    'name' => $action . '-' . $role,
                ]);
            }
        }
    }
}
