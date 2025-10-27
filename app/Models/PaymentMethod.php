<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable =[
        'payment_method_type','name','account_number','account_name','branch_name'
    ];
}
