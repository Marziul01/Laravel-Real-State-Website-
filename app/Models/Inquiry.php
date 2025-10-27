<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = [
        'property_id',
        'name',
        'phone',
        'email',
        'country_id',
        'schedule_date',
        'schedule_time',
        'demands',
        'message',
    ];

    public function country(){
        return $this->belongsTo(Country::class,'country_id');
    }

    public function property(){
        return $this->belongsTo(Property::class,'property_id');
    }
}
