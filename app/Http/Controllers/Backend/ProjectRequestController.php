<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Project;

class ProjectRequestController extends Controller
{
    /**
     * =========================================================
     * PROJECT REQUESTS INDEX
     * =========================================================
     *
     * Show customer requests waiting for admin action.
     *
     * Included statuses:
     *
     * request_pending
     * admin_review
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | TOTAL REQUESTS
        |--------------------------------------------------------------------------
        |
        | Total customer requests currently in the request queue.
        |
        */

        $totalRequests = Project::whereIn('status', [
            'request_pending',
            'admin_review',
        ])->count();


        /*
        |--------------------------------------------------------------------------
        | UNDER REVIEW
        |--------------------------------------------------------------------------
        */

        $underReview = Project::where(
            'status',
            'admin_review'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | PROJECT REQUEST LIST
        |--------------------------------------------------------------------------
        |
        | Load customer + service information.
        |
        */

        $projects = Project::with([
            'client.user',
            'service',
        ])
            ->whereIn('status', [
                'request_pending',
                'admin_review',
            ])
            ->latest()
            ->get();


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'backend.project-requests.index',
            compact(
                'projects',
                'totalRequests',
                'underReview'
            )
        );
    }


    /**
     * =========================================================
     * SHOW PROJECT REQUEST
     * =========================================================
     *
     * Show complete details of a project request.
     */
    public function show(Project $project)
    {
        /*
        |--------------------------------------------------------------------------
        | LOAD REQUIRED RELATIONSHIPS
        |--------------------------------------------------------------------------
        */

        $project->load([
            'client.user',
            'service',
            'budget',
            'payments',
            'projectSteps',
            'progressReports',
            'projectMaterials.material',
        ]);


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'backend.project-requests.show',
            compact('project')
        );
    }


    /**
     * =========================================================
     * START ADMIN REVIEW
     * =========================================================
     *
     * Change:
     *
     * request_pending
     *        ↓
     * admin_review
     *
     */
    public function review(Project $project)
    {
        /*
        |--------------------------------------------------------------------------
        | ONLY PENDING REQUEST CAN START REVIEW
        |--------------------------------------------------------------------------
        */

        if ($project->status !== 'request_pending') {

            return back()->with(
                'error',
                'Only pending project requests can be moved to admin review.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE PROJECT STATUS
        |--------------------------------------------------------------------------
        */

        $project->update([
            'status' => 'admin_review',
        ]);


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'admin.project-requests.show',
                $project
            )
            ->with(
                'success',
                'Project request moved to admin review.'
            );
    }
}