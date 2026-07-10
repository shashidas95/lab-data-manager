<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'salary_month',
        'base_salary',
        'allowance',
        'deductions',
        'net_salary',
        'bonus',
        'bank_advice_generated',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'base_salary' => 'float',
            'allowance' => 'float',
            'deductions' => 'float',
            'net_salary' => 'float',
            'bonus' => 'float',
            'bank_advice_generated' => 'boolean',
        ];
    }

    public function employee()
    {
        return $this->belongsTo(EmployeeProfile::class, 'employee_id');
    }
}
