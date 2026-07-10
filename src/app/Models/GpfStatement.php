<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GpfStatement extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'previous_balance',
        'current_contributions',
        'interest',
        'total_gpf_balance',
    ];

    public function employee()
    {
        return $this->belongsTo(EmployeeProfile::class, 'employee_id');
    }
}
