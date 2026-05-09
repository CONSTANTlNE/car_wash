<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = Tenant::first();
        $manager = User::create(
            [
                'name' => 'manager',
                'email' => 'manager@carbidpro.com',
                'password' => bcrypt('password'),
                'tenant_id' => $tenant->id,
            ]
        );

        $manager->assignRole('manager');

        $cashier = User::create(
            [
                'name' => 'cashier',
                'email' => 'cashier@carbidpro.com',
                'password' => bcrypt('password'),
                'tenant_id' => $tenant->id,
            ]
        );

        $cashier->assignRole('cashier');

        foreach (range(1, 10) as $i) {
            $user = User::create([
                'name' => fake()->name(),
                'email' => "washer{$i}@carbidpro.com",
                'password' => bcrypt('password'),
                'commission' => 35,
                'tenant_id' => $tenant->id,
            ]);

            $user->assignRole('washer');
        }

    }
}
