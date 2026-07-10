<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'audit_stage',
        'audit_date',
        'findings',
        'status',
        'auditor_id',
    ];

    public function application()
    {
        return $this->belongsTo(CertificationApplication::class, 'application_id');
    }

    public function auditor()
    {
        return $this->belongsTo(User::class, 'auditor_id');
    }
}
