<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrer extends Model
{
    protected $fillable = [
        'title',
        'position',
        'type',
        'salary',
        'description',
        'image',
        'location',
        'deadline'
    ];
}
