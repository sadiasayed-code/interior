<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        {{ $project->project_name }} - Project Details
    </title>


    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }


        body {
            font-family:
                Arial,
                sans-serif;

            background:
                #f4f6f9;

            color:
                #1f2937;
        }


        /* =====================================================
           NAVBAR
        ===================================================== */

        .navbar {
            background:
                #1f2937;

            color:
                white;

            padding:
                16px 30px;

            display:
                flex;

            justify-content:
                space-between;

            align-items:
                center;

            gap:
                15px;
        }


        .navbar h2 {
            font-size:
                20px;
        }


        .navbar-actions {
            display:
                flex;

            align-items:
                center;

            gap:
                10px;
        }


        .btn {
            border:
                none;

            text-decoration:
                none;

            padding:
                9px 15px;

            border-radius:
                7px;

            font-size:
                13px;

            font-weight:
                600;

            cursor:
                pointer;

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;
        }


        .btn-back {
            background:
                #374151;

            color:
                white;
        }


        .btn-back:hover {
            background:
                #4b5563;
        }


        .btn-print {
            background:
                #2563eb;

            color:
                white;
        }


        .btn-print:hover {
            background:
                #1d4ed8;
        }


        /* =====================================================
           CONTAINER
        ===================================================== */

        .container {
            max-width:
                1200px;

            margin:
                30px auto;

            padding:
                0 20px;
        }


        /* =====================================================
           PAGE HEADER
        ===================================================== */

        .page-header {
            background:
                white;

            border-radius:
                12px;

            padding:
                25px;

            margin-bottom:
                20px;

            box-shadow:
                0 3px 15px rgba(
                    0,
                    0,
                    0,
                    0.07
                );
        }


        .page-header h1 {
            font-size:
                28px;

            margin-bottom:
                8px;
        }


        .page-header p {
            color:
                #6b7280;

            font-size:
                14px;
        }


        /* =====================================================
           GRID
        ===================================================== */

        .grid {
            display:
                grid;

            grid-template-columns:
                repeat(
                    2,
                    minmax(
                        0,
                        1fr
                    )
                );

            gap:
                20px;
        }


        /* =====================================================
           CARD
        ===================================================== */

        .card {
            background:
                white;

            padding:
                25px;

            border-radius:
                12px;

            box-shadow:
                0 3px 15px rgba(
                    0,
                    0,
                    0.07
                );
        }


        .full-card {
            margin-top:
                20px;
        }


        .card-title {
            font-size:
                18px;

            margin-bottom:
                20px;

            padding-bottom:
                12px;

            border-bottom:
                1px solid #e5e7eb;
        }


        /* =====================================================
           INFORMATION
        ===================================================== */

        .info-row {
            display:
                flex;

            justify-content:
                space-between;

            gap:
                20px;

            padding:
                13px 0;

            border-bottom:
                1px solid #f0f0f0;
        }


        .info-row:last-child {
            border-bottom:
                none;
        }


        .label {
            color:
                #6b7280;

            font-size:
                13px;

            font-weight:
                600;
        }


        .value {
            text-align:
                right;

            font-size:
                14px;

            font-weight:
                500;

            color:
                #1f2937;
        }


        /* =====================================================
           STATUS BADGES
        ===================================================== */

        .badge {
            display:
                inline-block;

            padding:
                6px 12px;

            border-radius:
                20px;

            font-size:
                12px;

            font-weight:
                700;
        }


        .badge-pending {
            background:
                #fef3c7;

            color:
                #92400e;
        }


        .badge-approved {
            background:
                #dcfce7;

            color:
                #166534;
        }


        .badge-rejected {
            background:
                #fee2e2;

            color:
                #991b1b;
        }


        .badge-ongoing {
            background:
                #dbeafe;

            color:
                #1e40af;
        }


        .badge-completed {
            background:
                #dcfce7;

            color:
                #166534;
        }


        .badge-cancelled {
            background:
                #fee2e2;

            color:
                #991b1b;
        }


        .badge-paused {
            background:
                #fef3c7;

            color:
                #92400e;
        }


        /* =====================================================
           SUMMARY CARDS
        ===================================================== */

        .summary-grid {
            display:
                grid;

            grid-template-columns:
                repeat(
                    4,
                    minmax(
                        0,
                        1fr
                    )
                );

            gap:
                15px;
        }


        .summary-box {
            background:
                #f8fafc;

            border:
                1px solid #e5e7eb;

            border-radius:
                10px;

            padding:
                18px;
        }


        .summary-label {
            display:
                block;

            color:
                #6b7280;

            font-size:
                12px;

            margin-bottom:
                9px;

            text-transform:
                uppercase;

            font-weight:
                700;
        }


        .summary-value {
            font-size:
                20px;

            font-weight:
                700;

            color:
                #1f2937;
        }


        /* =====================================================
           PAYMENT STATUS
        ===================================================== */

        .payment-status {
            margin-top:
                20px;

            padding:
                14px 18px;

            border-radius:
                8px;

            background:
                #eff6ff;

            color:
                #1e40af;

            font-size:
                14px;

            font-weight:
                600;
        }


        /* =====================================================
           TABLE
        ===================================================== */

        .table-wrapper {
            width:
                100%;

            overflow-x:
                auto;
        }


        table {
            width:
                100%;

            border-collapse:
                collapse;

            min-width:
                750px;
        }


        th {
            text-align:
                left;

            padding:
                14px;

            background:
                #f8fafc;

            border-bottom:
                1px solid #e5e7eb;

            font-size:
                12px;

            color:
                #6b7280;

            text-transform:
                uppercase;
        }


        td {
            padding:
                14px;

            border-bottom:
                1px solid #f0f0f0;

            font-size:
                14px;
        }


        tr:last-child td {
            border-bottom:
                none;
        }


        /* =====================================================
           PAYMENT BADGES
        ===================================================== */

        .payment-badge {
            display:
                inline-block;

            padding:
                5px 10px;

            border-radius:
                15px;

            font-size:
                11px;

            font-weight:
                700;

            text-transform:
                capitalize;
        }


        .payment-paid {
            background:
                #dcfce7;

            color:
                #166534;
        }


        .payment-pending {
            background:
                #fef3c7;

            color:
                #92400e;
        }


        .payment-upcoming {
            background:
                #dbeafe;

            color:
                #1e40af;
        }


        .payment-overdue {
            background:
                #fee2e2;

            color:
                #991b1b;
        }


        /* =====================================================
           PROGRESS
        ===================================================== */

        .progress-section {
            margin-top:
                10px;
        }


        .progress-header {
            display:
                flex;

            justify-content:
                space-between;

            margin-bottom:
                10px;

            font-size:
                14px;

            font-weight:
                700;
        }


        .progress-bar {
            width:
                100%;

            height:
                14px;

            background:
                #e5e7eb;

            border-radius:
                20px;

            overflow:
                hidden;
        }


        .progress-fill {
            height:
                100%;

            background:
                #2563eb;

            border-radius:
                20px;

            transition:
                width 0.3s ease;
        }


        /* =====================================================
           EMPTY STATE
        ===================================================== */

        .empty {
            text-align:
                center;

            padding:
                30px;

            color:
                #6b7280;

            font-size:
                14px;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (
            max-width: 900px
        ) {

            .summary-grid {
                grid-template-columns:
                    repeat(
                        2,
                        1fr
                    );
            }

        }


        @media (
            max-width: 700px
        ) {

            .navbar {
                padding:
                    15px;

                flex-direction:
                    column;

                align-items:
                    flex-start;
            }


            .navbar-actions {
                width:
                    100%;
            }


            .navbar-actions .btn {
                flex:
                    1;
            }


            .container {
                margin:
                    20px auto;

                padding:
                    0 12px;
            }


            .grid {
                grid-template-columns:
                    1fr;
            }


            .summary-grid {
                grid-template-columns:
                    1fr;
            }


            .info-row {
                flex-direction:
                    column;

                gap:
                    5px;
            }


            .value {
                text-align:
                    left;
            }

        }


        /* =====================================================
           PRINT
        ===================================================== */

        @media print {

            body {
                background:
                    white;
            }


            .navbar {
                display:
                    none;
            }


            .container {
                max-width:
                    100%;

                margin:
                    0;

                padding:
                    0;
            }


            .card,
            .page-header {
                box-shadow:
                    none;

                border:
                    1px solid #ddd;

                break-inside:
                    avoid;
            }


            .full-card {
                break-inside:
                    avoid;
            }

        }

    </style>

</head>


<body>


<!-- =====================================================
     NAVBAR
===================================================== -->

<div class="navbar">

    <h2>
        Interior Project Management System
    </h2>


    <div class="navbar-actions">

        <a
            href="{{ route('customer.dashboard') }}"
            class="btn btn-back"
        >
            ← Dashboard
        </a>


        <button
            type="button"
            class="btn btn-print"
            onclick="window.print()"
        >
            Print Project
        </button>

    </div>

</div>



<!-- =====================================================
     MAIN CONTAINER
===================================================== -->

<div class="container">


    <!-- =================================================
         PAGE HEADER
    ================================================== -->

    <div class="page-header">

        <h1>
            {{ $project->project_name }}
        </h1>

        <p>
            Complete project overview, payment breakdown
            and progress information.
        </p>

    </div>



    <!-- =================================================
         PROJECT + CUSTOMER INFORMATION
    ================================================== -->

    <div class="grid">


        <!-- Project Information -->

        <div class="card">

            <h3 class="card-title">
                Project Information
            </h3>


            <div class="info-row">

                <span class="label">
                    Project Name
                </span>

                <span class="value">
                    {{ $project->project_name }}
                </span>

            </div>


            <div class="info-row">

                <span class="label">
                    Location
                </span>

                <span class="value">
                    {{ $project->location ?? '-' }}
                </span>

            </div>


            <div class="info-row">

                <span class="label">
                    Start Date
                </span>

                <span class="value">

                    @if($project->start_date)

                        {{ $project->start_date->format('d M Y') }}

                    @else

                        -

                    @endif

                </span>

            </div>


            <div class="info-row">

                <span class="label">
                    Expected End Date
                </span>

                <span class="value">

                    @if($project->end_date)

                        {{ $project->end_date->format('d M Y') }}

                    @else

                        -

                    @endif

                </span>

            </div>


            <div class="info-row">

                <span class="label">
                    Project Request Date
                </span>

                <span class="value">

                    @if($project->created_at)

                        {{ $project->created_at->format('d M Y, h:i A') }}

                    @else

                        -

                    @endif

                </span>

            </div>

        </div>



        <!-- Project Status -->

        <div class="card">

            <h3 class="card-title">
                Current Project Status
            </h3>


            <div class="info-row">

                <span class="label">
                    Approval Status
                </span>

                <span class="value">

                    <span
                        class="badge
                        badge-{{ strtolower($project->approval_status ?? 'pending') }}"
                    >
                        {{ ucfirst($project->approval_status ?? 'pending') }}
                    </span>

                </span>

            </div>


            <div class="info-row">

                <span class="label">
                    Project Status
                </span>

                <span class="value">

                    <span
                        class="badge
                        badge-{{ strtolower(str_replace(' ', '-', $project->status ?? 'pending')) }}"
                    >
                        {{ ucfirst($project->status ?? 'pending') }}
                    </span>

                </span>

            </div>


            <div class="info-row">

                <span class="label">
                    Payment Status
                </span>

                <span class="value">
                    {{ $paymentStatus }}
                </span>

            </div>


            <div class="info-row">

                <span class="label">
                    Overall Progress
                </span>

                <span class="value">
                    {{ number_format($overallProgress, 0) }}%
                </span>

            </div>

        </div>


    </div>



    <!-- =================================================
         FINANCIAL SUMMARY
    ================================================== -->

    <div class="card full-card">

        <h3 class="card-title">
            Payment Summary
        </h3>


        @if($project->budget)


            <div class="summary-grid">


                <div class="summary-box">

                    <span class="summary-label">
                        Contract Amount
                    </span>

                    <div class="summary-value">

                        ৳ {{ number_format($contractAmount, 2) }}

                    </div>

                </div>



                <div class="summary-box">

                    <span class="summary-label">
                        Total Milestone
                    </span>

                    <div class="summary-value">

                        ৳ {{ number_format($totalMilestoneAmount, 2) }}

                    </div>

                </div>



                <div class="summary-box">

                    <span class="summary-label">
                        Total Paid
                    </span>

                    <div class="summary-value">

                        ৳ {{ number_format($totalPaidAmount, 2) }}

                    </div>

                </div>



                <div class="summary-box">

                    <span class="summary-label">
                        Remaining
                    </span>

                    <div class="summary-value">

                        ৳ {{ number_format($remainingAmount, 2) }}

                    </div>

                </div>


            </div>


            <div class="payment-status">

                Payment Position:
                {{ $paymentStatus }}

            </div>


        @else


            <div class="empty">

                Financial information has not been
                finalized for this project yet.

            </div>


        @endif

    </div>



    <!-- =================================================
         PAYMENT BREAKDOWN
    ================================================== -->

    <div class="card full-card">

        <h3 class="card-title">
            Payment Milestone Breakdown
        </h3>


        @if(
            $project->payments->count() > 0
        )


            <div class="table-wrapper">


                <table>


                    <thead>

                        <tr>

                            <th>
                                #
                            </th>

                            <th>
                                Milestone
                            </th>

                            <th>
                                Amount
                            </th>

                            <th>
                                Due Date
                            </th>

                            <th>
                                Payment Date
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Payment Method
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                        @foreach($project->payments as $payment)


                            <tr>


                                <td>

                                    {{ $loop->iteration }}

                                </td>


                                <td>

                                    {{ $payment->milestone }}

                                </td>


                                <td>

                                    ৳ {{ number_format((float) $payment->amount, 2) }}

                                </td>


                                <td>

                                    @if($payment->due_date)

                                        {{ $payment->due_date->format('d M Y') }}

                                    @else

                                        -

                                    @endif

                                </td>


                                <td>

                                    @if($payment->payment_date)

                                        {{ $payment->payment_date->format('d M Y') }}

                                    @else

                                        -

                                    @endif

                                </td>


                                <td>

                                    <span
                                        class="payment-badge
                                        payment-{{ $payment->status }}"
                                    >

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



    <!-- =================================================
         PROJECT PROGRESS
    ================================================== -->

    <div class="card full-card">

        <h3 class="card-title">
            Project Progress
        </h3>


        <div class="progress-section">


            <div class="progress-header">

                <span>
                    Overall Completion
                </span>


                <span>
                    {{ number_format($overallProgress, 0) }}%
                </span>

            </div>


            <div class="progress-bar">

                <div
                    class="progress-fill"
                    style="
                        width:
                        {{ number_format($overallProgress, 2, '.', '') }}%;
                    "
                ></div>

            </div>


        </div>


    </div>



    <!-- =================================================
         PROGRESS REPORT BREAKDOWN
    ================================================== -->

    <!-- <div class="card full-card">

        <h3 class="card-title">
            Progress Report Breakdown
        </h3>


        @if(
            $project->progressReports->count() > 0
        )


            <div class="table-wrapper">


                <table>


                    <thead>

                        <tr>

                            <th>
                                #
                            </th>

                            <th>
                                Progress Added
                            </th>

                            <th>
                                Report Created
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                        @foreach($project->progressReports as $progressReport)


                            <tr>


                                <td>

                                    {{ $loop->iteration }}

                                </td>


                                <td>

                                    {{ number_format((float) $progressReport->progress_percentage, 2) }}%

                                </td>


                                <td>

                                    @if($progressReport->created_at)

                                        {{ $progressReport->created_at->format('d M Y, h:i A') }}

                                    @else

                                        -

                                    @endif

                                </td>


                            </tr>


                        @endforeach


                    </tbody>


                </table>


            </div>


        @else


            <div class="empty">

                No progress report has been added yet.

            </div>


        @endif

    </div> -->


</div>


</body>

</html>