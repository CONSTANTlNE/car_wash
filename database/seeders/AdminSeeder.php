<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{

    public function run(): void
    {
        $role = Role::firstOrCreate([
            'name'       => 'admin',
            'guard_name' => 'admin',
        ]);


        $admin = Admin::create([
            'name'     => 'admin',
            'email'    => 'admin@carbidpro.com',
            'password' => bcrypt('password'),
        ]);

        $admin->assignRole($role);
    }
}
