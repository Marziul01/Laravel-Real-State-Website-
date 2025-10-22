<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyAmenitie extends Model
{
    protected $fillable = [
        'property_id', 'amenities'
    ];
}
