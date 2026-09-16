<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\Payment;
use App\Models\Project;
use App\Models\ProjectStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectProposalController extends Controller
{
    /**
     * Show proposal setup page.
     */
    public function edit(Project $project)
    {
        $project->load([
            'client.user',
            'service',
            'budget',
            'payments',
            'projectSteps',
        ]);

        return view(
            'backend.project-proposals.edit',
            compact('project')
        );
    }


    /**
     * Save / update proposal information.
     */
    public function update(Request $request, Project $project)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'contract_amount' => [
                'required',
                'numeric',
                'min:0',
            ],

            'steps' => [
                'required',
                'array',
                'min:1',
            ],

            'steps.*.title' => [
                'required',
                'string',
                'max:255',
            ],

            'steps.*.description' => [
                'nullable',
                'string',
            ],

            'milestones' => [
                'required',
                'array',
                'min:1',
            ],

            'milestones.*.milestone' => [
                'required',
                'string',
                'max:255',
            ],

            'milestones.*.amount' => [
                'required',
                'numeric',
                'min:0',
            ],

            'milestones.*.due_date' => [
                'nullable',
                'date',
            ],

            'milestones.*.note' => [
                'nullable',
                'string',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | PROJECT STATUS CHECK
        |--------------------------------------------------------------------------
        */

        if (in_array($project->status, [
            'cancelled',
            'completed',
        ], true)) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'This project proposal cannot be modified.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CONTRACT AMOUNT
        |--------------------------------------------------------------------------
        */

        $contractAmount = (float) $validated['contract_amount'];


        /*
        |--------------------------------------------------------------------------
        | MILESTONE TOTAL
        |--------------------------------------------------------------------------
        */

        $milestoneTotal = collect(
            $validated['milestones']
        )->sum(function ($milestone) {

            return (float) $milestone['amount'];
        });


        /*
        |--------------------------------------------------------------------------
        | MILESTONE TOTAL MUST MATCH CONTRACT AMOUNT
        |--------------------------------------------------------------------------
        */

        if (abs($milestoneTotal - $contractAmount) > 0.01) {

            return back()
                ->withInput()
                ->withErrors([
                    'milestones' =>
                        'Total payment milestone amount must equal the final contract amount.'
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | SAVE PROPOSAL
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $project,
            $validated,
            $contractAmount
        ) {

            /*
            |--------------------------------------------------------------------------
            | BUDGET
            |--------------------------------------------------------------------------
            */

            $budget = Budget::firstOrNew([
                'project_id' => $project->id,
            ]);


            /*
            |--------------------------------------------------------------------------
            | FINAL CONTRACT AMOUNT
            |--------------------------------------------------------------------------
            |
            | contract_amount is customer-facing final amount.
            |
            | estimated_cost / actual_cost remain admin internal data.
            |
            */

            $budget->contract_amount = $contractAmount;


            /*
            |--------------------------------------------------------------------------
            | NEW BUDGET
            |--------------------------------------------------------------------------
            */

            if (!$budget->exists) {

                $budget->estimated_cost = $contractAmount;

                $budget->actual_cost = 0;
            }


            $budget->save();


            /*
            |--------------------------------------------------------------------------
            | PROJECT STEPS
            |--------------------------------------------------------------------------
            */

            ProjectStep::where(
                'project_id',
                $project->id
            )->delete();


            foreach (
                array_values($validated['steps'])
                as $index => $step
            ) {

                ProjectStep::create([

                    'project_id' =>
                        $project->id,

                    'step_number' =>
                        $index + 1,

                    'title' =>
                        $step['title'],

                    'description' =>
                        $step['description'] ?? null,

                    'estimated_days' =>
                        null,

                    'estimated_cost' =>
                        null,

                    'status' =>
                        'pending',

                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | PAYMENT MILESTONES
            |--------------------------------------------------------------------------
            |
            | The current payments table has dedicated columns for:
            | - milestone
            | - due_date
            | - status
            | - payment_method
            | - transaction_reference
            | - note
            |
            */

            Payment::where(
                'project_id',
                $project->id
            )->delete();


            foreach (
                array_values($validated['milestones'])
                as $milestone
            ) {

                /*
                |--------------------------------------------------------------------------
                | CREATE PAYMENT
                |--------------------------------------------------------------------------
                */

                Payment::create([

                    'project_id' =>
                        $project->id,

                    'amount' =>
                        $milestone['amount'],

                    'milestone' =>
                        $milestone['milestone'],

                    'due_date' =>
                        $milestone['due_date'] ?? null,

                    'payment_date' =>
                        null,

                    /*
                    | New milestone payment
                    | starts as pending.
                    */

                    'status' =>
                        'pending',

                    /*
                    | Payment method is only a default
                    | until the customer actually pays.
                    */

                    'payment_method' =>
                        'cash',

                    'transaction_reference' =>
                        null,

                    'note' =>
                        $milestone['note'] ?? null,

                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | PROJECT STATUS
            |--------------------------------------------------------------------------
            |
            | After admin prepares/saves proposal,
            | project remains under admin review.
            |
            */

            $project->update([

                'status' =>
                    'admin_review',

                'approval_status' =>
                    'pending',

                'customer_approved_at' =>
                    null,

                'customer_rejected_at' =>
                    null,

            ]);
        });


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'admin.project-proposals.edit',
                $project
            )
            ->with(
                'success',
                'Project proposal saved successfully. You can now send it to the customer.'
            );
    }


    /**
     * Send proposal to customer.
     */
    public function sendToCustomer(Project $project)
    {
        $project->load([
            'budget',
            'payments',
            'projectSteps',
        ]);


        /*
        |--------------------------------------------------------------------------
        | CHECK BUDGET
        |--------------------------------------------------------------------------
        */

        if (!$project->budget) {

            return back()
                ->with(
                    'error',
                    'Please create the final budget before sending the proposal.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CONTRACT AMOUNT
        |--------------------------------------------------------------------------
        */

        $contractAmount =
            (float) ($project->budget->contract_amount ?? 0);


        if ($contractAmount <= 0) {

            return back()
                ->with(
                    'error',
                    'Final contract amount must be greater than zero.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CHECK PROJECT STEPS
        |--------------------------------------------------------------------------
        */

        if ($project->projectSteps->count() === 0) {

            return back()
                ->with(
                    'error',
                    'Please add at least one project step.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CHECK PAYMENT MILESTONES
        |--------------------------------------------------------------------------
        */

        if ($project->payments->count() === 0) {

            return back()
                ->with(
                    'error',
                    'Please add at least one payment milestone.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CHECK PAYMENT TOTAL
        |--------------------------------------------------------------------------
        */

        $milestoneTotal =
            (float) $project->payments->sum('amount');


        if (abs($milestoneTotal - $contractAmount) > 0.01) {

            return back()
                ->with(
                    'error',
                    'Payment milestone total must equal the final contract amount.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | SEND PROPOSAL
        |--------------------------------------------------------------------------
        */

        $project->update([

            'status' =>
                'proposal_sent',

            'approval_status' =>
                'pending',

            'customer_approved_at' =>
                null,

            'customer_rejected_at' =>
                null,

        ]);


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
    ->route(
        'admin.project-proposals.edit',
        $project
    )
    ->with(
        'success',
        'Proposal has been sent to the customer successfully.'
    );
    }
}