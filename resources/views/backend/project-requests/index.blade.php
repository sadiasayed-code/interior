<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Project Requests</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6fa;
            color: #172033;
            line-height: 1.5;
        }

        .container {
            width: min(100% - 40px, 1360px);
            margin: 30px auto 50px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 28px;
        }

        .page-header h1 {
            font-size: 36px;
            line-height: 1.15;
            font-weight: 700;
            color: #172033;
            margin-bottom: 7px;
        }

        .page-header p {
            font-size: 16px;
            color: #667085;
        }

        .dashboard-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 46px;
            padding: 0 20px;
            border-radius: 9px;
            background: #172033;
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            white-space: nowrap;
            transition: .2s ease;
        }

        .dashboard-btn:hover {
            background: #0f172a;
            transform: translateY(-1px);
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: #fff;
            border: 1px solid #e1e5eb;
            border-radius: 13px;
            padding: 23px 25px;
            box-shadow: 0 5px 18px rgba(15, 23, 42, .05);
        }

        .stat-card h3 {
            color: #7b8496;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 7px;
        }

        .stat-number {
            color: #172033;
            font-size: 31px;
            font-weight: 700;
            line-height: 1;
        }

        .request-card {
            background: #fff;
            border: 1px solid #e1e5eb;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 6px 22px rgba(15, 23, 42, .06);
        }

        .card-header {
            padding: 22px 26px;
            border-bottom: 1px solid #e1e5eb;
        }

        .card-header h2 {
            font-size: 21px;
            font-weight: 700;
            color: #253044;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1080px;
        }

        thead th {
            padding: 15px 18px;
            background: #f8fafc;
            border-bottom: 1px solid #e1e5eb;
            color: #465166;
            font-size: 13px;
            font-weight: 700;
            text-align: left;
            white-space: nowrap;
        }

        tbody td {
            padding: 18px;
            border-bottom: 1px solid #edf0f4;
            color: #344054;
            font-size: 14px;
            vertical-align: middle;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover {
            background: #fbfcfe;
        }

        .id-link {
            color: #2563eb;
            font-weight: 700;
            text-decoration: none;
        }

        .id-link:hover {
            text-decoration: underline;
        }

        .customer-name {
            color: #172033;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .customer-email {
            color: #7b8496;
            font-size: 12px;
        }

        .service-name {
            color: #253044;
            font-weight: 600;
        }

        .budget {
            white-space: nowrap;
            color: #344054;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-review {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .approval-pending {
            background: #fef3c7;
            color: #a16207;
        }

        .date {
            color: #667085;
            white-space: nowrap;
            line-height: 1.35;
        }

        .view-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 9px 14px;
            border-radius: 7px;
            background: #2563eb;
            color: #fff;
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
            transition: .2s ease;
        }

        .view-btn:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        .empty {
            padding: 55px 25px;
            text-align: center;
            color: #667085;
            font-size: 15px;
        }

        .empty strong {
            display: block;
            margin-bottom: 6px;
            color: #344054;
            font-size: 18px;
        }

        .notice {
            margin-top: 18px;
            padding: 13px 16px;
            border-radius: 9px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e40af;
            font-size: 13px;
        }

        .alert-success,
        .alert-error {
            margin-bottom: 20px;
            padding: 13px 16px;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 600;
        }

        .alert-success {
            background: #dcfce7;
            border: 1px solid #bbf7d0;
            color: #166534;
        }

        .alert-error {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        @media (max-width: 800px) {
            .container {
                width: min(100% - 24px, 1360px);
                margin-top: 20px;
            }

            .page-header {
                flex-direction: column;
            }

            .page-header h1 {
                font-size: 29px;
            }

            .dashboard-btn {
                width: 100%;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .card-header {
                padding: 19px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    {{-- =========================================================
         PAGE HEADER
    ========================================================== --}}

    <div class="page-header">
        <div>
            <h1>Project Requests</h1>
            <p>Manage and review customer project requests.</p>
        </div>

        <a
            href="{{ route('admin.dashboard') }}"
            class="dashboard-btn"
        >
            ← Dashboard
        </a>
    </div>


    {{-- =========================================================
         FLASH MESSAGES
    ========================================================== --}}

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-error">
            {{ session('error') }}
        </div>
    @endif


    {{-- =========================================================
         STATISTICS
         IMPORTANT:
         These numbers include new customer requests and requests currently under admin review.
    ========================================================== --}}

    <div class="stats">

        <div class="stat-card">
            <h3>Total Requests</h3>

            <div class="stat-number">
                {{ $totalRequests }}
            </div>
        </div>

        <div class="stat-card">
            <h3>Under Review</h3>

            <div class="stat-number">
                {{ $underReview }}
            </div>
        </div>

    </div>


    {{-- =========================================================
         CUSTOMER REQUESTS
         New requests and requests currently under admin review are displayed.
    ========================================================== --}}

    <div class="request-card">

        <div class="card-header">
            <h2>Customer Requests</h2>
        </div>

        @if($projects->count())

            <div class="table-wrapper">

                <table>

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Service</th>
                            <th>Location</th>
                            <th>Approx. Budget</th>
                            <th>Approval</th>
                            <th>Project Status</th>
                            <th>Request Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($projects as $project)

                            <tr>

                                <td>
                                    <a
                                        href="{{ route('admin.project-requests.show', $project) }}"
                                        class="id-link"
                                    >
                                        #{{ $project->id }}
                                    </a>
                                </td>

                                <td>
                                    <div class="customer-name">
                                        {{ $project->client?->name ?? $project->client?->user?->name ?? 'N/A' }}
                                    </div>

                                    <div class="customer-email">
                                        {{ $project->client?->email ?? $project->client?->user?->email ?? '' }}
                                    </div>
                                </td>

                                <td>
                                    <div class="service-name">
                                        {{ $project->service?->name ?? 'N/A' }}
                                    </div>
                                </td>

                                <td>
                                    {{ $project->location ?? '-' }}
                                </td>

                                <td class="budget">
                                    @if($project->approximate_budget !== null)
                                        ৳ {{ number_format((float) $project->approximate_budget, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    <span class="status-badge approval-pending">
                                        {{ ucfirst($project->approval_status ?? 'pending') }}
                                    </span>
                                </td>

                                <td>
                                    <span class="status-badge status-review">
                                        Admin Review
                                    </span>
                                </td>

                                <td>
                                    <div class="date">
                                        {{ $project->created_at?->format('d M Y') ?? '-' }}
                                        <br>
                                        {{ $project->created_at?->format('h:i A') ?? '' }}
                                    </div>
                                </td>

                                <td>
                                    <a
                                        href="{{ route('admin.project-requests.show', $project) }}"
                                        class="view-btn"
                                    >
                                        View Request
                                    </a>
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty">
                <strong>No requests under admin review</strong>
                There are currently no project requests waiting for admin review.
            </div>

        @endif

    </div>


    <div class="notice">
        <strong>Review Queue:</strong>
        This page displays only projects whose
        <strong>Project Status = Admin Review</strong>.
        Other statuses are intentionally hidden from this request queue.
    </div>

</div>

</body>
</html>
