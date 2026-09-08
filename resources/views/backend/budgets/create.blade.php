@extends('backend.layouts.admin')

@section('title', 'Add Budget')

@section('page_title', 'Add Budget')

@section('content')


{{-- =====================================================
    PAGE HEADER
====================================================== --}}

<div class="page-header">

    <div>

        <h1>
            Add Budget
        </h1>

        <p>
            Set the estimated, contract and actual cost for a project.
        </p>

    </div>


    <a
        href="{{ route('admin.budgets.index') }}"
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
                Budget Information
            </h2>

            <p>
                One project can have only one budget.
            </p>

        </div>

    </div>



    {{-- =================================================
        FORM
    ================================================== --}}

    <div class="form-container">

        <form
            action="{{ route('admin.budgets.store') }}"
            method="POST"
            id="budgetForm"
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
                            data-status="{{ $project->status }}"
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
                COST GRID
            ================================================== --}}

            <div class="form-grid">


                {{-- =================================================
                    ESTIMATED COST
                ================================================== --}}

                <div class="form-group">

                    <label for="estimated_cost">

                        Estimated Cost

                        <span class="required">
                            *
                        </span>

                    </label>


                    <input
                        type="number"
                        name="estimated_cost"
                        id="estimated_cost"
                        value="{{ old('estimated_cost') }}"
                        min="0"
                        step="0.01"
                        placeholder="Enter estimated cost"
                        required
                    >


                    @error('estimated_cost')

                        <small class="field-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>



                {{-- =================================================
                    CONTRACT AMOUNT
                ================================================== --}}

                <div class="form-group">

                    <label for="contract_amount">

                        Contract Amount

                        <span class="required">
                            *
                        </span>

                    </label>


                    <input
                        type="number"
                        name="contract_amount"
                        id="contract_amount"
                        value="{{ old('contract_amount') }}"
                        min="0"
                        step="0.01"
                        placeholder="Enter contract amount"
                        required
                    >


                    @error('contract_amount')

                        <small class="field-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>



                {{-- =================================================
                    ACTUAL COST
                ================================================== --}}

                <div class="form-group">

                    <label for="actual_cost">

                        Actual Cost

                        <span class="optional">
                            Optional
                        </span>

                    </label>


                    <input
                        type="number"
                        name="actual_cost"
                        id="actual_cost"
                        value="{{ old('actual_cost') }}"
                        min="0"
                        step="0.01"
                        placeholder="Enter actual cost"
                    >


                    @error('actual_cost')

                        <small class="field-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>

            </div>



            {{-- =================================================
                BUDGET PREVIEW
            ================================================== --}}

            <div
                class="budget-preview"
                id="budgetPreview"
            >


                <div class="budget-preview-header">

                    <div>

                        <h3>
                            Budget Summary
                        </h3>

                        <p>
                            Live calculation based on the values above.
                        </p>

                    </div>

                </div>



                <div class="budget-summary-grid">


                    {{-- =================================================
                        ESTIMATED
                    ================================================== --}}

                    <div class="budget-summary-card">

                        <span>
                            Estimated Cost
                        </span>

                        <strong id="previewEstimated">
                            ৳0.00
                        </strong>

                    </div>



                    {{-- =================================================
                        CONTRACT
                    ================================================== --}}

                    <div class="budget-summary-card">

                        <span>
                            Contract Amount
                        </span>

                        <strong id="previewContract">
                            ৳0.00
                        </strong>

                    </div>



                    {{-- =================================================
                        ACTUAL
                    ================================================== --}}

                    <div class="budget-summary-card">

                        <span>
                            Actual Cost
                        </span>

                        <strong id="previewActual">
                            ৳0.00
                        </strong>

                    </div>



                    {{-- =================================================
                        VARIANCE
                    ================================================== --}}

                    <div class="budget-summary-card">

                        <span>
                            Variance
                        </span>

                        <strong id="previewVariance">
                            ৳0.00
                        </strong>

                    </div>



                    {{-- =================================================
                        PROFIT / LOSS
                    ================================================== --}}

                    <div class="budget-summary-card">

                        <span>
                            Profit / Loss
                        </span>

                        <strong id="previewProfitLoss">
                            ৳0.00
                        </strong>

                    </div>



                    {{-- =================================================
                        BUDGET STATUS
                    ================================================== --}}

                    <div class="budget-summary-card">

                        <span>
                            Budget Status
                        </span>

                        <strong
                            id="previewStatus"
                            class="status-badge status-secondary"
                        >
                            On Budget
                        </strong>

                    </div>



                    {{-- =================================================
                        FINANCIAL STATUS
                    ================================================== --}}

                    <div class="budget-summary-card">

                        <span>
                            Financial Status
                        </span>

                        <strong
                            id="previewFinancialStatus"
                            class="status-badge status-secondary"
                        >
                            Break-even
                        </strong>

                    </div>

                </div>

            </div>



            {{-- =================================================
                FORM ACTIONS
            ================================================== --}}

            <div class="form-actions">

                <a
                    href="{{ route('admin.budgets.index') }}"
                    class="secondary-btn"
                >
                    Cancel
                </a>


                <button
                    type="submit"
                    class="primary-btn"
                    id="saveBudgetButton"
                >
                    Save Budget
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


    /*
    |--------------------------------------------------------------------------
    | DOM ELEMENTS
    |--------------------------------------------------------------------------
    */

    const projectSelect =
        document.getElementById('project_id');

    const estimatedInput =
        document.getElementById('estimated_cost');

    const contractInput =
        document.getElementById('contract_amount');

    const actualInput =
        document.getElementById('actual_cost');


    const previewEstimated =
        document.getElementById('previewEstimated');

    const previewContract =
        document.getElementById('previewContract');

    const previewActual =
        document.getElementById('previewActual');

    const previewVariance =
        document.getElementById('previewVariance');

    const previewProfitLoss =
        document.getElementById('previewProfitLoss');

    const previewStatus =
        document.getElementById('previewStatus');

    const previewFinancialStatus =
        document.getElementById(
            'previewFinancialStatus'
        );

    const projectStatusMessage =
        document.getElementById(
            'projectStatusMessage'
        );

    const saveButton =
        document.getElementById(
            'saveBudgetButton'
        );



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
    | CALCULATE BUDGET
    |--------------------------------------------------------------------------
    */

    function calculateBudget() {


        const estimated =
            parseFloat(
                estimatedInput.value
            ) || 0;


        const contract =
            parseFloat(
                contractInput.value
            ) || 0;


        const actual =
            parseFloat(
                actualInput.value
            ) || 0;



        /*
        |--------------------------------------------------------------------------
        | VARIANCE
        |--------------------------------------------------------------------------
        |
        | Estimated Cost - Actual Cost
        |
        */

        const variance =
            estimated - actual;



        /*
        |--------------------------------------------------------------------------
        | PROFIT / LOSS
        |--------------------------------------------------------------------------
        |
        | Contract Amount - Actual Cost
        |
        */

        const profitLoss =
            contract - actual;



        /*
        |--------------------------------------------------------------------------
        | PREVIEW VALUES
        |--------------------------------------------------------------------------
        */

        previewEstimated.textContent =
            `৳${formatMoney(estimated)}`;


        previewContract.textContent =
            `৳${formatMoney(contract)}`;


        previewActual.textContent =
            `৳${formatMoney(actual)}`;



        /*
        |--------------------------------------------------------------------------
        | VARIANCE DISPLAY
        |--------------------------------------------------------------------------
        */

        if (variance > 0) {

            previewVariance.textContent =
                `+৳${formatMoney(variance)}`;

            previewVariance.className =
                'text-success';

        }
        else if (variance < 0) {

            previewVariance.textContent =
                `-৳${formatMoney(
                    Math.abs(variance)
                )}`;

            previewVariance.className =
                'text-danger';

        }
        else {

            previewVariance.textContent =
                '৳0.00';

            previewVariance.className =
                'text-muted';

        }



        /*
        |--------------------------------------------------------------------------
        | PROFIT / LOSS DISPLAY
        |--------------------------------------------------------------------------
        */

        if (profitLoss > 0) {

            previewProfitLoss.textContent =
                `+৳${formatMoney(profitLoss)}`;

            previewProfitLoss.className =
                'text-success';

        }
        else if (profitLoss < 0) {

            previewProfitLoss.textContent =
                `-৳${formatMoney(
                    Math.abs(profitLoss)
                )}`;

            previewProfitLoss.className =
                'text-danger';

        }
        else {

            previewProfitLoss.textContent =
                '৳0.00';

            previewProfitLoss.className =
                'text-muted';

        }



        /*
        |--------------------------------------------------------------------------
        | BUDGET STATUS
        |--------------------------------------------------------------------------
        */

        previewStatus.classList.remove(
            'status-success',
            'status-danger',
            'status-info',
            'status-warning',
            'status-secondary'
        );


        if (variance > 0) {

            previewStatus.textContent =
                'Under Budget';

            previewStatus.classList.add(
                'status-success'
            );

        }
        else if (variance < 0) {

            previewStatus.textContent =
                'Over Budget';

            previewStatus.classList.add(
                'status-danger'
            );

        }
        else {

            previewStatus.textContent =
                'On Budget';

            previewStatus.classList.add(
                'status-info'
            );

        }



        /*
        |--------------------------------------------------------------------------
        | FINANCIAL STATUS
        |--------------------------------------------------------------------------
        */

        previewFinancialStatus.classList.remove(
            'status-success',
            'status-danger',
            'status-info',
            'status-warning',
            'status-secondary'
        );


        if (profitLoss > 0) {

            previewFinancialStatus.textContent =
                'Profit';

            previewFinancialStatus.classList.add(
                'status-success'
            );

        }
        else if (profitLoss < 0) {

            previewFinancialStatus.textContent =
                'Loss';

            previewFinancialStatus.classList.add(
                'status-danger'
            );

        }
        else {

            previewFinancialStatus.textContent =
                'Break-even';

            previewFinancialStatus.classList.add(
                'status-info'
            );

        }

    }



    /*
    |--------------------------------------------------------------------------
    | PROJECT STATUS
    |--------------------------------------------------------------------------
    */

    function updateProjectStatus() {


        const selectedOption =
            projectSelect.options[
                projectSelect.selectedIndex
            ];


        /*
        |--------------------------------------------------------------------------
        | NO PROJECT
        |--------------------------------------------------------------------------
        */

        if (!selectedOption.value) {

            projectStatusMessage.textContent =
                '';

            saveButton.disabled =
                false;

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | GET STATUS
        |--------------------------------------------------------------------------
        */

        const status =
            selectedOption.dataset.status;



        /*
        |--------------------------------------------------------------------------
        | CANCELLED PROJECT
        |--------------------------------------------------------------------------
        */

        if (status === 'cancelled') {

            projectStatusMessage.textContent =
                'A budget cannot be added to a cancelled project.';

            projectStatusMessage.style.color =
                '#dc2626';

            saveButton.disabled =
                true;

            return;

        }



        /*
        |--------------------------------------------------------------------------
        | NORMAL PROJECT
        |--------------------------------------------------------------------------
        */

        projectStatusMessage.textContent =
            `Project status: ${status
                .replace('-', ' ')
                .replace(/\b\w/g, function (letter) {
                    return letter.toUpperCase();
                })}`;

        projectStatusMessage.style.color =
            '#6b7280';

        saveButton.disabled =
            false;

    }



    /*
    |--------------------------------------------------------------------------
    | INPUT EVENTS
    |--------------------------------------------------------------------------
    */

    estimatedInput.addEventListener(
        'input',
        calculateBudget
    );


    contractInput.addEventListener(
        'input',
        calculateBudget
    );


    actualInput.addEventListener(
        'input',
        calculateBudget
    );


    projectSelect.addEventListener(
        'change',
        updateProjectStatus
    );



    /*
    |--------------------------------------------------------------------------
    | FORM SUBMIT PROTECTION
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('budgetForm')
        .addEventListener(
            'submit',
            function (event) {


                const selectedOption =
                    projectSelect.options[
                        projectSelect.selectedIndex
                    ];


                /*
                |--------------------------------------------------------------------------
                | PROJECT REQUIRED
                |--------------------------------------------------------------------------
                */

                if (!projectSelect.value) {

                    event.preventDefault();

                    alert(
                        'Please select a project.'
                    );

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | CONTRACT AMOUNT REQUIRED
                |--------------------------------------------------------------------------
                */

                if (
                    contractInput.value === ''
                ) {

                    event.preventDefault();

                    alert(
                        'Please enter the contract amount.'
                    );

                    contractInput.focus();

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | CANCELLED PROJECT
                |--------------------------------------------------------------------------
                */

                if (
                    selectedOption.dataset.status
                    ===
                    'cancelled'
                ) {

                    event.preventDefault();

                    alert(
                        'A budget cannot be added to a cancelled project.'
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

    calculateBudget();


    /*
    |--------------------------------------------------------------------------
    | INITIAL PROJECT STATUS
    |--------------------------------------------------------------------------
    */

    updateProjectStatus();

});

</script>


@endsection