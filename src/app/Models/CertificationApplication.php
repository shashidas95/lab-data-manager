<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificationApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'application_type',
        'product_name',
        'bds_number',
        'status',
        'application_fee',
        'fee_paid',
    ];

    public function applicant()
    {
        return $this->belongsTo(User::class, 'applicant_id');
    }

    public function audits()
    {
        return $this->hasMany(AuditRecord::class, 'application_id');
    }
}
