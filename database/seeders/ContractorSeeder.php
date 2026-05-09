<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;

class ContractorSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::first();

        $tenant->contractors()->create([
            'name' => 'დაზღვევა შპს ალდაგი',
            'email' => 'insurance@gmail.com',
            'mobile' => '551576697',
            'is_insurance' => true,
            'tenant_id' => $tenant->id,
        ]);

        $tenant->contractors()->create([
            'name' => 'მომწოდებელი შპს მომწოდებელი',
            'email' => 'supplier@gmail.com',
            'mobile' => '551576697',
            'tenant_id' => $tenant->id,
            'is_supplier' => true,
        ]);

        $tenant->contractors()->create([
            'name' => 'კონტრაქტორი შპს კონტრაქტორი',
            'email' => 'contractor@gmail.com',
            'mobile' => '551576697',
            'tenant_id' => $tenant->id,
            'is_agreement' => true,
        ]);
    }
}
