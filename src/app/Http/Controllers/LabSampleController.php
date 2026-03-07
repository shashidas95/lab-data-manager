<?php

namespace App\Http\Controllers;

use App\Models\LabSample;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class LabSampleController extends Controller
{
    public function index()
    {
        // We eager load relationships to avoid N+1 issues
        return response()->json(LabSample::with(['product', 'lab', 'manufacturer'])->latest()->get());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sample_number'   => 'required|string|unique:lab_samples,sample_number',
            'product_id'      => 'required|exists:products,id',
            'lab_id'          => 'required|exists:labs,id',
            'manufacturer_id' => 'nullable|exists:manufacturers,id',
            'batch_number'    => 'required|string',
            'production_date' => 'nullable|date',
            'expiry_date'     => 'nullable|date',
            'priority'        => 'required|in:low,normal,high,urgent',
            'status'          => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation Error', 'errors' => $validator->errors()], 422);
        }

        // Auto-set received_at if not provided
        $data = $request->all();
        if (!isset($data['received_at'])) {
            $data['received_at'] = now();
        }

        $sample = LabSample::create($data);

        return response()->json([
            'message' => 'Sample registered successfully',
            'data' => $sample->load(['product', 'lab'])
        ], 201);
    }

    public function show(LabSample $sample)
    {
        return response()->json($sample->load(['product', 'lab', 'manufacturer']));
    }

    public function update(Request $request, LabSample $sample)
    {
        $sample->update($request->all());
        return response()->json(['message' => 'Sample updated', 'data' => $sample]);
    }

    public function destroy(LabSample $sample)
    {
        $sample->delete();
        return response()->json(['message' => 'Sample deleted']);
    }
    public function showPublic($id)
    {
        $sample = LabSample::with(['product', 'manufacturer'])
            ->where('id', $id)
            ->firstOrFail();

        // Return only necessary fields for verification
        return response()->json($sample->only([
            'id',
            'sample_number',
            'batch_number',
            'status',
            'updated_at',
            'product',
            'manufacturer'
        ]));
    }
}
