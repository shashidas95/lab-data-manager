<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmWorkflowLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'from_status',
        'to_status',
        'user_id',
        'remarks',
    ];

    public function application()
    {
        return $this->belongsTo(CmLicenseApplication::class, 'application_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
