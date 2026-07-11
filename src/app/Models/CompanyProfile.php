<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompanyProfile extends Model
{
    protected $fillable = [
        'name_bn',
        'name_en',
        'type_bn',
        'type_en',
        'head_division',
        'head_district',
        'head_thana',
        'head_post_code',
        'head_address',
        'head_email',
        'head_mobile',
        'head_phone',
        'factory_division',
        'factory_district',
        'factory_thana',
        'factory_post_code',
        'factory_address',
        'factory_email',
        'factory_mobile',
        'same_as_head',
        'ceo_name',
        'ceo_father_name',
        'ceo_nationality',
        'ceo_dob',
        'ceo_designation',
        'ceo_email',
        'ceo_mobile',
        'ceo_signature_path',
        'attachments',
    ];

    protected $casts = [
        'same_as_head' => 'boolean',
        'attachments' => 'array',
        'ceo_dob' => 'date',
    ];

    public function directors(): HasMany
    {
        return $this->hasMany(CompanyDirector::class);
    }
}
