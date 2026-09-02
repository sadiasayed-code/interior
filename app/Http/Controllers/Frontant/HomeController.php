<?php

namespace App\Http\Controllers\Frontant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function mainPage(){
       return view ('frontant.home');
    }
}
