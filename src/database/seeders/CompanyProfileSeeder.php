<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompanyProfile;
use App\Models\CompanyDirector;

class CompanyProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profile = CompanyProfile::updateOrCreate(
            ['id' => 1],
            [
                'name_bn' => 'jkljd',
                'name_en' => 'hlksdkf',
                'type_bn' => 'প্রোপ্রাইটরশীপ',
                'type_en' => 'Propritorship',

                'head_division' => 'Dhaka',
                'head_district' => 'Kishoreganj',
                'head_thana' => 'Austagram',
                'head_post_code' => 'পোস্ট কোড লিখুন',
                'head_address' => 'Jvprtjlkjdf',
                'head_email' => 'ইমেইল লিখুন',
                'head_mobile' => '+880',
                'head_phone' => 'ফোন নং লিখুন',

                'same_as_head' => false,
                'factory_division' => 'বিভাগ নির্বাচন করুন',
                'factory_district' => 'জেলা নির্বাচন করুন',
                'factory_thana' => 'থানা নির্বাচন করুন',
                'factory_post_code' => 'পোস্ট কোড লিখুন',
                'factory_address' => 'ঠিকানা লিখুন',
                'factory_email' => 'ইমেইল লিখুন',
                'factory_mobile' => '+880',

                'ceo_name' => 'নাম লিখুন',
                'ceo_father_name' => 'পিতার নাম লিখুন',
                'ceo_nationality' => 'নির্বাচন করুন',
                'ceo_dob' => null,
                'ceo_designation' => 'পদবি লিখুন',
                'ceo_email' => 'ইমেইল লিখুন',
                'ceo_mobile' => '+880',
                'attachments' => $this->getDefaultAttachments(),
            ]
        );

        // Clear existing directors if any to prevent duplicates during multiple seeds
        $profile->directors()->delete();

        // Let's create an empty array initially, directors can be added dynamically.
        // We can add one mock director to show how it looks.
        $profile->directors()->create([
            'name' => 'John Doe',
            'designation' => 'Managing Director',
            'nid_tin_passport' => '123456789',
            'nationality' => 'Bangladeshi',
        ]);
    }

    private function getDefaultAttachments()
    {
        $docNames = [
            'NID', 'TIN', 'Copy of Invoice of the Foreign Counterpart', 'Previous certificate',
            'Date of Last Verification', 'ট্রেড লাইসেন্স', 'Trade License', 'Income Tax Certificate',
            'Environment Clearance', 'Clay Bricks Burning Certificate from DC Office', 'Fire License',
            'Trade Marks', 'Premises License', 'BIDA Registration', 'Process Flow Chart',
            'List of Manufacturing Machineries', 'List of Testing Equipment', 'Factory Layout',
            'Calibration Certificate of Measuring Equipment', 'Quality Control Plan/STI',
            'CV/List of QC Personnel', 'Initial Questionnaire', 'PHP Registration',
            'Formulation License', 'Import License of active Ingredient', 'Registry Document',
            'Electricity Bill', 'Water Connection Bill', 'Gas Bill', 'Product Formula Sheet',
            'Raw Material List', 'Sourcing Agreement', 'Storage Plan', 'HACCP Certificate',
            'ISO Certificate', 'GMP Compliance Document', 'Safety Instruction Manual',
            'Packaging Details', 'Label Approval Document', 'Sanitary Certificate',
            'Boiler Certificate', 'Weight & Measure License', 'BSTI CM License Fee Receipt',
            'Bank Solvency Certificate', 'Export License', 'Customs Clearance Copy',
            'Undertaking Form'
        ];

        $list = [];
        foreach ($docNames as $index => $name) {
            $list[] = [
                'id' => $index + 1,
                'name' => $name,
                'uploaded' => false,
                'file_name' => null,
            ];
        }

        return $list;
    }
}
