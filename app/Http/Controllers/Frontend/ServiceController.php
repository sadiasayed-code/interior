<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceController extends Controller
{
    /**
     * Display all active services.
     */
    public function index()
    {
        $services = Service::query()
            ->where('status', 'active')
            ->latest()
            ->get();

        return view('frontend.services.index', compact('services'));
    }


    /**
     * Display a single active service.
     */
    public function show(Service $service)
    {
        /*
        |--------------------------------------------------------------------------
        | Customers should not be able to view inactive services
        |--------------------------------------------------------------------------
        */

        if ($service->status !== 'active') {
            abort(404);
        }

        return view('frontend.services.show', compact('service'));
    }
}