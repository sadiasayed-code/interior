<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;

class HomeController extends Controller
{
    public function mainPage()
    {
        $services = Service::query()
            ->where('status', 'active')
            ->latest()
            ->get();

        return view('frontend.home', compact('services'));
    }
}