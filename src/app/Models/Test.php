<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'sop_reference',
        'test_category',
        'method_validation_status',
        'estimated_tat_hours',
        'is_active'
    ];

    public function parameters()
    {
        return $this->belongsToMany(Parameter::class)->withPivot('sort_order')->withTimestamps();
    }
}
