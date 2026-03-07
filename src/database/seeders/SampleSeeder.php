<?php

namespace Database\Seeders;

use App\Models\Lab;
use App\Models\LabSample;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\Sample;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SampleSeeder extends Seeder
{
    public function run(): void
    {
        $product = Product::first();
        $lab = Lab::first();
        $manufacturer = Manufacturer::first();

        LabSample::create([
            'sample_number' => 'SAM-2026-0001',
            'product_id' => $product->id,
            'lab_id' => $lab->id,
            'manufacturer_id' => $manufacturer->id,
            'batch_number' => 'BATCH-594',
            'brand' => 'Vesper Health',
            'variant' => 'Standard',
            'flavour' => 'Unflavoured',
            'color' => 'Clear',
            'type' => 'Liquid',
            'sample_quantity' => 2,
            'collected_amount' => '02 bottles * 500ml',
            'status' => 'completed',
            'priority' => 'urgent',
            'production_date' => now()->subMonths(1),
            'expiry_date' => now()->addYear(),
            'received_at' => now()->subDays(5),
        ]);
    }
}
