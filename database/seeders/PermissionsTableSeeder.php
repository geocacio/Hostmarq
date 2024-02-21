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
            'Club',
            'User',
            'Type', 
            'Model',
            'Caliber',
            'Weapon',
            'Habituality',
            'Event',
            'Location',
            'Permission'
            
        ];

        foreach($roles as $role) {
            if($role != 'Permission') {
                foreach($actions as $action) {
                    \App\Models\Permission::firstOrCreate([
                        'name' => $action . '-' . $role,
                    ]);
                }
            }else{
                \App\App\Models\Permission::firstOrCreate([
                    'name' => 'view-Permission',
                ]);
                \App\App\Models\Permission::firstOrCreate([
                    'name' => 'add-Permission',
                ]);
                \App\App\Models\Permission::firstOrCreate([
                    'name' => 'remove-Permission',
                ]);
            }
        }
    }
}
