<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Project;
use App\Models\Budget;
use App\Models\Payment;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Client Summary
        |--------------------------------------------------------------------------
        */

        $totalClients = Client::count();


        /*
        |--------------------------------------------------------------------------
        | Project Summary
        |--------------------------------------------------------------------------
        */

        $totalProjects = Project::count();

        $pendingProjects = Project::where('status', 'pending')->count();

        $ongoingProjects = Project::where('status', 'ongoing')->count();

        $completedProjects = Project::where('status', 'completed')->count();

        $onHoldProjects = Project::where('status', 'on-hold')->count();


        /*
        |--------------------------------------------------------------------------
        | Financial Summary
        |--------------------------------------------------------------------------
        |
        | Total Cost   = Sum of Actual Cost
        | Total Profit = Contract Amount - Actual Cost (positive values)
        | Total Loss   = Actual Cost - Contract Amount (positive values)
        | Total Payment = Sum of all payments
        | Total Due     = Total Contract Amount - Total Payment
        |
        */


        // Get all budgets
        $budgets = Budget::get();


        // Total Actual Cost
        $totalCost = $budgets->sum(function ($budget) {
            return (float) ($budget->actual_cost ?? 0);
        });


        // Total Contract Amount
        $totalContractAmount = $budgets->sum(function ($budget) {
            return (float) ($budget->contract_amount ?? 0);
        });


        // Total Profit
        $totalProfit = 0;

        // Total Loss
        $totalLoss = 0;


        foreach ($budgets as $budget) {

            $contractAmount = (float) ($budget->contract_amount ?? 0);

            $actualCost = (float) ($budget->actual_cost ?? 0);

            $profitLoss = $contractAmount - $actualCost;


            if ($profitLoss > 0) {

                $totalProfit += $profitLoss;

            } elseif ($profitLoss < 0) {

                $totalLoss += abs($profitLoss);

            }
        }


        /*
        |--------------------------------------------------------------------------
        | Payment Summary
        |--------------------------------------------------------------------------
        */

        // Total Payment Received
        $totalPayment = (float) Payment::sum('amount');


        // Total Due
        $totalDue = $totalContractAmount - $totalPayment;


        // Due should not show negative value
        if ($totalDue < 0) {
            $totalDue = 0;
        }


        /*
        |--------------------------------------------------------------------------
        | Recent Projects
        |--------------------------------------------------------------------------
        |
        | Get latest 5 projects with their clients.
        |
        */

        $recentProjects = Project::with('client')
            ->latest()
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Send Data To Dashboard View
        |--------------------------------------------------------------------------
        */

        return view('backend.s', compact(
            'totalClients',
            'totalProjects',
            'pendingProjects',
            'ongoingProjects',
            'completedProjects',
            'onHoldProjects',
            'recentProjects',

            // Financial Data
            'totalCost',
            'totalProfit',
            'totalLoss',
            'totalPayment',
            'totalDue',
            'totalContractAmount'
        ));
    }
}