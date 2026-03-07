<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // This returns the test AND all the parameters associated with it
        return response()->json(\App\Models\Test::with('parameters.unit')->get());
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sample_id' => 'required|exists:lab_samples,id',
            'results' => 'required|array',
            'results.*.parameter_id' => 'required|exists:parameters,id',
            'results.*.value' => 'required'
        ]);

        foreach ($validated['results'] as $result) {
            \App\Models\Test::updateOrCreate(
                ['sample_id' => $validated['sample_id'], 'parameter_id' => $result['parameter_id']],
                ['value' => $result['value'], 'recorded_at' => now()]
            );
        }

        return response()->json(['message' => 'Results saved successfully']);
    }

    /**
     * Display the specified resource.
     */
   public function show($id)
    {
        return response()->json(\App\Models\Test::with('parameters.unit')->findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Test $test)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Test $test)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Test $test)
    {
        //
    }
}
