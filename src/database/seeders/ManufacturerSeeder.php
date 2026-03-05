<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ManufacturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */ public function run(): void
    {
        $manufacturers = [
            ['name' => 'Sigma-Aldrich', 'country' => 'USA', 'email' => 'sales@sigma.com', 'is_active' => true],
            ['name' => 'Merck Group', 'country' => 'Germany', 'email' => 'info@merck.com', 'is_active' => true],
        ];

        foreach ($manufacturers as $m) {
            \App\Models\Manufacturer::create($m);
        }
    }
}
