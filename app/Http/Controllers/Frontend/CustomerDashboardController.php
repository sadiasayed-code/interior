<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Project;

class CustomerDashboardController extends Controller
{
    /**
     * =========================================================
     * CUSTOMER DASHBOARD
     * =========================================================
     *
     * Show logged-in customer's dashboard.
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | CUSTOMER USER
        |--------------------------------------------------------------------------
        */

        $customerUserId = session('customer_user_id');

        if (!$customerUserId) {
            return redirect()
                ->route('customer.login')
                ->withErrors([
                    'customer' => 'Please login to access your dashboard.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | CUSTOMER PROFILE
        |--------------------------------------------------------------------------
        */

        $client = Client::where(
            'user_id',
            $customerUserId
        )->first();

        if (!$client) {
            return redirect()
                ->route('customer.login')
                ->withErrors([
                    'customer' => 'Customer profile was not found.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | USER
        |--------------------------------------------------------------------------
        |
        | Some existing dashboard fields use $user->email.
        | Load the related user through the client relation when available.
        |
        */

        $user = $client->user;


        /*
        |--------------------------------------------------------------------------
        | CUSTOMER PROJECTS
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        | Only projects belonging to this customer's client_id
        | will be loaded.
        |
        */

        $projects = Project::with([
            'service',
            'budget',
            'payments',
        ])
        ->where('client_id', $client->id)
        ->latest()
        ->get();


        /*
        |--------------------------------------------------------------------------
        | PROJECT STATISTICS
        |--------------------------------------------------------------------------
        */

        $totalProjects = $projects->count();


        /*
        | Pending means:
        | - approval_status = pending
        | OR
        | - project is still waiting for proposal/review
        |
        */

        $pendingProjects = $projects
            ->where('approval_status', 'pending')
            ->count();


        $ongoingProjects = $projects
            ->where('status', 'ongoing')
            ->count();


        $completedProjects = $projects
            ->where('status', 'completed')
            ->count();


        $cancelledProjects = $projects
            ->where('status', 'cancelled')
            ->count();


        $pausedProjects = $projects
            ->where('status', 'paused')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | FINANCIAL SUMMARY
        |--------------------------------------------------------------------------
        |
        | Customer can see:
        | - Contract amount
        | - Total paid
        | - Total due
        |
        | Customer does NOT see:
        | - Estimated internal cost
        | - Actual cost
        | - Profit / loss
        |
        */

        $totalContractAmount = 0;

        $totalPaidAmount = 0;


        foreach ($projects as $project) {

            /*
            |--------------------------------------------------------------------------
            | CONTRACT AMOUNT
            |--------------------------------------------------------------------------
            |
            | Contract amount is customer-facing.
            |
            */

            $contractAmount = 0;

            if ($project->budget) {
                $contractAmount = (float) (
                    $project->budget->contract_amount ?? 0
                );
            }

            $totalContractAmount += $contractAmount;


            /*
            |--------------------------------------------------------------------------
            | TOTAL PAID
            |--------------------------------------------------------------------------
            |
            | Only payments marked as "paid" are counted.
            |
            */

            $paidAmount = $project->payments
                ->where('status', 'paid')
                ->sum('amount');

            $paidAmount = (float) $paidAmount;

            $totalPaidAmount += $paidAmount;


            /*
            |--------------------------------------------------------------------------
            | PROJECT PAYMENT STATUS
            |--------------------------------------------------------------------------
            */

            if ($contractAmount <= 0) {

                $paymentStatus = 'No Budget';

            } elseif ($paidAmount >= $contractAmount) {

                $paymentStatus = 'Fully Paid';

            } elseif ($paidAmount > 0) {

                $paymentStatus = 'Partially Paid';

            } else {

                $paymentStatus = 'Payment Due';
            }


            /*
            |--------------------------------------------------------------------------
            | ATTACH CUSTOMER-SAFE CALCULATED VALUES
            |--------------------------------------------------------------------------
            |
            | These values are temporary attributes.
            | They are NOT database columns.
            |
            */

            $project->customer_contract_amount =
                $contractAmount;

            $project->customer_paid_amount =
                $paidAmount;

            $project->customer_due_amount =
                max(
                    $contractAmount - $paidAmount,
                    0
                );

            $project->paymentStatus =
                $paymentStatus;
        }


        /*
        |--------------------------------------------------------------------------
        | TOTAL DUE
        |--------------------------------------------------------------------------
        */

        $totalDueAmount = max(
            $totalContractAmount - $totalPaidAmount,
            0
        );


        /*
        |--------------------------------------------------------------------------
        | RETURN DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view(
            'frontend.customer.dashboard',
            compact(
                'client',
                'user',
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