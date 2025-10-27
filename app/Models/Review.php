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
    ];
}
