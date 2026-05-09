<?php

namespace Database\Seeders;

use App\Models\CarwashBox;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class BoxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = Tenant::first();
        foreach (range(1, 10) as $i) {
            CarwashBox::create([
                'box_number' => $i,
                'tenant_id' => $tenant->id,
            ]);

        }
    }
}
