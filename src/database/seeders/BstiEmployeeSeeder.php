<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class BstiEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed some representative BSTI Chemist / Scientist / Auditor employees
        $employees = [
            [
                'name' => 'Dr. Rahman',
                'email' => 'dr.rahman@bsti.gov.bd',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Mrs. Sultana',
                'email' => 'sultana.chem@bsti.gov.bd',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Mr. Haque',
                'email' => 'haque.qc@bsti.gov.bd',
                'password' => bcrypt('password'),
            ],
        ];

        foreach ($employees as $employee) {
            User::firstOrCreate(
                ['email' => $employee['email']],
                $employee
            );
        }
    }
}
