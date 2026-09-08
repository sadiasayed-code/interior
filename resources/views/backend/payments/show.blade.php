@extends('backend.layouts.admin')

@section('title', 'Payment Details')

@section('page_title', 'Payment Details')

@section('content')


{{-- =====================================================
    PAGE HEADER
====================================================== --}}

<div class="page-header">

    <div>

        <h1>
            Payment Details
        </h1>

        <p>
            Complete payment milestone details and project payment summary.
        </p>

    </div>


    <div class="table-actions">

        <a
            href="{{ route('admin.payments.index') }}"
            class="secondary-btn"
        >
            ← Back
        </a>


        @if(
            $project &&
            $project->status !== 'cancelled'
        )

            <a
                href="{{ route(
                    'admin.payments.edit',
                    $payment
                ) }}"
                class="primary-btn"
            >
                Edit Payment
            </a>

        @endif

    </div>

</div>



{{-- =====================================================
    PROJECT INFORMATION
====================================================== --}}

@php

    /*
    |--------------------------------------------------------------------------
    | PROJECT STATUS
    |--------------------------------------------------------------------------
    */

    $projectStatus =
        $project->status ?? 'pending';


    $projectStatusClass = match($projectStatus) {

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


    /*
    |--------------------------------------------------------------------------
    | INDIVIDUAL PAYMENT STATUS
    |--------------------------------------------------------------------------
    */

    $selectedPaymentStatus =
        $payment->status ?? 'pending';


    $selectedPaymentStatusClass = match(
        $selectedPaymentStatus
    ) {

        'paid' =>
            'status-success',

        'pending' =>
            'status-warning',

        'upcoming' =>
            'status-info',

        'overdue' =>
            'status-danger',

        default =>
            'status-secondary',

    };

@endphp



<div class="panel">

    <div class="panel-header">

        <div>

            <h2>
                Project Information
            </h2>

            <p>
                Basic information about this project's payment.
            </p>

        </div>


        <span
            class="
                status-badge
                {{ $projectStatusClass }}
            "
        >

            {{
                ucfirst(
                    str_replace(
                        '-',
                        ' ',
                        $projectStatus
                    )
                )
            }}

        </span>

    </div>



    <div class="detail-grid">


        {{-- PROJECT --}}

        <div class="detail-item">

            <span class="detail-label">
                Project
            </span>

            <strong class="detail-value">

                {{
                    $project->project_name
                    ??
                    'N/A'
                }}

            </strong>

        </div>



        {{-- CLIENT --}}

        <div class="detail-item">

            <span class="detail-label">
                Client
            </span>

            <strong class="detail-value">

                {{
                    $project->client?->name
                    ??
                    'N/A'
                }}

            </strong>

        </div>



        {{-- CLIENT PHONE --}}

        <div class="detail-item">

            <span class="detail-label">
                Client Phone
            </span>

            <strong class="detail-value">

                {{
                    $project->client?->phone
                    ??
                    'N/A'
                }}

            </strong>

        </div>



        {{-- SELECTED PAYMENT --}}

        <div class="detail-item">

            <span class="detail-label">
                Selected Payment ID
            </span>

            <strong class="detail-value">

                #{{ $payment->id }}

            </strong>

        </div>


    </div>

</div>



{{-- =====================================================
    FINANCIAL SUMMARY
====================================================== --}}

@php

    /*
    |--------------------------------------------------------------------------
    | CONTRACT AMOUNT
    |--------------------------------------------------------------------------
    */

    $displayContractAmount =
        (float) ($contractAmount ?? 0);


    /*
    |--------------------------------------------------------------------------
    | TOTAL PAID
    |--------------------------------------------------------------------------
    |
    | ONLY status = paid
    |
    */

    $displayTotalPaid =
        (float) ($totalPaid ?? 0);


    /*
    |--------------------------------------------------------------------------
    | TOTAL DUE
    |--------------------------------------------------------------------------
    */

    $displayRemaining =
        (float) ($remainingAmount ?? 0);


    /*
    |--------------------------------------------------------------------------
    | PROJECT PAYMENT STATUS
    |--------------------------------------------------------------------------
    */

    if (!$project->budget) {

        $projectPaymentStatus =
            'No Budget';

        $projectPaymentStatusClass =
            'status-secondary';

    }
    elseif ($displayContractAmount <= 0) {

        $projectPaymentStatus =
            'No Contract';

        $projectPaymentStatusClass =
            'status-secondary';

    }
    elseif ($displayRemaining <= 0) {

        $projectPaymentStatus =
            'Fully Paid';

        $projectPaymentStatusClass =
            'status-success';

    }
    elseif ($displayTotalPaid > 0) {

        $projectPaymentStatus =
            'Partially Paid';

        $projectPaymentStatusClass =
            'status-info';

    }
    else {

        $projectPaymentStatus =
            'Payment Due';

        $projectPaymentStatusClass =
            'status-warning';

    }


    /*
    |--------------------------------------------------------------------------
    | REMAINING AMOUNT CLASS
    |--------------------------------------------------------------------------
    */

    $remainingClass =
        $displayRemaining > 0
            ? 'text-danger'
            : 'text-success';

@endphp



<div class="panel">

    <div class="panel-header">

        <div>

            <h2>
                Financial Summary
            </h2>

            <p>
                Current financial position of this project.
            </p>

        </div>

    </div>



    <div class="payment-detail-grid">


        {{-- CONTRACT AMOUNT --}}

        <div class="payment-detail-card">

            <span>
                Contract Amount
            </span>

            <strong>

                @if($project->budget)

                    ৳{{ number_format(
                        $displayContractAmount,
                        2
                    ) }}

                @else

                    N/A

                @endif

            </strong>

        </div>



        {{-- TOTAL PAID --}}

        <div class="payment-detail-card">

            <span>
                Total Paid
            </span>

            <strong>

                ৳{{ number_format(
                    $displayTotalPaid,
                    2
                ) }}

            </strong>

        </div>



        {{-- TOTAL DUE --}}

        <div class="payment-detail-card">

            <span>
                Total Due
            </span>

            <strong
                class="{{ $remainingClass }}"
            >

                @if(!$project->budget)

                    N/A

                @else

                    ৳{{ number_format(
                        $displayRemaining,
                        2
                    ) }}

                @endif

            </strong>

        </div>



        {{-- PAYMENT STATUS --}}

        <div class="payment-detail-card">

            <span>
                Payment Status
            </span>

            <strong>

                <span
                    class="
                        status-badge
                        {{ $projectPaymentStatusClass }}
                    "
                >

                    {{ $projectPaymentStatus }}

                </span>

            </strong>

        </div>


    </div>

</div>



{{-- =====================================================
    SELECTED PAYMENT INFORMATION
====================================================== --}}

<div class="panel">

    <div class="panel-header">

        <div>

            <h2>
                Selected Payment Information
            </h2>

            <p>
                Complete details of the selected payment milestone.
            </p>

        </div>


        <span
            class="
                status-badge
                {{ $selectedPaymentStatusClass }}
            "
        >

            {{
                ucfirst(
                    $selectedPaymentStatus
                )
            }}

        </span>

    </div>



    <div class="detail-grid">


        {{-- MILESTONE --}}

        <div class="detail-item">

            <span class="detail-label">
                Milestone
            </span>

            <strong class="detail-value">

                {{
                    $payment->milestone
                    ??
                    'N/A'
                }}

            </strong>

        </div>



        {{-- AMOUNT --}}

        <div class="detail-item">

            <span class="detail-label">
                Amount
            </span>

            <strong class="detail-value">

                ৳{{ number_format(
                    (float) $payment->amount,
                    2
                ) }}

            </strong>

        </div>



        {{-- DUE DATE --}}

        <div class="detail-item">

            <span class="detail-label">
                Due Date
            </span>

            <strong class="detail-value">

                @if($payment->due_date)

                    {{
                        $payment->due_date
                        ->format('d M Y')
                    }}

                @else

                    N/A

                @endif

            </strong>

        </div>



        {{-- PAYMENT DATE --}}

        <div class="detail-item">

            <span class="detail-label">
                Payment Date
            </span>

            <strong class="detail-value">

                @if($payment->payment_date)

                    {{
                        $payment->payment_date
                        ->format('d M Y')
                    }}

                @else

                    N/A

                @endif

            </strong>

        </div>



        {{-- STATUS --}}

        <div class="detail-item">

            <span class="detail-label">
                Status
            </span>

            <strong class="detail-value">

                <span
                    class="
                        status-badge
                        {{ $selectedPaymentStatusClass }}
                    "
                >

                    {{
                        ucfirst(
                            $selectedPaymentStatus
                        )
                    }}

                </span>

            </strong>

        </div>



        {{-- PAYMENT METHOD --}}

        <div class="detail-item">

            <span class="detail-label">
                Payment Method
            </span>

            <strong class="detail-value">

                {{
                    $payment->payment_method
                    ??
                    'N/A'
                }}

            </strong>

        </div>



        {{-- NOTE --}}

        <div class="detail-item">

            <span class="detail-label">
                Note
            </span>

            <strong class="detail-value">

                {{
                    $payment->note
                    ??
                    'No note provided.'
                }}

            </strong>

        </div>


    </div>

</div>



{{-- =====================================================
    PAYMENT MILESTONE HISTORY
====================================================== --}}

<div class="panel">

    <div class="panel-header">

        <div>

            <h2>
                Payment Milestones
            </h2>

            <p>
                All payment milestones created for this project.
            </p>

        </div>


        <span class="table-count">

            {{ $project->payments->count() }}

            {{
                $project->payments->count() === 1
                    ? 'Milestone'
                    : 'Milestones'
            }}

        </span>

    </div>



    <div class="table-wrapper">

        <table>

            <thead>

                <tr>

                    <th>
                        #
                    </th>


                    <th>
                        MILESTONE
                    </th>


                    <th>
                        AMOUNT
                    </th>


                    <th>
                        DUE DATE
                    </th>


                    <th>
                        PAYMENT DATE
                    </th>


                    <th>
                        STATUS
                    </th>


                    <th>
                        PAYMENT METHOD
                    </th>


                    <th>
                        NOTE
                    </th>


                    <th>
                        ACTIONS
                    </th>

                </tr>

            </thead>



            <tbody>


                @forelse(
                    $project->payments->sortBy('due_date')
                    as $historyPayment
                )


                    @php

                        $historyStatus =
                            $historyPayment->status
                            ??
                            'pending';


                        $historyStatusClass =
                            match($historyStatus) {

                                'paid' =>
                                    'status-success',

                                'pending' =>
                                    'status-warning',

                                'upcoming' =>
                                    'status-info',

                                'overdue' =>
                                    'status-danger',

                                default =>
                                    'status-secondary',

                            };

                    @endphp



                    <tr>


                        {{-- SERIAL --}}

                        <td>

                            {{ $loop->iteration }}

                        </td>



                        {{-- MILESTONE --}}

                        <td>

                            <strong>

                                {{
                                    $historyPayment->milestone
                                    ??
                                    'N/A'
                                }}

                            </strong>

                        </td>



                        {{-- AMOUNT --}}

                        <td>

                            ৳{{ number_format(
                                (float) $historyPayment->amount,
                                2
                            ) }}

                        </td>



                        {{-- DUE DATE --}}

                        <td>

                            @if($historyPayment->due_date)

                                {{
                                    $historyPayment->due_date
                                    ->format('d M Y')
                                }}

                            @else

                                N/A

                            @endif

                        </td>



                        {{-- PAYMENT DATE --}}

                        <td>

                            @if($historyPayment->payment_date)

                                {{
                                    $historyPayment->payment_date
                                    ->format('d M Y')
                                }}

                            @else

                                —

                            @endif

                        </td>



                        {{-- STATUS --}}

                        <td>

                            <span
                                class="
                                    status-badge
                                    {{ $historyStatusClass }}
                                "
                            >

                                {{
                                    ucfirst(
                                        $historyStatus
                                    )
                                }}

                            </span>

                        </td>



                        {{-- PAYMENT METHOD --}}

                        <td>

                            {{
                                $historyPayment->payment_method
                                ??
                                '—'
                            }}

                        </td>



                        {{-- NOTE --}}

                        <td>

                            @if($historyPayment->note)

                                {{
                                    $historyPayment->note
                                }}

                            @else

                                —

                            @endif

                        </td>



                        {{-- ACTIONS --}}

                        <td>


                            @if(
                                $projectStatus !== 'cancelled'
                            )

                                <div class="table-actions">


                                    {{-- EDIT --}}

                                    <a
                                        href="{{ route(
                                            'admin.payments.edit',
                                            $historyPayment
                                        ) }}"
                                        class="small-action edit"
                                    >

                                        Edit

                                    </a>



                                    {{-- DELETE --}}

                                    <form
                                        action="{{ route(
                                            'admin.payments.destroy',
                                            $historyPayment
                                        ) }}"
                                        method="POST"
                                        style="display:inline;"
                                        onsubmit="
                                            return confirm(
                                                'Are you sure you want to delete this payment milestone?'
                                            );
                                        "
                                    >

                                        @csrf


                                        <button
                                            type="submit"
                                            class="small-action delete"
                                        >

                                            Delete

                                        </button>

                                    </form>


                                </div>

                            @else

                                —

                            @endif


                        </td>


                    </tr>


                @empty


                    <tr>

                        <td
                            colspan="9"
                            class="empty-state"
                        >

                            <strong>
                                No Payment Milestones Found
                            </strong>

                            <p>
                                No payment milestone has been created
                                for this project yet.
                            </p>

                        </td>

                    </tr>


                @endforelse


            </tbody>



            {{-- =============================================
                FOOTER SUMMARY
            ============================================== --}}

            @if(
                $project->payments->count() > 0
            )

                <tfoot>

                    <tr>


                        <th
                            colspan="2"
                            style="text-align:right;"
                        >

                            TOTAL PAID

                        </th>


                        <th>

                            ৳{{ number_format(
                                $displayTotalPaid,
                                2
                            ) }}

                        </th>


                        <th colspan="6"></th>


                    </tr>

                </tfoot>

            @endif


        </table>

    </div>

</div>



{{-- =====================================================
    PAYMENT ANALYSIS
====================================================== --}}

<div class="panel">

    <div class="panel-header">

        <div>

            <h2>
                Payment Analysis
            </h2>

            <p>
                Current payment position based on the contract amount.
            </p>

        </div>

    </div>



    <div class="budget-analysis">


        @if(!$project->budget)


            <div class="alert alert-error">

                <div>

                    <strong>
                        No Budget Available
                    </strong>

                    <p>
                        A contract amount has not been set
                        for this project yet.
                    </p>

                </div>

            </div>


        @elseif($displayRemaining > 0)


            <div class="alert alert-success">

                <div>

                    <strong>
                        Payment Still Due
                    </strong>

                    <p>

                        ৳{{ number_format(
                            $displayRemaining,
                            2
                        ) }}

                        is still due from the client.

                    </p>

                </div>

            </div>


        @else


            <div class="alert alert-success">

                <div>

                    <strong>
                        Payment Fully Completed
                    </strong>

                    <p>
                        The full contract amount has been received.
                    </p>

                </div>

            </div>


        @endif


    </div>

</div>



{{-- =====================================================
    PAGE ACTIONS
====================================================== --}}

<div class="form-actions">


    <a
        href="{{ route('admin.payments.index') }}"
        class="secondary-btn"
    >

        ← Back to Payments

    </a>



    @if(
        $projectStatus !== 'cancelled'
        &&
        $project->budget
        &&
        $displayRemaining > 0
    )

        <a
            href="{{ route('admin.payments.create') }}"
            class="primary-btn"
        >

            + Add New Payment

        </a>

    @endif


</div>


@endsection