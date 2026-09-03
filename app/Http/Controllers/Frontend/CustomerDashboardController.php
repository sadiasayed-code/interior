<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Client;
use App\Models\Project;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        // Logged-in customer ID
        $customerUserId = session('customer_user_id');

        // Customer user
        $user = User::findOrFail($customerUserId);

        // Customer profile
        $client = Client::where('user_id', $customerUserId)->firstOrFail();

        // IMPORTANT:
        // Customer's projects are connected through client_id
        $projects = Project::where('client_id', $client->id)
            ->latest()
            ->get();

        // Project statistics
        $totalProjects = $projects->count();

        $pendingProjects = $projects
            ->where('approval_status', 'pending')
            ->count();

        $ongoingProjects = $projects
            ->where('status', 'ongoing')
            ->count();

        $completedProjects = $projects
            ->where('status', 'completed')
            ->count();

        return view('frontend.customer.dashboard', compact(
            'user',
            'client',
            'projects',
            'totalProjects',
            'pendingProjects',
            'ongoingProjects',
            'completedProjects'
        ));
    }
}