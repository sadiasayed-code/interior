<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\PreviousWork;

class HomeController extends Controller
{
    public function mainPage()
    {
        $services = Service::query()
            ->where('status', 'active')
            ->latest()
            ->get();

        $previousWorks = PreviousWork::query()
            ->where('status', 'active')
            ->with([
                'images' => function ($query) {
                    $query->orderBy('sort_order');
                }
            ])
            ->latest()
            ->get();

        return view(
            'frontend.home',
            compact(
                'services',
                'previousWorks'
            )
        );
    }
}