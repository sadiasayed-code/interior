<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $project->project_name }} - Project Details</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            color: #222;
        }

        .navbar {
            background: #1f2937;
            color: white;
            padding: 16px 30px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h2 {
            font-size: 20px;
        }

        .back-btn {
            color: white;
            text-decoration: none;
            background: #374151;
            padding: 9px 14px;
            border-radius: 6px;
            font-size: 13px;
        }

        .container {
            max-width: 1100px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .page-header {
            background: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;

            box-shadow: 0 3px 15px rgba(0,0,0,0.07);
        }

        .page-header h1 {
            font-size: 26px;
            margin-bottom: 7px;
        }

        .page-header p {
            color: #777;
            font-size: 14px;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;

            box-shadow: 0 3px 15px rgba(0,0,0,0.07);
        }

        .card h3 {
            font-size: 18px;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #eee;
        }

        .item {
            margin-bottom: 17px;
        }

        .item:last-child {
            margin-bottom: 0;
        }

        .label {
            display: block;
            color: #888;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .value {
            font-size: 15px;
            color: #222;
        }

        .badge {
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

        .approved,
        .completed {
            background: #dcfce7;
            color: #166534;
        }

        .ongoing {
            background: #dbeafe;
            color: #1e40af;
        }

        .rejected,
        .cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .on-hold {
            background: #fef3c7;
            color: #92400e;
        }

        .full-card {
            margin-top: 20px;
        }

        .empty {
            color: #777;
            text-align: center;
            padding: 20px;
        }

        .progress-wrapper {
            margin-top: 10px;
        }

        .progress-bar {
            width: 100%;
            height: 12px;
            background: #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: #2563eb;
            border-radius: 10px;
        }

        .progress-text {
            margin-top: 8px;
            font-size: 14px;
            font-weight: 600;
        }

        @media (max-width: 750px) {

            .navbar {
                padding: 15px;
            }

            .navbar h2 {
                font-size: 16px;
            }

            .container {
                margin-top: 20px;
                padding: 0 12px;
            }

            .grid {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>


<body>


<div class="navbar">

    <h2>
        Interior Project Management System
    </h2>

    <a
        href="{{ route('customer.dashboard') }}"
        class="back-btn"
    >
        ← Dashboard
    </a>

</div>


<div class="container">


    <!-- Page Header -->

    <div class="page-header">

        <h1>
            {{ $project->project_name }}
        </h1>

        <p>
            Project Details & Status
        </p>

    </div>


    <!-- Basic Information -->

    <div class="grid">


        <div class="card">

            <h3>
                Project Information
            </h3>

            <div class="item">

                <span class="label">
                    Project Name
                </span>

                <span class="value">
                    {{ $project->project_name }}
                </span>

            </div>


            <div class="item">

                <span class="label">
                    Location
                </span>

                <span class="value">
                    {{ $project->location ?? 'Not provided' }}
                </span>

            </div>


            <div class="item">

                <span class="label">
                    Start Date
                </span>

                <span class="value">
                    {{ $project->start_date?->format('d M Y') ?? '-' }}
                </span>

            </div>


            <div class="item">

                <span class="label">
                    End Date
                </span>

                <span class="value">
                    {{ $project->end_date?->format('d M Y') ?? '-' }}
                </span>

            </div>

        </div>


        <!-- Status -->

        <div class="card">

            <h3>
                Project Status
            </h3>

            <div class="item">

                <span class="label">
                    Approval Status
                </span>

                <span class="badge {{ $project->approval_status }}">
                    {{ ucfirst($project->approval_status) }}
                </span>

            </div>


            <div class="item">

                <span class="label">
                    Project Status
                </span>

                <span class="badge {{ $project->status }}">
                    {{ ucfirst($project->status) }}
                </span>

            </div>


            <div class="item">

                <span class="label">
                    Request Date
                </span>

                <span class="value">
                    {{ $project->created_at?->format('d M Y, h:i A') ?? '-' }}
                </span>

            </div>

        </div>

    </div>


    <!-- Financial Information -->

    <div class="card full-card">

        <h3>
            Financial Information
        </h3>

        @if($project->budget)

            <div class="grid">

                <div class="item">

                    <span class="label">
                        Estimated Cost
                    </span>

                    <span class="value">
                        ৳ {{ number_format((float) $project->budget->estimated_cost, 2) }}
                    </span>

                </div>


                <div class="item">

                    <span class="label">
                        Contract Amount
                    </span>

                    <span class="value">
                        ৳ {{ number_format((float) $project->budget->contract_amount, 2) }}
                    </span>

                </div>

            </div>

        @else

            <div class="empty">
                Financial information has not been added yet.
            </div>

        @endif

    </div>


    <!-- Progress -->

    <div class="card full-card">

        <h3>
            Project Progress
        </h3>

        @php

            $overallProgress = $project->progressReports
                ->sum('progress_percentage');

            if ($overallProgress > 100) {
                $overallProgress = 100;
            }

        @endphp


        @if($project->progressReports->count() > 0)

            <div class="progress-wrapper">

                <div class="progress-bar">

                    <div
                        class="progress-fill"
                        style="width: {{ $overallProgress }}%;"
                    ></div>

                </div>


                <div class="progress-text">

                    Overall Progress:
                    {{ $overallProgress }}%

                </div>

            </div>

        @else

            <div class="empty">
                No progress report has been added yet.
            </div>

        @endif

    </div>


</div>


</body>

</html>