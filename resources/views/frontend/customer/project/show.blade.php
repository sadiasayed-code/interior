<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $project->service?->name ?? 'Project' }} - Project Details</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            color: #1f2937;
            line-height: 1.5;
        }

        .navbar {
            background: #1f2937;
            color: #fff;
            padding: 16px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .navbar h2 {
            font-size: 20px;
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            border: none;
            text-decoration: none;
            padding: 9px 15px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-back {
            background: #374151;
            color: #fff;
        }

        .btn-back:hover {
            background: #4b5563;
        }

        .btn-print {
            background: #2563eb;
            color: #fff;
        }

        .btn-print:hover {
            background: #1d4ed8;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .page-header {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, .07);
        }

        .page-header h1 {
            font-size: 28px;
            margin-bottom: 8px;
        }

        .page-header p {
            color: #6b7280;
            font-size: 14px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .card {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0, 0, .07);
        }

        .full-card {
            width: min(100%, 1080px);
            margin: 20px auto 0;
        }

        /* Keep all long sections centered with visible space on both sides */
        .full-card .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .full-card .proposal-box {
            width: 100%;
        }

        .card-title {
            font-size: 18px;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 13px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .label {
            color: #6b7280;
            font-size: 13px;
            font-weight: 600;
        }

        .value {
            text-align: right;
            font-size: 14px;
            font-weight: 500;
            color: #1f2937;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-pending,
        .badge-request_pending,
        .badge-admin_review,
        .badge-paused {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-proposal_sent,
        .badge-customer_approved,
        .badge-ongoing {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-approved,
        .badge-completed {
            background: #dcfce7;
            color: #166534;
        }

        .badge-rejected,
        .badge-customer_rejected,
        .badge-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-default {
            background: #e5e7eb;
            color: #374151;
        }

        .alert {
            padding: 14px 18px;
            border-radius: 9px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .proposal-box {
            border: 2px solid #2563eb;
            background: #eff6ff;
            border-radius: 12px;
            padding: 22px;
        }

        .proposal-box h3 {
            color: #1e40af;
            margin-bottom: 8px;
        }

        .proposal-box p {
            color: #4b5563;
            font-size: 14px;
        }

        .proposal-amount {
            margin: 18px 0;
            background: #fff;
            border-radius: 10px;
            padding: 18px;
            border: 1px solid #dbeafe;
        }

        .proposal-amount small {
            display: block;
            color: #6b7280;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .proposal-amount strong {
            font-size: 28px;
            color: #111827;
        }

        .action-row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 18px;
        }

        .action-row form {
            margin: 0;
        }

        .btn-approve {
            background: #16a34a;
            color: #fff;
        }

        .btn-approve:hover {
            background: #15803d;
        }

        .btn-reject {
            background: #dc2626;
            color: #fff;
        }

        .btn-reject:hover {
            background: #b91c1c;
        }

        .btn-edit {
            background: #7c3aed;
            color: #fff;
        }

        .btn-pause {
            background: #f59e0b;
            color: #fff;
        }

        .btn-resume {
            background: #16a34a;
            color: #fff;
        }

        .btn-cancel {
            background: #dc2626;
            color: #fff;
        }

        .btn-muted {
            background: #e5e7eb;
            color: #374151;
        }

        .notice {
            margin-top: 15px;
            padding: 13px 15px;
            border-radius: 8px;
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 13px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 15px;
        }

        .summary-box {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 18px;
        }

        .summary-label {
            display: block;
            color: #6b7280;
            font-size: 12px;
            margin-bottom: 9px;
            text-transform: uppercase;
            font-weight: 700;
        }

        .summary-value {
            font-size: 20px;
            font-weight: 700;
            color: #1f2937;
        }

        .payment-status {
            margin-top: 20px;
            padding: 14px 18px;
            border-radius: 8px;
            background: #eff6ff;
            color: #1e40af;
            font-size: 14px;
            font-weight: 600;
        }

        .progress-section {
            margin-top: 10px;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
            font-weight: 700;
        }

        .progress-bar {
            width: 100%;
            height: 14px;
            background: #e5e7eb;
            border-radius: 20px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: #2563eb;
            border-radius: 20px;
            transition: width .3s ease;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }

        th {
            text-align: left;
            padding: 14px;
            background: #f8fafc;
            border-bottom: 1px solid #e5e7eb;
            font-size: 12px;
            color: #6b7280;
            text-transform: uppercase;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            vertical-align: top;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .payment-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: 700;
            text-transform: capitalize;
        }

        .payment-paid {
            background: #dcfce7;
            color: #166534;
        }

        .payment-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .payment-upcoming {
            background: #dbeafe;
            color: #1e40af;
        }

        .payment-overdue {
            background: #fee2e2;
            color: #991b1b;
        }

        .step-list {
            display: grid;
            gap: 12px;
        }

        .step-item {
            display: grid;
            grid-template-columns: 42px 1fr auto;
            gap: 14px;
            align-items: start;
            padding: 16px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            background: #fafafa;
        }

        .step-number {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #2563eb;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
        }

        .step-title {
            font-weight: 700;
            margin-bottom: 4px;
        }

        .step-description {
            color: #6b7280;
            font-size: 13px;
        }

        .step-status {
            font-size: 12px;
            font-weight: 700;
            padding: 5px 9px;
            border-radius: 15px;
            background: #e5e7eb;
            color: #374151;
            text-transform: capitalize;
        }

        .report-list {
            display: grid;
            gap: 12px;
        }

        .report-item {
            padding: 16px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            background: #fafafa;
        }

        .report-top {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 8px;
        }

        .report-progress {
            font-weight: 700;
            color: #1e40af;
        }

        .report-date {
            color: #6b7280;
            font-size: 12px;
        }

        .report-note {
            color: #4b5563;
            font-size: 13px;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #6b7280;
            font-size: 14px;
            background: #fafafa;
            border-radius: 8px;
        }

        .cancel-box {
            margin-top: 18px;
            padding: 15px;
            border: 1px solid #fecaca;
            background: #fff7f7;
            border-radius: 9px;
        }

        .cancel-box label {
            display: block;
            margin-bottom: 7px;
            font-size: 13px;
            font-weight: 700;
            color: #991b1b;
        }

        .cancel-box textarea {
            width: 100%;
            min-height: 90px;
            resize: vertical;
            padding: 10px;
            border: 1px solid #fecaca;
            border-radius: 7px;
            font-family: inherit;
            margin-bottom: 10px;
        }

        .security-note {
            margin-top: 20px;
            padding: 14px 16px;
            background: #f8fafc;
            border-left: 4px solid #2563eb;
            color: #6b7280;
            font-size: 13px;
        }

        @media (max-width: 900px) {
            .summary-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 700px) {
            .navbar {
                padding: 15px;
                flex-direction: column;
                align-items: flex-start;
            }

            .navbar-actions {
                width: 100%;
            }

            .navbar-actions .btn {
                flex: 1;
            }

            .container {
                margin: 20px auto;
                padding: 0 12px;
            }

            .grid {
                grid-template-columns: 1fr;
            }

            .full-card {
                width: 100%;
            }

            .summary-grid {
                grid-template-columns: 1fr;
            }

            .info-row {
                flex-direction: column;
                gap: 5px;
            }

            .value {
                text-align: left;
            }

            .page-header h1 {
                font-size: 24px;
            }

            .step-item {
                grid-template-columns: 38px 1fr;
            }

            .step-status {
                grid-column: 2;
                width: fit-content;
            }

            .report-top {
                flex-direction: column;
                gap: 4px;
            }
        }

        @media print {
            body {
                background: #fff;
            }

            .navbar {
                display: none;
            }

            .container {
                max-width: 100%;
                margin: 0;
                padding: 0;
            }

            .card,
            .page-header {
                box-shadow: none;
                border: 1px solid #ddd;
                break-inside: avoid;
            }

            .action-row,
            .cancel-box,
            .security-note {
                display: none !important;
            }
        }

        /* =========================================================
   CUSTOMER PROJECT PROGRESS UPDATES
========================================================= */

.progress-updates-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    padding-bottom: 16px;
    margin-bottom: 18px;
    border-bottom: 1px solid #e5e7eb;
}

.progress-updates-subtitle {
    margin: 4px 0 0;
    color: #6b7280;
    font-size: 13px;
}

.progress-work-count {
    font-size: 15px;
    font-weight: 600;
    color: #1f2937;
    white-space: nowrap;
}


/* =========================================================
   PROGRESS LIST
========================================================= */

.customer-progress-list {
    display: grid;
    gap: 16px;
}

.customer-progress-item {
    padding: 18px;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    background: #fafafa;
}


/* =========================================================
   TOP
========================================================= */

.customer-progress-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 12px;
}

.customer-progress-work {
    display: flex;
    align-items: center;
    gap: 12px;
}

.customer-progress-number {
    width: 34px;
    height: 34px;
    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #2563eb;
    color: #ffffff;

    font-size: 13px;
    font-weight: 700;
}

.customer-work-type {
    font-size: 15px;
    font-weight: 700;
    color: #111827;
    text-transform: capitalize;
}

.customer-progress-label {
    margin-top: 3px;
    font-size: 12px;
    color: #6b7280;
}

.customer-progress-percentage {
    font-size: 18px;
    font-weight: 700;
    color: #1e40af;
}


/* =========================================================
   PROGRESS BAR
========================================================= */

.customer-progress-bar {
    width: 100%;
    height: 9px;

    background: #e5e7eb;
    border-radius: 20px;

    overflow: hidden;

    margin-bottom: 16px;
}

.customer-progress-fill {
    height: 100%;

    background: #2563eb;

    border-radius: 20px;

    transition: width 0.4s ease;
}


/* =========================================================
   DESCRIPTION
========================================================= */

.customer-progress-description {
    padding: 13px 14px;
    margin-top: 10px;

    background: #ffffff;

    border: 1px solid #e5e7eb;
    border-radius: 8px;
}

.customer-detail-title {
    margin-bottom: 5px;

    font-size: 12px;
    font-weight: 700;

    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.customer-detail-text {
    font-size: 14px;
    line-height: 1.6;
    color: #374151;
}


/* =========================================================
   IMAGE
========================================================= */

.customer-progress-image-section {
    margin-top: 15px;
}

.customer-progress-image {
    margin-top: 8px;
}

.customer-progress-image img {
    display: block;

    width: 100%;
    max-width: 420px;
    max-height: 280px;

    object-fit: cover;

    border-radius: 9px;

    border: 1px solid #e5e7eb;

    cursor: pointer;

    transition: transform 0.2s ease,
                box-shadow 0.2s ease;
}

.customer-progress-image img:hover {
    transform: translateY(-2px);

    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
}


/* =========================================================
   FOOTER
========================================================= */

.customer-progress-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 15px;

    margin-top: 16px;
    padding-top: 12px;

    border-top: 1px solid #e5e7eb;

    font-size: 12px;
    color: #6b7280;
}

.customer-progress-footer strong {
    color: #374151;
    font-weight: 600;
}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 600px) {

    .progress-updates-header {
        align-items: flex-start;
    }

    .progress-work-count {
        font-size: 13px;
    }

    .customer-progress-item {
        padding: 14px;
    }

    .customer-progress-top {
        gap: 10px;
    }

    .customer-progress-percentage {
        font-size: 16px;
    }

    .customer-work-type {
        font-size: 14px;
    }

    .customer-progress-footer {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }

    .customer-progress-image img {
        max-width: 100%;
        max-height: 240px;
    }
}
    </style>
</head>

<body>

<div class="navbar">
    <h2>Interior Project Management System</h2>

    <div class="navbar-actions">
        <a href="{{ route('customer.dashboard') }}" class="btn btn-back">
            ← Dashboard
        </a>

        <button type="button" class="btn btn-print" onclick="window.print()">
            Print Project
        </button>
    </div>
</div>

<div class="container">

    {{-- =========================================================
         FLASH MESSAGES
    ========================================================== --}}

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            {{ $errors->first() }}
        </div>
    @endif


    {{-- =========================================================
         PAGE HEADER
    ========================================================== --}}

    <div class="page-header">
        <h1>{{ $project->service?->name ?? 'Project' }}</h1>

        <p>
            Track your project request, proposal, working steps,
            payment milestones and project progress from one place.
        </p>
    </div>


    {{-- =========================================================
         PROJECT INFORMATION + STATUS
    ========================================================== --}}

    <div class="grid">

        <div class="card">
            <h3 class="card-title">Project Information</h3>

            <div class="info-row">
                <span class="label">Service</span>
                <span class="value">
                    {{ $project->service?->name ?? 'Project' }}
                </span>
            </div>

            <div class="info-row">
                <span class="label">Location</span>
                <span class="value">{{ $project->location ?? '-' }}</span>
            </div>

            <div class="info-row">
                <span class="label">Description</span>
                <span class="value">
                    {{ $project->description ?? '-' }}
                </span>
            </div>

            <div class="info-row">
                <span class="label">Approximate Budget</span>
                <span class="value">
                    @if($project->approximate_budget !== null)
                        ৳ {{ number_format((float) $project->approximate_budget, 2) }}
                    @else
                        -
                    @endif
                </span>
            </div>

            <div class="info-row">
                <span class="label">Expected Start</span>
                <span class="value">
                    {{ $project->start_date ? $project->start_date->format('d M Y') : '-' }}
                </span>
            </div>

            <div class="info-row">
                <span class="label">Expected End</span>
                <span class="value">
                    {{ $project->end_date ? $project->end_date->format('d M Y') : '-' }}
                </span>
            </div>

            <div class="info-row">
                <span class="label">Request Date</span>
                <span class="value">
                    {{ $project->created_at ? $project->created_at->format('d M Y, h:i A') : '-' }}
                </span>
            </div>
        </div>


        <div class="card">
            <h3 class="card-title">Current Project Status</h3>

            @php
                $status = $project->status ?? 'request_pending';

                $statusLabels = [
                    'request_pending'   => 'Request Pending',
                    'admin_review'      => 'Under Admin Review',
                    'proposal_sent'    => 'Proposal Sent',
                    'customer_approved'=> 'Customer Approved',
                    'customer_rejected'=> 'Customer Rejected',
                    'ongoing'           => 'Ongoing',
                    'paused'            => 'Paused',
                    'completed'         => 'Completed',
                    'cancelled'         => 'Cancelled',
                ];

                $statusLabel = $statusLabels[$status] ?? ucfirst(str_replace('_', ' ', $status));

                $approvalStatus = $project->approval_status ?? 'pending';
                $approvalLabels = [
                    'pending'  => 'Pending',
                    'approved' => 'Approved',
                    'rejected' => 'Rejected',
                ];
            @endphp

            <div class="info-row">
                <span class="label">Approval Status</span>
                <span class="value">
                    <span class="badge badge-{{ $approvalStatus }}">
                        {{ $approvalLabels[$approvalStatus] ?? ucfirst($approvalStatus) }}
                    </span>
                </span>
            </div>

            <div class="info-row">
                <span class="label">Project Status</span>
                <span class="value">
                    <span class="badge badge-{{ $status }}">
                        {{ $statusLabel }}
                    </span>
                </span>
            </div>

            <div class="info-row">
                <span class="label">Payment Status</span>
                <span class="value">{{ $paymentStatus }}</span>
            </div>

            <div class="info-row">
                <span class="label">Overall Progress</span>
                <span class="value">
                    {{ number_format($overallProgress, 0) }}%
                </span>
            </div>

            @if($project->customer_approved_at)
                <div class="info-row">
                    <span class="label">Approved At</span>
                    <span class="value">
                        {{ $project->customer_approved_at->format('d M Y, h:i A') }}
                    </span>
                </div>
            @endif

            @if($project->cancelled_at)
                <div class="info-row">
                    <span class="label">Cancelled At</span>
                    <span class="value">
                        {{ $project->cancelled_at->format('d M Y, h:i A') }}
                    </span>
                </div>
            @endif
        </div>

    </div>


    {{-- =========================================================
         CUSTOMER ACTIONS
    ========================================================== --}}

    <div class="card full-card">
        <h3 class="card-title">Project Actions</h3>

     


            @if($status === 'request_pending')

                <a href="{{ route('customer.project.edit', $project) }}"
                   class="btn btn-edit">
                    ✎ Edit Request
                </a>

            @endif


            {{-- Proposal Approve/Reject buttons are shown in the Proposal section below.
                 Keeping them in one place avoids duplicate actions. --}}


            @if($status === 'ongoing')

                <form action="{{ route('customer.projects.pause', $project) }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to pause this project?');">
                    @csrf

                    <button type="submit" class="btn btn-pause">
                        Pause Project
                    </button>
                </form>

            @endif


            @if($status === 'paused')

                <form action="{{ route('customer.projects.resume', $project) }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to resume this project?');">
                    @csrf

                    <button type="submit" class="btn btn-resume">
                        Resume Project
                    </button>
                </form>

            @endif


            @if(in_array($status, [
                'request_pending',
                'admin_review',
                'proposal_sent',
                'ongoing',
                'paused'
            ], true))

                <button type="button"
                        class="btn btn-cancel"
                        onclick="document.getElementById('cancelBox').style.display =
                                 document.getElementById('cancelBox').style.display === 'none'
                                 ? 'block' : 'none';">
                    Cancel Project
                </button>

            @endif

        </div>


        @if($status === 'request_pending')
            <div class="notice">
                Your request has been submitted. You can edit it while
                it is still waiting for admin review.
            </div>
        @elseif($status === 'admin_review')
            <div class="notice">
                Your request is currently being reviewed by the admin.
                The final proposal will be prepared after review.
            </div>
        @elseif($status === 'proposal_sent')
            <div class="notice">
                Your final proposal is ready. Please review the proposal
                below and choose Approve or Reject.
            </div>
        @elseif($status === 'ongoing')
            <div class="notice">
                Your proposal has been approved and your project is now ongoing.
            </div>
        @elseif($status === 'paused')
            <div class="notice">
                Your project is currently paused. You can resume it when appropriate.
            </div>
        @elseif($status === 'completed')
            <div class="notice">
                This project has been marked as completed.
            </div>
        @elseif($status === 'cancelled')
            <div class="notice">
                This project has been cancelled.
            </div>
        @elseif($status === 'customer_rejected')
            <div class="notice">
                The proposal for this project was rejected. The proposal details remain available below for your reference.
            </div>
        @endif


        {{-- CANCEL FORM --}}

        @if(in_array($status, [
            'request_pending',
            'admin_review',
            'proposal_sent',
            'ongoing',
            'paused'
        ], true))

            <div id="cancelBox"
                 class="cancel-box"
                 style="display:none;">

                <form action="{{ route('customer.projects.cancel', $project) }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to cancel this project?');">

                    @csrf

                    <label for="cancellation_reason">
                        Cancellation Reason (Optional)
                    </label>

                    <textarea
                        name="cancellation_reason"
                        id="cancellation_reason"
                        maxlength="2000"
                        placeholder="Please tell us why you want to cancel this project..."
                    ></textarea>

                    <button type="submit" class="btn btn-cancel">
                        Confirm Cancellation
                    </button>
                </form>
            </div>

        @endif

    </div>


    {{-- =========================================================
         PROPOSAL
    ========================================================== --}}

    @if(in_array($status, [
        'proposal_sent',
        'customer_approved',
        'customer_rejected',
        'ongoing',
        'paused',
        'completed'
    ], true))

        <div class="card full-card">

            <h3 class="card-title">Project Proposal</h3>

            <div class="proposal-box">

                <h3>Final Project Proposal</h3>

                <p>
                    This is the customer-facing project amount finalized
                    by the admin. Internal estimated cost, actual cost,
                    profit and loss are not displayed here.
                </p>

                @if($project->budget && $contractAmount > 0)

                    <div class="proposal-amount">
                        <small>Final Contract Amount</small>

                        <strong>
                            ৳ {{ number_format($contractAmount, 2) }}
                        </strong>
                    </div>

                @else

                    <div class="notice">
                        The final contract amount has not been finalized yet.
                    </div>

                @endif


                @if($status === 'proposal_sent' && $approvalStatus === 'pending')

                    <div class="action-row">

                        <div class="notice" style="width:100%; margin-top:0; margin-bottom:5px;">
                            Please review the final contract amount, project steps and payment milestones before approving.
                        </div>

                        <form action="{{ route('customer.project.approve', $project) }}"
                              method="POST"
                              onsubmit="return confirm('Are you sure you want to approve this proposal?');">
                            @csrf

                            <button type="submit" class="btn btn-approve">
                                ✓ Approve Proposal
                            </button>
                        </form>

                        <form action="{{ route('customer.project.reject', $project) }}"
                              method="POST"
                              onsubmit="return confirm('Are you sure you want to reject this proposal?');">
                            @csrf

                            <button type="submit" class="btn btn-reject">
                                ✕ Reject Proposal
                            </button>
                        </form>

                    </div>

                @elseif($approvalStatus === 'approved')

                    <div class="notice">
                        ✓ You approved this proposal.
                        The project is now under execution.
                    </div>

                @elseif($approvalStatus === 'rejected' || $status === 'customer_rejected')

                    <div class="notice">
                        ✕ You rejected this proposal.
                        The project is not currently under execution.
                    </div>

                @endif

            </div>
        </div>

    @endif


    {{-- =========================================================
         PROJECT STEPS / WORKING PROCEDURE
    ========================================================== --}}

    @if(in_array($status, [
        'proposal_sent',
        'customer_approved',
        'customer_rejected',
        'ongoing',
        'paused',
        'completed'
    ], true))

        <div class="card full-card">

            <h3 class="card-title">
                Project Steps / Working Procedure
            </h3>

            @if($project->projectSteps && $project->projectSteps->count())

                <div class="step-list">

                    @foreach($project->projectSteps as $step)

                        <div class="step-item">

                            <div class="step-number">
                                {{ $step->step_number ?? $loop->iteration }}
                            </div>

                            <div>
                                <div class="step-title">
                                    {{ $step->title ?? $step->name ?? 'Project Step' }}
                                </div>

                                @if($step->description)
                                    <div class="step-description">
                                        {{ $step->description }}
                                    </div>
                                @endif
                            </div>

                            <div>
                                <span class="step-status">
                                    {{ $step->status ?? 'planned' }}
                                </span>
                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="empty">
                    Project working steps have not been added yet.
                </div>

            @endif

        </div>

    @endif


    {{-- =========================================================
         PAYMENT SUMMARY
         Customer sees only finalized contract/payment information.
    ========================================================== --}}

    @if(in_array($status, [
        'proposal_sent',
        'customer_approved',
        'customer_rejected',
        'ongoing',
        'paused',
        'completed'
    ], true))

        <div class="card full-card">

            <h3 class="card-title">Payment Summary</h3>

            @if($project->budget)

                <div class="summary-grid">

                    <div class="summary-box">
                        <span class="summary-label">Contract Amount</span>

                        <div class="summary-value">
                            ৳ {{ number_format($contractAmount, 2) }}
                        </div>
                    </div>

                    <div class="summary-box">
                        <span class="summary-label">Milestones</span>

                        <div class="summary-value">
                            {{ $totalMilestones }}
                        </div>
                    </div>

                    <div class="summary-box">
                        <span class="summary-label">Total Paid</span>

                        <div class="summary-value">
                            ৳ {{ number_format($totalPaidAmount, 2) }}
                        </div>
                    </div>

                    <div class="summary-box">
                        <span class="summary-label">Remaining</span>

                        <div class="summary-value">
                            ৳ {{ number_format($remainingAmount, 2) }}
                        </div>
                    </div>

                </div>

                <div class="payment-status">
                    Payment Position: {{ $paymentStatus }}
                </div>

            @else

                <div class="empty">
                    Financial information has not been finalized for this project yet.
                </div>

            @endif

        </div>

    @endif


    {{-- =========================================================
         PAYMENT MILESTONES
    ========================================================== --}}

    @if(in_array($status, [
        'proposal_sent',
        'customer_approved',
        'customer_rejected',
        'ongoing',
        'paused',
        'completed'
    ], true))

        <div class="card full-card">

            <h3 class="card-title">Payment Milestones</h3>

            @if($project->payments && $project->payments->count())

                <div class="table-wrapper">

                    <table>

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Milestone</th>
                                <th>Amount</th>
                                <th>Due Date</th>
                                <th>Payment Date</th>
                                <th>Status</th>
                                <th>Payment Method</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($project->payments as $payment)

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ $payment->milestone ?? '-' }}
                                    </td>

                                    <td>
                                        ৳ {{ number_format((float) $payment->amount, 2) }}
                                    </td>

                                    <td>
                                        {{ $payment->due_date
                                            ? $payment->due_date->format('d M Y')
                                            : '-' }}
                                    </td>

                                    <td>
                                        {{ $payment->payment_date
                                            ? $payment->payment_date->format('d M Y')
                                            : '-' }}
                                    </td>

                                    <td>
                                        <span class="payment-badge payment-{{ $payment->status }}">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $payment->payment_method ?? '-' }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="empty">
                    No payment milestones have been added yet.
                </div>

            @endif

        </div>

    @endif


    {{-- =========================================================
         PAYMENT PROGRESS
    ========================================================== --}}

    @if(in_array($status, [
        'customer_approved',
        'ongoing',
        'paused',
        'completed'
    ], true))

        <div class="card full-card">

            <h3 class="card-title">Payment Progress</h3>

            <div class="progress-section">

                <div class="progress-header">
                    <span>Paid Amount</span>
                    <span>{{ number_format($paymentProgress, 0) }}%</span>
                </div>

                <div class="progress-bar">
                    <div class="progress-fill"
                         style="width: {{ number_format($paymentProgress, 2, '.', '') }}%;">
                    </div>
                </div>

            </div>

        </div>

    @endif


    {{-- =========================================================
         PROJECT PROGRESS
    ========================================================== --}}

    @if(in_array($status, [
        'customer_approved',
        'ongoing',
        'paused',
        'completed'
    ], true))

        <div class="card full-card">

            <h3 class="card-title">Project Progress</h3>

            <div class="progress-section">

                <div class="progress-header">
                    <span>Overall Completion</span>

                    <span>
                        {{ number_format($overallProgress, 0) }}%
                    </span>
                </div>

                <div class="progress-bar">

                    <div class="progress-fill"
                         style="width: {{ number_format($overallProgress, 2, '.', '') }}%;">
                    </div>

                </div>

            </div>

        </div>

    @endif


    {{-- =========================================================
         PROGRESS REPORTS
    ========================================================== --}}
{{-- =========================================================
     PROJECT PROGRESS UPDATES
========================================================== --}}

@if(in_array($status, [
    'customer_approved',
    'ongoing',
    'paused',
    'completed'
], true))

    <div class="card full-card">

        <div class="progress-updates-header">

            <div>
                <h3 class="card-title">
                    Project Progress Updates
                </h3>

                <p class="progress-updates-subtitle">
                    Detailed progress updates for your project.
                </p>
            </div>

            <div class="progress-work-count">
                {{ $progressReports ? $progressReports->count() : 0 }}
                {{ ($progressReports && $progressReports->count() == 1) ? 'Work' : 'Works' }}
            </div>

        </div>


        @if($progressReports && $progressReports->count())

            <div class="customer-progress-list">

                @foreach($progressReports as $index => $report)

                    <div class="customer-progress-item">

                        {{-- =================================================
                             TOP SECTION
                        ================================================== --}}

                        <div class="customer-progress-top">

                            <div class="customer-progress-work">

                                <span class="customer-progress-number">
                                    {{ $index + 1 }}
                                </span>

                                <div>

                                    <div class="customer-work-type">
                                        {{ $report->work_type ?? 'Work Type' }}
                                    </div>

                                    <div class="customer-progress-label">
                                        Work Progress
                                    </div>

                                </div>

                            </div>


                            <div class="customer-progress-percentage">

                                {{ number_format(
                                    (float) ($report->progress_percent ?? 0),
                                    0
                                ) }}%

                            </div>

                        </div>


                        {{-- =================================================
                             PROGRESS BAR
                        ================================================== --}}

                        @php
                            $reportProgress = (float) (
                                $report->progress_percent ?? 0
                            );

                            if ($reportProgress < 0) {
                                $reportProgress = 0;
                            }

                            if ($reportProgress > 100) {
                                $reportProgress = 100;
                            }
                        @endphp


                        <div class="customer-progress-bar">

                            <div
                                class="customer-progress-fill"
                                style="width: {{ $reportProgress }}%;"
                            ></div>

                        </div>


                        {{-- =================================================
                             DESCRIPTION
                        ================================================== --}}

                        @if($report->description)

                            <div class="customer-progress-description">

                                <div class="customer-detail-title">
                                    Description
                                </div>

                                <div class="customer-detail-text">
                                    {{ $report->description }}
                                </div>

                            </div>

                        @endif


                        {{-- =================================================
                             IMAGE
                        ================================================== --}}

                        @if($report->image)

                            <div class="customer-progress-image-section">

                                <div class="customer-detail-title">
                                    Progress Image
                                </div>

                                <div class="customer-progress-image">

                                    <a
                                        href="{{ asset('storage/' . $report->image) }}"
                                        target="_blank"
                                    >
                                        <img
                                            src="{{ asset('storage/' . $report->image) }}"
                                            alt="{{ $report->work_type ?? 'Project Progress' }}"
                                        >
                                    </a>

                                </div>

                            </div>

                        @endif


                        {{-- =================================================
                             UPDATED DATE
                        ================================================== --}}

                        <div class="customer-progress-footer">

                            <span>
                                Last Updated
                            </span>

                            <strong>
                                {{ $report->updated_at
                                    ? $report->updated_at->format('d M Y, h:i A')
                                    : '-'
                                }}
                            </strong>

                        </div>

                    </div>

                @endforeach

            </div>


        @else

            <div class="empty">

                No progress update has been added yet.

            </div>

        @endif

    </div>

@endif


    {{-- =========================================================
         COMPLETION
    ========================================================== --}}

    @if($status === 'completed')

        <div class="card full-card">

            <div class="proposal-box">

                <h3>✓ Project Completed</h3>

                <p>
                    Your project has been marked as completed by the
                    project management team.
                </p>

            </div>

        </div>

    @endif


    {{-- =========================================================
         CANCELLATION INFORMATION
    ========================================================== --}}

    @if($status === 'cancelled')

        <div class="card full-card">

            <h3 class="card-title">Cancellation Information</h3>

            <div class="info-row">
                <span class="label">Cancelled At</span>

                <span class="value">
                    {{ $project->cancelled_at
                        ? $project->cancelled_at->format('d M Y, h:i A')
                        : '-' }}
                </span>
            </div>

            <div class="info-row">
                <span class="label">Reason</span>

                <span class="value">
                    {{ $project->cancellation_reason ?? 'No reason provided.' }}
                </span>
            </div>

        </div>

    @endif


    {{-- =========================================================
         CUSTOMER PRIVACY NOTE
    ========================================================== --}}

    <div class="security-note">
        <strong>Customer Information:</strong>
        This page shows only customer-facing project information,
        finalized contract/payment information and project progress.
        Internal estimated cost, actual cost, profit/loss and internal
        management data are not displayed.
    </div>

</div>

</body>
</html>
