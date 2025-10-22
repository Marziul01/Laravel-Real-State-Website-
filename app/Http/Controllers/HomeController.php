<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public static function index(){
        return view('frontend.home.home' , [
            'properties' => Property::where('status', 1 )->get(),
         ]);
    }
}
