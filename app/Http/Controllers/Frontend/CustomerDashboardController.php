<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Client;
use App\Models\Project;

class CustomerDashboardController extends Controller
{
    /**
     * =========================================================
     * CUSTOMER DASHBOARD
     * =========================================================
     */
    public function index()
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
        | CUSTOMER USER
        |--------------------------------------------------------------------------
        */

        $user = User::findOrFail(
            $customerUserId
        );


        /*
        |--------------------------------------------------------------------------
        | CUSTOMER PROFILE
        |--------------------------------------------------------------------------
        */

        $client = Client::where(
            'user_id',
            $customerUserId
        )->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | LOAD CUSTOMER PROJECTS
        |--------------------------------------------------------------------------
        */

        $projects = Project::with([

            'client',

            'budget',

            'payments',

            'progressReports',

        ])
        ->where(
            'client_id',
            $client->id
        )
        ->latest()
        ->get();


        /*
        |--------------------------------------------------------------------------
        | PROJECT STATISTICS
        |--------------------------------------------------------------------------
        */

        $totalProjects = $projects->count();


        $pendingProjects = $projects
            ->where(
                'approval_status',
                'pending'
            )
            ->count();


        $ongoingProjects = $projects
            ->where(
                'status',
                'ongoing'
            )
            ->count();


        $completedProjects = $projects
            ->where(
                'status',
                'completed'
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | CANCELLED PROJECTS
        |--------------------------------------------------------------------------
        */

        $cancelledProjects = $projects
            ->filter(
                function ($project) {

                    return in_array(
                        $project->status,
                        [
                            'cancelled',
                            'canceled',
                        ]
                    );

                }
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | PAUSED / ON-HOLD PROJECTS
        |--------------------------------------------------------------------------
        */

        $pausedProjects = $projects
            ->filter(
                function ($project) {

                    return in_array(
                        $project->status,
                        [
                            'paused',
                            'on-hold',
                        ]
                    );

                }
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | GLOBAL FINANCIAL TOTALS
        |--------------------------------------------------------------------------
        */

        $totalContractAmount = 0;

        $totalPaidAmount = 0;

        $totalDueAmount = 0;


        /*
        |--------------------------------------------------------------------------
        | CALCULATE EACH PROJECT
        |--------------------------------------------------------------------------
        */

        foreach ($projects as $project) {


            /*
            |--------------------------------------------------------------------------
            | CONTRACT AMOUNT
            |--------------------------------------------------------------------------
            */

            $contractAmount = $project->budget
                ? (float) $project->budget->contract_amount
                : 0;


            /*
            |--------------------------------------------------------------------------
            | TOTAL PAID
            |--------------------------------------------------------------------------
            */

            $totalPaid = (float) $project
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
            | TOTAL DUE
            |--------------------------------------------------------------------------
            */

            $totalDue = max(
                $contractAmount - $totalPaid,
                0
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
            elseif ($totalPaid >= $contractAmount) {

                $paymentStatus = 'Fully Paid';

            }
            elseif ($totalPaid > 0) {

                $paymentStatus = 'Partially Paid';

            }
            else {

                $paymentStatus = 'Payment Due';

            }


            /*
            |--------------------------------------------------------------------------
            | OVERALL PROJECT PROGRESS
            |--------------------------------------------------------------------------
            |
            | IMPORTANT:
            |
            | Database column is:
            |
            | progress_percent
            |
            | NOT:
            |
            | progress_percentage
            |
            */

            $overallProgress = (float) $project
                ->progressReports
                ->sum(
                    'progress_percent'
                );


            /*
            |--------------------------------------------------------------------------
            | LIMIT PROGRESS 0 - 100
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
            | ADD CALCULATED DATA TO PROJECT
            |--------------------------------------------------------------------------
            */

            $project->contractAmount = $contractAmount;

            $project->totalPaid = $totalPaid;

            $project->totalDue = $totalDue;

            $project->paymentStatus = $paymentStatus;

            $project->overallProgress = $overallProgress;


            /*
            |--------------------------------------------------------------------------
            | ADD TO GLOBAL TOTALS
            |--------------------------------------------------------------------------
            */

            $totalContractAmount +=
                $contractAmount;


            $totalPaidAmount +=
                $totalPaid;


            $totalDueAmount +=
                $totalDue;

        }


        /*
        |--------------------------------------------------------------------------
        | RETURN DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view(

            'frontend.customer.dashboard',

            compact(

                'user',

                'client',

                'projects',

                'totalProjects',

                'pendingProjects',

                'ongoingProjects',

                'completedProjects',

                'cancelledProjects',

                'pausedProjects',

                'totalContractAmount',

                'totalPaidAmount',

                'totalDueAmount'

            )

        );
    }
}