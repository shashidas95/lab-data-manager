<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabSample extends Model
{
    protected $fillable = [
        'office_id',
        'product_id',
        'collection_place',
        'sample_submission_date',
        'total_sample_submitted',
        'pass_sample_count',
        'fail_sample_count',
        'pending_sample_count',
        'status',
        'action_taken'
    ];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
