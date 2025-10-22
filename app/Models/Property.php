<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'property_type_id',
        'realtor_id',
        'type',
        'featured_image',
        'name',
        'slug',
        'price',
        'description',
        'property_listing',
        'bedrooms',
        'bathrooms',
        'space',
        'parking_space',
        'country_id',
        'state_id',
        'property_area_id',
        'house',
        'city',
        'road',
        'rent_start',
        'status',
        'created_at',
        'updated_at',
    ];

    public function images(){
        return $this->hasMany(PropertyImage::class,'property_id');
    }

    public function features(){
        return $this->hasMany(PropertyFeature::class,'property_id');
    }

    public function amenities(){
        return $this->hasMany(PropertyAmenitie::class,'property_id');
    }

    public function propertyType(){
        return $this->belongsTo(PropertyType::class,'property_type_id');
    }

    public function country(){
        return $this->belongsTo(Country::class ,'country_id','id');
    }

    public function state(){
        return $this->belongsTo(State::class ,'state_id','id');
    }

    public function propertyarea(){
        return $this->belongsTo(Upazila::class ,'property_area_id','id');
    }

    public function realtor(){
        return $this->belongsTo(User::class ,'realtor_id','id');
    }
}
