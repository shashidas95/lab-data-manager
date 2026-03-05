<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    protected $fillable = ['name', 'country', 'contact_person', 'email', 'website', 'is_active'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
