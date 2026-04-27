<?php

namespace Database\Seeders;

use App\Models\CarwashBox;
use Illuminate\Database\Seeder;

class BoxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 10) as $i) {
            CarwashBox::create([
                'box_number' => $i,
            ]);

        }
    }
}
