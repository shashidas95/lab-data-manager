<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodTestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'food_sample_id',
        'parameter_id',
        'numeric_value',
        'text_value',
        'is_compliant',
        'tested_by',
        'chemist_remarks',
    ];

    public function sample()
    {
        return $this->belongsTo(FoodSample::class, 'food_sample_id');
    }

    public function parameter()
    {
        return $this->belongsTo(FoodTestingParameter::class, 'parameter_id');
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($result) {
            $parameter = $result->parameter;
            if (!$parameter) {
                return;
            }

            if ($parameter->limit_type === 'maximum') {
                $result->is_compliant = ($result->numeric_value <= $parameter->max_limit);
            } elseif ($parameter->limit_type === 'minimum') {
                $result->is_compliant = ($result->numeric_value >= $parameter->min_limit);
            } elseif ($parameter->limit_type === 'range') {
                $result->is_compliant = ($result->numeric_value >= $parameter->min_limit && $result->numeric_value <= $parameter->max_limit);
            } elseif ($parameter->limit_type === 'absence') {
                $result->is_compliant = (strtolower($result->text_value ?? '') === strtolower($parameter->qualitative_limit ?? ''));
            }
        });
    }
}
