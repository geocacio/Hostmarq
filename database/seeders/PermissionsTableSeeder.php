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
            // 'Master',
            'Admin',
            'Club',
            'ClubAdmin',
            'User',
            'Type', 
            'Model',
            'Caliber',
            'Weapon',
            'Habituality',
            'Event',
            'Location',
            'Permission',
        ];

        foreach($roles as $role) {
            if($role !== 'Permission'){
                foreach($actions as $action) {
                    \App\Models\Permission::firstOrCreate([
                        'name' => $action . '-' . $role,
                    ]);
                }
            }else{
                \App\Models\Permission::firstOrCreate([
                    'name' => 'toggle-Permission',
                ]);
            }
        }

        //adicionar todas permissões para o usuário master
        $permissions = \App\Models\Permission::all();
        $role = \App\Models\Role::where('name', 'Master')->first();
        $role->permissions()->sync($permissions);
    }
}
