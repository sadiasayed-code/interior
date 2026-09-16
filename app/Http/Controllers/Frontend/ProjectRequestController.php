<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Request;

class ProjectRequestController extends Controller
{
    /**
     * Show project request form
     */
    public function create(Request $request)
    {
        $customerUserId = session('customer_user_id');

        $client = Client::where('user_id', $customerUserId)->first();

        if (!$client) {
            return redirect()
                ->route('customer.dashboard')
                ->withErrors([
                    'customer' => 'Customer profile was not found.'
                ]);
        }

        // Load only active services
        $services = Service::where('status', 'active')
            ->orderBy('name')
            ->get();

        // If request comes from a specific service page,
        // pre-select that service.
        $selectedService = null;

        if ($request->filled('service')) {
            $selectedService = Service::where('slug', $request->service)
                ->where('status', 'active')
                ->first();
        }

        return view(
            'frontend.customer.project-request.create',
            compact('client', 'services', 'selectedService')
        );
    }


    /**
     * Store new project request
     */
    public function store(Request $request)
    {
        $customerUserId = session('customer_user_id');

        $client = Client::where('user_id', $customerUserId)->first();

        if (!$client) {
            return redirect()
                ->route('customer.dashboard')
                ->withErrors([
                    'customer' => 'Customer profile was not found.'
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Validate Request
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'service_id' => [
                'required',
                'integer',
                'exists:services,id',
            ],

           

            'location' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'approximate_budget' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'customer_note' => [
                'nullable',
                'string',
            ],

            'start_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Make Sure Selected Service Is Active
        |--------------------------------------------------------------------------
        */

        $service = Service::where('id', $validated['service_id'])
            ->where('status', 'active')
            ->first();

        if (!$service) {
            return back()
                ->withInput()
                ->withErrors([
                    'service_id' => 'The selected service is not available.'
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Create Project Request
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        | We do NOT set user_id here.
        |
        | user_id is reserved for the admin who will handle/review
        | the project later.
        |
        */

        Project::create([
            'client_id' => $client->id,
            'service_id' => $service->id,

            
            'location' => $validated['location'],

            'description' => $validated['description'] ?? null,

            'approximate_budget' =>
                $validated['approximate_budget'] ?? null,

            'customer_note' =>
                $validated['customer_note'] ?? null,

            'start_date' =>
                $validated['start_date'] ?? null,

            'end_date' =>
                $validated['end_date'] ?? null,

            // Initial request state
            'approval_status' => 'pending',
            'status' => 'request_pending',

            'customer_approved_at' => null,
            'customer_rejected_at' => null,
            'cancelled_at' => null,
            'cancellation_reason' => null,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Redirect Customer Dashboard
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('customer.dashboard')
            ->with(
                'success',
                'Your project request has been submitted successfully. The admin will review your request.'
            );
    }
}