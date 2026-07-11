<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyProfile;
use App\Models\CompanyDirector;
use Illuminate\Support\Facades\Storage;

class CompanyProfileController extends Controller
{
    /**
     * Display the company profile along with directors.
     */
    public function show()
    {
        // Fetch the first profile, or create a blank one with empty lists
        $profile = CompanyProfile::with('directors')->first();

        if (!$profile) {
            $profile = CompanyProfile::create([
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
                'factory_division' => '비ভাগ িনব াচন কXন',
                'factory_district' => 'েজলা িনব াচন কXন',
                'factory_thana' => 'থানা িনব াচন কXন',
                'factory_post_code' => 'পোস্ট কোড লিখুন',
                'factory_address' => 'ঠিকানা লিখুন',
                'factory_email' => 'ইমেইল লিখুন',
                'factory_mobile' => '+880',
                'ceo_name' => 'নাম লিখুন',
                'ceo_father_name' => 'পিতার নাম লিখুন',
                'ceo_nationality' => 'িনব াচন কXন',
                'ceo_dob' => null,
                'ceo_designation' => 'পদবি লিখুন',
                'ceo_email' => 'ইমেইল লিখুন',
                'ceo_mobile' => '+880',
                'attachments' => $this->getDefaultAttachments(),
            ]);
            $profile->load('directors');
        }

        return response()->json($profile);
    }

    /**
     * Update the company profile.
     */
    public function update(Request $request)
    {
        $profile = CompanyProfile::first();
        if (!$profile) {
            $profile = new CompanyProfile();
        }

        $validated = $request->validate([
            'name_bn' => 'nullable|string',
            'name_en' => 'nullable|string',
            'type_bn' => 'nullable|string',
            'type_en' => 'nullable|string',
            'head_division' => 'nullable|string',
            'head_district' => 'nullable|string',
            'head_thana' => 'nullable|string',
            'head_post_code' => 'nullable|string',
            'head_address' => 'nullable|string',
            'head_email' => 'nullable|string',
            'head_mobile' => 'nullable|string',
            'head_phone' => 'nullable|string',
            'factory_division' => 'nullable|string',
            'factory_district' => 'nullable|string',
            'factory_thana' => 'nullable|string',
            'factory_post_code' => 'nullable|string',
            'factory_address' => 'nullable|string',
            'factory_email' => 'nullable|string',
            'factory_mobile' => 'nullable|string',
            'same_as_head' => 'nullable|boolean',
            'ceo_name' => 'nullable|string',
            'ceo_father_name' => 'nullable|string',
            'ceo_nationality' => 'nullable|string',
            'ceo_dob' => 'nullable|date',
            'ceo_designation' => 'nullable|string',
            'ceo_email' => 'nullable|string',
            'ceo_mobile' => 'nullable|string',
            'ceo_signature_path' => 'nullable|string',
            'attachments' => 'nullable|array',
        ]);

        if ($validated['same_as_head'] ?? false) {
            $validated['factory_division'] = $validated['head_division'] ?? $profile->head_division;
            $validated['factory_district'] = $validated['head_district'] ?? $profile->head_district;
            $validated['factory_thana'] = $validated['head_thana'] ?? $profile->head_thana;
            $validated['factory_post_code'] = $validated['head_post_code'] ?? $profile->head_post_code;
            $validated['factory_address'] = $validated['head_address'] ?? $profile->head_address;
            $validated['factory_email'] = $validated['head_email'] ?? $profile->head_email;
            $validated['factory_mobile'] = $validated['head_mobile'] ?? $profile->head_mobile;
        }

        $profile->fill($validated);
        $profile->save();

        // Handle updating/creating directors list if present in request
        if ($request->has('directors')) {
            $directorIds = [];
            foreach ($request->input('directors') as $dirData) {
                if (isset($dirData['id'])) {
                    $director = CompanyDirector::find($dirData['id']);
                    if ($director && $director->company_profile_id == $profile->id) {
                        $director->update($dirData);
                        $directorIds[] = $director->id;
                    }
                } else {
                    $newDirector = $profile->directors()->create($dirData);
                    $directorIds[] = $newDirector->id;
                }
            }
            // Delete directors not included in the payload
            $profile->directors()->whereNotIn('id', $directorIds)->delete();
        }

        return response()->json($profile->load('directors'));
    }

    /**
     * Mock upload for CEO's signature or attachments.
     */
    public function uploadSignature(Request $request)
    {
        $request->validate([
            'signature' => 'required|image|max:5120', // Max 5MB
        ]);

        $profile = CompanyProfile::firstOrCreate([]);

        if ($request->hasFile('signature')) {
            $file = $request->file('signature');
            // Simply store it or mock a path
            $path = $file->store('signatures', 'public');
            $profile->ceo_signature_path = Storage::url($path);
            $profile->save();

            return response()->json([
                'signature_path' => $profile->ceo_signature_path,
                'message' => 'Signature uploaded successfully!'
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    /**
     * Get default 47 attachments from Bangladesh standard list.
     */
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
