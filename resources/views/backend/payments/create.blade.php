@extends('backend.layouts.admin')

@section('title', 'Add Payment')

@section('page_title', 'Add Payment')

@section('content')


{{-- =====================================================
    PAGE HEADER
====================================================== --}}

<div class="page-header">

    <div>

        <h1>
            Add Payment
        </h1>

        <p>
            Add a payment milestone for a project.
        </p>

    </div>


    <a
        href="{{ route('admin.payments.index') }}"
        class="secondary-btn"
    >
        ← Back
    </a>

</div>



{{-- =====================================================
    MAIN PANEL
====================================================== --}}

<div class="panel">


    <div class="panel-header">

        <div>

            <h2>
                Payment Information
            </h2>

            <p>
                Create and manage project payment milestones.
            </p>

        </div>

    </div>



    <div class="form-container">


        <form
            action="{{ route('admin.payments.store') }}"
            method="POST"
            id="paymentForm"
        >

            @csrf



            {{-- =================================================
                PROJECT
            ================================================== --}}

            <div class="form-group">

                <label for="project_id">

                    Project

                    <span class="required">
                        *
                    </span>

                </label>


                <select
                    name="project_id"
                    id="project_id"
                    required
                >

                    <option value="">
                        -- Select Project --
                    </option>


                    @foreach($projects as $project)

                        <option
                            value="{{ $project->id }}"
                            {{ old('project_id') == $project->id
                                ? 'selected'
                                : ''
                            }}
                        >

                            {{ $project->project_name }}

                            —
                            {{ ucfirst(
                                str_replace(
                                    '-',
                                    ' ',
                                    $project->status
                                )
                            ) }}

                        </option>

                    @endforeach

                </select>


                @error('project_id')

                    <small class="field-error">

                        {{ $message }}

                    </small>

                @enderror


                <small
                    id="projectStatusMessage"
                    class="form-help"
                ></small>

            </div>



            {{-- =================================================
                PAYMENT SUMMARY
            ================================================== --}}

            <div
                class="payment-summary"
                id="paymentSummary"
            >


                <div class="payment-summary-header">

                    <div>

                        <h3>
                            Project Payment Summary
                        </h3>

                        <p>
                            Current financial position of the selected project.
                        </p>

                    </div>

                </div>



                <div class="payment-summary-grid">


                    {{-- CONTRACT AMOUNT --}}

                    <div class="payment-summary-card">

                        <span>
                            Contract Amount
                        </span>

                        <strong
                            id="projectBudget"
                        >
                            Not Available
                        </strong>

                    </div>



                    {{-- TOTAL PAID --}}

                    <div class="payment-summary-card">

                        <span>
                            Total Paid
                        </span>

                        <strong
                            id="totalPaid"
                        >
                            ৳0.00
                        </strong>

                    </div>



                    {{-- CURRENT DUE --}}

                    <div class="payment-summary-card">

                        <span>
                            Current Due
                        </span>

                        <strong
                            id="currentRemaining"
                            class="text-muted"
                        >
                            Not Available
                        </strong>

                    </div>



                    {{-- MILESTONE CAPACITY --}}

                    <div class="payment-summary-card">

                        <span>
                            Available Milestone Amount
                        </span>

                        <strong
                            id="availableMilestoneAmount"
                            class="text-muted"
                        >
                            Not Available
                        </strong>

                    </div>


                </div>

            </div>



            {{-- =================================================
                MILESTONE
            ================================================== --}}

            <div class="form-group">

                <label for="milestone">

                    Payment Milestone

                    <span class="required">
                        *
                    </span>

                </label>


                <input
                    type="text"
                    name="milestone"
                    id="milestone"
                    value="{{ old('milestone') }}"
                    placeholder="Example: Advance Payment"
                    required
                >


                @error('milestone')

                    <small class="field-error">

                        {{ $message }}

                    </small>

                @enderror

            </div>



            {{-- =================================================
                PAYMENT DETAILS
            ================================================== --}}

            <div class="form-grid">


                {{-- AMOUNT --}}

                <div class="form-group">

                    <label for="amount">

                        Amount

                        <span class="required">
                            *
                        </span>

                    </label>


                    <input
                        type="number"
                        name="amount"
                        id="amount"
                        value="{{ old('amount') }}"
                        min="0.01"
                        step="0.01"
                        placeholder="Enter milestone amount"
                        required
                    >


                    <small
                        id="amountMessage"
                        class="form-help"
                    ></small>


                    @error('amount')

                        <small class="field-error">

                            {{ $message }}

                        </small>

                    @enderror

                </div>



                {{-- DUE DATE --}}

                <div class="form-group">

                    <label for="due_date">

                        Due Date

                        <span class="optional">
                            Optional
                        </span>

                    </label>


                    <input
                        type="date"
                        name="due_date"
                        id="due_date"
                        value="{{ old('due_date') }}"
                    >


                    @error('due_date')

                        <small class="field-error">

                            {{ $message }}

                        </small>

                    @enderror

                </div>


            </div>



            {{-- =================================================
                PAYMENT STATUS
            ================================================== --}}

            <div class="form-group">

                <label for="status">

                    Payment Status

                    <span class="required">
                        *
                    </span>

                </label>


                <select
                    name="status"
                    id="status"
                    required
                >

                    <option value="pending"
                        {{ old('status', 'pending') === 'pending'
                            ? 'selected'
                            : ''
                        }}
                    >
                        Pending
                    </option>


                    <option value="upcoming"
                        {{ old('status') === 'upcoming'
                            ? 'selected'
                            : ''
                        }}
                    >
                        Upcoming
                    </option>


                    <option value="paid"
                        {{ old('status') === 'paid'
                            ? 'selected'
                            : ''
                        }}
                    >
                        Paid
                    </option>


                    <option value="overdue"
                        {{ old('status') === 'overdue'
                            ? 'selected'
                            : ''
                        }}
                    >
                        Overdue
                    </option>

                </select>


                @error('status')

                    <small class="field-error">

                        {{ $message }}

                    </small>

                @enderror

            </div>



            {{-- =================================================
                PAID DETAILS
            ================================================== --}}

            <div
                id="paidDetails"
                style="display:none;"
            >


                <div class="form-grid">


                    {{-- PAYMENT DATE --}}

                    <div class="form-group">

                        <label for="payment_date">

                            Payment Date

                            <span class="required">
                                *
                            </span>

                        </label>


                        <input
                            type="date"
                            name="payment_date"
                            id="payment_date"
                            value="{{ old(
                                'payment_date',
                                now()->format('Y-m-d')
                            ) }}"
                        >


                        @error('payment_date')

                            <small class="field-error">

                                {{ $message }}

                            </small>

                        @enderror

                    </div>



                    {{-- PAYMENT METHOD --}}

                    <div class="form-group">

                        <label for="payment_method">

                            Payment Method

                            <span class="required">
                                *
                            </span>

                        </label>


                        <select
                            name="payment_method"
                            id="payment_method"
                        >

                            <option value="">

                                -- Select Payment Method --

                            </option>


                            <option
                                value="Cash"
                                {{ old('payment_method') === 'Cash'
                                    ? 'selected'
                                    : ''
                                }}
                            >
                                Cash
                            </option>


                            <option
                                value="Bank Transfer"
                                {{ old('payment_method') === 'Bank Transfer'
                                    ? 'selected'
                                    : ''
                                }}
                            >
                                Bank Transfer
                            </option>


                            <option
                                value="Cheque"
                                {{ old('payment_method') === 'Cheque'
                                    ? 'selected'
                                    : ''
                                }}
                            >
                                Cheque
                            </option>


                            <option
                                value="Mobile Banking"
                                {{ old('payment_method') === 'Mobile Banking'
                                    ? 'selected'
                                    : ''
                                }}
                            >
                                Mobile Banking
                            </option>


                            <option
                                value="Other"
                                {{ old('payment_method') === 'Other'
                                    ? 'selected'
                                    : ''
                                }}
                            >
                                Other
                            </option>

                        </select>


                        @error('payment_method')

                            <small class="field-error">

                                {{ $message }}

                            </small>

                        @enderror

                    </div>


                </div>


            </div>



            {{-- =================================================
                NOTE
            ================================================== --}}

            <div class="form-group">

                <label for="note">

                    Note

                    <span class="optional">
                        Optional
                    </span>

                </label>


                <textarea
                    name="note"
                    id="note"
                    rows="4"
                    placeholder="Enter additional notes..."
                >{{ old('note') }}</textarea>


                @error('note')

                    <small class="field-error">

                        {{ $message }}

                    </small>

                @enderror

            </div>



            {{-- =================================================
                FORM ACTIONS
            ================================================== --}}

            <div class="form-actions">


                <a
                    href="{{ route('admin.payments.index') }}"
                    class="secondary-btn"
                >
                    Cancel
                </a>



                <button
                    type="submit"
                    class="primary-btn"
                    id="savePaymentButton"
                >
                    Save Payment
                </button>


            </div>


        </form>


    </div>


</div>



{{-- =====================================================
    JAVASCRIPT
====================================================== --}}

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        /*
        |--------------------------------------------------------------------------
        | PROJECT DATA
        |--------------------------------------------------------------------------
        */

        const projectData =
            @json($projectData);



        /*
        |--------------------------------------------------------------------------
        | DOM ELEMENTS
        |--------------------------------------------------------------------------
        */

        const projectSelect =
            document.getElementById(
                'project_id'
            );

        const amountInput =
            document.getElementById(
                'amount'
            );

        const statusSelect =
            document.getElementById(
                'status'
            );

        const paidDetails =
            document.getElementById(
                'paidDetails'
            );

        const paymentDate =
            document.getElementById(
                'payment_date'
            );

        const paymentMethod =
            document.getElementById(
                'payment_method'
            );

        const projectBudget =
            document.getElementById(
                'projectBudget'
            );

        const totalPaid =
            document.getElementById(
                'totalPaid'
            );

        const currentRemaining =
            document.getElementById(
                'currentRemaining'
            );

        const availableMilestoneAmount =
            document.getElementById(
                'availableMilestoneAmount'
            );

        const projectStatusMessage =
            document.getElementById(
                'projectStatusMessage'
            );

        const amountMessage =
            document.getElementById(
                'amountMessage'
            );

        const saveButton =
            document.getElementById(
                'savePaymentButton'
            );



        /*
        |--------------------------------------------------------------------------
        | FORMAT MONEY
        |--------------------------------------------------------------------------
        */

        function formatMoney(value) {

            return Number(value)
                .toLocaleString(
                    'en-US',
                    {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }
                );

        }



        /*
        |--------------------------------------------------------------------------
        | PAID DETAILS VISIBILITY
        |--------------------------------------------------------------------------
        */

        function updatePaidDetails() {

            if (
                statusSelect.value === 'paid'
            ) {

                paidDetails.style.display =
                    'block';

                paymentDate.required =
                    true;

                paymentMethod.required =
                    true;

            } else {

                paidDetails.style.display =
                    'none';

                paymentDate.required =
                    false;

                paymentMethod.required =
                    false;

            }

        }



        /*
        |--------------------------------------------------------------------------
        | RESET SUMMARY
        |--------------------------------------------------------------------------
        */

        function resetSummary() {

            projectBudget.textContent =
                'Not Available';

            totalPaid.textContent =
                '৳0.00';

            currentRemaining.textContent =
                'Not Available';

            availableMilestoneAmount.textContent =
                'Not Available';


            amountInput.removeAttribute(
                'max'
            );

            amountInput.disabled =
                false;

            saveButton.disabled =
                false;


            projectStatusMessage.textContent =
                '';

            amountMessage.textContent =
                '';

        }



        /*
        |--------------------------------------------------------------------------
        | UPDATE PROJECT SUMMARY
        |--------------------------------------------------------------------------
        */

        function updateProjectSummary() {

            const projectId =
                projectSelect.value;


            if (!projectId) {

                resetSummary();

                return;

            }


            const project =
                projectData[projectId];


            if (!project) {

                resetSummary();

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | CANCELLED PROJECT
            |--------------------------------------------------------------------------
            */

            if (
                project.status === 'cancelled'
            ) {

                projectStatusMessage.textContent =
                    'Payment cannot be added to a cancelled project.';

                projectStatusMessage.className =
                    'field-error';

                amountInput.disabled =
                    true;

                saveButton.disabled =
                    true;

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | CONTRACT AMOUNT
            |--------------------------------------------------------------------------
            */

            if (
                project.contract_amount === null
            ) {

                projectBudget.textContent =
                    'No Budget';

                totalPaid.textContent =
                    `৳${formatMoney(
                        project.total_paid
                    )}`;

                currentRemaining.textContent =
                    'No Budget';

                availableMilestoneAmount.textContent =
                    'No Budget';


                projectStatusMessage.textContent =
                    'This project does not have a budget yet.';

                projectStatusMessage.className =
                    'field-error';

                amountInput.disabled =
                    true;

                saveButton.disabled =
                    true;

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | CONTRACT AMOUNT
            |--------------------------------------------------------------------------
            */

            projectBudget.textContent =
                `৳${formatMoney(
                    project.contract_amount
                )}`;



            /*
            |--------------------------------------------------------------------------
            | TOTAL PAID
            |--------------------------------------------------------------------------
            */

            totalPaid.textContent =
                `৳${formatMoney(
                    project.total_paid
                )}`;



            /*
            |--------------------------------------------------------------------------
            | CURRENT DUE
            |--------------------------------------------------------------------------
            */

            currentRemaining.textContent =
                `৳${formatMoney(
                    project.remaining
                )}`;



            /*
            |--------------------------------------------------------------------------
            | AVAILABLE MILESTONE AMOUNT
            |--------------------------------------------------------------------------
            */

            const availableAmount =
                Number(
                    project.contract_amount
                )
                -
                Number(
                    project.total_milestone_amount
                    ?? 0
                );


            availableMilestoneAmount.textContent =
                `৳${formatMoney(
                    Math.max(
                        availableAmount,
                        0
                    )
                )}`;


            /*
            |--------------------------------------------------------------------------
            | FULL MILESTONE ALLOCATION
            |--------------------------------------------------------------------------
            */

            if (
                availableAmount <= 0
            ) {

                amountMessage.textContent =
                    'All contract amount has already been allocated to payment milestones.';

                amountMessage.className =
                    'field-error';

                amountInput.value =
                    '';

                amountInput.disabled =
                    true;

                saveButton.disabled =
                    true;

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | ENABLE PAYMENT
            |--------------------------------------------------------------------------
            */

            amountInput.disabled =
                false;

            amountInput.max =
                availableAmount;

            saveButton.disabled =
                false;


            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            projectStatusMessage.textContent =
                `Project status: ${
                    project.status
                }`;

            projectStatusMessage.className =
                'form-help';


            validateAmount();

        }



        /*
        |--------------------------------------------------------------------------
        | VALIDATE MILESTONE AMOUNT
        |--------------------------------------------------------------------------
        */

        function validateAmount() {

            const projectId =
                projectSelect.value;


            if (!projectId) {

                return;

            }


            const project =
                projectData[projectId];


            if (
                !project
                ||
                project.contract_amount === null
            ) {

                return;

            }


            const availableAmount =
                Number(
                    project.contract_amount
                )
                -
                Number(
                    project.total_milestone_amount
                    ?? 0
                );


            const enteredAmount =
                parseFloat(
                    amountInput.value
                )
                ||
                0;


            if (
                enteredAmount <= 0
            ) {

                amountMessage.textContent =
                    `Maximum milestone amount available: ৳${formatMoney(
                        availableAmount
                    )}`;

                amountMessage.className =
                    'form-help';

                saveButton.disabled =
                    false;

                return;

            }


            if (
                enteredAmount >
                availableAmount
            ) {

                amountMessage.textContent =
                    `Milestone amount cannot exceed ৳${formatMoney(
                        availableAmount
                    )}.`;

                amountMessage.className =
                    'field-error';

                saveButton.disabled =
                    true;

                return;

            }


            amountMessage.textContent =
                `Available milestone amount: ৳${formatMoney(
                    availableAmount
                )}`;

            amountMessage.className =
                'form-help';

            saveButton.disabled =
                false;

        }



        /*
        |--------------------------------------------------------------------------
        | PROJECT CHANGE
        |--------------------------------------------------------------------------
        */

        projectSelect.addEventListener(
            'change',
            function () {

                amountInput.value =
                    '';

                updateProjectSummary();

            }
        );



        /*
        |--------------------------------------------------------------------------
        | AMOUNT INPUT
        |--------------------------------------------------------------------------
        */

        amountInput.addEventListener(
            'input',
            validateAmount
        );



        /*
        |--------------------------------------------------------------------------
        | STATUS CHANGE
        |--------------------------------------------------------------------------
        */

        statusSelect.addEventListener(
            'change',
            updatePaidDetails
        );



        /*
        |--------------------------------------------------------------------------
        | FORM SUBMIT PROTECTION
        |--------------------------------------------------------------------------
        */

        document
            .getElementById(
                'paymentForm'
            )
            .addEventListener(
                'submit',
                function (event) {


                    const projectId =
                        projectSelect.value;


                    const project =
                        projectData[projectId];


                    if (!project) {

                        event.preventDefault();

                        alert(
                            'Please select a valid project.'
                        );

                        return;

                    }


                    if (
                        project.status ===
                        'cancelled'
                    ) {

                        event.preventDefault();

                        alert(
                            'Payment cannot be added to a cancelled project.'
                        );

                        return;

                    }


                    if (
                        project.contract_amount ===
                        null
                    ) {

                        event.preventDefault();

                        alert(
                            'This project does not have a budget.'
                        );

                        return;

                    }


                    const availableAmount =
                        Number(
                            project.contract_amount
                        )
                        -
                        Number(
                            project.total_milestone_amount
                            ?? 0
                        );


                    const enteredAmount =
                        parseFloat(
                            amountInput.value
                        )
                        ||
                        0;


                    if (
                        enteredAmount <= 0
                    ) {

                        event.preventDefault();

                        alert(
                            'Please enter a valid payment amount.'
                        );

                        return;

                    }


                    if (
                        enteredAmount >
                        availableAmount
                    ) {

                        event.preventDefault();

                        alert(
                            `Payment milestone cannot exceed ৳${formatMoney(
                                availableAmount
                            )}.`
                        );

                        return;

                    }


                    if (
                        statusSelect.value ===
                        'paid'
                    ) {

                        if (
                            !paymentDate.value
                        ) {

                            event.preventDefault();

                            alert(
                                'Payment date is required for a paid payment.'
                            );

                            return;

                        }


                        if (
                            !paymentMethod.value
                        ) {

                            event.preventDefault();

                            alert(
                                'Payment method is required for a paid payment.'
                            );

                            return;

                        }

                    }

                }
            );



        /*
        |--------------------------------------------------------------------------
        | INITIAL LOAD
        |--------------------------------------------------------------------------
        */

        updatePaidDetails();

        updateProjectSummary();


    }
);

</script>


@endsection