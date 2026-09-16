<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Request;

class CustomerProjectController extends Controller
{
    /**
     * =========================================================
     * SHOW CUSTOMER PROJECT DETAILS
     * =========================================================
     */
    public function show(Project $project)
    {
        $this->authorizeCustomerProject($project);

        $project->load([
            'client',
            'service',
            'budget',
            'payments',
            'progressReports',
            'projectMaterials.material',
            'projectSteps',
        ]);

        /*
        |--------------------------------------------------------------------------
        | CUSTOMER-SAFE CONTRACT AMOUNT
        |--------------------------------------------------------------------------
        */

        $contractAmount = $project->budget
            ? (float) ($project->budget->contract_amount ?? 0)
            : 0;


        /*
        |--------------------------------------------------------------------------
        | PAYMENT SUMMARY
        |--------------------------------------------------------------------------
        */

        $totalMilestoneAmount = (float) $project->payments
            ->sum('amount');

        $totalPaidAmount = (float) $project->payments
            ->where('status', 'paid')
            ->sum('amount');

        $totalPaid = $totalPaidAmount;

        $remainingAmount = max(
            $contractAmount - $totalPaidAmount,
            0
        );

        $totalDueAmount = $remainingAmount;

        $unpaidMilestoneAmount = (float) $project->payments
            ->where('status', '!=', 'paid')
            ->sum('amount');


        /*
        |--------------------------------------------------------------------------
        | PAYMENT STATUS
        |--------------------------------------------------------------------------
        */

        if (!$project->budget) {

            $paymentStatus = 'No Budget';

        } elseif ($contractAmount <= 0) {

            $paymentStatus = 'No Contract';

        } elseif ($totalPaidAmount >= $contractAmount) {

            $paymentStatus = 'Fully Paid';

        } elseif ($totalPaidAmount > 0) {

            $paymentStatus = 'Partially Paid';

        } else {

            $paymentStatus = 'Payment Due';
        }


        /*
        |--------------------------------------------------------------------------
        | PAYMENT PROGRESS
        |--------------------------------------------------------------------------
        */

        $paymentProgress = $contractAmount > 0
            ? ($totalPaidAmount / $contractAmount) * 100
            : 0;

        $paymentProgress = max(
            0,
            min((float) $paymentProgress, 100)
        );


        /*
        |--------------------------------------------------------------------------
        | WORK PROGRESS
        |--------------------------------------------------------------------------
        */

        $progressReports = $project->progressReports
            ->sortByDesc('updated_at')
            ->values();

        $overallProgress = (float) $progressReports
            ->sum('progress_percent');

        $overallProgress = max(
            0,
            min($overallProgress, 100)
        );


        /*
        |--------------------------------------------------------------------------
        | PAYMENT MILESTONES
        |--------------------------------------------------------------------------
        */

        $totalMilestones = $project->payments->count();

        $paidMilestones = $project->payments
            ->where('status', 'paid')
            ->count();

        $pendingMilestones = $project->payments
            ->where('status', 'pending')
            ->count();

        $upcomingMilestones = $project->payments
            ->where('status', 'upcoming')
            ->count();

        $overdueMilestones = $project->payments
            ->where('status', 'overdue')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | PROJECT MATERIAL COUNT
        |--------------------------------------------------------------------------
        */

        $totalProjectMaterials = $project->projectMaterials
            ->count();


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'frontend.customer.project.show',
            compact(
                'project',

                'contractAmount',
                'totalMilestoneAmount',
                'totalPaidAmount',
                'totalPaid',
                'remainingAmount',
                'totalDueAmount',
                'unpaidMilestoneAmount',
                'paymentStatus',
                'paymentProgress',

                'totalMilestones',
                'paidMilestones',
                'pendingMilestones',
                'upcomingMilestones',
                'overdueMilestones',

                'progressReports',
                'overallProgress',

                'totalProjectMaterials'
            )
        );
    }


    /**
     * =========================================================
     * EDIT PROJECT REQUEST
     * =========================================================
     */
    public function edit(Project $project)
    {
        $this->authorizeCustomerProject($project);

        /*
        |--------------------------------------------------------------------------
        | ONLY REQUEST-PENDING PROJECT CAN BE EDITED
        |--------------------------------------------------------------------------
        */

        if ($project->status !== 'request_pending') {
            return redirect()
                ->route('customer.project.show', $project)
                ->with(
                    'error',
                    'This project request can no longer be edited.'
                );
        }

        $services = Service::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view(
            'frontend.customer.project.edit',
            compact(
                'project',
                'services'
            )
        );
    }


    /**
     * =========================================================
     * UPDATE PROJECT REQUEST
     * =========================================================
     */
    public function update(
        Request $request,
        Project $project
    ) {
        $this->authorizeCustomerProject($project);

        /*
        |--------------------------------------------------------------------------
        | ONLY REQUEST-PENDING PROJECT CAN BE UPDATED
        |--------------------------------------------------------------------------
        */

        if ($project->status !== 'request_pending') {
            return redirect()
                ->route('customer.project.show', $project)
                ->with(
                    'error',
                    'This project request can no longer be updated.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDATION
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
        | ACTIVE SERVICE CHECK
        |--------------------------------------------------------------------------
        */

        $service = Service::where(
            'id',
            $validated['service_id']
        )
        ->where(
            'status',
            'active'
        )
        ->first();

        if (!$service) {
            return back()
                ->withInput()
                ->withErrors([
                    'service_id' =>
                        'The selected service is not available.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */

        $project->update([

            'service_id' => $service->id,

            'project_name' => $service->name,

            'location' =>
                $validated['location'],

            'description' =>
                $validated['description'] ?? null,

            'approximate_budget' =>
                $validated['approximate_budget'] ?? null,

            'customer_note' =>
                $validated['customer_note'] ?? null,

            'start_date' =>
                $validated['start_date'] ?? null,

            'end_date' =>
                $validated['end_date'] ?? null,
        ]);


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'customer.project.show',
                $project
            )
            ->with(
                'success',
                'Project request updated successfully.'
            );
    }


    /**
     * =========================================================
     * APPROVE ADMIN PROPOSAL
     * =========================================================
     */
    public function approve(Project $project)
    {
        $this->authorizeCustomerProject($project);


        /*
        |--------------------------------------------------------------------------
        | PROPOSAL MUST BE SENT
        |--------------------------------------------------------------------------
        */

        if ($project->status !== 'proposal_sent') {
            return back()->with(
                'error',
                'This project does not have an active proposal for approval.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | APPROVE
        |--------------------------------------------------------------------------
        */

        $project->update([

            'approval_status' => 'approved',

            'status' => 'ongoing',

            'customer_approved_at' => now(),

            'customer_rejected_at' => null,
        ]);


        return redirect()
            ->route(
                'customer.project.show',
                $project
            )
            ->with(
                'success',
                'Project proposal approved successfully. Your project is now ongoing.'
            );
    }


    /**
     * =========================================================
     * REJECT ADMIN PROPOSAL
     * =========================================================
     */
    public function reject(Project $project)
    {
        $this->authorizeCustomerProject($project);


        /*
        |--------------------------------------------------------------------------
        | PROPOSAL MUST BE SENT
        |--------------------------------------------------------------------------
        */

        if ($project->status !== 'proposal_sent') {
            return back()->with(
                'error',
                'This project does not have an active proposal to reject.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | REJECT
        |--------------------------------------------------------------------------
        */

        $project->update([

            'approval_status' => 'rejected',

            'status' => 'customer_rejected',

            'customer_rejected_at' => now(),

            'customer_approved_at' => null,
        ]);


        return redirect()
            ->route(
                'customer.dashboard'
            )
            ->with(
                'success',
                'Project proposal rejected successfully.'
            );
    }


    /**
     * =========================================================
     * PAUSE PROJECT
     * =========================================================
     */
    public function pause(Project $project)
    {
        $this->authorizeCustomerProject($project);


        /*
        |--------------------------------------------------------------------------
        | ONLY APPROVED ONGOING PROJECT
        |--------------------------------------------------------------------------
        */

        if (
            $project->approval_status !== 'approved' ||
            $project->status !== 'ongoing'
        ) {
            return back()->with(
                'error',
                'Only an approved ongoing project can be paused.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | PAUSE
        |--------------------------------------------------------------------------
        */

        $project->update([
            'status' => 'paused',
        ]);


        return back()->with(
            'success',
            'Project paused successfully.'
        );
    }


    /**
     * =========================================================
     * RESUME PROJECT
     * =========================================================
     */
    public function resume(Project $project)
    {
        $this->authorizeCustomerProject($project);


        /*
        |--------------------------------------------------------------------------
        | ONLY APPROVED PAUSED PROJECT
        |--------------------------------------------------------------------------
        */

        if (
            $project->approval_status !== 'approved' ||
            $project->status !== 'paused'
        ) {
            return back()->with(
                'error',
                'Only an approved paused project can be resumed.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | RESUME
        |--------------------------------------------------------------------------
        */

        $project->update([
            'status' => 'ongoing',
        ]);


        return back()->with(
            'success',
            'Project resumed successfully.'
        );
    }


    /**
     * =========================================================
     * CANCEL PROJECT
     * =========================================================
     */
    public function cancel(
        Request $request,
        Project $project
    ) {
        $this->authorizeCustomerProject($project);


        /*
        |--------------------------------------------------------------------------
        | ALREADY CANCELLED
        |--------------------------------------------------------------------------
        */

        if ($project->status === 'cancelled') {
            return back()->with(
                'error',
                'This project has already been cancelled.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | COMPLETED PROJECT CANNOT BE CANCELLED
        |--------------------------------------------------------------------------
        */

        if ($project->status === 'completed') {
            return back()->with(
                'error',
                'Completed projects cannot be cancelled.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDATE CANCELLATION REASON
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'cancellation_reason' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | CANCEL
        |--------------------------------------------------------------------------
        */

        $project->update([

            'status' => 'cancelled',

            'cancelled_at' => now(),

            'cancellation_reason' =>
                $validated['cancellation_reason'] ?? null,
        ]);


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'customer.dashboard'
            )
            ->with(
                'success',
                'Project cancelled successfully.'
            );
    }


    /**
     * =========================================================
     * CUSTOMER PROJECT AUTHORIZATION
     * =========================================================
     *
     * Customer can only access his/her own project.
     */
    private function authorizeCustomerProject(
        Project $project
    ): void {
        $customerUserId = session(
            'customer_user_id'
        );

        $project->loadMissing(
            'client'
        );

        if (
            !$project->client ||
            (int) $project->client->user_id !==
            (int) $customerUserId
        ) {
            abort(
                403,
                'Unauthorized access.'
            );
        }
    }
}