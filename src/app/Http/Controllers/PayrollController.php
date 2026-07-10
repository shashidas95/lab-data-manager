<?php

namespace App\Http\Controllers;

use App\Models\PayrollRecord;
use App\Models\EmployeeLoan;
use App\Models\GpfStatement;
use App\Models\EmployeeProfile;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        return response()->json(PayrollRecord::with('employee.user')->get());
    }

    public function processSalary(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employee_profiles,id',
            'salary_month' => 'required|string',
            'allowance' => 'nullable|numeric',
            'deductions' => 'nullable|numeric',
            'bonus' => 'nullable|numeric',
        ]);

        $employee = EmployeeProfile::findOrFail($validated['employee_id']);
        $base = $employee->basic_salary;
        $allowance = $validated['allowance'] ?? 0.00;
        $deductions = $validated['deductions'] ?? 0.00;
        $bonus = $validated['bonus'] ?? 0.00;

        $net = ($base + $allowance + $bonus) - $deductions;

        $record = PayrollRecord::create([
            'employee_id' => $employee->id,
            'salary_month' => $validated['salary_month'],
            'base_salary' => $base,
            'allowance' => $allowance,
            'deductions' => $deductions,
            'net_salary' => $net,
            'bonus' => $bonus,
            'bank_advice_generated' => false,
            'status' => 'Processed',
        ]);

        return response()->json($record, 201);
    }

    public function issueLoan(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employee_profiles,id',
            'loan_amount' => 'required|numeric',
        ]);

        $loan = EmployeeLoan::create([
            'employee_id' => $validated['employee_id'],
            'loan_amount' => $validated['loan_amount'],
            'remaining_balance' => $validated['loan_amount'],
            'status' => 'Active',
        ]);

        return response()->json($loan, 201);
    }

    public function updateGpf(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employee_profiles,id',
            'previous_balance' => 'required|numeric',
            'current_contributions' => 'required|numeric',
            'interest' => 'required|numeric',
        ]);

        $total = $validated['previous_balance'] + $validated['current_contributions'] + $validated['interest'];

        $statement = GpfStatement::updateOrCreate(
            ['employee_id' => $validated['employee_id']],
            [
                'previous_balance' => $validated['previous_balance'],
                'current_contributions' => $validated['current_contributions'],
                'interest' => $validated['interest'],
                'total_gpf_balance' => $total,
            ]
        );

        return response()->json($statement);
    }
}
