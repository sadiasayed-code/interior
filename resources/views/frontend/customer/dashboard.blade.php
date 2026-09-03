<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Customer Dashboard</title>

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

        /* =========================
           Navbar
        ========================= */

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

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .customer-name {
            font-size: 14px;
        }

        .logout {
            color: white;
            text-decoration: none;

            background: #dc2626;

            padding: 8px 14px;

            border-radius: 6px;

            font-size: 14px;
        }

        .logout:hover {
            background: #b91c1c;
        }


        /* =========================
           Main Container
        ========================= */

        .container {
            max-width: 1150px;

            margin: 35px auto;

            padding: 0 20px;
        }


        /* =========================
           Welcome
        ========================= */

        .welcome {
            background: white;

            padding: 25px;

            border-radius: 10px;

            margin-bottom: 25px;

            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.07);
        }

        .welcome h1 {
            margin-bottom: 8px;

            font-size: 26px;
        }

        .welcome p {
            color: #666;
        }


        /* =========================
           Success Message
        ========================= */

        .success {
            background: #dcfce7;

            color: #166534;

            padding: 12px 15px;

            border-radius: 7px;

            margin-bottom: 20px;
        }


        /* =========================
           Statistics
        ========================= */

        .stats {
            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 18px;

            margin-bottom: 25px;
        }

        .stat-card {
            background: white;

            padding: 22px;

            border-radius: 10px;

            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.07);
        }

        .stat-card h3 {
            font-size: 14px;

            color: #777;

            margin-bottom: 10px;
        }

        .stat-card .number {
            font-size: 28px;

            font-weight: bold;

            color: #2563eb;
        }


        /* =========================
           Profile + Projects
        ========================= */

        .grid {
            display: grid;

            grid-template-columns:
                1fr 2fr;

            gap: 20px;
        }

        .card {
            background: white;

            padding: 25px;

            border-radius: 10px;

            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.07);
        }

        .card h2 {
            font-size: 19px;

            margin-bottom: 20px;
        }


        /* =========================
           Profile
        ========================= */

        .profile-item {
            margin-bottom: 15px;
        }

        .profile-item strong {
            display: block;

            color: #555;

            font-size: 13px;

            margin-bottom: 4px;
        }

        .profile-item span {
            color: #222;

            font-size: 15px;
        }


        /* =========================
           Projects Table
        ========================= */

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;

            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 12px 10px;

            text-align: left;

            border-bottom: 1px solid #eee;

            font-size: 14px;
        }

        table th {
            background: #f8fafc;

            color: #555;
        }


        /* =========================
           View Details Button
        ========================= */

        .view-details {
            display: inline-block;

            background: #2563eb;

            color: white;

            text-decoration: none;

            padding: 7px 12px;

            border-radius: 6px;

            font-size: 12px;

            font-weight: 600;

            white-space: nowrap;

            transition: 0.2s ease;
        }

        .view-details:hover {
            background: #1d4ed8;
        }


        /* =========================
           Status Badge
        ========================= */

        .badge {
            display: inline-block;

            padding: 5px 9px;

            border-radius: 20px;

            font-size: 12px;

            font-weight: 600;
        }

        .pending {
            background: #fef3c7;

            color: #92400e;
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

        .completed {
            background: #dcfce7;

            color: #166534;
        }

        .cancelled {
            background: #fee2e2;

            color: #991b1b;
        }

        .on-hold {
            background: #fef3c7;

            color: #92400e;
        }


        /* =========================
           Empty Projects
        ========================= */

        .empty {
            text-align: center;

            padding: 30px 10px;

            color: #777;
        }


        /* =========================
           Responsive
        ========================= */

        @media (max-width: 850px) {

            .stats {
                grid-template-columns:
                    repeat(2, 1fr);
            }

            .grid {
                grid-template-columns: 1fr;
            }

        }


        @media (max-width: 550px) {

            .navbar {
                padding: 15px;

                flex-direction: column;

                gap: 12px;

                align-items: flex-start;
            }

            .navbar-right {
                width: 100%;

                justify-content: space-between;
            }

            .container {
                margin-top: 20px;

                padding: 0 12px;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .welcome h1 {
                font-size: 22px;
            }

        }

    </style>

</head>


<body>


<!-- =========================
     Navbar
========================= -->

<div class="navbar">

    <h2>
        Interior Project Management System
    </h2>

    <div class="navbar-right">

        <span class="customer-name">
            {{ $user->name }}
        </span>

        <a
            href="{{ route('customer.logout') }}"
            class="logout"
        >
            Logout
        </a>

    </div>

</div>



<!-- =========================
     Main
========================= -->

<div class="container">


    @if(session('success'))

        <div class="success">
            {{ session('success') }}
        </div>

    @endif



    <!-- Welcome -->

    <div class="welcome">

        <h1>
            Welcome, {{ $user->name }}!
        </h1>

        <p>
            Manage your interior projects from your customer dashboard.
        </p>

    </div>


    <!-- Request New Project -->

    <div style="margin-top: 20px; margin-bottom: 20px;">

        <a
            href="{{ route('customer.project-request.create') }}"
            style="
                display: inline-block;
                background: #2563eb;
                color: white;
                text-decoration: none;
                padding: 12px 18px;
                border-radius: 7px;
                font-size: 14px;
                font-weight: 600;
            "
        >
            + Request New Project
        </a>

    </div>



    <!-- =========================
         Statistics
    ========================= -->

    <div class="stats">


        <div class="stat-card">

            <h3>
                Total Projects
            </h3>

            <div class="number">
                {{ $totalProjects }}
            </div>

        </div>


        <div class="stat-card">

            <h3>
                Pending Requests
            </h3>

            <div class="number">
                {{ $pendingProjects }}
            </div>

        </div>


        <div class="stat-card">

            <h3>
                Ongoing Projects
            </h3>

            <div class="number">
                {{ $ongoingProjects }}
            </div>

        </div>


        <div class="stat-card">

            <h3>
                Completed Projects
            </h3>

            <div class="number">
                {{ $completedProjects }}
            </div>

        </div>


    </div>



    <!-- =========================
         Profile + Projects
    ========================= -->

    <div class="grid">


        <!-- Customer Profile -->

        <div class="card">

            <h2>
                My Profile
            </h2>


            <div class="profile-item">

                <strong>
                    Full Name
                </strong>

                <span>
                    {{ $client->name }}
                </span>

            </div>


            <div class="profile-item">

                <strong>
                    Email
                </strong>

                <span>
                    {{ $client->email ?? 'Not provided' }}
                </span>

            </div>


            <div class="profile-item">

                <strong>
                    Phone
                </strong>

                <span>
                    {{ $client->phone }}
                </span>

            </div>


            <div class="profile-item">

                <strong>
                    Address
                </strong>

                <span>
                    {{ $client->address ?? 'Not provided' }}
                </span>

            </div>

        </div>



        <!-- Projects -->

        <div class="card">

            <h2>
                My Projects
            </h2>


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
                                    Start Date
                                </th>

                                <th>
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($projects as $project)

                                <tr>

                                    <td>
                                        {{ $project->project_name }}
                                    </td>


                                    <td>

                                        <span
                                            class="badge {{ $project->approval_status }}"
                                        >
                                            {{ ucfirst($project->approval_status) }}
                                        </span>

                                    </td>


                                    <td>

                                        <span
                                            class="badge {{ $project->status }}"
                                        >
                                            {{ ucfirst($project->status) }}
                                        </span>

                                    </td>


                                    <td>
                                        {{ $project->start_date?->format('d M Y') ?? '-' }}
                                    </td>


                                    <!-- View Details -->

                                    <td>

                                        <a
                                            href="{{ route('customer.project.show', $project->id) }}"
                                            class="view-details"
                                        >
                                            View Details
                                        </a>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="empty">

                    <p>
                        You don't have any projects yet.
                    </p>

                </div>

            @endif

        </div>


    </div>


</div>


</body>

</html>