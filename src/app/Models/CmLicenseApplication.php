<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmLicenseApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'bds_standard_id',
        'product_name',
        'status',
        'current_owner_id',
        'questionnaire',
        'application_fee',
        'application_fee_paid',
        'license_fee',
        'license_fee_paid',
        'man_day_calculation',
        'primary_inspection_report',
        'observation_feedback',
        'observation_evidence',
        'formal_inspection_date',
        'formal_inspection_report',
        'resampling_required',
        'test_report_passed',
        'evaluation_report',
        'checklist',
        'committee_conditions',
        'refuse_letter',
    ];

    public function applicant()
    {
        return $this->belongsTo(User::class, 'applicant_id');
    }

    public function standard()
    {
        return $this->belongsTo(BdsFoodStandard::class, 'bds_standard_id');
    }

    public function currentOwner()
    {
        return $this->belongsTo(User::class, 'current_owner_id');
    }

    public function logs()
    {
        return $this->hasMany(CmWorkflowLog::class, 'application_id');
    }

    public function logTransition(User $user, $from, $to, $remarks = null)
    {
        return $this->logs()->create([
            'from_status' => $from,
            'to_status' => $to,
            'user_id' => $user->id,
            'remarks' => $remarks,
        ]);
    }
}
