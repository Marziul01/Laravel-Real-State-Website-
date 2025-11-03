<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = [
        'type',
        'name',
        'slug',
        'icon',
        'file_type',
        'file',
        'description',
    ];


}
