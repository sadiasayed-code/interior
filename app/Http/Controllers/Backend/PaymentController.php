<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    |
    | Show project-wise payment summary.
    |
    | IMPORTANT LOGIC:
    |
    | Total Amount = Budget Contract Amount
    | Total Paid = Only status = paid
    | Total Due = Contract Amount - Total Paid
    |
    */

    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | LOAD PROJECTS
        |--------------------------------------------------------------------------
        */

        $projects = Project::with([
            'client',
            'service',
            'budget',
            'payments',
        ])
            ->latest()
            ->get();


        /*
        |--------------------------------------------------------------------------
        | PROJECT PAYMENT SUMMARY
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
            |
            | Only status = paid
            |
            */

            $totalPaid = (float) $project
                ->payments
                ->where('status', 'paid')
                ->sum('amount');


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
            | ATTACH SUMMARY DATA
            |--------------------------------------------------------------------------
            */

            $project->totalAmount = $contractAmount;

            $project->totalPaid = $totalPaid;

            $project->totalDue = $totalDue;
        }


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'backend.payments.index',
            compact('projects')
        );
    }



    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    |
    | Show create payment milestone form.
    |
    */

    public function create()
    {
        /*
        |--------------------------------------------------------------------------
        | LOAD PROJECTS
        |--------------------------------------------------------------------------
        |
        | Project table does NOT have project_name.
        | Therefore service information is loaded.
        |
        */

        $projects = Project::with([
            'payments',
            'budget',
            'service',
        ])
            ->where(
                'status',
                '!=',
                'cancelled'
            )
            ->orderBy(
                Service::select('name')
                    ->whereColumn(
                        'services.id',
                        'projects.service_id'
                    )
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | PROJECT DATA
        |--------------------------------------------------------------------------
        */

        $projectData = [];


        foreach ($projects as $project) {

            /*
            |--------------------------------------------------------------------------
            | TOTAL PAID
            |--------------------------------------------------------------------------
            |
            | Only paid payments.
            |
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
            | CONTRACT AMOUNT
            |--------------------------------------------------------------------------
            */

            $contractAmount = $project->budget
                ? (float) $project
                    ->budget
                    ->contract_amount
                : null;


            /*
            |--------------------------------------------------------------------------
            | TOTAL MILESTONE AMOUNT
            |--------------------------------------------------------------------------
            |
            | All milestones are counted here,
            | regardless of status.
            |
            */

            $totalMilestoneAmount = (float) $project
                ->payments
                ->sum(
                    'amount'
                );


            /*
            |--------------------------------------------------------------------------
            | REMAINING PAYMENT CAPACITY
            |--------------------------------------------------------------------------
            |
            | Prevent creating milestones beyond
            | contract amount.
            |
            */

            $remainingForMilestone = $contractAmount !== null
                ? max(
                    $contractAmount
                    -
                    $totalMilestoneAmount,
                    0
                )
                : null;


            /*
            |--------------------------------------------------------------------------
            | REMAINING CONTRACT DUE
            |--------------------------------------------------------------------------
            |
            | Contract Amount - Actual Paid Amount
            |
            */

            $remainingDue = $contractAmount !== null
                ? max(
                    $contractAmount
                    -
                    $totalPaid,
                    0
                )
                : null;


            /*
            |--------------------------------------------------------------------------
            | PAYMENT STATUS
            |--------------------------------------------------------------------------
            */

            if ($contractAmount === null) {

                $paymentStatus = 'No Budget';

            } elseif ($remainingDue <= 0) {

                $paymentStatus = 'Fully Paid';

            } elseif ($totalPaid > 0) {

                $paymentStatus = 'Partially Paid';

            } else {

                $paymentStatus = 'Payment Due';
            }


            /*
            |--------------------------------------------------------------------------
            | STORE PROJECT DATA
            |--------------------------------------------------------------------------
            |
            | Service name is used instead of project_name.
            |
            */

            $projectData[
                $project->id
            ] = [

                'name' =>
                    $project->service
                        ? $project->service->name
                        : 'Service not found',

                'status' =>
                    $project->status,

                'contract_amount' =>
                    $contractAmount,

                'total_paid' =>
                    $totalPaid,

                'total_milestone_amount' =>
                    $totalMilestoneAmount,

                'remaining_for_milestone' =>
                    $remainingForMilestone,

                'remaining_due' =>
                    $remainingDue,

                'payment_status' =>
                    $paymentStatus,

            ];
        }


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'backend.payments.create',
            compact(
                'projects',
                'projectData'
            )
        );
    }



    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    |
    | Create new payment milestone.
    |
    */

    public function store(
        Request $request
    ) {

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'project_id' => [
                'required',
                'exists:projects,id',
            ],

            'project_step_id' => [
                'nullable',
                'exists:project_steps,id',
            ],

            'milestone' => [
                'nullable',
                'string',
                'max:255',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'due_date' => [
                'nullable',
                'date',
            ],

            'payment_date' => [
                'nullable',
                'date',
            ],

            'status' => [
                'required',
                'in:paid,pending,upcoming,overdue,cancelled',
            ],

            'payment_method' => [
                'nullable',
                'string',
                'max:100',
            ],

            'transaction_reference' => [
                'nullable',
                'string',
                'max:255',
            ],

            'note' => [
                'nullable',
                'string',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | LOAD PROJECT
        |--------------------------------------------------------------------------
        */

        $project = Project::with([
            'budget',
            'payments',
        ])
            ->findOrFail(
                $validated['project_id']
            );


        /*
        |--------------------------------------------------------------------------
        | CANCELLED PROJECT CHECK
        |--------------------------------------------------------------------------
        */

        if (
            $project->status === 'cancelled'
        ) {

            return back()
                ->withErrors([
                    'project_id' =>
                        'Payment cannot be added to a cancelled project.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | PROJECT MUST HAVE BUDGET
        |--------------------------------------------------------------------------
        */

        if (
            !$project->budget
        ) {

            return back()
                ->withErrors([
                    'project_id' =>
                        'Please create a budget before adding payment milestones.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | PAID PAYMENT VALIDATION
        |--------------------------------------------------------------------------
        */

        if (
            $validated['status'] === 'paid'
        ) {

            if (
                empty(
                    $validated['payment_date']
                )
            ) {

                return back()
                    ->withErrors([
                        'payment_date' =>
                            'Payment date is required when status is Paid.',
                    ])
                    ->withInput();
            }


            if (
                empty(
                    $validated['payment_method']
                )
            ) {

                return back()
                    ->withErrors([
                        'payment_method' =>
                            'Payment method is required when status is Paid.',
                    ])
                    ->withInput();
            }
        }


        /*
        |--------------------------------------------------------------------------
        | CONTRACT AMOUNT
        |--------------------------------------------------------------------------
        */

        $contractAmount = (float) $project
            ->budget
            ->contract_amount;


        /*
        |--------------------------------------------------------------------------
        | TOTAL EXISTING MILESTONES
        |--------------------------------------------------------------------------
        |
        | ALL statuses are counted here because
        | this is for milestone allocation.
        |
        */

        $existingMilestoneAmount = (float) $project
            ->payments
            ->sum(
                'amount'
            );


        /*
        |--------------------------------------------------------------------------
        | NEW PAYMENT AMOUNT
        |--------------------------------------------------------------------------
        */

        $paymentAmount = (float)
            $validated['amount'];


        /*
        |--------------------------------------------------------------------------
        | MAXIMUM ALLOWED
        |--------------------------------------------------------------------------
        */

        $maximumAllowed =
            $contractAmount
            -
            $existingMilestoneAmount;


        /*
        |--------------------------------------------------------------------------
        | CONTRACT LIMIT CHECK
        |--------------------------------------------------------------------------
        */

        if (
            $paymentAmount > $maximumAllowed
        ) {

            return back()
                ->withErrors([
                    'amount' =>
                        'Payment milestone amount cannot be greater than ৳'
                        .
                        number_format(
                            max(
                                $maximumAllowed,
                                0
                            ),
                            2
                        )
                        .
                        '.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | PAYMENT METHOD
        |--------------------------------------------------------------------------
        |
        | Database default is cash.
        | Do not send null to the non-nullable enum column.
        |
        */

        $paymentMethod =
            $validated['payment_method']
            ??
            'cash';


        /*
        |--------------------------------------------------------------------------
        | CREATE PAYMENT
        |--------------------------------------------------------------------------
        */

        $payment = Payment::create([

            'project_id' =>
                $project->id,

            'project_step_id' =>
                $validated['project_step_id'] ?? null,

            'milestone' =>
                $validated['milestone'] ?? null,

            'amount' =>
                $paymentAmount,

            'due_date' =>
                $validated['due_date']
                ??
                null,

            'payment_date' =>
                $validated['payment_date']
                ??
                null,

            'status' =>
                $validated['status'],

            'payment_method' =>
                $paymentMethod,

            'transaction_reference' =>
                $validated['transaction_reference']
                ??
                null,

            'note' =>
                $validated['note']
                ??
                null,

        ]);


        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'admin.payments.show',
                $payment
            )
            ->with(
                'success',
                'Payment milestone created successfully.'
            );
    }



    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    |
    | Show selected payment and all milestones
    | of that project.
    |
    */

    public function show(
        Payment $payment
    ) {

        /*
        |--------------------------------------------------------------------------
        | LOAD RELATIONSHIPS
        |--------------------------------------------------------------------------
        */

        $payment->load([

            'project.client',

            'project.service',

            'project.budget',

            'project.payments' => function (
                $query
            ) {

                $query->orderBy(
                    'due_date'
                )
                    ->orderBy(
                        'id'
                    );
            },

        ]);


        /*
        |--------------------------------------------------------------------------
        | PROJECT
        |--------------------------------------------------------------------------
        */

        $project =
            $payment->project;


        /*
        |--------------------------------------------------------------------------
        | CONTRACT AMOUNT
        |--------------------------------------------------------------------------
        */

        $contractAmount =
            $project->budget
                ? (float)
                    $project
                        ->budget
                        ->contract_amount
                : 0;


        /*
        |--------------------------------------------------------------------------
        | ALL MILESTONES
        |--------------------------------------------------------------------------
        */

        $payments =
            $project->payments;


        /*
        |--------------------------------------------------------------------------
        | TOTAL MILESTONE AMOUNT
        |--------------------------------------------------------------------------
        */

        $totalMilestoneAmount =
            (float)
            $payments
                ->sum(
                    'amount'
                );


        /*
        |--------------------------------------------------------------------------
        | TOTAL PAID
        |--------------------------------------------------------------------------
        |
        | Only paid status.
        |
        */

        $totalPaid =
            (float)
            $payments
                ->where(
                    'status',
                    'paid'
                )
                ->sum(
                    'amount'
                );


        /*
        |--------------------------------------------------------------------------
        | REMAINING AMOUNT
        |--------------------------------------------------------------------------
        */

        $remainingAmount =
            max(
                $contractAmount
                -
                $totalPaid,
                0
            );


        /*
        |--------------------------------------------------------------------------
        | PAYMENT STATUS
        |--------------------------------------------------------------------------
        */

        if (
            $contractAmount <= 0
        ) {

            $paymentStatus =
                'No Budget';

        } elseif (
            $remainingAmount <= 0
        ) {

            $paymentStatus =
                'Fully Paid';

        } elseif (
            $totalPaid > 0
        ) {

            $paymentStatus =
                'Partially Paid';

        } else {

            $paymentStatus =
                'Payment Due';
        }


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'backend.payments.show',
            compact(

                'payment',

                'project',

                'payments',

                'contractAmount',

                'totalMilestoneAmount',

                'totalPaid',

                'remainingAmount',

                'paymentStatus'

            )
        );
    }



    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    |
    | Edit payment milestone.
    |
    */

    public function edit(
        Payment $payment
    ) {

        /*
        |--------------------------------------------------------------------------
        | LOAD RELATIONSHIPS
        |--------------------------------------------------------------------------
        */

        $payment->load([

            'project.budget',

            'project.payments',

        ]);


        /*
        |--------------------------------------------------------------------------
        | PROJECT CHECK
        |--------------------------------------------------------------------------
        */

        if (
            !$payment->project
        ) {

            abort(
                404
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CANCELLED PROJECT CHECK
        |--------------------------------------------------------------------------
        */

        if (
            $payment->project->status === 'cancelled'
        ) {

            return redirect()
                ->route(
                    'admin.payments.show',
                    $payment
                )
                ->with(
                    'error',
                    'Payment of a cancelled project cannot be edited.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | BUDGET CHECK
        |--------------------------------------------------------------------------
        */

        if (
            !$payment
                ->project
                ->budget
        ) {

            return redirect()
                ->route(
                    'admin.payments.show',
                    $payment
                )
                ->with(
                    'error',
                    'This project does not have a budget.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CONTRACT AMOUNT
        |--------------------------------------------------------------------------
        */

        $contractAmount =
            (float)
            $payment
                ->project
                ->budget
                ->contract_amount;


        /*
        |--------------------------------------------------------------------------
        | OTHER MILESTONES
        |--------------------------------------------------------------------------
        |
        | Exclude current payment.
        |
        */

        $otherPayments =
            (float)
            $payment
                ->project
                ->payments
                ->where(
                    'id',
                    '!=',
                    $payment->id
                )
                ->sum(
                    'amount'
                );


        /*
        |--------------------------------------------------------------------------
        | REMAINING FOR EDIT
        |--------------------------------------------------------------------------
        */

        $remainingForEdit =
            max(
                $contractAmount
                -
                $otherPayments,
                0
            );


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'backend.payments.edit',
            compact(

                'payment',

                'contractAmount',

                'remainingForEdit'

            )
        );
    }



    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    |
    | Update payment milestone.
    |
    */

    public function update(
        Request $request,
        Payment $payment
    ) {

        /*
        |--------------------------------------------------------------------------
        | LOAD RELATIONSHIPS
        |--------------------------------------------------------------------------
        */

        $payment->load([

            'project.budget',

            'project.payments',

        ]);


        /*
        |--------------------------------------------------------------------------
        | PROJECT CHECK
        |--------------------------------------------------------------------------
        */

        if (
            !$payment->project
        ) {

            abort(
                404
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CANCELLED PROJECT CHECK
        |--------------------------------------------------------------------------
        */

        if (
            $payment->project->status === 'cancelled'
        ) {

            return redirect()
                ->route(
                    'admin.payments.show',
                    $payment
                )
                ->with(
                    'error',
                    'Payment of a cancelled project cannot be edited.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | BUDGET CHECK
        |--------------------------------------------------------------------------
        */

        if (
            !$payment
                ->project
                ->budget
        ) {

            return redirect()
                ->route(
                    'admin.payments.show',
                    $payment
                )
                ->with(
                    'error',
                    'This project does not have a budget.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'project_step_id' => [
                'nullable',
                'exists:project_steps,id',
            ],

            'milestone' => [
                'nullable',
                'string',
                'max:255',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'due_date' => [
                'nullable',
                'date',
            ],

            'payment_date' => [
                'nullable',
                'date',
            ],

            'status' => [
                'required',
                'in:paid,pending,upcoming,overdue,cancelled',
            ],

            'payment_method' => [
                'nullable',
                'string',
                'max:100',
            ],

            'transaction_reference' => [
                'nullable',
                'string',
                'max:255',
            ],

            'note' => [
                'nullable',
                'string',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | PAID VALIDATION
        |--------------------------------------------------------------------------
        */

        if (
            $validated['status'] === 'paid'
        ) {

            if (
                empty(
                    $validated['payment_date']
                )
            ) {

                return back()
                    ->withErrors([
                        'payment_date' =>
                            'Payment date is required when status is Paid.',
                    ])
                    ->withInput();
            }


            if (
                empty(
                    $validated['payment_method']
                )
            ) {

                return back()
                    ->withErrors([
                        'payment_method' =>
                            'Payment method is required when status is Paid.',
                    ])
                    ->withInput();
            }
        }


        /*
        |--------------------------------------------------------------------------
        | CONTRACT AMOUNT
        |--------------------------------------------------------------------------
        */

        $contractAmount =
            (float)
            $payment
                ->project
                ->budget
                ->contract_amount;


        /*
        |--------------------------------------------------------------------------
        | OTHER MILESTONES
        |--------------------------------------------------------------------------
        */

        $otherPayments =
            (float)
            $payment
                ->project
                ->payments
                ->where(
                    'id',
                    '!=',
                    $payment->id
                )
                ->sum(
                    'amount'
                );


        /*
        |--------------------------------------------------------------------------
        | MAXIMUM ALLOWED
        |--------------------------------------------------------------------------
        */

        $maximumAllowed =
            $contractAmount
            -
            $otherPayments;


        /*
        |--------------------------------------------------------------------------
        | PAYMENT AMOUNT
        |--------------------------------------------------------------------------
        */

        $paymentAmount =
            (float)
            $validated['amount'];


        /*
        |--------------------------------------------------------------------------
        | CONTRACT LIMIT CHECK
        |--------------------------------------------------------------------------
        */

        if (
            $paymentAmount > $maximumAllowed
        ) {

            return back()
                ->withErrors([

                    'amount' =>

                        'Payment amount cannot be greater than ৳'

                        .

                        number_format(
                            max(
                                $maximumAllowed,
                                0
                            ),
                            2
                        )

                        .

                        '.',

                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | PAYMENT METHOD
        |--------------------------------------------------------------------------
        |
        | Database column has default cash.
        |
        */

        $paymentMethod =
            $validated['payment_method']
            ??
            'cash';


        /*
        |--------------------------------------------------------------------------
        | UPDATE PAYMENT
        |--------------------------------------------------------------------------
        */

        $payment->update([

            'milestone' =>
                $validated['milestone'] ?? $payment->milestone,

            'project_step_id' =>
                $validated['project_step_id'] ?? $payment->project_step_id,

            'amount' =>
                $paymentAmount,

            'due_date' =>
                $validated['due_date']
                ??
                null,

            'payment_date' =>
                $validated['payment_date']
                ??
                null,

            'status' =>
                $validated['status'],

            'payment_method' =>
                $paymentMethod,

            'transaction_reference' =>
                $validated['transaction_reference']
                ??
                null,

            'note' =>
                $validated['note']
                ??
                null,

        ]);


        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'admin.payments.show',
                $payment
            )
            ->with(
                'success',
                'Payment milestone updated successfully.'
            );
    }



    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    |
    | Delete payment milestone.
    |
    */

    public function destroy(
        Payment $payment
    ) {

        /*
        |--------------------------------------------------------------------------
        | PROJECT
        |--------------------------------------------------------------------------
        */

        $project =
            $payment
                ->project;


        /*
        |--------------------------------------------------------------------------
        | DELETE
        |--------------------------------------------------------------------------
        */

        $payment->delete();


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'admin.payments.index'
            )
            ->with(
                'success',
                'Payment milestone deleted successfully.'
            );
    }
}