@extends('backend.layouts.admin')

@section('content')

<style>

    .proposal-page {
        padding: 20px;
        max-width: 1200px;
        margin: auto;
    }

    .page-header {
        margin-bottom: 25px;
    }

    .page-header h2 {
        margin: 0 0 6px;
        font-size: 26px;
        color: #222;
    }

    .page-header p {
        margin: 0;
        color: #777;
        font-size: 14px;
    }

    .back-btn {
        display: inline-block;
        margin-top: 15px;
        padding: 9px 15px;
        background: #374151;
        color: #fff;
        text-decoration: none;
        border-radius: 6px;
        font-size: 13px;
    }

    .back-btn:hover {
        background: #1f2937;
    }

    .card {
        background: #fff;
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 3px 15px rgba(0,0,0,.07);
    }

    .card h3 {
        margin: 0 0 6px;
        font-size: 18px;
        color: #222;
    }

    .card-description {
        margin: 0 0 20px;
        color: #777;
        font-size: 13px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    label {
        display: block;
        margin-bottom: 7px;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
    }

    .required {
        color: #dc2626;
    }

    input,
    textarea,
    select {
        width: 100%;
        box-sizing: border-box;
        padding: 11px 13px;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        background: #fff;
        font-size: 14px;
        outline: none;
    }

    input:focus,
    textarea:focus,
    select:focus {
        border-color: #2563eb;
    }

    textarea {
        min-height: 100px;
        resize: vertical;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    .project-summary {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
    }

    .summary-item {
        background: #f9fafb;
        border-radius: 8px;
        padding: 15px;
    }

    .summary-label {
        display: block;
        font-size: 11px;
        color: #888;
        text-transform: uppercase;
        margin-bottom: 6px;
        font-weight: 600;
    }

    .summary-value {
        display: block;
        font-size: 15px;
        color: #222;
        font-weight: 600;
    }

    .step-row,
    .milestone-row {
        border: 1px solid #e5e7eb;
        border-radius: 9px;
        padding: 18px;
        margin-bottom: 15px;
        background: #fafafa;
    }

    .step-header,
    .milestone-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .step-number,
    .milestone-number {
        font-size: 14px;
        font-weight: 700;
        color: #2563eb;
    }

    .remove-btn {
        border: none;
        background: #fee2e2;
        color: #991b1b;
        padding: 7px 11px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
        font-weight: 600;
    }

    .remove-btn:hover {
        background: #fecaca;
    }

    .add-btn {
        border: none;
        background: #2563eb;
        color: #fff;
        padding: 10px 16px;
        border-radius: 7px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 600;
    }

    .add-btn:hover {
        background: #1d4ed8;
    }

    .milestone-total {
        margin-top: 15px;
        padding: 15px;
        background: #eff6ff;
        border-radius: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .milestone-total span {
        font-size: 13px;
        color: #374151;
        font-weight: 600;
    }

    .milestone-total strong {
        font-size: 18px;
        color: #1d4ed8;
    }

    .warning-box {
        padding: 13px 15px;
        background: #fff7ed;
        color: #9a3412;
        border-radius: 7px;
        font-size: 13px;
        margin-bottom: 20px;
    }

    .info-box {
        padding: 13px 15px;
        background: #eff6ff;
        color: #1e40af;
        border-radius: 7px;
        font-size: 13px;
        margin-bottom: 20px;
    }

    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-top: 20px;
    }

    .secondary-btn,
    .primary-btn {
        display: inline-block;
        border: none;
        padding: 12px 20px;
        border-radius: 7px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
    }

    .secondary-btn {
        background: #e5e7eb;
        color: #374151;
    }

    .secondary-btn:hover {
        background: #d1d5db;
    }

    .primary-btn {
        background: #16a34a;
        color: #fff;
    }

    .primary-btn:hover {
        background: #15803d;
    }

    .send-btn {
        display: inline-block;
        border: none;
        padding: 12px 20px;
        border-radius: 7px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        background: #2563eb;
        color: #fff;
    }

    .send-btn:hover {
        background: #1d4ed8;
    }

    .send-btn:disabled {
        opacity: .6;
        cursor: not-allowed;
    }

    .action-buttons {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .send-form {
        margin: 0;
    }

    .success-message,
    .danger-message {
        padding: 13px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 13px;
        font-weight: 600;
    }

    .success-message {
        background: #ecfdf5;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .danger-message {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .danger-message ul {
        margin: 8px 0 0 18px;
        padding: 0;
        font-weight: 500;
    }

    .danger-message li {
        margin-bottom: 4px;
    }

    .error-message {
        display: block;
        margin-top: 5px;
        color: #dc2626;
        font-size: 12px;
    }

    .empty-message {
        padding: 20px;
        text-align: center;
        background: #f9fafb;
        border-radius: 8px;
        color: #777;
        font-size: 13px;
    }

    @media (max-width: 900px) {

        .project-summary {
            grid-template-columns: 1fr 1fr;
        }

    }

    @media (max-width: 700px) {

        .proposal-page {
            padding: 12px;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .project-summary {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .secondary-btn,
        .primary-btn {
            width: 100%;
            text-align: center;
        }

    }

</style>


<div class="proposal-page">

    {{-- =====================================================
         GLOBAL SUCCESS / ERROR MESSAGES
    ====================================================== --}}

    @if(session('success'))
        <div class="success-message">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="danger-message">
            ✕ {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="danger-message">
            <strong>Please fix the following:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="page-header">

        <h2>
            Project Proposal
        </h2>

        <p>
            Prepare the final proposal for the customer.
        </p>

        <a
            href="{{ route('admin.project-requests.show', $project) }}"
            class="back-btn"
        >
            ← Back to Project Request
        </a>

    </div>


    {{-- =====================================================
         INFO
    ====================================================== --}}

    <div class="info-box">

        <strong>Proposal Workflow:</strong>

        Set the final contract amount, working procedure/project
        steps and customer payment milestones.

        Internal estimated cost, actual cost and profit information
        will remain admin-only.

    </div>


    {{-- =====================================================
         PROJECT SUMMARY
    ====================================================== --}}

    <div class="card">

        <h3>
            Project Summary
        </h3>

        <p class="card-description">
            Customer request information.
        </p>


        <div class="project-summary">

            <div class="summary-item">

                <span class="summary-label">
                    Project ID
                </span>

                <span class="summary-value">
                    #{{ $project->id }}
                </span>

            </div>


            <div class="summary-item">

                <span class="summary-label">
                    Customer
                </span>

                <span class="summary-value">

                    {{ $project->client?->user?->name
                        ?? $project->client?->name
                        ?? 'N/A' }}

                </span>

            </div>


            <div class="summary-item">

                <span class="summary-label">
                    Service
                </span>

                <span class="summary-value">

                    {{ $project->service?->name ?? 'N/A' }}

                </span>

            </div>


            <div class="summary-item">

                <span class="summary-label">
                    Approx. Budget
                </span>

                <span class="summary-value">

                    @if($project->approximate_budget !== null)

                        ৳ {{ number_format(
                            (float) $project->approximate_budget,
                            2
                        ) }}

                    @else

                        Not provided

                    @endif

                </span>

            </div>

        </div>

    </div>


    {{-- =====================================================
         PROPOSAL FORM
    ====================================================== --}}

    <form
        action="{{ route('admin.project-proposals.update', $project) }}"
        method="POST"
        id="proposalForm"
    >

        @csrf


        {{-- =================================================
             FINAL CONTRACT AMOUNT
        ================================================== --}}

        <div class="card">

            <h3>
                Final Contract Amount
            </h3>

            <p class="card-description">
                This is the amount the customer will see in the proposal.
            </p>


            <div class="form-group">

                <label for="contract_amount">

                    Final Contract Amount
                    <span class="required">*</span>

                </label>


                <input
                    type="number"
                    name="contract_amount"
                    id="contract_amount"
                    value="{{ old(
                        'contract_amount',
                        $project->budget?->contract_amount ?? ''
                    ) }}"
                    min="0"
                    step="0.01"
                    placeholder="Enter final contract amount"
                    required
                >


                @error('contract_amount')

                    <small class="error-message">
                        {{ $message }}
                    </small>

                @enderror

            </div>


            <div class="warning-box">

                <strong>Note:</strong>

                The final contract amount is customer-facing.
                Estimated cost and actual internal cost should not
                be entered here.

            </div>

        </div>


        {{-- =================================================
             WORKING PROCEDURE
        ================================================== --}}

        <div class="card">

            <h3>
                Working Procedure / Project Steps
            </h3>

            <p class="card-description">
                Define the work process that the customer will be able
                to see after receiving the proposal.
            </p>


            <div id="stepsContainer">

                @if(isset($project->projectSteps) && $project->projectSteps->count())

                    @foreach($project->projectSteps as $index => $step)

                        <div class="step-row">

                            <div class="step-header">

                                <span class="step-number">
                                    Step {{ $index + 1 }}
                                </span>

                                <button
                                    type="button"
                                    class="remove-btn"
                                    onclick="removeStep(this)"
                                >
                                    Remove
                                </button>

                            </div>


                            <div class="form-group">

                                <label>
                                    Step Title
                                </label>

                                <input
                                    type="text"
                                    name="steps[{{ $index }}][title]"
                                    value="{{ old(
                                        "steps.$index.title",
                                        $step->title ?? $step->name ?? ''
                                    ) }}"
                                    placeholder="Example: Design & Planning"
                                >

                            </div>


                            <div class="form-group">

                                <label>
                                    Description
                                </label>

                                <textarea
                                    name="steps[{{ $index }}][description]"
                                    placeholder="Describe this project step..."
                                >{{ old(
                                    "steps.$index.description",
                                    $step->description ?? ''
                                ) }}</textarea>

                            </div>

                        </div>

                    @endforeach

                @else

                    <div class="step-row">

                        <div class="step-header">

                            <span class="step-number">
                                Step 1
                            </span>

                            <button
                                type="button"
                                class="remove-btn"
                                onclick="removeStep(this)"
                            >
                                Remove
                            </button>

                        </div>


                        <div class="form-group">

                            <label>
                                Step Title
                            </label>

                            <input
                                type="text"
                                name="steps[0][title]"
                                placeholder="Example: Design & Planning"
                            >

                        </div>


                        <div class="form-group">

                            <label>
                                Description
                            </label>

                            <textarea
                                name="steps[0][description]"
                                placeholder="Describe this project step..."
                            ></textarea>

                        </div>

                    </div>

                @endif

            </div>


            <button
                type="button"
                class="add-btn"
                onclick="addStep()"
            >
                + Add Project Step
            </button>

        </div>


        {{-- =================================================
             PAYMENT MILESTONES
        ================================================== --}}

        <div class="card">

            <h3>
                Payment Milestones
            </h3>

            <p class="card-description">
                Divide the final contract amount into customer payment milestones.
            </p>


            <div id="milestonesContainer">

                @if(isset($project->payments) && $project->payments->count())

                    @foreach($project->payments as $index => $payment)

                        <div class="milestone-row">

                            <div class="milestone-header">

                                <span class="milestone-number">
                                    Payment {{ $index + 1 }}
                                </span>

                                <button
                                    type="button"
                                    class="remove-btn"
                                    onclick="removeMilestone(this)"
                                >
                                    Remove
                                </button>

                            </div>


                            <div class="form-grid">

                                <div class="form-group">

                                    <label>
                                        Milestone Name
                                    </label>

                                    <input
                                        type="text"
                                        name="milestones[{{ $index }}][milestone]"
                                        value="{{ old(
                                            "milestones.$index.milestone",
                                            $payment->milestone ?? ''
                                        ) }}"
                                        placeholder="Example: Advance Payment"
                                    >

                                </div>


                                <div class="form-group">

                                    <label>
                                        Amount
                                    </label>

                                    <input
                                        type="number"
                                        class="milestone-amount"
                                        name="milestones[{{ $index }}][amount]"
                                        value="{{ old(
                                            "milestones.$index.amount",
                                            $payment->amount ?? ''
                                        ) }}"
                                        min="0"
                                        step="0.01"
                                        placeholder="Enter amount"
                                        oninput="calculateMilestoneTotal()"
                                    >

                                </div>

                            </div>


                            <div class="form-grid">

                                <div class="form-group">

                                    <label>
                                        Due Date
                                    </label>

                                    <input
                                        type="date"
                                        name="milestones[{{ $index }}][due_date]"
                                        value="{{ old(
                                            "milestones.$index.due_date",
                                            $payment->due_date?->format('Y-m-d')
                                        ) }}"
                                    >

                                </div>


                                <div class="form-group">

                                    <label>
                                        Note
                                    </label>

                                    <input
                                        type="text"
                                        name="milestones[{{ $index }}][note]"
                                        value="{{ old(
                                            "milestones.$index.note",
                                            $payment->note ?? ''
                                        ) }}"
                                        placeholder="Payment-related note"
                                    >

                                </div>

                            </div>

                        </div>

                    @endforeach

                @else

                    <div class="milestone-row">

                        <div class="milestone-header">

                            <span class="milestone-number">
                                Payment 1
                            </span>

                            <button
                                type="button"
                                class="remove-btn"
                                onclick="removeMilestone(this)"
                            >
                                Remove
                            </button>

                        </div>


                        <div class="form-grid">

                            <div class="form-group">

                                <label>
                                    Milestone Name
                                </label>

                                <input
                                    type="text"
                                    name="milestones[0][milestone]"
                                    placeholder="Example: Advance Payment"
                                >

                            </div>


                            <div class="form-group">

                                <label>
                                    Amount
                                </label>

                                <input
                                    type="number"
                                    class="milestone-amount"
                                    name="milestones[0][amount]"
                                    min="0"
                                    step="0.01"
                                    placeholder="Enter amount"
                                    oninput="calculateMilestoneTotal()"
                                >

                            </div>

                        </div>


                        <div class="form-grid">

                            <div class="form-group">

                                <label>
                                    Due Date
                                </label>

                                <input
                                    type="date"
                                    name="milestones[0][due_date]"
                                >

                            </div>


                            <div class="form-group">

                                <label>
                                    Note
                                </label>

                                <input
                                    type="text"
                                    name="milestones[0][note]"
                                    placeholder="Payment-related note"
                                >

                            </div>

                        </div>

                    </div>

                @endif

            </div>


            <button
                type="button"
                class="add-btn"
                onclick="addMilestone()"
            >
                + Add Payment Milestone
            </button>


            <div class="milestone-total">

                <span>
                    Total Milestone Amount
                </span>

                <strong id="milestoneTotal">
                    ৳0.00
                </strong>

            </div>

        </div>


        {{-- =================================================
             FORM ACTIONS
        ================================================== --}}

        <div class="card">

            <div class="form-actions">

                <a
                    href="{{ route('admin.project-requests.show', $project) }}"
                    class="secondary-btn"
                >
                    ← Back
                </a>

                <div class="action-buttons">

                    {{-- Save Proposal --}}
                    <button
                        type="submit"
                        class="primary-btn"
                    >
                        Save Proposal
                    </button>


                    {{-- Send Proposal to Customer --}}
                    @if($project->status !== 'proposal_sent')

                        <button
                            type="submit"
                            class="send-btn"
                            id="sendProposalButton"
                            formaction="{{ route('admin.project-proposals.send', $project) }}"
                            formmethod="POST"
                            onclick="return confirmSendProposal();"
                        >
                            ✓ Send Proposal to Customer
                        </button>

                    @else

                        <button
                            type="button"
                            class="send-btn"
                            disabled
                        >
                            ✓ Proposal Already Sent
                        </button>

                    @endif

                </div>

            </div>

        </div>

    </form>

</div>


{{-- =====================================================
     JAVASCRIPT
====================================================== --}}

<script>

    function confirmSendProposal() {
        const contractAmount =
            parseFloat(document.getElementById('contract_amount')?.value) || 0;

        const milestoneInputs =
            document.querySelectorAll('.milestone-amount');

        let milestoneTotal = 0;

        milestoneInputs.forEach(function (input) {
            milestoneTotal += parseFloat(input.value) || 0;
        });

        if (contractAmount <= 0) {
            alert('Please enter a valid final contract amount.');
            return false;
        }

        if (milestoneInputs.length === 0) {
            alert('Please add at least one payment milestone.');
            return false;
        }

        if (Math.abs(milestoneTotal - contractAmount) > 0.01) {
            alert(
                'Payment milestone total must equal the final contract amount.\n\n' +
                'Contract Amount: ৳' + contractAmount.toLocaleString('en-BD') +
                '\nMilestone Total: ৳' + milestoneTotal.toLocaleString('en-BD')
            );
            return false;
        }

        return confirm(
            'Are you sure you want to send this proposal to the customer?'
        );
    }

    let stepIndex =
        document.querySelectorAll('#stepsContainer .step-row').length;

    let milestoneIndex =
        document.querySelectorAll('#milestonesContainer .milestone-row').length;


    /*
    |--------------------------------------------------------------------------
    | ADD PROJECT STEP
    |--------------------------------------------------------------------------
    */

    function addStep() {

        const container =
            document.getElementById('stepsContainer');

        const div =
            document.createElement('div');

        div.className = 'step-row';

        div.innerHTML = `

            <div class="step-header">

                <span class="step-number">
                    Step ${stepIndex + 1}
                </span>

                <button
                    type="button"
                    class="remove-btn"
                    onclick="removeStep(this)"
                >
                    Remove
                </button>

            </div>


            <div class="form-group">

                <label>
                    Step Title
                </label>

                <input
                    type="text"
                    name="steps[${stepIndex}][title]"
                    placeholder="Example: Design & Planning"
                >

            </div>


            <div class="form-group">

                <label>
                    Description
                </label>

                <textarea
                    name="steps[${stepIndex}][description]"
                    placeholder="Describe this project step..."
                ></textarea>

            </div>

        `;

        container.appendChild(div);

        stepIndex++;

        refreshStepNumbers();
    }


    /*
    |--------------------------------------------------------------------------
    | REMOVE PROJECT STEP
    |--------------------------------------------------------------------------
    */

    function removeStep(button) {

        const rows =
            document.querySelectorAll(
                '#stepsContainer .step-row'
            );

        if (rows.length <= 1) {

            alert('At least one project step is required.');

            return;
        }

        button.closest('.step-row').remove();

        refreshStepNumbers();
    }


    /*
    |--------------------------------------------------------------------------
    | REFRESH STEP NUMBERS
    |--------------------------------------------------------------------------
    */

    function refreshStepNumbers() {

        const rows =
            document.querySelectorAll(
                '#stepsContainer .step-row'
            );

        rows.forEach(function(row, index) {

            const number =
                row.querySelector('.step-number');

            if (number) {

                number.textContent =
                    'Step ' + (index + 1);

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | ADD PAYMENT MILESTONE
    |--------------------------------------------------------------------------
    */

    function addMilestone() {

        const container =
            document.getElementById(
                'milestonesContainer'
            );

        const div =
            document.createElement('div');

        div.className = 'milestone-row';

        div.innerHTML = `

            <div class="milestone-header">

                <span class="milestone-number">
                    Payment ${milestoneIndex + 1}
                </span>

                <button
                    type="button"
                    class="remove-btn"
                    onclick="removeMilestone(this)"
                >
                    Remove
                </button>

            </div>


            <div class="form-grid">

                <div class="form-group">

                    <label>
                        Milestone Name
                    </label>

                    <input
                        type="text"
                        name="milestones[${milestoneIndex}][milestone]"
                        placeholder="Example: Advance Payment"
                    >

                </div>


                <div class="form-group">

                    <label>
                        Amount
                    </label>

                    <input
                        type="number"
                        class="milestone-amount"
                        name="milestones[${milestoneIndex}][amount]"
                        min="0"
                        step="0.01"
                        placeholder="Enter amount"
                        oninput="calculateMilestoneTotal()"
                    >

                </div>

            </div>


            <div class="form-grid">

                <div class="form-group">

                    <label>
                        Due Date
                    </label>

                    <input
                        type="date"
                        name="milestones[${milestoneIndex}][due_date]"
                    >

                </div>


                <div class="form-group">

                    <label>
                        Note
                    </label>

                    <input
                        type="text"
                        name="milestones[${milestoneIndex}][note]"
                        placeholder="Payment-related note"
                    >

                </div>

            </div>

        `;

        container.appendChild(div);

        milestoneIndex++;

        refreshMilestoneNumbers();

        calculateMilestoneTotal();
    }


    /*
    |--------------------------------------------------------------------------
    | REMOVE PAYMENT MILESTONE
    |--------------------------------------------------------------------------
    */

    function removeMilestone(button) {

        const rows =
            document.querySelectorAll(
                '#milestonesContainer .milestone-row'
            );

        if (rows.length <= 1) {

            alert('At least one payment milestone is required.');

            return;
        }

        button.closest('.milestone-row').remove();

        refreshMilestoneNumbers();

        calculateMilestoneTotal();
    }


    /*
    |--------------------------------------------------------------------------
    | REFRESH MILESTONE NUMBERS
    |--------------------------------------------------------------------------
    */

    function refreshMilestoneNumbers() {

        const rows =
            document.querySelectorAll(
                '#milestonesContainer .milestone-row'
            );

        rows.forEach(function(row, index) {

            const number =
                row.querySelector('.milestone-number');

            if (number) {

                number.textContent =
                    'Payment ' + (index + 1);

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | CALCULATE TOTAL MILESTONE AMOUNT
    |--------------------------------------------------------------------------
    */

    function calculateMilestoneTotal() {

        const amounts =
            document.querySelectorAll(
                '.milestone-amount'
            );

        let total = 0;

        amounts.forEach(function(input) {

            const value =
                parseFloat(input.value) || 0;

            total += value;

        });

        document.getElementById(
            'milestoneTotal'
        ).textContent =
            '৳' +
            total.toLocaleString(
                'en-BD',
                {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }
            );

    }


    /*
    |--------------------------------------------------------------------------
    | INITIAL CALCULATION
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            calculateMilestoneTotal();

        }
    );

</script>

@endsection