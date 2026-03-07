<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class Product extends Model
{
    // use HasUuids; // Add this if your migrations use UUIDs for products

    protected $fillable = ['name', 'sku', 'description', 'manufacturer_id', 'category', 'is_active'];

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
    }
    public function labSamples()
    {
        return $this->hasMany(LabSample::class);
    }
}

