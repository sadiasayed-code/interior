<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Project;

class CustomerProjectController extends Controller
{
    /**
     * Show customer's project details
     */
    public function show(Project $project)
    {
        $customerUserId = session('customer_user_id');

        // Security:
        // Customer can only view their own project.
        if ($project->client?->user_id !== $customerUserId) {
            abort(403, 'Unauthorized access.');
        }

        $project->load([
            'client',
            'budget',
            'payments',
            'progressReports',
            'projectMaterials.material',
        ]);

        return view(
            'frontend.customer.project.show',
            compact('project')
        );
    }
}