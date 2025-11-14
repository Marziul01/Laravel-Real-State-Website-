<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'property_id',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
