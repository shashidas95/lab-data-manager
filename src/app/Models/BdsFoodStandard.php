<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BdsFoodStandard extends Model
{
    use HasFactory;

    protected $fillable = [
        'bds_number',
        'product_name',
        'governing_wing',
        'scope_description',
        'is_mandatory',
    ];

    public function parameters()
    {
        return $this->hasMany(FoodTestingParameter::class, 'bds_standard_id');
    }

    public function samples()
    {
        return $this->hasMany(FoodSample::class, 'bds_standard_id');
    }
}
