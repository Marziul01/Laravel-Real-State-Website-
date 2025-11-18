<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminAccess extends Model
{
    protected $fillable = [
        'admin_id',
        'control_panel',
        'rent_property',
        'sell_property',
        'coupons',
        'payment_methods',
        'booking',
        'property_inquiries',
        'property_submissions',
        'services',
        'teams',
        'reviews',
        'user_management',
        'pages_management',
        'seo',
        'reports',
        'settings',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
