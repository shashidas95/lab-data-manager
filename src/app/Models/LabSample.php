<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabSample extends Model
{
    use HasUuids;

    protected $table = 'lab_samples';

    protected $fillable = [
        'sample_number',
        'product_id',
        'lab_id',
        'manufacturer_id',
        'batch_number',
        'production_date',
        'expiry_date',
        'brand',
        'variant',
        'flavour',
        'color',
        'type',
        'sample_quantity',
        'collected_amount',
        'status',
        'priority',
        'received_at'
    ];

    protected $casts = [
        'production_date' => 'date',
        'expiry_date' => 'date',
        'received_at' => 'datetime',
    ];

    /**
     * FIX: This was missing and caused your 500 error!
     */
    public function lab(): BelongsTo
    {
        return $this->belongsTo(Lab::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Direct relationship to manufacturer
     */
    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
    }

    // Note: You had an office() method, but no office_id in $fillable.
    // If samples belong to a lab, and labs belong to an office,
    // you usually access office THROUGH the lab.
}
