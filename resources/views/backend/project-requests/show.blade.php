@extends('backend.layouts.admin')

@section('content')

<style>

    .request-details-page {
        padding: 20px;
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
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-size: 13px;
    }

    .back-btn:hover {
        background: #1f2937;
    }

    .details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .details-card {
        background: #fff;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.07);
    }

    .details-card h3 {
        margin: 0 0 20px;
        font-size: 18px;
        color: #333;
        padding-bottom: 12px;
        border-bottom: 1px solid #eee;
    }

    .detail-item {
        margin-bottom: 18px;
    }

    .detail-item:last-child {
        margin-bottom: 0;
    }

    .detail-label {
        display: block;
        font-size: 12px;
        color: #888;
        margin-bottom: 5px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .detail-value {
        color: #222;
        font-size: 15px;
        word-break: break-word;
    }

    .description-box {
        background: #f9fafb;
        border-radius: 7px;
        padding: 12px 15px;
        white-space: pre-line;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 11px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .pending {
        background: #fef3c7;
        color: #92400e;
    }

    .review {
        background: #dbeafe;
        color: #1e40af;
    }

    .proposal {
        background: #ede9fe;
        color: #5b21b6;
    }

    .approved {
        background: #dcfce7;
        color: #166534;
    }

    .rejected {
        background: #fee2e2;
        color: #991b1b;
    }

    .ongoing {
        background: #dbeafe;
        color: #1e40af;
    }

    .paused {
        background: #fef3c7;
        color: #92400e;
    }

    .completed {
        background: #dcfce7;
        color: #166534;
    }

    .cancelled {
        background: #e5e7eb;
        color: #374151;
    }

    .action-card {
        margin-top: 20px;
        background: #fff;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.07);
    }

    .action-card h3 {
        margin: 0 0 8px;
        font-size: 18px;
        color: #222;
    }

    .action-card p {
        color: #777;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .review-btn {
        border: none;
        padding: 12px 22px;
        border-radius: 7px;
        background: #2563eb;
        color: white;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
    }

    .review-btn:hover {
        background: #1d4ed8;
    }

    .info-box {
        margin-top: 15px;
        padding: 13px 15px;
        background: #eff6ff;
        color: #1e40af;
        border-radius: 7px;
        font-size: 13px;
    }

    .success-box {
        margin-top: 15px;
        padding: 13px 15px;
        background: #ecfdf5;
        color: #166534;
        border-radius: 7px;
        font-size: 13px;
    }

    .warning-box {
        margin-top: 15px;
        padding: 13px 15px;
        background: #fff7ed;
        color: #9a3412;
        border-radius: 7px;
        font-size: 13px;
    }

    .action-form {
        display: inline-block;
    }

    @media (max-width: 750px) {

        .request-details-page {
            padding: 12px;
        }

        .details-grid {
            grid-template-columns: 1fr;
        }

        .review-btn {
            width: 100%;
        }

        .action-form {
            width: 100%;
        }
    }

</style>


<div class="request-details-page">

    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="page-header">

        <h2>
            Project Request Details
        </h2>

        <p>
            Review the customer's project request before preparing the proposal.
        </p>

        <a
            href="{{ route('admin.project-requests.index') }}"
            class="back-btn"
        >
            ← Back to Requests
        </a>

    </div>


    {{-- =====================================================
         FLASH MESSAGES
    ====================================================== --}}

    @if(session('success'))

        <div class="success-box">
            {{ session('success') }}
        </div>

    @endif


    @if(session('error'))

        <div class="warning-box">
            {{ session('error') }}
        </div>

    @endif


    {{-- =====================================================
         DETAILS GRID
    ====================================================== --}}

    <div class="details-grid">


        {{-- =================================================
             CUSTOMER INFORMATION
        ================================================== --}}

        <div class="details-card">

            <h3>
                Customer Information
            </h3>


            <div class="detail-item">

                <span class="detail-label">
                    Name
                </span>

                <span class="detail-value">

                    {{ $project->client?->user?->name
                        ?? $project->client?->name
                        ?? 'N/A' }}

                </span>

            </div>


            <div class="detail-item">

                <span class="detail-label">
                    Email
                </span>

                <span class="detail-value">

                    {{ $project->client?->user?->email
                        ?? $project->client?->email
                        ?? 'N/A' }}

                </span>

            </div>


            <div class="detail-item">

                <span class="detail-label">
                    Phone
                </span>

                <span class="detail-value">

                    {{ $project->client?->phone ?? 'N/A' }}

                </span>

            </div>


            <div class="detail-item">

                <span class="detail-label">
                    Address
                </span>

                <span class="detail-value">

                    {{ $project->client?->address ?? 'N/A' }}

                </span>

            </div>

        </div>


        {{-- =================================================
             PROJECT INFORMATION
        ================================================== --}}

        <div class="details-card">

            <h3>
                Project Information
            </h3>


            <div class="detail-item">

                <span class="detail-label">
                    Project ID
                </span>

                <span class="detail-value">

                    #{{ $project->id }}

                </span>

            </div>


            <div class="detail-item">

                <span class="detail-label">
                    Service
                </span>

                <span class="detail-value">

                    {{ $project->service?->name
                        ?? $project->project_name
                        ?? 'N/A' }}

                </span>

            </div>


            <div class="detail-item">

                <span class="detail-label">
                    Location
                </span>

                <span class="detail-value">

                    {{ $project->location ?? 'N/A' }}

                </span>

            </div>


            <div class="detail-item">

                <span class="detail-label">
                    Approximate Budget
                </span>

                <span class="detail-value">

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


            <div class="detail-item">

                <span class="detail-label">
                    Expected Start Date
                </span>

                <span class="detail-value">

                    {{ $project->start_date?->format('d M Y') ?? 'N/A' }}

                </span>

            </div>


            <div class="detail-item">

                <span class="detail-label">
                    Expected End Date
                </span>

                <span class="detail-value">

                    {{ $project->end_date?->format('d M Y') ?? 'N/A' }}

                </span>

            </div>

        </div>


        {{-- =================================================
             DESCRIPTION
        ================================================== --}}

        <div class="details-card">

            <h3>
                Project Description
            </h3>

            <div class="detail-item">

                <span class="detail-value description-box">

                    {{ $project->description
                        ?? 'No description provided.' }}

                </span>

            </div>

        </div>


        {{-- =================================================
             CUSTOMER NOTE
        ================================================== --}}

        <div class="details-card">

            <h3>
                Customer Note
            </h3>

            <div class="detail-item">

                <span class="detail-value description-box">

                    {{ $project->customer_note
                        ?? 'No additional note provided.' }}

                </span>

            </div>

        </div>


        {{-- =================================================
             REQUEST STATUS
        ================================================== --}}

        <div class="details-card">

            <h3>
                Request Status
            </h3>


            <div class="detail-item">

                <span class="detail-label">
                    Approval Status
                </span>

                @if($project->approval_status === 'pending')

                    <span class="status-badge pending">
                        Pending
                    </span>

                @elseif($project->approval_status === 'approved')

                    <span class="status-badge approved">
                        Approved
                    </span>

                @elseif($project->approval_status === 'rejected')

                    <span class="status-badge rejected">
                        Rejected
                    </span>

                @endif

            </div>


            <div class="detail-item">

                <span class="detail-label">
                    Project Status
                </span>

                @switch($project->status)

                    @case('request_pending')

                        <span class="status-badge pending">
                            Request Pending
                        </span>

                        @break

                    @case('admin_review')

                        <span class="status-badge review">
                            Admin Review
                        </span>

                        @break

                    @case('proposal_sent')

                        <span class="status-badge proposal">
                            Proposal Sent
                        </span>

                        @break

                    @case('ongoing')

                        <span class="status-badge ongoing">
                            Ongoing
                        </span>

                        @break

                    @case('paused')

                        <span class="status-badge paused">
                            Paused
                        </span>

                        @break

                    @case('completed')

                        <span class="status-badge completed">
                            Completed
                        </span>

                        @break

                    @case('customer_rejected')

                        <span class="status-badge rejected">
                            Customer Rejected
                        </span>

                        @break

                    @case('cancelled')

                        <span class="status-badge cancelled">
                            Cancelled
                        </span>

                        @break

                    @default

                        <span class="status-badge cancelled">
                            {{ ucwords(str_replace('_', ' ', $project->status)) }}
                        </span>

                @endswitch

            </div>


            <div class="detail-item">

                <span class="detail-label">
                    Request Submitted
                </span>

                <span class="detail-value">

                    {{ $project->created_at?->format('d M Y, h:i A') ?? 'N/A' }}

                </span>

            </div>

        </div>

    </div>


    {{-- =====================================================
         ADMIN ACTION
    ====================================================== --}}

    @if($project->status === 'request_pending')

        <div class="action-card">

            <h3>
                Start Project Review
            </h3>

            <p>
                The customer has submitted this project request.
                Start the review process before preparing the final
                budget, project steps and payment plan.
            </p>


            <form
                action="{{ route('admin.project-requests.review', $project) }}"
                method="POST"
                class="action-form"
            >

                @csrf

                <button
                    type="submit"
                    class="review-btn"
                    onclick="return confirm('Start reviewing this project request?')"
                >
                    ✓ Start Review
                </button>

            </form>


            <div class="info-box">

                <strong>Next Step:</strong>

                After starting the review, prepare the final project
                proposal, budget, working procedure/project steps and
                payment milestones.

            </div>

        </div>


    @elseif($project->status === 'admin_review')

        <div class="action-card">

            <h3>
                Request Under Review
            </h3>

            <p>
                This project request is currently being reviewed by the admin.
            </p>

            <div class="info-box">

                <strong>Next Step:</strong>

                Prepare the final budget, project steps and payment
                milestones for the customer proposal.

            </div>

            <div style="margin-top: 20px;">

                <a
                    href="{{ route('admin.project-proposals.edit', $project) }}"
                    class="review-btn"
                    style="display:inline-block; text-decoration:none;"
                >
                    📋 Prepare Proposal
                </a>

            </div>

        </div>


    @elseif($project->status === 'proposal_sent')

        <div class="action-card">

            <h3>
                Proposal Sent
            </h3>

            <p>
                The final proposal has been sent to the customer.
                Waiting for customer approval or rejection.
            </p>


            <div class="success-box">

                Customer can now review the proposal from their dashboard.

            </div>

        </div>


    @else

        <div class="action-card">

            <h3>
                Request Status
            </h3>

            <p>

                This request is currently:

                <strong>
                    {{ ucwords(str_replace('_', ' ', $project->status)) }}
                </strong>

            </p>

        </div>

    @endif


</div>

@endsection