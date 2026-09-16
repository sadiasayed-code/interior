@extends('backend.layouts.admin')

@section('title', 'Budgets')

@section('page_title', 'Budgets')

@section('content')


{{-- =====================================================
    PAGE HEADER
====================================================== --}}

<div class="page-header">

    <div>

        <h1>
            Budgets
        </h1>

        <p>
            Manage estimated, contract and actual costs for each project.
        </p>

    </div>


    <a
        href="{{ route('admin.budgets.create') }}"
        class="primary-btn">
        + Add Budget
    </a>

</div>



{{-- =====================================================
    BUDGET SUMMARY
====================================================== --}}

<div class="panel">


    {{-- =================================================
        PANEL HEADER
    ================================================== --}}

    <div class="panel-header">

        <div>

            <h2>
                Project Budget List
            </h2>

            <p>
                Compare estimated, contract and actual project costs.
            </p>

        </div>


        <span class="table-count">

            {{ $budgets->count() }}

            {{ $budgets->count() === 1 ? 'Budget' : 'Budgets' }}

        </span>

    </div>



    {{-- =================================================
        TABLE
    ================================================== --}}

    <div class="table-wrapper">

        <table>

            <thead>

                <tr>

                    {{-- Serial --}}

                    <th>
                        #
                    </th>


                    {{-- Project --}}

                    <th>
                        PROJECT
                    </th>


                    {{-- Estimated --}}

                    <th>
                        ESTIMATED COST
                    </th>


                    {{-- Contract --}}

                    <th>
                        CONTRACT AMOUNT
                    </th>


                    {{-- Actual --}}

                    <th>
                        ACTUAL COST
                    </th>


                    {{-- Variance --}}

                    <th>
                        VARIANCE
                    </th>


                    {{-- Budget Status --}}

                    <th>
                        BUDGET STATUS
                    </th>


                    {{-- Profit / Loss --}}

                    <th>
                        PROFIT / LOSS
                    </th>


                    {{-- Financial Status --}}

                    <th>
                        FINANCIAL STATUS
                    </th>


                    {{-- Actions --}}

                    <th>
                        ACTIONS
                    </th>

                </tr>

            </thead>



            <tbody>


                @forelse($budgets as $budget)


                @php

                /*
                |--------------------------------------------------------------------------
                | COST VALUES
                |--------------------------------------------------------------------------
                */

                $estimatedCost =
                (float) $budget->estimated_cost;

                $contractAmount =
                (float) $budget->contract_amount;

                $actualCost =
                (float) ($budget->actual_cost ?? 0);



                /*
                |--------------------------------------------------------------------------
                | VARIANCE
                |--------------------------------------------------------------------------
                |
                | Estimated Cost - Actual Cost
                |
                */

                $variance =
                $estimatedCost - $actualCost;



                /*
                |--------------------------------------------------------------------------
                | VARIANCE STATUS
                |--------------------------------------------------------------------------
                */

                $varianceStatus =
                $budget->variance_status
                ?? (
                $variance > 0
                ? 'Under Budget'
                : (
                $variance < 0
                    ? 'Over Budget'
                    : 'On Budget'
                    )
                    );



                    /*
                    |--------------------------------------------------------------------------
                    | VARIANCE STATUS CLASS
                    |--------------------------------------------------------------------------
                    */

                    $statusClass=match(
                    $varianceStatus
                    ) { 'Under Budget'=>
                    'status-success',

                    'Over Budget' =>
                    'status-danger',

                    'On Budget' =>
                    'status-info',

                    default =>
                    'status-secondary',

                    };



                    /*
                    |--------------------------------------------------------------------------
                    | VARIANCE TEXT CLASS
                    |--------------------------------------------------------------------------
                    */

                    $varianceClass =
                    $variance > 0
                    ? 'text-success'
                    : (
                    $variance < 0
                        ? 'text-danger'
                        : 'text-muted'
                        );



                        /*
                        |--------------------------------------------------------------------------
                        | PROFIT / LOSS
                        |--------------------------------------------------------------------------
                        |
                        | Contract Amount - Actual Cost
                        |
                        */

                        $profitLoss=$contractAmount - $actualCost;



                        /*
                        |--------------------------------------------------------------------------
                        | FINANCIAL STATUS
                        |--------------------------------------------------------------------------
                        */

                        $financialStatus=$budget->financial_status
                        ?? (
                        $profitLoss > 0
                        ? 'Profit'
                        : (
                        $profitLoss < 0
                            ? 'Loss'
                            : 'Break-even'
                            )
                            );



                            /*
                            |--------------------------------------------------------------------------
                            | FINANCIAL STATUS CLASS
                            |--------------------------------------------------------------------------
                            */

                            $financialStatusClass=match(
                            $financialStatus
                            ) { 'Profit'=>
                            'status-success',

                            'Loss' =>
                            'status-danger',

                            'Break-even' =>
                            'status-info',

                            default =>
                            'status-secondary',

                            };



                            /*
                            |--------------------------------------------------------------------------
                            | PROFIT / LOSS TEXT CLASS
                            |--------------------------------------------------------------------------
                            */

                            $profitLossClass =
                            $profitLoss > 0
                            ? 'text-success'
                            : (
                            $profitLoss < 0
                                ? 'text-danger'
                                : 'text-muted'
                                );

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
                                        {{ $budget->project?->service?->name ?? 'Service Not Found' }}
                                    </strong>

                                </td>



                                {{-- =================================================
                            ESTIMATED COST
                        ================================================== --}}

                                <td>

                                    <strong>

                                        ৳{{ number_format(
                                    $estimatedCost,
                                    2
                                ) }}

                                    </strong>

                                </td>



                                {{-- =================================================
                            CONTRACT AMOUNT
                        ================================================== --}}

                                <td>

                                    <strong>

                                        ৳{{ number_format(
                                    $contractAmount,
                                    2
                                ) }}

                                    </strong>

                                </td>



                                {{-- =================================================
                            ACTUAL COST
                        ================================================== --}}

                                <td>

                                    @if($budget->actual_cost !== null)

                                    ৳{{ number_format(
                                    $actualCost,
                                    2
                                ) }}

                                    @else

                                    <span class="text-muted">
                                        Not Set
                                    </span>

                                    @endif

                                </td>



                                {{-- =================================================
                            VARIANCE
                        ================================================== --}}

                                <td>

                                    <strong class="{{ $varianceClass }}">

                                        @if($variance > 0)

                                        +৳{{ number_format(
                                        abs($variance),
                                        2
                                    ) }}

                                        @elseif($variance < 0)

                                            -৳{{ number_format(
                                        abs($variance),
                                        2
                                    ) }}

                                            @else

                                            ৳0.00

                                            @endif

                                            </strong>

                                </td>



                                {{-- =================================================
                            BUDGET STATUS
                        ================================================== --}}

                                <td>

                                    <span
                                        class="status-badge {{ $statusClass }}">

                                        {{ $varianceStatus }}

                                    </span>

                                </td>



                                {{-- =================================================
                            PROFIT / LOSS
                        ================================================== --}}

                                <td>

                                    <strong class="{{ $profitLossClass }}">

                                        @if($profitLoss > 0)

                                        +৳{{ number_format(
                                        abs($profitLoss),
                                        2
                                    ) }}

                                        @elseif($profitLoss < 0)

                                            -৳{{ number_format(
                                        abs($profitLoss),
                                        2
                                    ) }}

                                            @else

                                            ৳0.00

                                            @endif

                                            </strong>

                                </td>



                                {{-- =================================================
                            FINANCIAL STATUS
                        ================================================== --}}

                                <td>

                                    <span
                                        class="status-badge {{ $financialStatusClass }}">

                                        {{ $financialStatus }}

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

                                        <a
                                            href="{{ route(
                                        'admin.budgets.show',
                                        $budget
                                    ) }}"
                                            class="small-action view">
                                            View
                                        </a>



                                        {{-- =================================================
                                    EDIT
                                ================================================== --}}

                                        @if(
                                        $budget->project &&
                                        $budget->project->status !== 'cancelled'
                                        )

                                        <a
                                            href="{{ route(
                                            'admin.budgets.edit',
                                            $budget
                                        ) }}"
                                            class="small-action edit">
                                            Edit
                                        </a>

                                        @endif



                                        {{-- =================================================
                                    DELETE
                                ================================================== --}}

                                        <form
                                            action="{{ route(
                                        'admin.budgets.destroy',
                                        $budget
                                    ) }}"
                                            method="POST"
                                            style="display: inline;"
                                            onsubmit="
                                        return confirm(
                                            'Are you sure you want to delete this budget?'
                                        );
                                    ">

                                            @csrf

                                            <button
                                                type="submit"
                                                class="small-action delete">
                                                Delete
                                            </button>

                                        </form>


                                    </div>

                                </td>


                                </tr>


                                @empty


                                {{-- =================================================
                        EMPTY STATE
                    ================================================== --}}

                                <tr>

                                    <td
                                        colspan="11"
                                        class="empty-state">

                                        <div>

                                            <strong>
                                                No budgets found.
                                            </strong>

                                            <p>
                                                Create a budget for a project
                                                to see it here.
                                            </p>


                                            <a
                                                href="{{ route(
                                        'admin.budgets.create'
                                    ) }}"
                                                class="primary-btn">
                                                + Add Budget
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