<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $fillable = ['gtm_id', 'meta_pixel_id', 'meta_access_token' , 'ga4_id' , 'meta_test_event_code'];
}
