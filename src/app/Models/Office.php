<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $fillable = ['name', 'code', 'location', 'contact_email'];

    public function labs()
    {
        return $this->hasMany(Lab::class);
    }
    public function labSamples()
    {
        return $this->hasMany(LabSample::class);
    }
}
