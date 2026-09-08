<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Project;

class CustomerProjectController extends Controller
{
    /**
     * =========================================================
     * SHOW CUSTOMER PROJECT DETAILS
     * =========================================================
     */
    public function show(Project $project)
    {
        /*
        |--------------------------------------------------------------------------
        | LOGGED-IN CUSTOMER
        |--------------------------------------------------------------------------
        */

        $customerUserId = session(
            'customer_user_id'
        );


        /*
        |--------------------------------------------------------------------------
        | LOAD PROJECT RELATIONSHIPS
        |--------------------------------------------------------------------------
        */

        $project->load([

            'client',

            'budget',

            'payments',

            'progressReports',

            'projectMaterials.material',

        ]);


        /*
        |--------------------------------------------------------------------------
        | SECURITY CHECK
        |--------------------------------------------------------------------------
        |
        | Customer can only view his/her own project.
        |
        */

        if (
            !$project->client ||
            $project->client->user_id !== $customerUserId
        ) {

            abort(
                403,
                'Unauthorized access.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CONTRACT AMOUNT
        |--------------------------------------------------------------------------
        */

        $contractAmount = $project->budget
            ? (float) (
                $project->budget->contract_amount ?? 0
            )
            : 0;


        /*
        |--------------------------------------------------------------------------
        | TOTAL MILESTONE AMOUNT
        |--------------------------------------------------------------------------
        |
        | Total of all payment/milestone amounts.
        |
        */

        $totalMilestoneAmount = (float) $project
            ->payments
            ->sum(
                'amount'
            );


        /*
        |--------------------------------------------------------------------------
        | TOTAL PAID AMOUNT
        |--------------------------------------------------------------------------
        |
        | Only payments with status = paid
        | are counted as received payment.
        |
        */

        $totalPaidAmount = (float) $project
            ->payments
            ->where(
                'status',
                'paid'
            )
            ->sum(
                'amount'
            );


        /*
        |--------------------------------------------------------------------------
        | BLADE COMPATIBILITY
        |--------------------------------------------------------------------------
        */

        $totalPaid = $totalPaidAmount;


        /*
        |--------------------------------------------------------------------------
        | REMAINING / DUE AMOUNT
        |--------------------------------------------------------------------------
        */

        $remainingAmount = max(

            $contractAmount
            -
            $totalPaidAmount,

            0

        );


        /*
        |--------------------------------------------------------------------------
        | BLADE COMPATIBILITY
        |--------------------------------------------------------------------------
        */

        $totalDueAmount = $remainingAmount;


        /*
        |--------------------------------------------------------------------------
        | UNPAID MILESTONE AMOUNT
        |--------------------------------------------------------------------------
        |
        | All milestones except paid.
        |
        */

        $unpaidMilestoneAmount = (float) $project
            ->payments
            ->where(
                'status',
                '!=',
                'paid'
            )
            ->sum(
                'amount'
            );


        /*
        |--------------------------------------------------------------------------
        | PAYMENT STATUS
        |--------------------------------------------------------------------------
        */

        if (!$project->budget) {

            $paymentStatus = 'No Budget';

        }
        elseif ($contractAmount <= 0) {

            $paymentStatus = 'No Contract';

        }
        elseif ($totalPaidAmount >= $contractAmount) {

            $paymentStatus = 'Fully Paid';

        }
        elseif ($totalPaidAmount > 0) {

            $paymentStatus = 'Partially Paid';

        }
        else {

            $paymentStatus = 'Payment Due';

        }


        /*
        |--------------------------------------------------------------------------
        | PAYMENT PROGRESS
        |--------------------------------------------------------------------------
        */

        if ($contractAmount > 0) {

            $paymentProgress = (
                $totalPaidAmount
                /
                $contractAmount
            ) * 100;

        }
        else {

            $paymentProgress = 0;

        }


        /*
        |--------------------------------------------------------------------------
        | LIMIT PAYMENT PROGRESS
        |--------------------------------------------------------------------------
        */

        $paymentProgress = max(

            0,

            min(

                (float) $paymentProgress,

                100

            )

        );


        /*
        |--------------------------------------------------------------------------
        | PROGRESS REPORTS
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        |
        | Actual database column:
        |
        | progress_percent
        |
        | NOT:
        |
        | progress_percentage
        |
        |
        | This variable is passed to Blade so customer can
        | see the same work progress data as admin.
        |
        */

        $progressReports = $project
            ->progressReports
            ->sortByDesc(
                'updated_at'
            )
            ->values();


        /*
        |--------------------------------------------------------------------------
        | PROJECT PROGRESS
        |--------------------------------------------------------------------------
        |
        | Existing project logic is preserved.
        |
        | Overall progress =
        | Sum of all progress report progress_percent.
        |
        */

        $overallProgress = (float) $progressReports
            ->sum(
                'progress_percent'
            );


        /*
        |--------------------------------------------------------------------------
        | LIMIT PROJECT PROGRESS
        |--------------------------------------------------------------------------
        */

        $overallProgress = max(

            0,

            min(

                $overallProgress,

                100

            )

        );


        /*
        |--------------------------------------------------------------------------
        | PAYMENT MILESTONE COUNTS
        |--------------------------------------------------------------------------
        */

        $totalMilestones = $project
            ->payments
            ->count();


        $paidMilestones = $project
            ->payments
            ->where(
                'status',
                'paid'
            )
            ->count();


        $pendingMilestones = $project
            ->payments
            ->where(
                'status',
                'pending'
            )
            ->count();


        $upcomingMilestones = $project
            ->payments
            ->where(
                'status',
                'upcoming'
            )
            ->count();


        $overdueMilestones = $project
            ->payments
            ->where(
                'status',
                'overdue'
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL PROJECT MATERIALS
        |--------------------------------------------------------------------------
        */

        $totalProjectMaterials = $project
            ->projectMaterials
            ->count();


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        |
        | All old variables are preserved.
        | New progressReports variable is added.
        |
        */

        return view(

            'frontend.customer.project.show',

            compact(

                'project',

                /*
                |----------------------------------------------
                | PAYMENT / FINANCIAL
                |----------------------------------------------
                */

                'contractAmount',

                'totalMilestoneAmount',

                'totalPaidAmount',

                'totalPaid',

                'remainingAmount',

                'totalDueAmount',

                'unpaidMilestoneAmount',

                'paymentStatus',

                'paymentProgress',


                /*
                |----------------------------------------------
                | PAYMENT MILESTONE COUNTS
                |----------------------------------------------
                */

                'totalMilestones',

                'paidMilestones',

                'pendingMilestones',

                'upcomingMilestones',

                'overdueMilestones',


                /*
                |----------------------------------------------
                | PROJECT PROGRESS
                |----------------------------------------------
                */

                'progressReports',

                'overallProgress',


                /*
                |----------------------------------------------
                | MATERIALS
                |----------------------------------------------
                */

                'totalProjectMaterials'

            )

        );
    }


    /**
     * =========================================================
     * PAUSE PROJECT
     * =========================================================
     */
    public function pause(Project $project)
    {
        /*
        |--------------------------------------------------------------------------
        | LOGGED-IN CUSTOMER
        |--------------------------------------------------------------------------
        */

        $customerUserId = session(
            'customer_user_id'
        );


        /*
        |--------------------------------------------------------------------------
        | LOAD CLIENT
        |--------------------------------------------------------------------------
        */

        $project->load(
            'client'
        );


        /*
        |--------------------------------------------------------------------------
        | SECURITY CHECK
        |--------------------------------------------------------------------------
        */

        if (
            !$project->client ||
            $project->client->user_id !== $customerUserId
        ) {

            abort(
                403,
                'Unauthorized access.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | ONLY APPROVED + ONGOING PROJECT
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
        | PAUSE PROJECT
        |--------------------------------------------------------------------------
        */

        $project->update([

            'status' => 'on-hold',

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
        /*
        |--------------------------------------------------------------------------
        | LOGGED-IN CUSTOMER
        |--------------------------------------------------------------------------
        */

        $customerUserId = session(
            'customer_user_id'
        );


        /*
        |--------------------------------------------------------------------------
        | LOAD CLIENT
        |--------------------------------------------------------------------------
        */

        $project->load(
            'client'
        );


        /*
        |--------------------------------------------------------------------------
        | SECURITY CHECK
        |--------------------------------------------------------------------------
        */

        if (
            !$project->client ||
            $project->client->user_id !== $customerUserId
        ) {

            abort(
                403,
                'Unauthorized access.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | ONLY APPROVED + PAUSED PROJECT
        |--------------------------------------------------------------------------
        */

        if (
            $project->approval_status !== 'approved' ||
            $project->status !== 'on-hold'
        ) {

            return back()->with(
                'error',
                'Only an approved paused project can be resumed.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | RESUME PROJECT
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
    public function cancel(Project $project)
    {
        /*
        |--------------------------------------------------------------------------
        | LOGGED-IN CUSTOMER
        |--------------------------------------------------------------------------
        */

        $customerUserId = session(
            'customer_user_id'
        );


        /*
        |--------------------------------------------------------------------------
        | LOAD CLIENT
        |--------------------------------------------------------------------------
        */

        $project->load(
            'client'
        );


        /*
        |--------------------------------------------------------------------------
        | SECURITY CHECK
        |--------------------------------------------------------------------------
        */

        if (
            !$project->client ||
            $project->client->user_id !== $customerUserId
        ) {

            abort(
                403,
                'Unauthorized access.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | ALREADY CANCELLED CHECK
        |--------------------------------------------------------------------------
        */

        if (
            in_array(

                $project->status,

                [

                    'cancelled',

                    'canceled',

                ]

            )
        ) {

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

        if (
            $project->status === 'completed'
        ) {

            return back()->with(
                'error',
                'Completed projects cannot be cancelled.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CANCEL PROJECT
        |--------------------------------------------------------------------------
        */

        $project->update([

            'status' => 'cancelled',

        ]);


        return redirect()
            ->route(
                'customer.dashboard'
            )
            ->with(
                'success',
                'Project cancelled successfully.'
            );
    }
}