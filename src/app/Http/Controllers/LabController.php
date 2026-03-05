<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use Illuminate\Http\Request;

class LabController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Get all labs
   public function index()
    {
        // Includes the Office name/details in the response
        return response()->json(\App\Models\Lab::with('office')->get());
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
        $data = $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|unique:labs',
            'office_id' => 'required|exists:offices,id',
            'is_active' => 'boolean'
        ]);
        return response()->json(\App\Models\Lab::create($data), 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Lab $lab)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lab $lab)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lab $lab)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lab $lab)
    {
        //
    }
}
