<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manager=User::create(
            [
                'name'=>'manager',
                'email'=>'manager@carbidpro.com',
                'password'=>bcrypt('password'),
            ]
        );
        $manager->assignRole('manager');

        $manager=User::create(
            [
                'name'=>'cashier',
                'email'=>'cashier@carbidpro.com',
                'password'=>bcrypt('password'),
            ]
        );
        $manager->assignRole('cashier');


        foreach (range(1, 10) as $i) {
            $user = User::create([
                'name' => fake()->name(),
                'email' => "washer{$i}@carbidpro.com",
                'password' => bcrypt('password'),
                'commission' => 35
            ]);

            $user->assignRole('washer');
        }


    }
}
