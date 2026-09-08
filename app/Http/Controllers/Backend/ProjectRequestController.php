<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectRequestController extends Controller
{
    /**
     * =========================================================
     * SHOW ALL ACTIVE PENDING PROJECT REQUESTS
     * =========================================================
     *
     * Cancelled projects will NOT appear here.
     *
     * Only projects where:
     *
     * approval_status = pending
     * AND
     * status != cancelled
     *
     * will be shown to Admin.
     *
     */
    public function index()
    {
        $projects = Project::with('client')
            ->where('approval_status', 'pending')
            ->where('status', '!=', 'cancelled')
            ->latest()
            ->get();

        return view(
            'backend.project-requests.index',
            compact('projects')
        );
    }


    /**
     * =========================================================
     * SHOW PROJECT REQUEST DETAILS
     * =========================================================
     *
     * Cancelled projects cannot be opened as an active request.
     *
     */
    public function show(Project $project)
    {
        /*
        |----------------------------------------------------------
        | SECURITY / LOGICAL VALIDATION
        |----------------------------------------------------------
        |
        | Only active pending requests can be viewed.
        |
        */

        if (
            $project->approval_status !== 'pending'
            ||
            $project->status === 'cancelled'
        ) {

            return redirect()
                ->route('admin.project-requests.index')
                ->withErrors([
                    'project' =>
                        'This project request is no longer available for processing.',
                ]);
        }


        /*
        |----------------------------------------------------------
        | LOAD CLIENT
        |----------------------------------------------------------
        */

        $project->load(
            'client'
        );


        /*
        |----------------------------------------------------------
        | RETURN VIEW
        |----------------------------------------------------------
        */

        return view(
            'backend.project-requests.show',
            compact('project')
        );
    }


    /**
     * =========================================================
     * APPROVE PROJECT REQUEST
     * =========================================================
     *
     * Only active pending projects can be approved.
     *
     * Cancelled projects can NEVER be approved.
     *
     */
    public function approve(
        Request $request,
        Project $project
    ) {

        /*
        |----------------------------------------------------------
        | VALIDATE PROJECT STATE
        |----------------------------------------------------------
        */

        if (
            $project->approval_status !== 'pending'
            ||
            $project->status === 'cancelled'
        ) {

            return redirect()
                ->route('admin.project-requests.index')
                ->withErrors([
                    'project' =>
                        'This project request cannot be approved because it has already been cancelled or processed.',
                ]);
        }


        /*
        |----------------------------------------------------------
        | CURRENT ADMIN ID
        |----------------------------------------------------------
        */

        $adminUserId = $request
            ->session()
            ->get(
                'admin_user_id'
            );


        /*
        |----------------------------------------------------------
        | ADMIN SESSION VALIDATION
        |----------------------------------------------------------
        */

        if (!$adminUserId) {

            return redirect()
                ->route('login')
                ->withErrors([
                    'admin' =>
                        'Admin session not found. Please login again.',
                ]);
        }


        /*
        |----------------------------------------------------------
        | APPROVE PROJECT
        |----------------------------------------------------------
        */

        $project->update([

            /*
            | Admin responsible for this project
            */

            'user_id' =>
                $adminUserId,


            /*
            | Request approved
            */

            'approval_status' =>
                'approved',


            /*
            | Project starts as ongoing
            */

            'status' =>
                'ongoing',

        ]);


        /*
        |----------------------------------------------------------
        | REDIRECT
        |----------------------------------------------------------
        */

        return redirect()
            ->route(
                'admin.project-requests.index'
            )
            ->with(
                'success',
                'Project request approved successfully.'
            );
    }


    /**
     * =========================================================
     * REJECT PROJECT REQUEST
     * =========================================================
     *
     * Only active pending projects can be rejected.
     *
     * Cancelled projects cannot be processed again.
     *
     */
    public function reject(
        Request $request,
        Project $project
    ) {

        /*
        |----------------------------------------------------------
        | VALIDATE PROJECT STATE
        |----------------------------------------------------------
        */

        if (
            $project->approval_status !== 'pending'
            ||
            $project->status === 'cancelled'
        ) {

            return redirect()
                ->route('admin.project-requests.index')
                ->withErrors([
                    'project' =>
                        'This project request has already been cancelled or processed.',
                ]);
        }


        /*
        |----------------------------------------------------------
        | REJECT PROJECT REQUEST
        |----------------------------------------------------------
        */

        $project->update([

            'approval_status' =>
                'rejected',

        ]);


        /*
        |----------------------------------------------------------
        | REDIRECT
        |----------------------------------------------------------
        */

        return redirect()
            ->route(
                'admin.project-requests.index'
            )
            ->with(
                'success',
                'Project request rejected successfully.'
            );
    }
}