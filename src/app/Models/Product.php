<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'sku', 'description', 'manufacturer_id', 'category', 'is_active'];

   
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function labSamples()
    {
        return $this->hasMany(LabSample::class);
    }
}
