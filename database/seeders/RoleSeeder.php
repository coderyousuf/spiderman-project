<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //1. Create an admin role
        //2. And assign all permission on it
        $adminPermissions=Permission::select('id')->get();

        Role::updateOrCreate([
            'role_name'=>'Admin',
            'role_slug'=>'admin',
            'role_note'=>'admin has all permissions',
            'is_deletable'=>false,
        ])->permissions()->sync($adminPermissions->pluck('id'));




        //3. Create a user role
        Role::updateOrCreate([
            'role_name'=>'User',
            'role_slug'=>'user',
            'role_note'=>'user has limited permissions',
            'is_deletable'=>true,
        ]);
    }
}
