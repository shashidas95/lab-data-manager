<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'unit_id',
        'data_type',
        'decimal_places',
        'lower_spec_limit',
        'upper_spec_limit',
        'target_value',
        'lod',
        'loq',
        'is_quantitative',
        'is_critical',
        'is_active'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
  
}
