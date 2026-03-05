<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['name', 'abbreviation', 'description', 'category'];

    public function parameters()
    {
        return $this->hasMany(Parameter::class);
    }
}
