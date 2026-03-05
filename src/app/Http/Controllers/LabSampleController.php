<?php

namespace App\Http\Controllers;

use App\Models\LabSample;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LabSampleController extends Controller
{
    /**
     * Display a listing of samples with their related data.
     */
    public function index()
    {
        // Eager load product and lab to avoid N+1 query issues
        $samples = LabSample::with(['product.manufacturer', 'lab.office'])->latest()->get();
        return response()->json($samples);
    }

    /**
     * Store a newly created sample.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sample_number' => 'required|string|unique:lab_samples',
            'product_id'    => 'required|exists:products,id',
            'lab_id'        => 'required|exists:labs,id',
            'status'        => 'required|in:received,in_progress,completed,rejected',
            'received_at'   => 'required|date',
            'batch_number'  => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $sample = LabSample::create($request->all());

        return response()->json([
            'message' => 'Sample registered successfully',
            'data'    => $sample->load(['product', 'lab'])
        ], 201);
    }

    /**
     * Display the specified sample with its full history/details.
     */
    public function show($id)
    {
        $sample = LabSample::with(['product', 'lab', 'testResults.parameter'])->findOrFail($id);
        return response()->json($sample);
    }

    /**
     * Update the status of a sample (e.g., moving from Received to In Progress).
     */
    public function update(Request $request, $id)
    {
        $sample = LabSample::findOrFail($id);

        $request->validate([
            'status' => 'required|in:received,in_progress,completed,rejected',
            'notes'  => 'nullable|string'
        ]);

        $sample->update($request->only(['status', 'notes']));

        return response()->json([
            'message' => 'Sample status updated',
            'data'    => $sample
        ]);
    }

    /**
     * Remove the sample from the system.
     */
    public function destroy($id)
    {
        $sample = LabSample::findOrFail($id);
        $sample->delete();

        return response()->json(['message' => 'Sample deleted successfully']);
    }
}
