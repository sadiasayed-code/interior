<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Customer Dashboard
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
                #f3f5f8;

            color:
                #1f2937;
        }


        /*
        =========================================================
        NAVBAR
        =========================================================
        */

        .navbar {

            background:
                #1f2937;

            color:
                white;

            padding:
                16px 35px;

            display:
                flex;

            justify-content:
                space-between;

            align-items:
                center;

            gap:
                20px;
        }


        .brand h2 {

            font-size:
                20px;

            margin-bottom:
                4px;
        }


        .brand p {

            font-size:
                12px;

            color:
                #cbd5e1;
        }


        .navbar-actions {

            display:
                flex;

            align-items:
                center;

            gap:
                10px;
        }


        .new-project-btn {

            background:
                #2563eb;

            color:
                white;

            text-decoration:
                none;

            padding:
                10px 16px;

            border-radius:
                7px;

            font-size:
                13px;

            font-weight:
                600;
        }


        .new-project-btn:hover {

            background:
                #1d4ed8;
        }


        .logout-btn {

            border:
                none;

            background:
                #dc2626;

            color:
                white;

            padding:
                10px 16px;

            border-radius:
                7px;

            cursor:
                pointer;

            font-size:
                13px;

            font-weight:
                600;
        }


        .logout-btn:hover {

            background:
                #b91c1c;
        }


        /*
        =========================================================
        MAIN CONTAINER
        =========================================================
        */

        .container {

            max-width:
                1450px;

            margin:
                35px auto;

            padding:
                0 25px;
        }


        /*
        =========================================================
        PAGE HEADER
        =========================================================
        */

        .page-header {

            margin-bottom:
                25px;
        }


        .page-header h1 {

            font-size:
                30px;

            margin-bottom:
                6px;
        }


        .page-header p {

            color:
                #6b7280;

            font-size:
                14px;
        }


        /*
        =========================================================
        INFO GRID
        =========================================================
        */

        .info-grid {

            display:
                grid;

            grid-template-columns:
                1fr 2fr;

            gap:
                20px;

            margin-bottom:
                25px;
        }


        .info-card {

            background:
                white;

            border-radius:
                14px;

            padding:
                25px;

            box-shadow:
                0 4px 20px rgba(
                    0,
                    0,
                    0,
                    0.06
                );
        }


        .info-card h3 {

            font-size:
                19px;

            margin-bottom:
                20px;

            padding-bottom:
                12px;

            border-bottom:
                1px solid #e5e7eb;
        }


        /*
        =========================================================
        CUSTOMER INFO
        =========================================================
        */

        .customer-item {

            padding:
                13px 0;

            border-bottom:
                1px solid #f1f5f9;
        }


        .customer-item:last-child {

            border-bottom:
                none;
        }


        .customer-label {

            display:
                block;

            color:
                #6b7280;

            font-size:
                11px;

            font-weight:
                700;

            text-transform:
                uppercase;

            margin-bottom:
                5px;
        }


        .customer-value {

            font-size:
                15px;

            color:
                #1f2937;

            font-weight:
                500;
        }


        /*
        =========================================================
        PROJECT STATISTICS
        =========================================================
        */

        .stats-grid {

            display:
                grid;

            grid-template-columns:
                repeat(
                    3,
                    1fr
                );

            gap:
                15px;
        }


        .stat-card {

            background:
                #f8fafc;

            border:
                1px solid #e2e8f0;

            border-radius:
                12px;

            padding:
                20px;
        }


        .stat-title {

            font-size:
                12px;

            color:
                #64748b;

            font-weight:
                700;

            text-transform:
                uppercase;

            margin-bottom:
                12px;
        }


        .stat-number {

            font-size:
                28px;

            font-weight:
                700;

            color:
                #1f2937;
        }


        .cancelled-stat {

            border-color:
                #fecaca;

            background:
                #fff7f7;
        }


        .cancelled-stat .stat-number {

            color:
                #dc2626;
        }


        /*
        =========================================================
        FINANCIAL SUMMARY
        =========================================================
        */

        .financial-card {

            background:
                white;

            border-radius:
                14px;

            padding:
                25px;

            margin-bottom:
                25px;

            box-shadow:
                0 4px 20px rgba(
                    0,
                    0,
                    0,
                    0.06
                );
        }


        .financial-card h3 {

            font-size:
                19px;

            margin-bottom:
                20px;

            padding-bottom:
                12px;

            border-bottom:
                1px solid #e5e7eb;
        }


        .financial-grid {

            display:
                grid;

            grid-template-columns:
                repeat(
                    3,
                    1fr
                );

            gap:
                20px;
        }


        .financial-item {

            padding:
                20px;

            border:
                1px solid #e5e7eb;

            border-radius:
                12px;

            background:
                #fafafa;
        }


        .financial-label {

            color:
                #64748b;

            font-size:
                12px;

            font-weight:
                700;

            text-transform:
                uppercase;

            margin-bottom:
                10px;
        }


        .financial-value {

            font-size:
                24px;

            font-weight:
                700;

            color:
                #1f2937;
        }


        /*
        =========================================================
        PROJECT TABLE
        =========================================================
        */

        .projects-card {

            background:
                white;

            border-radius:
                14px;

            overflow:
                hidden;

            box-shadow:
                0 4px 20px rgba(
                    0,
                    0,
                    0,
                    0.06
                );
        }


        .projects-header {

            padding:
                25px;

            border-bottom:
                1px solid #e5e7eb;
        }


        .projects-header h3 {

            font-size:
                20px;

            margin-bottom:
                6px;
        }


        .projects-header p {

            color:
                #6b7280;

            font-size:
                13px;
        }


        .table-wrapper {

            overflow-x:
                auto;
        }


        table {

            width:
                100%;

            border-collapse:
                collapse;
        }


        th {

            background:
                #f8fafc;

            padding:
                17px;

            text-align:
                left;

            font-size:
                12px;

            color:
                #64748b;

            text-transform:
                uppercase;
        }


        td {

            padding:
                18px 17px;

            border-top:
                1px solid #eef2f7;

            font-size:
                14px;
        }


        .project-name {

            font-weight:
                600;

            color:
                #1f2937;
        }


        /*
        =========================================================
        BADGES
        =========================================================
        */

        .badge {

            display:
                inline-block;

            padding:
                7px 12px;

            border-radius:
                20px;

            font-size:
                12px;

            font-weight:
                700;
        }


        .pending {

            background:
                #fef3c7;

            color:
                #92400e;
        }


        .approved {

            background:
                #dcfce7;

            color:
                #166534;
        }


        .rejected {

            background:
                #fee2e2;

            color:
                #991b1b;
        }


        .ongoing {

            background:
                #dbeafe;

            color:
                #1e40af;
        }


        .completed {

            background:
                #dcfce7;

            color:
                #166534;
        }


        .cancelled {

            background:
                #fee2e2;

            color:
                #991b1b;
        }


        .admin-review,
        .proposal-sent {

            background:
                #e0e7ff;

            color:
                #3730a3;
        }


        .customer-approved {

            background:
                #dcfce7;

            color:
                #166534;
        }


        .customer-rejected {

            background:
                #fee2e2;

            color:
                #991b1b;
        }


        .paused,
        .on-hold {

            background:
                #fef3c7;

            color:
                #92400e;
        }


        /*
        =========================================================
        PAYMENT STATUS
        =========================================================
        */

        .payment-status {

            background:
                #e5e7eb;

            color:
                #4b5563;
        }


        .payment-due {

            background:
                #fee2e2;

            color:
                #991b1b;
        }


        .partially-paid {

            background:
                #fef3c7;

            color:
                #92400e;
        }


        .fully-paid {

            background:
                #dcfce7;

            color:
                #166534;
        }


        .no-budget {

            background:
                #e5e7eb;

            color:
                #4b5563;
        }


        /*
        =========================================================
        ACTION BUTTONS
        =========================================================
        */

        .actions {

            display:
                flex;

            flex-wrap:
                wrap;

            gap:
                7px;
        }


        .action-btn {

            border:
                none;

            text-decoration:
                none;

            padding:
                8px 13px;

            border-radius:
                6px;

            font-size:
                12px;

            font-weight:
                600;

            cursor:
                pointer;
        }


        .view-btn {

            background:
                #2563eb;

            color:
                white;
        }


        .pause-btn {

            background:
                #f59e0b;

            color:
                white;
        }


        .resume-btn {

            background:
                #16a34a;

            color:
                white;
        }


        .cancel-btn {

            background:
                #dc2626;

            color:
                white;
        }


        /*
        =========================================================
        EMPTY
        =========================================================
        */

        .empty {

            padding:
                45px;

            text-align:
                center;

            color:
                #6b7280;
        }


        /*
        =========================================================
        RESPONSIVE
        =========================================================
        */

        @media (
            max-width:
            1000px
        ) {

            .info-grid {

                grid-template-columns:
                    1fr;
            }


            .stats-grid {

                grid-template-columns:
                    repeat(
                        2,
                        1fr
                    );
            }


            .financial-grid {

                grid-template-columns:
                    1fr;
            }

        }


        @media (
            max-width:
            600px
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

                flex-wrap:
                    wrap;
            }


            .container {

                padding:
                    0 12px;

                margin:
                    20px auto;
            }


            .page-header h1 {

                font-size:
                    24px;
            }


            .stats-grid {

                grid-template-columns:
                    1fr;
            }

        }

    </style>

</head>


<body>


<!-- =====================================================
     NAVBAR
===================================================== -->

<div class="navbar">

    <div class="brand">

        <h2>
            Interior Project Management System
        </h2>

        <p>
            Customer Dashboard
        </p>

    </div>


    <div class="navbar-actions">

        <a
    href="{{ route('customer.project-request.create') }}"
    class="new-project-btn"
>
    + New Project Request
</a>

        @if(Route::has('customer.logout'))

            <form
                action="{{ route('customer.logout') }}"
                method="POST"
            >

                @csrf

                <button
                    type="submit"
                    class="logout-btn"
                >
                    Logout
                </button>

            </form>

        @endif

    </div>

</div>



<!-- =====================================================
     MAIN CONTAINER
===================================================== -->

<div class="container">


    <!-- =================================================
         PAGE HEADER
    ================================================= -->

    <div class="page-header">

        <h1>
            Welcome,
            {{ $client->name }}
        </h1>

        <p>
            Manage and track all your interior projects from one place.
        </p>

    </div>



    <!-- =================================================
         CUSTOMER + PROJECT INFORMATION
    ================================================= -->

    <div class="info-grid">


        <!-- CUSTOMER INFORMATION -->

        <div class="info-card">

            <h3>
                Customer Information
            </h3>


            <div class="customer-item">

                <span class="customer-label">
                    Full Name
                </span>

                <span class="customer-value">
                    {{ $client->name }}
                </span>

            </div>


            <div class="customer-item">

                <span class="customer-label">
                    Email Address
                </span>

                <span class="customer-value">
                    {{ $client->email ?? $user->email ?? '-' }}
                </span>

            </div>


            <div class="customer-item">

                <span class="customer-label">
                    Phone Number
                </span>

                <span class="customer-value">
                    {{ $client->phone ?? '-' }}
                </span>

            </div>


            <div class="customer-item">

                <span class="customer-label">
                    Address
                </span>

                <span class="customer-value">
                    {{ $client->address ?? 'Not provided' }}
                </span>

            </div>


        </div>



        <!-- PROJECT INFORMATION -->

        <div class="info-card">

            <h3>
                Project Information
            </h3>


            <div class="stats-grid">


                <div class="stat-card">

                    <div class="stat-title">
                        Total Projects
                    </div>

                    <div class="stat-number">
                        {{ $totalProjects }}
                    </div>

                </div>



                <div class="stat-card">

                    <div class="stat-title">
                        Pending Approval
                    </div>

                    <div class="stat-number">
                        {{ $pendingProjects }}
                    </div>

                </div>



                <div class="stat-card">

                    <div class="stat-title">
                        Ongoing Projects
                    </div>

                    <div class="stat-number">
                        {{ $ongoingProjects }}
                    </div>

                </div>



                <div class="stat-card">

                    <div class="stat-title">
                        Completed Projects
                    </div>

                    <div class="stat-number">
                        {{ $completedProjects }}
                    </div>

                </div>



                <div class="stat-card cancelled-stat">

                    <div class="stat-title">
                        Cancelled Projects
                    </div>

                    <div class="stat-number">
                        {{ $cancelledProjects }}
                    </div>

                </div>



                <div class="stat-card">

                    <div class="stat-title">
                        Paused Projects
                    </div>

                    <div class="stat-number">
                        {{ $pausedProjects }}
                    </div>

                </div>


            </div>

        </div>


    </div>



    <!-- =================================================
         FINANCIAL SUMMARY
    ================================================= -->

    <div class="financial-card">

        <h3>
            Financial Summary
        </h3>


        <div class="financial-grid">


            <div class="financial-item">

                <div class="financial-label">
                    Total Contract Amount
                </div>

                <div class="financial-value">

                    ৳
                    {{ number_format($totalContractAmount, 2) }}

                </div>

            </div>



            <div class="financial-item">

                <div class="financial-label">
                    Total Paid Amount
                </div>

                <div class="financial-value">

                    ৳
                    {{ number_format($totalPaidAmount, 2) }}

                </div>

            </div>



            <div class="financial-item">

                <div class="financial-label">
                    Total Due Amount
                </div>

                <div class="financial-value">

                    ৳
                    {{ number_format($totalDueAmount, 2) }}

                </div>

            </div>


        </div>

    </div>



    <!-- =================================================
         MY PROJECTS
    ================================================= -->

    <div class="projects-card">


        <div class="projects-header">

            <h3>
                My Projects
            </h3>

            <p>
                View and manage your project requests.
            </p>

        </div>



        @if($projects->count() > 0)


            <div class="table-wrapper">


                <table>


                    <thead>

                        <tr>

                            <th>
                                Project
                            </th>

                            <th>
                                Approval
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Payment Status
                            </th>

                            <th>
                                Action
                            </th>

                        </tr>

                    </thead>



                    <tbody>


                        @foreach($projects as $project)


                            @php

                                $paymentClass =
                                    strtolower(
                                        str_replace(
                                            ' ',
                                            '-',
                                            $project->paymentStatus
                                        )
                                    );

                            @endphp


                            <tr>


                                <!-- PROJECT -->

                                <td>

                                    <span class="project-name">

                                        {{ optional($project->service)->name ?? $project->project_name }}

                                    </span>

                                </td>



                                <!-- APPROVAL -->

                                <td>

                                    <span
                                        class="badge {{ $project->approval_status }}"
                                    >

                                        {{ ucfirst($project->approval_status) }}

                                    </span>

                                </td>



                                <!-- STATUS -->

                                <td>

                                    <span
                                        class="badge {{ $project->status }}"
                                    >

                                        {{ ucwords(
                                            str_replace(
                                                '-',
                                                ' ',
                                                $project->status
                                            )
                                        ) }}

                                    </span>

                                </td>



                                <!-- PAYMENT STATUS -->

                                <td>

                                    <span
                                        class="
                                            badge
                                            payment-status
                                            {{ $paymentClass }}
                                        "
                                    >

                                        {{ $project->paymentStatus }}

                                    </span>

                                </td>



                                <!-- ACTION -->

                                <td>


                                    <div class="actions">


                                        <!-- VIEW -->

                                        <a
                                            href="{{ route(
                                                'customer.project.show',
                                                $project
                                            ) }}"
                                            class="
                                                action-btn
                                                view-btn
                                            "
                                        >

                                            View

                                        </a>



                                        <!-- PAUSE -->

                                        @if(
                                            $project->approval_status === 'approved'
                                            &&
                                            $project->status === 'ongoing'
                                        )

                                            <form
                                                action="{{ route(
                                                    'customer.projects.pause',
                                                    $project
                                                ) }}"
                                                method="POST"
                                            >

                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="
                                                        action-btn
                                                        pause-btn
                                                    "
                                                >

                                                    Pause

                                                </button>

                                            </form>

                                        @endif



                                        <!-- RESUME -->

                                        @if(
                                            in_array(
                                                $project->status,
                                                [
                                                    'paused',
                                                    'on-hold'
                                                ]
                                            )
                                        )

                                            <form
                                                action="{{ route(
                                                    'customer.projects.resume',
                                                    $project
                                                ) }}"
                                                method="POST"
                                            >

                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="
                                                        action-btn
                                                        resume-btn
                                                    "
                                                >

                                                    Resume

                                                </button>

                                            </form>

                                        @endif



                                        <!-- CANCEL -->

                                        @if(
                                            $project->status !== 'completed'
                                            &&
                                            $project->status !== 'cancelled'
                                            &&
                                            $project->status !== 'customer_rejected'
                                        )

                                            <form
                                                action="{{ route(
                                                    'customer.projects.cancel',
                                                    $project
                                                ) }}"
                                                method="POST"

                                                onsubmit="
                                                    return confirm(
                                                        'Are you sure you want to cancel this project?'
                                                    );
                                                "
                                            >

                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="
                                                        action-btn
                                                        cancel-btn
                                                    "
                                                >

                                                    Cancel

                                                </button>

                                            </form>

                                        @endif


                                    </div>


                                </td>


                            </tr>


                        @endforeach


                    </tbody>


                </table>


            </div>


        @else


            <div class="empty">

                No project has been created yet.

            </div>


        @endif


    </div>


</div>


</body>

</html>