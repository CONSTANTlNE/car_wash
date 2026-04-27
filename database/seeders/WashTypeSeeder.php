<?php

namespace Database\Seeders;

use App\Models\WashType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WashTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WashType::create(['wash_type'=>'Total']);
        WashType::create(['wash_type'=>'Only Inside']);
        WashType::create(['wash_type'=>'Only Outside']);
        WashType::create(['wash_type'=>'Dry Clean']);
    }
}
