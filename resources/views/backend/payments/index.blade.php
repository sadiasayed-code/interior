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


    {{-- =================================================
        PANEL HEADER
    ================================================== --}}

    <div class="panel-header">

        <div>

            <h2>
                Project Payment List
            </h2>

            <p>
                Track contract amount, payments received and
                remaining amounts.
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

    @if($projects->count() > 0)


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
                            TOTAL DUE
                        </th>


                        <th>
                            PAYMENT STATUS
                        </th>


                        <th>
                            PROJECT STATUS
                        </th>


                        <th>
                            ACTION
                        </th>

                    </tr>

                </thead>



                <tbody>


                    @foreach($projects as $project)


                        {{-- =========================================
                            PROJECT PAYMENT CALCULATIONS
                        ========================================== --}}

                        @php

                            /*
                            |--------------------------------------------------------------------------
                            | CONTRACT AMOUNT
                            |--------------------------------------------------------------------------
                            |
                            | Contract Amount always comes
                            | from the project's budget.
                            |
                            */

                            $contractAmount = $project->budget
                                ? (float) $project->budget->contract_amount
                                : 0;


                            /*
                            |--------------------------------------------------------------------------
                            | TOTAL PAID
                            |--------------------------------------------------------------------------
                            |
                            | ONLY payments with status = paid
                            | are counted as received money.
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
                            |
                            | Contract Amount - Total Paid
                            |
                            */

                            $totalDue = max(

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

                            if (!$project->budget) {

                                $paymentStatus =
                                    'No Budget';

                                $paymentStatusClass =
                                    'status-secondary';

                            }
                            elseif ($contractAmount <= 0) {

                                $paymentStatus =
                                    'No Contract';

                                $paymentStatusClass =
                                    'status-secondary';

                            }
                            elseif ($totalDue <= 0) {

                                $paymentStatus =
                                    'Fully Paid';

                                $paymentStatusClass =
                                    'status-success';

                            }
                            elseif ($totalPaid > 0) {

                                $paymentStatus =
                                    'Partially Paid';

                                $paymentStatusClass =
                                    'status-info';

                            }
                            else {

                                $paymentStatus =
                                    'Payment Due';

                                $paymentStatusClass =
                                    'status-warning';

                            }



                            /*
                            |--------------------------------------------------------------------------
                            | PROJECT STATUS
                            |--------------------------------------------------------------------------
                            */

                            $projectStatus =
                                $project->status
                                ??
                                'pending';


                            $projectStatusClass =
                                match($projectStatus) {

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
                            | FIRST PAYMENT
                            |--------------------------------------------------------------------------
                            |
                            | Existing show route requires Payment ID.
                            |
                            */

                            $firstPayment =
                                $project
                                    ->payments
                                    ->first();

                        @endphp



                        <tr>


                            {{-- =====================================
                                SERIAL
                            ====================================== --}}

                            <td>

                                {{ $loop->iteration }}

                            </td>



                            {{-- =====================================
                                PROJECT / CLIENT
                            ====================================== --}}

                            <td>

                                <span class="project-name">

                                    {{
                                        $project->project_name
                                        ??
                                        'Untitled Project'
                                    }}

                                </span>


                                <span class="client-name">

                                    {{
                                        $project->client?->name
                                        ??
                                        'No Client'
                                    }}

                                </span>

                            </td>



                            {{-- =====================================
                                CONTRACT AMOUNT
                            ====================================== --}}

                            <td>


                                @if($project->budget)


                                    <span class="amount">

                                        ৳ {{ number_format(
                                            $contractAmount,
                                            2
                                        ) }}

                                    </span>


                                @else


                                    <span
                                        class="
                                            status-badge
                                            status-secondary
                                        "
                                    >

                                        No Budget

                                    </span>


                                @endif


                            </td>



                            {{-- =====================================
                                TOTAL PAID
                            ====================================== --}}

                            <td>

                                <span class="amount-paid">

                                    ৳ {{ number_format(
                                        $totalPaid,
                                        2
                                    ) }}

                                </span>

                            </td>



                            {{-- =====================================
                                TOTAL DUE
                            ====================================== --}}

                            <td>


                                @if($project->budget)


                                    @if($totalDue > 0)


                                        <span class="amount-due">

                                            ৳ {{ number_format(
                                                $totalDue,
                                                2
                                            ) }}

                                        </span>


                                    @else


                                        <span class="fully-paid">

                                            Fully Paid

                                        </span>


                                    @endif


                                @else


                                    <span
                                        class="
                                            status-badge
                                            status-secondary
                                        "
                                    >

                                        N/A

                                    </span>


                                @endif


                            </td>



                            {{-- =====================================
                                PAYMENT STATUS
                            ====================================== --}}

                            <td>

                                <span
                                    class="
                                        status-badge
                                        {{ $paymentStatusClass }}
                                    "
                                >

                                    {{ $paymentStatus }}

                                </span>

                            </td>



                            {{-- =====================================
                                PROJECT STATUS
                            ====================================== --}}

                            <td>

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

                            </td>



                            {{-- =====================================
                                ACTION
                            ====================================== --}}

                            <td>


                                @if($firstPayment)


                                    <a
                                        href="{{ route(
                                            'admin.payments.show',
                                            $firstPayment->id
                                        ) }}"
                                        class="btn-view"
                                    >

                                        View

                                    </a>


                                @else


                                    <span
                                        class="
                                            status-badge
                                            status-secondary
                                        "
                                    >

                                        No Payment Yet

                                    </span>


                                @endif


                            </td>


                        </tr>


                    @endforeach


                </tbody>

            </table>

        </div>



    @else


        {{-- =============================================
            EMPTY STATE
        ============================================== --}}

        <div class="empty-state">

            <h3>
                No Projects Found
            </h3>

            <p>
                No project payment data is available yet.
            </p>

        </div>


    @endif


</div>


@endsection