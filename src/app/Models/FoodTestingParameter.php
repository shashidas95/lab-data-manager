<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodTestingParameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'bds_standard_id',
        'parameter_name',
        'test_method',
        'unit_id',
        'limit_type',
        'min_limit',
        'max_limit',
        'qualitative_limit',
        'is_critical_for_compliance',
    ];

    public function standard()
    {
        return $this->belongsTo(BdsFoodStandard::class, 'bds_standard_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
