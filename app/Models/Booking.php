<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public function coupon(){
        return $this->belongsTo(Coupon::class,'coupon_id');
    }

    public function payment(){
        return $this->belongsTo(PaymentMethod::class,'payment_id');
    }

    public function property(){
        return $this->belongsTo(Property::class,'property_id');
    }

    public function user() {
        return $this->belongsTo(User::class ,'user_id');
    }
}
