<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::where('name', 'Master')->first();

        $roleMaster = \App\Models\Role::where('name', 'Master')->first();
        $user->roles()->attach($roleMaster);
    }
}
