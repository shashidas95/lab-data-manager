<?php

namespace App\Http\Controllers;

use App\Models\BdsFoodStandard;
use App\Models\FoodTestingParameter;
use App\Models\Unit;
use Illuminate\Http\Request;

class BdsFoodStandardController extends Controller
{
    public function index()
    {
        return response()->json(BdsFoodStandard::with('parameters.unit')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bds_number' => 'required|string|unique:bds_food_standards,bds_number',
            'product_name' => 'required|string',
            'governing_wing' => 'nullable|string',
            'scope_description' => 'nullable|string',
            'is_mandatory' => 'nullable|boolean',
            'parameters' => 'nullable|array',
            'parameters.*.parameter_name' => 'required|string',
            'parameters.*.test_method' => 'nullable|string',
            'parameters.*.unit_id' => 'required|exists:units,id',
            'parameters.*.limit_type' => 'required|in:range,maximum,minimum,absence',
            'parameters.*.min_limit' => 'nullable|numeric',
            'parameters.*.max_limit' => 'nullable|numeric',
            'parameters.*.qualitative_limit' => 'nullable|string',
        ]);

        $standard = BdsFoodStandard::create([
            'bds_number' => $validated['bds_number'],
            'product_name' => $validated['product_name'],
            'governing_wing' => $validated['governing_wing'] ?? 'Chemical & Food Wing',
            'scope_description' => $validated['scope_description'] ?? null,
            'is_mandatory' => $validated['is_mandatory'] ?? true,
        ]);

        if (!empty($validated['parameters'])) {
            foreach ($validated['parameters'] as $paramData) {
                $standard->parameters()->create($paramData);
            }
        }

        return response()->json($standard->load('parameters.unit'), 210);
    }

    public function show($id)
    {
        $standard = BdsFoodStandard::with('parameters.unit')->findOrFail($id);
        return response()->json($standard);
    }
}
