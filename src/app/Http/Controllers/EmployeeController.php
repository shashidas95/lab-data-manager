<?php

namespace App\Http\Controllers;

use App\Models\EmployeeProfile;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        return response()->json(EmployeeProfile::with('user')->get());
    }

    public function storeProfile(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'designation' => 'required|string',
            'department' => 'required|string',
            'joining_date' => 'required|date',
            'basic_salary' => 'required|numeric',
            'grade' => 'nullable|string',
        ]);

        $profile = EmployeeProfile::create($validated);
        return response()->json($profile, 201);
    }

    public function listLeaves()
    {
        return response()->json(LeaveRequest::with('employee.user')->get());
    }

    public function requestLeave(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employee_profiles,id',
            'leave_type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'reason' => 'nullable|string',
        ]);

        $validated['status'] = 'Pending';

        $leave = LeaveRequest::create($validated);
        return response()->json($leave, 201);
    }

    public function updateLeaveStatus(Request $request, $id)
    {
        $leave = LeaveRequest::findOrFail($id);
        $validated = $request->validate([
            'status' => 'required|in:Approved,Rejected',
            'approved_by' => 'required|exists:users,id',
        ]);

        $leave->update($validated);
        return response()->json($leave);
    }
}
