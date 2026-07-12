<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyDirector extends Model
{
    protected $fillable = [
        'company_profile_id',
        'name',
        'designation',
        'nid_tin_passport',
        'nationality',
    ];

    public function companyProfile(): BelongsTo
    {
        return $this->belongsTo(CompanyProfile::class);
    }
}
