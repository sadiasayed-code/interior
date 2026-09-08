@extends('backend.layouts.admin')

@section('title', 'Payments')

@section('page_title', 'Payments')

@section('content')


{{-- =====================================================
    PAGE HEADER
====================================================== --}}

<div class="page-header">

    <div>

        <h1>
            Payments
        </h1>

        <p>
            View payment summaries for each project.
        </p>

    </div>


    <a
        href="{{ route('admin.payments.create') }}"
        class="primary-btn"
    >
        + Add Payment
    </a>

</div>



{{-- =====================================================
    PAYMENT SUMMARY
====================================================== --}}

<div class="panel">

    <div class="panel-header">

        <div>

            <h2>
                Project Payment List
            </h2>

            <p>
                Track contract amount, payments received and remaining amounts.
            </p>

        </div>


        <span class="table-count">

            {{ $projects->count() }}

            {{ $projects->count() === 1 ? 'Project' : 'Projects' }}

        </span>

    </div>



    {{-- =================================================
        TABLE
    ================================================== --}}

    <div class="table-wrapper">

        <table>

            <thead>

                <tr>

                    <th>
                        #
                    </th>

                    <th>
                        PROJECT
                    </th>

                    <th>
                        CONTRACT AMOUNT
                    </th>

                    <th>
                        TOTAL PAID
                    </th>

                    <th>
                        REMAINING
                    </th>

                    <th>
                        PAYMENT STATUS
                    </th>

                    <th>
                        PROJECT STATUS
                    </th>

                    <th>
                        ACTIONS
                    </th>

                </tr>

            </thead>



            <tbody>

                @forelse($projects as $project)

                    @php

                        /*
                        |--------------------------------------------------------------------------
                        | VALUES FROM CONTROLLER
                        |--------------------------------------------------------------------------
                        */

                        $contractAmount =
                            (float) ($project->contract_amount ?? 0);

                        $totalPaid =
                            (float) ($project->total_paid ?? 0);

                        $remaining =
                            (float) ($project->remaining_amount ?? 0);


                        /*
                        |--------------------------------------------------------------------------
                        | PAYMENT STATUS
                        |--------------------------------------------------------------------------
                        */

                        if (!$project->budget) {

                            $paymentStatus =
                                'No Budget';

                        } elseif ($remaining > 0) {

                            $paymentStatus =
                                'Payment Due';

                        } else {

                            $paymentStatus =
                                'Fully Paid';

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | PAYMENT STATUS CLASS
                        |--------------------------------------------------------------------------
                        */

                        $paymentStatusClass = match(
                            $paymentStatus
                        ) {

                            'Payment Due' =>
                                'status-warning',

                            'Fully Paid' =>
                                'status-success',

                            'No Budget' =>
                                'status-secondary',

                            default =>
                                'status-secondary',

                        };


                        /*
                        |--------------------------------------------------------------------------
                        | REMAINING AMOUNT CLASS
                        |--------------------------------------------------------------------------
                        */

                        if ($remaining > 0) {

                            $remainingClass =
                                'text-danger';

                        } elseif ($remaining == 0) {

                            $remainingClass =
                                'text-success';

                        } else {

                            $remainingClass =
                                'text-danger';

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | PROJECT STATUS CLASS
                        |--------------------------------------------------------------------------
                        */

                        $statusClass = match(
                            $project->status
                        ) {

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



                    <tr>


                        {{-- =================================================
                            SERIAL
                        ================================================== --}}

                        <td>

                            {{ $loop->iteration }}

                        </td>



                        {{-- =================================================
                            PROJECT
                        ================================================== --}}

                        <td>

                            <strong>

                                {{ $project->project_name }}

                            </strong>


                            @if($project->client)

                                <small
                                    style="
                                        display:block;
                                        margin-top:4px;
                                        color:#6b7280;
                                    "
                                >

                                    {{ $project->client->name }}

                                </small>

                            @endif

                        </td>



                        {{-- =================================================
                            CONTRACT AMOUNT
                        ================================================== --}}

                        <td>

                            @if($project->budget)

                                <strong>

                                    ৳{{ number_format(
                                        $contractAmount,
                                        2
                                    ) }}

                                </strong>

                            @else

                                <span class="text-muted">
                                    No Budget
                                </span>

                            @endif

                        </td>



                        {{-- =================================================
                            TOTAL PAID
                        ================================================== --}}

                        <td>

                            <strong>

                                ৳{{ number_format(
                                    $totalPaid,
                                    2
                                ) }}

                            </strong>

                        </td>



                        {{-- =================================================
                            REMAINING
                        ================================================== --}}

                        <td>

                            @if($project->budget)

                                <strong
                                    class="{{ $remainingClass }}"
                                >

                                    @if($remaining > 0)

                                        ৳{{ number_format(
                                            $remaining,
                                            2
                                        ) }}

                                    @elseif($remaining < 0)

                                        -৳{{ number_format(
                                            abs($remaining),
                                            2
                                        ) }}

                                    @else

                                        ৳0.00

                                    @endif

                                </strong>

                            @else

                                <span class="text-muted">
                                    N/A
                                </span>

                            @endif

                        </td>



                        {{-- =================================================
                            PAYMENT STATUS
                        ================================================== --}}

                        <td>

                            <span
                                class="status-badge {{ $paymentStatusClass }}"
                            >

                                {{ $paymentStatus }}

                            </span>

                        </td>



                        {{-- =================================================
                            PROJECT STATUS
                        ================================================== --}}

                        <td>

                            <span
                                class="status-badge {{ $statusClass }}"
                            >

                                {{ ucfirst(
                                    str_replace(
                                        '-',
                                        ' ',
                                        $project->status
                                    )
                                ) }}

                            </span>

                        </td>



                        {{-- =================================================
                            ACTIONS
                        ================================================== --}}

                        <td>

                            <div class="table-actions">


                                {{-- =================================================
                                    VIEW
                                ================================================== --}}

                                @php

                                    $firstPayment =
                                        $project->payments->first();

                                @endphp


                                @if($firstPayment)

                                    <a
                                        href="{{ route(
                                            'admin.payments.show',
                                            $firstPayment
                                        ) }}"
                                        class="small-action view"
                                    >
                                        View
                                    </a>

                                @endif



                                {{-- =================================================
                                    ADD PAYMENT
                                ================================================== --}}

                                @if(
                                    $project->status !== 'cancelled'
                                    &&
                                    $project->budget
                                    &&
                                    $remaining > 0
                                )

                                    <a
                                        href="{{ route(
                                            'admin.payments.create'
                                        ) }}"
                                        class="small-action edit"
                                    >
                                        + Payment
                                    </a>

                                @elseif($project->status === 'cancelled')

                                    <span
                                        class="small-action disabled-action"
                                    >
                                        Cancelled
                                    </span>

                                @elseif($project->budget && $remaining <= 0)

                                    <span
                                        class="small-action disabled-action"
                                    >
                                        Fully Paid
                                    </span>

                                @else

                                    <span
                                        class="small-action disabled-action"
                                    >
                                        No Budget
                                    </span>

                                @endif


                            </div>

                        </td>


                    </tr>


                @empty


                    {{-- =================================================
                        EMPTY STATE
                    ================================================== --}}

                    <tr>

                        <td
                            colspan="8"
                            class="empty-state"
                        >

                            <div>

                                <strong>
                                    No payments found.
                                </strong>

                                <p>
                                    Add a payment to a project
                                    to see it here.
                                </p>


                                <a
                                    href="{{ route(
                                        'admin.payments.create'
                                    ) }}"
                                    class="primary-btn"
                                >
                                    + Add Payment
                                </a>

                            </div>

                        </td>

                    </tr>


                @endforelse


            </tbody>

        </table>

    </div>

</div>


@endsection