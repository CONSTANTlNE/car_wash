<?php

namespace Database\Seeders;

use App\Models\CarType;
use App\Models\Tenant;
use App\Models\WashPrice;
use App\Models\WashType;
use Illuminate\Database\Seeder;

class WashPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = Tenant::first();
        $sedan = CarType::create(['name' => 'სედანი', 'tenant_id' => $tenant->id]);
        $smallSuv = CarType::create(['name' => 'პატარა ჯიპი', 'tenant_id' => $tenant->id]);
        $mediumSuv = CarType::create(['name' => 'საშუალო ჯიპი', 'tenant_id' => $tenant->id]);
        $bigSuv = CarType::create(['name' => 'დიდი ჯიპი', 'tenant_id' => $tenant->id]);

        $total = WashType::create(['wash_type' => 'სრული', 'tenant_id' => $tenant->id]);
        $outside = WashType::create(['wash_type' => 'გარედან რეცხვა', 'tenant_id' => $tenant->id]);
        $inside = WashType::create(['wash_type' => 'შიგნიდან რეცხვა', 'tenant_id' => $tenant->id]);
        $vip = WashType::create(['wash_type' => 'VIP', 'tenant_id' => $tenant->id]);

        WashPrice::create(['wash_type_id' => $total->id, 'car_type_id' => $sedan->id, 'price' => 30, 'tenant_id' => $tenant->id]);
        WashPrice::create(['wash_type_id' => $total->id, 'car_type_id' => $smallSuv->id, 'price' => 38, 'tenant_id' => $tenant->id]);
        WashPrice::create(['wash_type_id' => $total->id, 'car_type_id' => $mediumSuv->id, 'price' => 40, 'tenant_id' => $tenant->id]);
        WashPrice::create(['wash_type_id' => $total->id, 'car_type_id' => $bigSuv->id, 'price' => 45, 'tenant_id' => $tenant->id]);

        WashPrice::create(['wash_type_id' => $outside->id, 'car_type_id' => $sedan->id, 'price' => 20, 'tenant_id' => $tenant->id]);
        WashPrice::create(['wash_type_id' => $inside->id, 'car_type_id' => $sedan->id, 'price' => 15, 'tenant_id' => $tenant->id]);

        WashPrice::create(['wash_type_id' => $outside->id, 'car_type_id' => $smallSuv->id, 'price' => 25, 'tenant_id' => $tenant->id]);
        WashPrice::create(['wash_type_id' => $inside->id, 'car_type_id' => $smallSuv->id, 'price' => 20, 'tenant_id' => $tenant->id]);

        WashPrice::create(['wash_type_id' => $outside->id, 'car_type_id' => $mediumSuv->id, 'price' => 25, 'tenant_id' => $tenant->id]);
        WashPrice::create(['wash_type_id' => $inside->id, 'car_type_id' => $mediumSuv->id, 'price' => 20, 'tenant_id' => $tenant->id]);

        WashPrice::create(['wash_type_id' => $outside->id, 'car_type_id' => $bigSuv->id, 'price' => 25, 'tenant_id' => $tenant->id]);
        WashPrice::create(['wash_type_id' => $inside->id, 'car_type_id' => $bigSuv->id, 'price' => 20, 'tenant_id' => $tenant->id]);

    }
}
