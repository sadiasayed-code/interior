<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectRequestController extends Controller
{
    /**
     * Show New Project Request Form
     */
    public function create()
    {
        $customerUserId = session('customer_user_id');

        $client = Client::where('user_id', $customerUserId)
            ->firstOrFail();

        return view('frontend.customer.project-request.create', compact('client'));
    }


    /**
     * Store New Project Request
     */
    public function store(Request $request)
    {
        $customerUserId = session('customer_user_id');

        $client = Client::where('user_id', $customerUserId)
            ->firstOrFail();

        $validated = $request->validate([
            'project_name' => 'required|string|max:255',

            'location' => 'required|string|max:500',

            'start_date' => 'required|date',

            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        Project::create([
            'client_id' => $client->id,

            
            'user_id' => null,

            'project_name' => $validated['project_name'],

            'location' => $validated['location'],

            'start_date' => $validated['start_date'],

            'end_date' => $validated['end_date'] ?? null,

            // Admin approval-
            'approval_status' => 'pending',

            // Project 
            'status' => 'pending',
        ]);

        return redirect()
            ->route('customer.dashboard')
            ->with(
                'success',
                'Project request submitted successfully. Please wait for admin approval.'
            );
    }
}