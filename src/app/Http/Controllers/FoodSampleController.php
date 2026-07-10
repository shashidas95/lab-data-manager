<?php

namespace App\Http\Controllers;

use App\Models\FoodSample;
use App\Models\BdsFoodStandard;
use App\Models\FoodTestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FoodSampleController extends Controller
{
    public function index()
    {
        return response()->json(FoodSample::with(['standard', 'results.parameter.unit', 'chemist'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bds_standard_id' => 'required|exists:bds_food_standards,id',
            'sample_name' => 'required|string',
            'sample_quantity' => 'nullable|integer',
            'temperature_on_receipt' => 'nullable|string',
            'assigned_chemist_id' => 'nullable|exists:users,id',
        ]);

        // Auto-generate public verification B-Code & Lab Blind Code
        $bCode = 'BSTI-' . date('Y') . '-F-' . strtoupper(Str::random(6));
        $labBlindCode = 'LAB-CH-' . rand(10000, 99999);

        $sample = FoodSample::create([
            'b_code' => $bCode,
            'lab_blind_code' => $labBlindCode,
            'bds_standard_id' => $validated['bds_standard_id'],
            'sample_name' => $validated['sample_name'],
            'sample_quantity' => $validated['sample_quantity'] ?? 1,
            'temperature_on_receipt' => $validated['temperature_on_receipt'] ?? 'Ambient',
            'assigned_chemist_id' => $validated['assigned_chemist_id'] ?? null,
            'status' => 'Received',
        ]);

        return response()->json($sample->load('standard'), 210);
    }

    public function show($id)
    {
        $sample = FoodSample::with(['standard.parameters.unit', 'results.parameter.unit', 'chemist'])->findOrFail($id);
        return response()->json($sample);
    }

    public function updateStatus(Request $request, $id)
    {
        $sample = FoodSample::findOrFail($id);
        $validated = $request->validate([
            'status' => 'required|in:Received,Assigned,Testing,Completed,Approved,Rejected',
            'assigned_chemist_id' => 'nullable|exists:users,id',
        ]);

        $sample->update($validated);
        return response()->json($sample);
    }

    public function recordResults(Request $request, $id)
    {
        $sample = FoodSample::with('standard.parameters')->findOrFail($id);
        $validated = $request->validate([
            'results' => 'required|array',
            'results.*.parameter_id' => 'required|exists:food_testing_parameters,id',
            'results.*.numeric_value' => 'nullable|numeric',
            'results.*.text_value' => 'nullable|string',
            'results.*.chemist_remarks' => 'nullable|string',
        ]);

        foreach ($validated['results'] as $resultData) {
            FoodTestResult::updateOrCreate(
                [
                    'food_sample_id' => $sample->id,
                    'parameter_id' => $resultData['parameter_id'],
                ],
                [
                    'numeric_value' => $resultData['numeric_value'] ?? null,
                    'text_value' => $resultData['text_value'] ?? null,
                    'chemist_remarks' => $resultData['chemist_remarks'] ?? null,
                ]
            );
        }

        // Evaluate overall sample status
        $results = FoodTestResult::where('food_sample_id', $sample->id)->get();
        $anyFailure = $results->contains('is_compliant', false);

        $sample->update([
            'status' => $anyFailure ? 'Rejected' : 'Completed'
        ]);

        return response()->json($sample->load('results.parameter.unit'));
    }

    public function verifyPublic($bCode)
    {
        $sample = FoodSample::with(['standard', 'results.parameter.unit'])
            ->where('b_code', $bCode)
            ->first();

        if (!$sample) {
            return response()->json(['error' => 'Certificate Verification Code not found in BSTI central records.'], 404);
        }

        // Hide sensitive lab codes and internal details for public safety
        return response()->json([
            'b_code' => $sample->b_code,
            'product_name' => $sample->sample_name,
            'standard_specification' => $sample->standard->bds_number . ' (' . $sample->standard->product_name . ')',
            'testing_status' => $sample->status,
            'is_certified' => ($sample->status === 'Approved' || $sample->status === 'Completed'),
            'verified_at' => now()->toIso8601String(),
            'analysis' => $sample->results->map(function ($res) {
                return [
                    'parameter' => $res->parameter->parameter_name,
                    'unit' => $res->parameter->unit->name,
                    'is_compliant' => $res->is_compliant,
                ];
            })
        ]);
    }
}
