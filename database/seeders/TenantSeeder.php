<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        $manager = User::create(
            [
                'name' => 'manager',
                'email' => 'manager@carbidpro.com',
                'password' => bcrypt('password'),
            ]
        );

        $manager->assignRole('manager');

        $tenant = Tenant::create(['company_name' => 'test tenant', 'mobile' => '01711111111', 'address' => 'test address', 'user_id' => $manager->id, 'main_user_id' => $manager->id]);
        $manager->tenant_id = 1;
        $manager->save();

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
