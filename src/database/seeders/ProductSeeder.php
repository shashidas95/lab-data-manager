<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $merck = \App\Models\Manufacturer::where('name', 'Merck Group')->first()->id;

        $products = [
            ['name' => 'Hydrochloric Acid 37%', 'sku' => 'MER-HCL-01', 'manufacturer_id' => $merck, 'category' => 'Reagent'],
            ['name' => 'Ethanol Absolute', 'sku' => 'MER-ETH-05', 'manufacturer_id' => $merck, 'category' => 'Solvent'],
        ];

        foreach ($products as $p) {
            \App\Models\Product::create($p);
        }
    }
}
