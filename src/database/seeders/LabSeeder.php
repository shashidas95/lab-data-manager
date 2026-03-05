<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $officeId = \App\Models\Office::first()->id;

        \App\Models\Lab::create([
            'name' => 'Main Quality Control Lab',
            'code' => 'QC-01',
            'location' => 'Level 4, Section B',
            'office_id' => $officeId,
            'contact_person' => 'Dr. Shashi',
            'accreditation_status' => 'ISO 17025',
            'is_active' => true
        ]);
    }
    
}
