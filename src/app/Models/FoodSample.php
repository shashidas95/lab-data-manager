<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodSample extends Model
{
    use HasFactory;

    protected $fillable = [
        'b_code',
        'lab_blind_code',
        'bds_standard_id',
        'sample_name',
        'sample_quantity',
        'temperature_on_receipt',
        'status',
        'received_by',
        'assigned_chemist_id',
    ];

    public function standard()
    {
        return $this->belongsTo(BdsFoodStandard::class, 'bds_standard_id');
    }

    public function results()
    {
        return $this->hasMany(FoodTestResult::class, 'food_sample_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function chemist()
    {
        return $this->belongsTo(User::class, 'assigned_chemist_id');
    }
}
