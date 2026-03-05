<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $offices = [
            ['name' => 'Head Office - Dhaka', 'code' => 'HO-DHK', 'location' => 'Gulshan', 'contact_email' => 'admin@labmanager.com'],
            ['name' => 'Regional Branch - Chittagong', 'code' => 'RB-CTG', 'location' => 'Agrabad', 'contact_email' => 'ctg@labmanager.com'],
        ];

        foreach ($offices as $office) {
            \App\Models\Office::create($office);
        }
    }
    
}
