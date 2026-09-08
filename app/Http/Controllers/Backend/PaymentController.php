<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Project;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * =========================================================
     * INDEX
     * =========================================================
     *
     * Show payment summary project-wise.
     */
    public function index()
    {
        $projects = Project::with([
            'payments',
            'budget',
            'client',
        ])
        ->whereHas('payments')
        ->latest()
        ->get();

        foreach ($projects as $project) {

            /*
            |--------------------------------------------------------------------------
            | TOTAL PAID
            |--------------------------------------------------------------------------
            */

            $totalPaid = (float) $project->payments->sum('amount');


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
            | REMAINING AMOUNT
            |--------------------------------------------------------------------------
            */

            $remainingAmount =
                $contractAmount - $totalPaid;


            /*
            |--------------------------------------------------------------------------
            | PAYMENT STATUS
            |--------------------------------------------------------------------------
            */

            if (!$project->budget) {

                $paymentStatus = 'No Budget';

            } elseif ($remainingAmount > 0) {

                $paymentStatus = 'Partially Paid';

            } else {

                $paymentStatus = 'Fully Paid';
            }


            /*
            |--------------------------------------------------------------------------
            | ATTACH VALUES
            |--------------------------------------------------------------------------
            */

            $project->contract_amount =
                $contractAmount;

            $project->total_paid =
                $totalPaid;

            $project->remaining_amount =
                max($remainingAmount, 0);

            $project->payment_status =
                $paymentStatus;
        }


        return view(
            'backend.payments.index',
            compact('projects')
        );
    }


    /**
     * =========================================================
     * CREATE
     * =========================================================
     *
     * Show payment creation form.
     */
    public function create()
    {
        $projects = Project::with([
            'payments',
            'budget',
        ])
        ->where('status', '!=', 'cancelled')
        ->orderBy('project_name')
        ->get();


        $projectData = [];


        foreach ($projects as $project) {

            /*
            |--------------------------------------------------------------------------
            | TOTAL PAID
            |--------------------------------------------------------------------------
            */

            $totalPaid =
                (float) $project->payments->sum('amount');


            /*
            |--------------------------------------------------------------------------
            | CONTRACT AMOUNT
            |--------------------------------------------------------------------------
            */

            $contractAmount = $project->budget
                ? (float) $project->budget->contract_amount
                : null;


            /*
            |--------------------------------------------------------------------------
            | REMAINING
            |--------------------------------------------------------------------------
            */

            $remaining = $contractAmount !== null
                ? max($contractAmount - $totalPaid, 0)
                : null;


            /*
            |--------------------------------------------------------------------------
            | PAYMENT STATUS
            |--------------------------------------------------------------------------
            */

            if ($contractAmount === null) {

                $paymentStatus = 'No Budget';

            } elseif ($remaining > 0) {

                $paymentStatus = 'Payment Due';

            } else {

                $paymentStatus = 'Fully Paid';
            }


            $projectData[$project->id] = [

                'name' =>
                    $project->project_name,

                'status' =>
                    $project->status,

                'budget' =>
                    $contractAmount,

                'contract_amount' =>
                    $contractAmount,

                'total_paid' =>
                    $totalPaid,

                'remaining' =>
                    $remaining,

                'payment_status' =>
                    $paymentStatus,

            ];
        }


        return view(
            'backend.payments.create',
            compact(
                'projects',
                'projectData'
            )
        );
    }


    /**
     * =========================================================
     * STORE
     * =========================================================
     *
     * Store a new payment.
     *
     * Rules:
     * - Cancelled project cannot receive payment.
     * - Project must have a budget.
     * - Payment cannot exceed contract amount.
     * - Payment cannot exceed remaining amount.
     */
    public function store(Request $request)
    {
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

            'amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'payment_date' => [
                'required',
                'date',
            ],

            'payment_method' => [
                'required',
                'string',
                'max:100',
            ],

            'note' => [
                'nullable',
                'string',
            ],

        ], [

            'project_id.required' =>
                'Please select a project.',

            'project_id.exists' =>
                'The selected project does not exist.',

            'amount.required' =>
                'Please enter the payment amount.',

            'amount.numeric' =>
                'Payment amount must be a valid number.',

            'amount.min' =>
                'Payment amount must be greater than zero.',

            'payment_date.required' =>
                'Please select the payment date.',

            'payment_date.date' =>
                'Please enter a valid payment date.',

            'payment_method.required' =>
                'Please select a payment method.',

            'payment_method.max' =>
                'Payment method cannot exceed 100 characters.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | GET PROJECT
        |--------------------------------------------------------------------------
        */

        $project = Project::with([
            'budget',
            'payments',
        ])->findOrFail(
            $validated['project_id']
        );


        /*
        |--------------------------------------------------------------------------
        | CANCELLED PROJECT CHECK
        |--------------------------------------------------------------------------
        */

        if ($project->status === 'cancelled') {

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

        if (!$project->budget) {

            return back()
                ->withErrors([
                    'project_id' =>
                        'This project does not have a budget yet. Please create a budget first.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | CONTRACT AMOUNT
        |--------------------------------------------------------------------------
        */

        $contractAmount =
            (float) $project->budget->contract_amount;


        /*
        |--------------------------------------------------------------------------
        | TOTAL PAYMENT ALREADY RECEIVED
        |--------------------------------------------------------------------------
        */

        $totalPaid =
            (float) $project->payments->sum('amount');


        /*
        |--------------------------------------------------------------------------
        | REMAINING AMOUNT
        |--------------------------------------------------------------------------
        */

        $remainingAmount =
            $contractAmount - $totalPaid;


        /*
        |--------------------------------------------------------------------------
        | FULL PAYMENT CHECK
        |--------------------------------------------------------------------------
        */

        if ($remainingAmount <= 0) {

            return back()
                ->withErrors([
                    'amount' =>
                        'This project has already received the full contract amount. No further payment is allowed.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | NEW PAYMENT AMOUNT
        |--------------------------------------------------------------------------
        */

        $paymentAmount =
            (float) $validated['amount'];


        /*
        |--------------------------------------------------------------------------
        | PAYMENT CANNOT EXCEED REMAINING
        |--------------------------------------------------------------------------
        */

        if ($paymentAmount > $remainingAmount) {

            return back()
                ->withErrors([
                    'amount' =>
                        'Payment amount cannot be greater than the remaining amount of ৳'
                        . number_format(
                            $remainingAmount,
                            2
                        )
                        . '.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | CREATE PAYMENT
        |--------------------------------------------------------------------------
        */

        Payment::create([

            'project_id' =>
                $project->id,

            'amount' =>
                $paymentAmount,

            'payment_date' =>
                $validated['payment_date'],

            'payment_method' =>
                $validated['payment_method'],

            'note' =>
                $validated['note'] ?? null,
        ]);


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.payments.index')
            ->with(
                'success',
                'Payment added successfully.'
            );
    }


    /**
     * =========================================================
     * SHOW
     * =========================================================
     *
     * Show one payment with project payment summary.
     */
    public function show(Payment $payment)
    {
        /*
        |--------------------------------------------------------------------------
        | LOAD RELATIONSHIPS
        |--------------------------------------------------------------------------
        */

        $payment->load([
            'project.client',
            'project.budget',
            'project.payments',
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
        | TOTAL PAID
        |--------------------------------------------------------------------------
        */

        $totalPaid =
            (float) $project->payments->sum('amount');


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
        | REMAINING AMOUNT
        |--------------------------------------------------------------------------
        */

        $remainingAmount =
            $contractAmount - $totalPaid;


        /*
        |--------------------------------------------------------------------------
        | PAYMENT STATUS
        |--------------------------------------------------------------------------
        */

        if (!$project->budget) {

            $paymentStatus = 'No Budget';

        } elseif ($remainingAmount > 0) {

            $paymentStatus = 'Partially Paid';

        } else {

            $paymentStatus = 'Fully Paid';
        }


        /*
        |--------------------------------------------------------------------------
        | ATTACH VALUES
        |--------------------------------------------------------------------------
        */

        $payment->total_paid =
            $totalPaid;

        $payment->contract_amount =
            $contractAmount;

        $payment->remaining_amount =
            max($remainingAmount, 0);

        $payment->payment_status =
            $paymentStatus;


        return view(
            'backend.payments.show',
            compact(
                'payment',
                'project',
                'totalPaid',
                'contractAmount',
                'remainingAmount',
                'paymentStatus'
            )
        );
    }


    /**
     * =========================================================
     * EDIT
     * =========================================================
     *
     * Show payment edit form.
     */
    public function edit(Payment $payment)
    {
        /*
        |--------------------------------------------------------------------------
        | LOAD PROJECT
        |--------------------------------------------------------------------------
        */

        $payment->load([
            'project.budget',
            'project.payments',
        ]);


        /*
        |--------------------------------------------------------------------------
        | CANCELLED PROJECT CHECK
        |--------------------------------------------------------------------------
        */

        if (
            $payment->project &&
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
        | CONTRACT AMOUNT
        |--------------------------------------------------------------------------
        */

        $contractAmount = $payment->project->budget
            ? (float) $payment->project->budget->contract_amount
            : null;


        /*
        |--------------------------------------------------------------------------
        | TOTAL OTHER PAYMENTS
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        | Current payment is excluded.
        |
        */

        $otherPayments = $payment->project->payments
            ->where('id', '!=', $payment->id)
            ->sum('amount');


        $otherPayments =
            (float) $otherPayments;


        /*
        |--------------------------------------------------------------------------
        | MAXIMUM ALLOWED PAYMENT
        |--------------------------------------------------------------------------
        */

        $remainingForEdit =
            $contractAmount !== null
                ? max(
                    $contractAmount - $otherPayments,
                    0
                )
                : null;


        return view(
            'backend.payments.edit',
            compact(
                'payment',
                'contractAmount',
                'remainingForEdit'
            )
        );
    }


    /**
     * =========================================================
     * UPDATE
     * =========================================================
     *
     * Update existing payment.
     */
    public function update(
        Request $request,
        Payment $payment
    ) {
        /*
        |--------------------------------------------------------------------------
        | LOAD PROJECT
        |--------------------------------------------------------------------------
        */

        $payment->load([
            'project.budget',
            'project.payments',
        ]);


        /*
        |--------------------------------------------------------------------------
        | CANCELLED PROJECT CHECK
        |--------------------------------------------------------------------------
        */

        if (
            $payment->project &&
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
        | PROJECT MUST HAVE BUDGET
        |--------------------------------------------------------------------------
        */

        if (!$payment->project->budget) {

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

            'amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'payment_date' => [
                'required',
                'date',
            ],

            'payment_method' => [
                'required',
                'string',
                'max:100',
            ],

            'note' => [
                'nullable',
                'string',
            ],

        ], [

            'amount.required' =>
                'Please enter the payment amount.',

            'amount.numeric' =>
                'Payment amount must be a valid number.',

            'amount.min' =>
                'Payment amount must be greater than zero.',

            'payment_date.required' =>
                'Please select the payment date.',

            'payment_date.date' =>
                'Please enter a valid payment date.',

            'payment_method.required' =>
                'Please select a payment method.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | CONTRACT AMOUNT
        |--------------------------------------------------------------------------
        */

        $contractAmount =
            (float) $payment->project->budget->contract_amount;


        /*
        |--------------------------------------------------------------------------
        | OTHER PAYMENTS
        |--------------------------------------------------------------------------
        |
        | Exclude current payment.
        |
        */

        $otherPayments = $payment->project->payments
            ->where('id', '!=', $payment->id)
            ->sum('amount');


        $otherPayments =
            (float) $otherPayments;


        /*
        |--------------------------------------------------------------------------
        | MAXIMUM ALLOWED AMOUNT
        |--------------------------------------------------------------------------
        */

        $maximumAllowed =
            $contractAmount - $otherPayments;


        /*
        |--------------------------------------------------------------------------
        | NEW PAYMENT AMOUNT
        |--------------------------------------------------------------------------
        */

        $paymentAmount =
            (float) $validated['amount'];


        /*
        |--------------------------------------------------------------------------
        | PAYMENT CANNOT EXCEED CONTRACT LIMIT
        |--------------------------------------------------------------------------
        */

        if ($paymentAmount > $maximumAllowed) {

            return back()
                ->withErrors([
                    'amount' =>
                        'Payment amount cannot be greater than ৳'
                        . number_format(
                            max($maximumAllowed, 0),
                            2
                        )
                        . '.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE PAYMENT
        |--------------------------------------------------------------------------
        */

        $payment->update([

            'amount' =>
                $paymentAmount,

            'payment_date' =>
                $validated['payment_date'],

            'payment_method' =>
                $validated['payment_method'],

            'note' =>
                $validated['note'] ?? null,
        ]);


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'admin.payments.show',
                $payment
            )
            ->with(
                'success',
                'Payment updated successfully.'
            );
    }


    /**
     * =========================================================
     * DESTROY
     * =========================================================
     *
     * Delete payment.
     *
     * POST only.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()
            ->route('admin.payments.index')
            ->with(
                'success',
                'Payment deleted successfully.'
            );
    }
}