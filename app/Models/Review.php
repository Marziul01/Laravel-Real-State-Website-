<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable =[
        'user_id',
        'property_id',
        'booking_id',
        'rating',
        'comment',
        'service_id',
        'name',
        'status',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class , 'service_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
