<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
  

    protected $fillable = ['name', 'address', 'email', 'contact_person', 'license_number', 'is_active'];

    public function samples()
    {
        return $this->hasMany(LabSample::class);
    }


    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
