<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'team_id',
        'name',
        'phone',
        'email',
        'country_id',
        'schedule_date',
        'schedule_time',
        'demands',
        'message',
        'status',
    ];

    public function country(){
        return $this->belongsTo(Country::class,'country_id');
    }

    public function team(){
        return $this->belongsTo(Team::class,'team_id');
    }
}
