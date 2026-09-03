<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectRequestController extends Controller
{
    /**
     * Show all pending project requests
     */
    public function index()
    {
        $projects = Project::with('client')
            ->where('approval_status', 'pending')
            ->latest()
            ->get();

        return view('backend.project-requests.index', compact('projects'));
    }


    /**
     * Show project request details
     */
    public function show(Project $project)
    {
        $project->load('client');

        return view(
            'backend.project-requests.show',
            compact('project')
        );
    }


    /**
     * Approve project request
     */
    public function approve(Request $request, Project $project)
    {
        // Only pending requests can be approved
        if ($project->approval_status !== 'pending') {
            return back()->withErrors([
                'project' => 'This project request has already been processed.',
            ]);
        }

        // Currently logged-in Admin
        $adminUserId = $request->session()->get('admin_user_id');

        $project->update([
            'user_id' => $adminUserId,
            'approval_status' => 'approved',
            'status' => 'ongoing',
        ]);

        return redirect()
            ->route('admin.project-requests.index')
            ->with(
                'success',
                'Project request approved successfully.'
            );
    }

    /**
     * Reject project request
     */
    public function reject(Request $request, Project $project)
    {
        // Only pending requests can be rejected
        if ($project->approval_status !== 'pending') {
            return back()->withErrors([
                'project' => 'This project request has already been processed.',
            ]);
        }

        $project->update([
            'approval_status' => 'rejected',
        ]);

        return redirect()
            ->route('admin.project-requests.index')
            ->with(
                'success',
                'Project request rejected successfully.'
            );
    }
}
