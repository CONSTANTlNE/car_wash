<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\WashType;
use Illuminate\Database\Seeder;

class WashTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['Total', 'Only Inside', 'Only Outside', 'Dry Clean'];
        $tenant = Tenant::first();

        foreach ($types as $type) {
            WashType::create(['wash_type' => $type, 'tenant_id' => $tenant->id]);
        }
    }
}
