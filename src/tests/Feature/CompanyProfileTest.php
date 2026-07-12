<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\CompanyProfile;
use App\Models\CompanyDirector;

class CompanyProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test can fetch company profile (creates default if empty).
     */
    public function test_can_fetch_company_profile()
    {
        $response = $this->getJson('/api/company-profile');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'name_bn',
            'name_en',
            'type_bn',
            'type_en',
            'head_division',
            'head_district',
            'head_thana',
            'head_post_code',
            'head_address',
            'attachments',
            'directors',
        ]);

        $this->assertDatabaseHas('company_profiles', [
            'name_bn' => 'jkljd',
            'name_en' => 'hlksdkf',
        ]);
    }

    /**
     * Test can update company profile and associated directors.
     */
    public function test_can_update_company_profile_and_directors()
    {
        $profile = CompanyProfile::create([
            'name_bn' => 'Old Name BN',
            'name_en' => 'Old Name EN',
            'same_as_head' => false,
        ]);

        $response = $this->putJson('/api/company-profile', [
            'name_bn' => 'নতুন নাম',
            'name_en' => 'New English Name',
            'type_bn' => 'প্রোপ্রাইটরশীপ',
            'type_en' => 'Propritorship',
            'head_division' => 'Dhaka',
            'head_district' => 'Kishoreganj',
            'head_thana' => 'Austagram',
            'head_post_code' => '2300',
            'head_address' => 'Some address',
            'same_as_head' => true,
            'directors' => [
                [
                    'name' => 'Alice Smith',
                    'designation' => 'CEO',
                    'nid_tin_passport' => '987654321',
                    'nationality' => 'Bangladeshi',
                ],
                [
                    'name' => 'Bob Jones',
                    'designation' => 'Chairman',
                    'nid_tin_passport' => '11223344',
                    'nationality' => 'Bangladeshi',
                ]
            ],
            'ceo_name' => 'John Doe',
            'ceo_designation' => 'CEO',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('name_en', 'New English Name');
        $response->assertJsonPath('factory_address', 'Some address'); // Copied from head because same_as_head is true
        $this->assertCount(2, $response->json('directors'));

        $this->assertDatabaseHas('company_profiles', [
            'name_en' => 'New English Name',
            'factory_address' => 'Some address',
        ]);

        $this->assertDatabaseHas('company_directors', [
            'name' => 'Alice Smith',
            'designation' => 'CEO',
        ]);
    }
}
