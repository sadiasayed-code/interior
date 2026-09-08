@extends('backend.layouts.admin')

@section('title', 'Budget Details')

@section('page_title', 'Budget Details')

@section('content')

{{-- =====================================================
    PAGE HEADER
====================================================== --}}

<div class="page-header">

    <div>

        <h1>
            Budget Details
        </h1>

        <p>
            Complete financial summary for this project.
        </p>

    </div>

    <div class="table-actions">

        <a
            href="{{ route('admin.budgets.index') }}"
            class="secondary-btn"
        >
            ← Back
        </a>

        @if(
            $budget->project &&
            $budget->project->status !== 'cancelled'
        )

            <a
                href="{{ route('admin.budgets.edit', $budget) }}"
                class="primary-btn"
            >
                Edit Budget
            </a>

        @endif

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
                Basic information related to this budget.
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
                {{ $budget->project->project_name ?? 'N/A' }}
            </strong>

        </div>


        {{-- CLIENT --}}

        <div class="detail-item">

            <span class="detail-label">
                Client
            </span>

            <strong class="detail-value">
                {{ $budget->project->client->name ?? 'N/A' }}
            </strong>

        </div>


        {{-- PROJECT STATUS --}}

        <div class="detail-item">

            <span class="detail-label">
                Project Status
            </span>

            @php

                $projectStatus =
                    $budget->project->status ?? null;

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

            @endphp

            <span class="status-badge {{ $projectStatusClass }}">

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


        {{-- BUDGET CREATED --}}

        <div class="detail-item">

            <span class="detail-label">
                Budget Created
            </span>

            <strong class="detail-value">

                {{ $budget->created_at
                    ? $budget->created_at->format('d M Y')
                    : 'N/A'
                }}

            </strong>

        </div>

    </div>

</div>



{{-- =====================================================
    FINANCIAL SUMMARY
====================================================== --}}

@php

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
    | Estimated Cost - Actual Cost
    |
    | Positive = Under Budget
    | Negative = Over Budget
    |--------------------------------------------------------------------------
    */

    $variance =
        $estimatedCost - $actualCost;


    /*
    |--------------------------------------------------------------------------
    | PROFIT / LOSS
    |--------------------------------------------------------------------------
    | Contract Amount - Actual Cost
    |
    | Positive = Profit
    | Negative = Loss
    | Zero = Break-even
    |--------------------------------------------------------------------------
    */

    $profitLoss =
        $contractAmount - $actualCost;


    /*
    |--------------------------------------------------------------------------
    | VARIANCE STATUS
    |--------------------------------------------------------------------------
    */

    if ($variance > 0) {

        $varianceStatus = 'Under Budget';

    } elseif ($variance < 0) {

        $varianceStatus = 'Over Budget';

    } else {

        $varianceStatus = 'On Budget';

    }


    /*
    |--------------------------------------------------------------------------
    | FINANCIAL STATUS
    |--------------------------------------------------------------------------
    */

    if ($profitLoss > 0) {

        $financialStatus = 'Profit';

    } elseif ($profitLoss < 0) {

        $financialStatus = 'Loss';

    } else {

        $financialStatus = 'Break-even';

    }


    /*
    |--------------------------------------------------------------------------
    | CSS CLASSES
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


    $profitLossClass =
        $profitLoss > 0
            ? 'text-success'
            : (
                $profitLoss < 0
                    ? 'text-danger'
                    : 'text-muted'
            );


    $varianceStatusClass = match($varianceStatus) {

        'Under Budget' =>
            'status-success',

        'Over Budget' =>
            'status-danger',

        'On Budget' =>
            'status-info',

        default =>
            'status-secondary',

    };


    $financialStatusClass = match($financialStatus) {

        'Profit' =>
            'status-success',

        'Loss' =>
            'status-danger',

        'Break-even' =>
            'status-info',

        default =>
            'status-secondary',

    };

@endphp


<div class="panel">

    <div class="panel-header">

        <div>

            <h2>
                Financial Summary
            </h2>

            <p>
                Complete budget, contract and financial performance.
            </p>

        </div>

    </div>


    <div class="budget-detail-grid">


        {{-- =================================================
            ESTIMATED COST
        ================================================== --}}

        <div class="budget-detail-card">

            <span>
                Estimated Cost
            </span>

            <strong>

                ৳{{ number_format(
                    $estimatedCost,
                    2
                ) }}

            </strong>

        </div>



        {{-- =================================================
            CONTRACT AMOUNT
        ================================================== --}}

        <div class="budget-detail-card">

            <span>
                Contract Amount
            </span>

            <strong>

                ৳{{ number_format(
                    $contractAmount,
                    2
                ) }}

            </strong>

        </div>



        {{-- =================================================
            ACTUAL COST
        ================================================== --}}

        <div class="budget-detail-card">

            <span>
                Actual Cost
            </span>

            <strong>

                ৳{{ number_format(
                    $actualCost,
                    2
                ) }}

            </strong>

        </div>



        {{-- =================================================
            VARIANCE
        ================================================== --}}

        <div class="budget-detail-card">

            <span>
                Variance
            </span>

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

        </div>



        {{-- =================================================
            BUDGET STATUS
        ================================================== --}}

        <div class="budget-detail-card">

            <span>
                Budget Status
            </span>

            <strong>

                <span class="status-badge {{ $varianceStatusClass }}">

                    {{ $varianceStatus }}

                </span>

            </strong>

        </div>



        {{-- =================================================
            PROFIT / LOSS
        ================================================== --}}

        <div class="budget-detail-card">

            <span>
                Profit / Loss
            </span>

            <strong class="{{ $profitLossClass }}">

                @if($profitLoss > 0)

                    +৳{{ number_format(
                        $profitLoss,
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

        </div>



        {{-- =================================================
            FINANCIAL STATUS
        ================================================== --}}

        <div class="budget-detail-card">

            <span>
                Financial Status
            </span>

            <strong>

                <span class="status-badge {{ $financialStatusClass }}">

                    {{ $financialStatus }}

                </span>

            </strong>

        </div>

    </div>

</div>



{{-- =====================================================
    FINANCIAL ANALYSIS
====================================================== --}}

<div class="panel">

    <div class="panel-header">

        <div>

            <h2>
                Financial Analysis
            </h2>

            <p>
                Detailed analysis of project financial performance.
            </p>

        </div>

    </div>


    <div class="budget-analysis">


        {{-- =================================================
            BUDGET ANALYSIS
        ================================================== --}}

        @if($variance > 0)

            <div class="alert alert-success">

                <div>

                    <strong>
                        Project is Under Budget
                    </strong>

                    <p>

                        The current actual cost is
                        ৳{{ number_format(
                            abs($variance),
                            2
                        ) }}
                        below the estimated budget.

                    </p>

                </div>

            </div>


        @elseif($variance < 0)

            <div class="alert alert-error">

                <div>

                    <strong>
                        Project is Over Budget
                    </strong>

                    <p>

                        The current actual cost exceeds
                        the estimated budget by
                        ৳{{ number_format(
                            abs($variance),
                            2
                        ) }}.

                    </p>

                </div>

            </div>


        @else

            <div class="alert alert-success">

                <div>

                    <strong>
                        Project is On Budget
                    </strong>

                    <p>

                        The actual cost matches the
                        estimated budget.

                    </p>

                </div>

            </div>

        @endif



        {{-- =================================================
            PROFIT / LOSS ANALYSIS
        ================================================== --}}

        @if($profitLoss > 0)

            <div class="alert alert-success">

                <div>

                    <strong>
                        Project is Profitable
                    </strong>

                    <p>

                        The contract amount is
                        ৳{{ number_format(
                            $profitLoss,
                            2
                        ) }}
                        higher than the actual cost.

                    </p>

                </div>

            </div>


        @elseif($profitLoss < 0)

            <div class="alert alert-error">

                <div>

                    <strong>
                        Project is Running at a Loss
                    </strong>

                    <p>

                        The actual cost is
                        ৳{{ number_format(
                            abs($profitLoss),
                            2
                        ) }}
                        higher than the contract amount.

                    </p>

                </div>

            </div>


        @else

            <div class="alert alert-success">

                <div>

                    <strong>
                        Project is Break-even
                    </strong>

                    <p>

                        The contract amount and actual
                        cost are exactly equal.

                    </p>

                </div>

            </div>

        @endif

    </div>

</div>



{{-- =====================================================
    FINANCIAL BREAKDOWN
====================================================== --}}

<div class="panel">

    <div class="panel-header">

        <div>

            <h2>
                Financial Breakdown
            </h2>

            <p>
                How the project's financial figures are calculated.
            </p>

        </div>

    </div>


    <div class="detail-grid">


        {{-- VARIANCE FORMULA --}}

        <div class="detail-item">

            <span class="detail-label">
                Budget Variance
            </span>

            <strong class="detail-value">

                Estimated Cost − Actual Cost

            </strong>

        </div>


        {{-- VARIANCE RESULT --}}

        <div class="detail-item">

            <span class="detail-label">
                Variance Result
            </span>

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

        </div>


        {{-- PROFIT LOSS FORMULA --}}

        <div class="detail-item">

            <span class="detail-label">
                Profit / Loss Formula
            </span>

            <strong class="detail-value">

                Contract Amount − Actual Cost

            </strong>

        </div>


        {{-- PROFIT LOSS RESULT --}}

        <div class="detail-item">

            <span class="detail-label">
                Profit / Loss Result
            </span>

            <strong class="{{ $profitLossClass }}">

                @if($profitLoss > 0)

                    +৳{{ number_format(
                        $profitLoss,
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

        </div>

    </div>

</div>



{{-- =====================================================
    ACTIONS
====================================================== --}}

<div class="form-actions">

    <a
        href="{{ route('admin.budgets.index') }}"
        class="secondary-btn"
    >
        ← Back to Budgets
    </a>


    @if(
        $budget->project &&
        $budget->project->status !== 'cancelled'
    )

        <a
            href="{{ route('admin.budgets.edit', $budget) }}"
            class="primary-btn"
        >
            Edit Budget
        </a>

    @endif

</div>


@endsection