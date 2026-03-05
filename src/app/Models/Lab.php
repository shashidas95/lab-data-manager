<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    protected $fillable = [
        'name',
        'code',
        'location',
        'contact_person',
        'contact_email',
        'phone_number',
        'accreditation_status',
        'notes',
        'is_active',
        'office_id'
    ];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }
  
}
