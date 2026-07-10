<?php

namespace App\Http\Controllers;

use App\Models\CmLicenseApplication;
use App\Models\CmWorkflowLog;
use Illuminate\Http\Request;

class CmWorkflowController extends Controller
{
    public function listApplications()
    {
        return response()->json(CmLicenseApplication::with(['applicant', 'standard', 'logs.user'])->get());
    }

    public function show($id)
    {
        return response()->json(CmLicenseApplication::with(['applicant', 'standard', 'logs.user'])->findOrFail($id));
    }

    public function submitApplication(Request $request)
    {
        $validated = $request->validate([
            'applicant_id' => 'required|exists:users,id',
            'bds_standard_id' => 'required|exists:bds_food_standards,id',
            'product_name' => 'required|string',
            'questionnaire' => 'nullable|string',
            'application_fee' => 'nullable|numeric',
        ]);

        $app = CmLicenseApplication::create([
            'applicant_id' => $validated['applicant_id'],
            'bds_standard_id' => $validated['bds_standard_id'],
            'product_name' => $validated['product_name'],
            'questionnaire' => $validated['questionnaire'] ?? null,
            'application_fee' => $validated['application_fee'] ?? 0.00,
            'application_fee_paid' => false,
            'status' => 'Applied',
        ]);

        $app->logTransition($app->applicant, 'None', 'Applied', 'CM License application submitted by applicant.');

        return response()->json($app, 201);
    }

    public function forward(Request $request, $id)
    {
        $app = CmLicenseApplication::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'to_status' => 'required|in:Forwarded_To_DD,Forwarded_To_AD,Forwarded_To_Inspector',
            'remarks' => 'nullable|string',
            'current_owner_id' => 'nullable|exists:users,id',
        ]);

        $oldStatus = $app->status;
        $app->update([
            'status' => $validated['to_status'],
            'current_owner_id' => $validated['current_owner_id'] ?? null,
        ]);

        $app->logTransition(
            \App\Models\User::findOrFail($validated['user_id']),
            $oldStatus,
            $validated['to_status'],
            $validated['remarks'] ?? 'Forwarded along the BSTI approval hierarchy.'
        );

        return response()->json($app);
    }

    public function reportShortfall(Request $request, $id)
    {
        $app = CmLicenseApplication::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'remarks' => 'required|string',
        ]);

        $oldStatus = $app->status;
        $app->update([
            'status' => 'Shortfall',
        ]);

        $app->logTransition(
            \App\Models\User::findOrFail($validated['user_id']),
            $oldStatus,
            'Shortfall',
            'Shortfall noted: ' . $validated['remarks']
        );

        return response()->json($app);
    }

    public function rectifyShortfall(Request $request, $id)
    {
        $app = CmLicenseApplication::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'remarks' => 'nullable|string',
        ]);

        $oldStatus = $app->status;
        $app->update([
            'status' => 'Forwarded_To_Inspector',
        ]);

        $app->logTransition(
            \App\Models\User::findOrFail($validated['user_id']),
            $oldStatus,
            'Forwarded_To_Inspector',
            'Shortfall rectified by applicant: ' . ($validated['remarks'] ?? 'Documents updated.')
        );

        return response()->json($app);
    }

    public function recordInspection(Request $request, $id)
    {
        $app = CmLicenseApplication::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'man_day_calculation' => 'required|string',
            'primary_inspection_report' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        $oldStatus = $app->status;
        $app->update([
            'status' => 'Primary_Inspection',
            'man_day_calculation' => $validated['man_day_calculation'],
            'primary_inspection_report' => $validated['primary_inspection_report'],
        ]);

        $app->logTransition(
            \App\Models\User::findOrFail($validated['user_id']),
            $oldStatus,
            'Primary_Inspection',
            'Inspector completed primary inspection. ' . ($validated['remarks'] ?? '')
        );

        return response()->json($app);
    }

    public function recordFormalInspection(Request $request, $id)
    {
        $app = CmLicenseApplication::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'formal_inspection_date' => 'required|date',
            'formal_inspection_report' => 'required|string',
        ]);

        $oldStatus = $app->status;
        $app->update([
            'status' => 'Formal_Inspection',
            'formal_inspection_date' => $validated['formal_inspection_date'],
            'formal_inspection_report' => $validated['formal_inspection_report'],
        ]);

        $app->logTransition(
            \App\Models\User::findOrFail($validated['user_id']),
            $oldStatus,
            'Formal_Inspection',
            'Formal inspection completed, lab testing samples collected.'
        );

        return response()->json($app);
    }

    public function compileTestReport(Request $request, $id)
    {
        $app = CmLicenseApplication::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'test_report_passed' => 'required|boolean',
            'evaluation_report' => 'nullable|string',
            'refuse_letter' => 'nullable|string',
        ]);

        $oldStatus = $app->status;
        if ($validated['test_report_passed']) {
            $newStatus = 'Evaluation_Report';
            $app->update([
                'status' => $newStatus,
                'test_report_passed' => true,
                'evaluation_report' => $validated['evaluation_report'] ?? 'Evaluation passes all reference BDS specifications.',
            ]);
        } else {
            $newStatus = 'Refused';
            $app->update([
                'status' => $newStatus,
                'test_report_passed' => false,
                'refuse_letter' => $validated['refuse_letter'] ?? 'Reference BDS specifications failed.',
            ]);
        }

        $app->logTransition(
            \App\Models\User::findOrFail($validated['user_id']),
            $oldStatus,
            $newStatus,
            $validated['test_report_passed'] ? 'Lab test compiled: PASS. Evaluation report prepared.' : 'Lab test compiled: FAIL. Refuse letter prepared.'
        );

        return response()->json($app);
    }

    public function ddVerify(Request $request, $id)
    {
        $app = CmLicenseApplication::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'checklist' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        $oldStatus = $app->status;
        $app->update([
            'status' => 'Verified_By_DD',
            'checklist' => $validated['checklist'],
        ]);

        $app->logTransition(
            \App\Models\User::findOrFail($validated['user_id']),
            $oldStatus,
            'Verified_By_DD',
            'DD verified evaluation report and finalized the check list.'
        );

        return response()->json($app);
    }

    public function committeeReview(Request $request, $id)
    {
        $app = CmLicenseApplication::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'decision' => 'required|in:Committee_Approved,Committee_Approved_Conditionally,Re_Inspection,Rejected',
            'conditions' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $oldStatus = $app->status;
        $newStatus = $validated['decision'];

        $updateData = ['status' => $newStatus];
        if ($newStatus === 'Committee_Approved_Conditionally') {
            $updateData['committee_conditions'] = $validated['conditions'];
        }

        $app->update($updateData);

        $app->logTransition(
            \App\Models\User::findOrFail($validated['user_id']),
            $oldStatus,
            $newStatus,
            'Certification Committee Decision: ' . $newStatus . '. ' . ($validated['remarks'] ?? '')
        );

        return response()->json($app);
    }

    public function completePayment(Request $request, $id)
    {
        $app = CmLicenseApplication::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'license_fee' => 'required|numeric',
        ]);

        $oldStatus = $app->status;
        $app->update([
            'status' => 'License_Issued',
            'license_fee' => $validated['license_fee'],
            'license_fee_paid' => true,
        ]);

        $app->logTransition(
            \App\Models\User::findOrFail($validated['user_id']),
            $oldStatus,
            'License_Issued',
            'License fee payment received. Official BSTI CM License generated and issued.'
        );

        return response()->json($app);
    }
}
