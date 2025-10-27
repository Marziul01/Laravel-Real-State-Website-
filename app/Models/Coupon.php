<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'discount_type' , 'discount', 'start_date', 'expire_date', 'max_uses','max_user_uses' 
    ];

    public function bookings(){
        return $this->hasMany(Booking::class,'coupon_id');
    }
}
