<?php

namespace App\Http\Controllers;

use App\Models\CertificationApplication;
use App\Models\AuditRecord;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    public function listApplications()
    {
        return response()->json(CertificationApplication::with(['applicant', 'audits'])->get());
    }

    public function submitApplication(Request $request)
    {
        $validated = $request->validate([
            'applicant_id' => 'required|exists:users,id',
            'application_type' => 'required|string',
            'product_name' => 'required|string',
            'bds_number' => 'nullable|string',
            'application_fee' => 'nullable|numeric',
        ]);

        $application = CertificationApplication::create([
            'applicant_id' => $validated['applicant_id'],
            'application_type' => $validated['application_type'],
            'product_name' => $validated['product_name'],
            'bds_number' => $validated['bds_number'] ?? null,
            'application_fee' => $validated['application_fee'] ?? 0.00,
            'fee_paid' => false,
            'status' => 'Received',
        ]);

        return response()->json($application, 201);
    }

    public function updateApplicationStatus(Request $request, $id)
    {
        $application = CertificationApplication::findOrFail($id);
        $validated = $request->validate([
            'status' => 'required|in:Received,Under_Review,Pending_Audit,Approved,Rejected',
            'fee_paid' => 'nullable|boolean',
        ]);

        $application->update($validated);
        return response()->json($application);
    }

    public function recordAudit(Request $request)
    {
        $validated = $request->validate([
            'application_id' => 'required|exists:certification_applications,id',
            'audit_stage' => 'required|in:Stage_1,Stage_2,Re_Inspection',
            'audit_date' => 'required|date',
            'findings' => 'nullable|string',
            'status' => 'required|in:Pending,Passed,Failed',
            'auditor_id' => 'nullable|exists:users,id',
        ]);

        $audit = AuditRecord::create($validated);

        // If the audit passes, automatically update the application status to Under_Review or Approved
        $application = CertificationApplication::findOrFail($validated['application_id']);
        if ($validated['status'] === 'Passed') {
            $newStatus = ($validated['audit_stage'] === 'Stage_2') ? 'Approved' : 'Under_Review';
            $application->update(['status' => $newStatus]);
        } elseif ($validated['status'] === 'Failed') {
            $application->update(['status' => 'Rejected']);
        }

        return response()->json($audit, 201);
    }
}
