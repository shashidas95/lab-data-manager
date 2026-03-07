<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ManufacturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // database/seeders/ManufacturerSeeder.php

    public function run(): void
    {
        $manufacturers = [
            [
                'name' => 'Sigma-Aldrich',
                'address' => 'USA', // Change 'country' to 'address'
                'email' => 'sales@sigma.com',
                'is_active' => true
            ],
            [
                'name' => 'Merck Group',
                'address' => 'Germany', // Change 'country' to 'address'
                'email' => 'info@merck.com',
                'is_active' => true
            ],
        ];

        foreach ($manufacturers as $m) {
            \App\Models\Manufacturer::create($m);
        }
    }
}
