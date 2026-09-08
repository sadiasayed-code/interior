@extends('backend.layouts.admin')

@section('title', 'Edit Payment')

@section('page_title', 'Edit Payment')

@section('content')


{{-- =====================================================
    PAGE HEADER
====================================================== --}}

<div class="page-header">

    <div>

        <h1>
            Edit Payment
        </h1>

        <p>
            Update the payment information for this project.
        </p>

    </div>


    <div class="table-actions">

        <a
            href="{{ route('admin.payments.show', $payment) }}"
            class="secondary-btn"
        >
            ← Back
        </a>

    </div>

</div>



{{-- =====================================================
    PROJECT INFORMATION
====================================================== --}}

<div class="panel">

    <div class="panel-header">

        <div>

            <h2>
                Project Information
            </h2>

            <p>
                Payment belongs to this project.
            </p>

        </div>

    </div>


    <div class="detail-grid">


        {{-- PROJECT --}}

        <div class="detail-item">

            <span class="detail-label">
                Project
            </span>

            <strong class="detail-value">

                {{ $payment->project->project_name ?? 'N/A' }}

            </strong>

        </div>



        {{-- PROJECT STATUS --}}

        <div class="detail-item">

            <span class="detail-label">
                Project Status
            </span>

            @php

                $projectStatus =
                    $payment->project->status ?? null;

                $statusClass = match($projectStatus) {

                    'pending' =>
                        'status-warning',

                    'ongoing' =>
                        'status-info',

                    'on-hold' =>
                        'status-danger',

                    'completed' =>
                        'status-success',

                    'cancelled' =>
                        'status-danger',

                    default =>
                        'status-secondary',

                };

            @endphp


            <span class="status-badge {{ $statusClass }}">

                {{ $projectStatus
                    ? ucfirst(
                        str_replace(
                            '-',
                            ' ',
                            $projectStatus
                        )
                    )
                    : 'N/A'
                }}

            </span>

        </div>



        {{-- CONTRACT AMOUNT --}}

        <div class="detail-item">

            <span class="detail-label">
                Contract Amount
            </span>

            <strong class="detail-value">

                @if($contractAmount !== null)

                    ৳{{ number_format(
                        (float) $contractAmount,
                        2
                    ) }}

                @else

                    No Budget

                @endif

            </strong>

        </div>



        {{-- PAYMENT ID --}}

        <div class="detail-item">

            <span class="detail-label">
                Payment ID
            </span>

            <strong class="detail-value">

                #{{ $payment->id }}

            </strong>

        </div>

    </div>

</div>



{{-- =====================================================
    PAYMENT SUMMARY
====================================================== --}}

@php

    $currentPayment =
        (float) $payment->amount;

    $remainingForEdit =
        $remainingForEdit !== null
            ? (float) $remainingForEdit
            : null;


    /*
    |--------------------------------------------------------------------------
    | OTHER PAYMENTS
    |--------------------------------------------------------------------------
    */

    $otherPayments =
        $remainingForEdit !== null
            ? max(
                $remainingForEdit
                - $currentPayment,
                0
            )
            : null;


    /*
    |--------------------------------------------------------------------------
    | AFTER UPDATE
    |--------------------------------------------------------------------------
    */

    $currentRemainingAfterUpdate =
        $remainingForEdit !== null
            ? max(
                $remainingForEdit
                - $currentPayment,
                0
            )
            : null;

@endphp


<div class="panel">

    <div class="panel-header">

        <div>

            <h2>
                Payment Summary
            </h2>

            <p>
                Current payment and remaining contract amount.
            </p>

        </div>

    </div>


    <div class="payment-detail-grid">


        {{-- CURRENT PAYMENT --}}

        <div class="payment-detail-card">

            <span>
                Current Payment
            </span>

            <strong>

                ৳{{ number_format(
                    $currentPayment,
                    2
                ) }}

            </strong>

        </div>



        {{-- CONTRACT AMOUNT --}}

        <div class="payment-detail-card">

            <span>
                Contract Amount
            </span>

            <strong>

                @if($contractAmount !== null)

                    ৳{{ number_format(
                        (float) $contractAmount,
                        2
                    ) }}

                @else

                    No Budget

                @endif

            </strong>

        </div>



        {{-- MAXIMUM ALLOWED --}}

        <div class="payment-detail-card">

            <span>
                Maximum Allowed
            </span>

            <strong>

                @if($remainingForEdit !== null)

                    ৳{{ number_format(
                        $remainingForEdit,
                        2
                    ) }}

                @else

                    N/A

                @endif

            </strong>

        </div>



        {{-- REMAINING AFTER CURRENT --}}

        <div class="payment-detail-card">

            <span>
                Remaining After Current
            </span>

            <strong class="text-danger">

                @if($currentRemainingAfterUpdate !== null)

                    ৳{{ number_format(
                        $currentRemainingAfterUpdate,
                        2
                    ) }}

                @else

                    N/A

                @endif

            </strong>

        </div>

    </div>

</div>



{{-- =====================================================
    EDIT PAYMENT FORM
====================================================== --}}

<div class="panel">

    <div class="panel-header">

        <div>

            <h2>
                Update Payment
            </h2>

            <p>
                Change the payment information below.
            </p>

        </div>

    </div>


    <div class="form-container">

        <form
            action="{{ route(
                'admin.payments.update',
                $payment
            ) }}"
            method="POST"
            id="paymentEditForm"
        >

            @csrf



            {{-- =================================================
                PAYMENT AMOUNT
            ================================================== --}}

            <div class="form-group">

                <label for="amount">

                    Payment Amount

                    <span class="required">
                        *
                    </span>

                </label>


                <input
                    type="number"
                    name="amount"
                    id="amount"
                    value="{{ old(
                        'amount',
                        $payment->amount
                    ) }}"
                    min="0.01"
                    step="0.01"
                    @if($remainingForEdit !== null)
                        max="{{ $remainingForEdit }}"
                    @endif
                    required
                >


                <small
                    id="amountMessage"
                    class="form-help"
                >

                    @if($remainingForEdit !== null)

                        Maximum allowed:
                        ৳{{ number_format(
                            $remainingForEdit,
                            2
                        ) }}

                    @endif

                </small>


                @error('amount')

                    <small class="field-error">
                        {{ $message }}
                    </small>

                @enderror

            </div>



            {{-- =================================================
                PAYMENT DATE
            ================================================== --}}

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
                        $payment->payment_date
                    ) }}"
                    required
                >


                @error('payment_date')

                    <small class="field-error">
                        {{ $message }}
                    </small>

                @enderror

            </div>



            {{-- =================================================
                PAYMENT METHOD
            ================================================== --}}

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
                    required
                >

                    <option value="">
                        -- Select Payment Method --
                    </option>


                    <option
                        value="Cash"
                        {{ old(
                            'payment_method',
                            $payment->payment_method
                        ) === 'Cash'
                            ? 'selected'
                            : ''
                        }}
                    >
                        Cash
                    </option>


                    <option
                        value="Bank Transfer"
                        {{ old(
                            'payment_method',
                            $payment->payment_method
                        ) === 'Bank Transfer'
                            ? 'selected'
                            : ''
                        }}
                    >
                        Bank Transfer
                    </option>


                    <option
                        value="Cheque"
                        {{ old(
                            'payment_method',
                            $payment->payment_method
                        ) === 'Cheque'
                            ? 'selected'
                            : ''
                        }}
                    >
                        Cheque
                    </option>


                    <option
                        value="Mobile Banking"
                        {{ old(
                            'payment_method',
                            $payment->payment_method
                        ) === 'Mobile Banking'
                            ? 'selected'
                            : ''
                        }}
                    >
                        Mobile Banking
                    </option>


                    <option
                        value="Other"
                        {{ old(
                            'payment_method',
                            $payment->payment_method
                        ) === 'Other'
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
                    placeholder="Enter any additional payment note..."
                >{{ old(
                    'note',
                    $payment->note
                ) }}</textarea>


                @error('note')

                    <small class="field-error">
                        {{ $message }}
                    </small>

                @enderror

            </div>



            {{-- =================================================
                LIVE SUMMARY
            ================================================== --}}

            <div
                class="payment-summary"
                style="margin-top:20px;"
            >

                <div class="payment-summary-header">

                    <div>

                        <h3>
                            After Update
                        </h3>

                        <p>
                            Estimated remaining amount after this payment is updated.
                        </p>

                    </div>

                </div>


                <div class="payment-summary-grid">

                    <div class="payment-summary-card">

                        <span>
                            New Payment
                        </span>

                        <strong id="newPayment">
                            ৳{{ number_format(
                                $currentPayment,
                                2
                            ) }}
                        </strong>

                    </div>


                    <div class="payment-summary-card">

                        <span>
                            Remaining After Update
                        </span>

                        <strong
                            id="newRemaining"
                            class="text-danger"
                        >

                            @if($currentRemainingAfterUpdate !== null)

                                ৳{{ number_format(
                                    $currentRemainingAfterUpdate,
                                    2
                                ) }}

                            @else

                                N/A

                            @endif

                        </strong>

                    </div>

                </div>

            </div>



            {{-- =================================================
                FORM ACTIONS
            ================================================== --}}

            <div class="form-actions">

                <a
                    href="{{ route(
                        'admin.payments.show',
                        $payment
                    ) }}"
                    class="secondary-btn"
                >
                    Cancel
                </a>


                <button
                    type="submit"
                    class="primary-btn"
                    id="updatePaymentButton"
                >
                    Update Payment
                </button>

            </div>


        </form>

    </div>

</div>



{{-- =====================================================
    JAVASCRIPT
====================================================== --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const amountInput =
        document.getElementById('amount');

    const newPayment =
        document.getElementById('newPayment');

    const newRemaining =
        document.getElementById('newRemaining');

    const amountMessage =
        document.getElementById('amountMessage');

    const updateButton =
        document.getElementById(
            'updatePaymentButton'
        );

    const paymentEditForm =
        document.getElementById(
            'paymentEditForm'
        );


    /*
    |--------------------------------------------------------------------------
    | MAXIMUM ALLOWED
    |--------------------------------------------------------------------------
    */

    const maximumAllowed =
        {{ $remainingForEdit !== null
            ? $remainingForEdit
            : 'null'
        }};


    /*
    |--------------------------------------------------------------------------
    | FORMAT MONEY
    |--------------------------------------------------------------------------
    */

    function formatMoney(value) {

        return Number(value).toLocaleString(
            'en-US',
            {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | CALCULATE
    |--------------------------------------------------------------------------
    */

    function calculate() {

        const paymentAmount =
            parseFloat(
                amountInput.value
            ) || 0;


        /*
        |--------------------------------------------------------------------------
        | NO BUDGET
        |--------------------------------------------------------------------------
        */

        if (maximumAllowed === null) {

            newPayment.textContent =
                `৳${formatMoney(
                    paymentAmount
                )}`;

            newRemaining.textContent =
                'N/A';

            updateButton.disabled =
                true;

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | EXCEEDS MAXIMUM
        |--------------------------------------------------------------------------
        */

        if (
            paymentAmount >
            maximumAllowed
        ) {

            const excess =
                paymentAmount -
                maximumAllowed;


            newPayment.textContent =
                `৳${formatMoney(
                    paymentAmount
                )}`;


            newRemaining.textContent =
                `-৳${formatMoney(
                    excess
                )}`;


            newRemaining.className =
                'text-danger';


            amountMessage.textContent =
                `Payment cannot exceed ৳${formatMoney(
                    maximumAllowed
                )}.`;


            amountMessage.className =
                'field-error';


            updateButton.disabled =
                true;

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | VALID
        |--------------------------------------------------------------------------
        */

        const remaining =
            maximumAllowed -
            paymentAmount;


        newPayment.textContent =
            `৳${formatMoney(
                paymentAmount
            )}`;


        newRemaining.textContent =
            `৳${formatMoney(
                remaining
            )}`;


        if (remaining > 0) {

            newRemaining.className =
                'text-danger';

        } else {

            newRemaining.className =
                'text-success';

        }


        amountMessage.textContent =
            `Maximum allowed: ৳${formatMoney(
                maximumAllowed
            )}.`;


        amountMessage.className =
            'form-help';


        updateButton.disabled =
            paymentAmount <= 0;

    }


    /*
    |--------------------------------------------------------------------------
    | AMOUNT INPUT
    |--------------------------------------------------------------------------
    */

    amountInput.addEventListener(
        'input',
        calculate
    );


    /*
    |--------------------------------------------------------------------------
    | FORM SUBMIT
    |--------------------------------------------------------------------------
    */

    paymentEditForm.addEventListener(
        'submit',
        function (event) {

            const paymentAmount =
                parseFloat(
                    amountInput.value
                ) || 0;


            if (
                maximumAllowed === null
            ) {

                event.preventDefault();

                alert(
                    'This project does not have a budget.'
                );

                return;

            }


            if (
                paymentAmount <= 0
            ) {

                event.preventDefault();

                alert(
                    'Please enter a valid payment amount.'
                );

                return;

            }


            if (
                paymentAmount >
                maximumAllowed
            ) {

                event.preventDefault();

                alert(
                    `Payment cannot exceed ৳${formatMoney(
                        maximumAllowed
                    )}.`
                );

                return;

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | INITIAL CALCULATION
    |--------------------------------------------------------------------------
    */

    calculate();

});

</script>


@endsection