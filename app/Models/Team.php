<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name',
        'position',
        'photo',
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
        'bio',
        'email',
        'phone',
    ];
}
