<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyFeature extends Model
{
    protected $fillable = [
        'property_id', 'feature_keys', 'feature_values'
    ];
}
