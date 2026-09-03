@extends('backend.layouts.admin')

@section('content')

<style>

    .request-page {
        padding: 20px;
    }

    .request-header {
        margin-bottom: 25px;
    }

    .request-header h2 {
        margin: 0 0 6px;
        font-size: 26px;
        color: #222;
    }

    .request-header p {
        margin: 0;
        color: #777;
        font-size: 14px;
    }

    .message-success {
        background: #dcfce7;
        color: #166534;
        padding: 13px 16px;
        border-radius: 7px;
        margin-bottom: 20px;
    }

    .message-error {
        background: #fee2e2;
        color: #991b1b;
        padding: 13px 16px;
        border-radius: 7px;
        margin-bottom: 20px;
    }

    .request-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.07);
        overflow: hidden;
    }

    .request-card-header {
        padding: 18px 20px;
        border-bottom: 1px solid #eee;
    }

    .request-card-header h3 {
        margin: 0;
        font-size: 18px;
        color: #333;
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .request-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 750px;
    }

    .request-table th,
    .request-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #eee;
        text-align: left;
        font-size: 14px;
    }

    .request-table th {
        background: #f8fafc;
        color: #555;
        font-weight: 600;
    }

    .request-table tbody tr:hover {
        background: #fafafa;
    }

    .customer-name {
        font-weight: 600;
        color: #222;
    }

    .customer-phone {
        display: block;
        margin-top: 4px;
        color: #888;
        font-size: 12px;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .view-btn {
        display: inline-block;
        padding: 8px 13px;
        background: #2563eb;
        color: #fff;
        text-decoration: none;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
    }

    .view-btn:hover {
        background: #1d4ed8;
    }

    .empty-request {
        text-align: center;
        padding: 55px 20px;
    }

    .empty-request h3 {
        margin-bottom: 8px;
        color: #444;
    }

    .empty-request p {
        color: #888;
        margin: 0;
    }


    /* =========================
       Responsive
    ========================= */

    @media (max-width: 700px) {

        .request-page {
            padding: 12px;
        }

        .request-header h2 {
            font-size: 22px;
        }

        .request-card-header {
            padding: 15px;
        }

    }

</style>


<div class="request-page">


    {{-- Page Header --}}

    <div class="request-header">

        <h2>
            Project Requests
        </h2>

        <p>
            Review and manage customer project requests.
        </p>

    </div>


    {{-- Success Message --}}

    @if(session('success'))

        <div class="message-success">
            {{ session('success') }}
        </div>

    @endif


    {{-- Error Message --}}

    @if($errors->any())

        <div class="message-error">

            @foreach($errors->all() as $error)

                <div>
                    {{ $error }}
                </div>

            @endforeach

        </div>

    @endif


    {{-- Project Requests Card --}}

    <div class="request-card">


        <div class="request-card-header">

            <h3>
                Pending Project Requests
            </h3>

        </div>


        @if($projects->count() > 0)

            <div class="table-wrapper">

                <table class="request-table">

                    <thead>

                        <tr>

                            <th>
                                #
                            </th>

                            <th>
                                Customer
                            </th>

                            <th>
                                Project
                            </th>

                            <th>
                                Location
                            </th>

                            <th>
                                Start Date
                            </th>

                            <th>
                                Approval
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
                                    {{ $loop->iteration }}
                                </td>


                                <td>

                                    <span class="customer-name">
                                        {{ $project->client->name ?? 'N/A' }}
                                    </span>

                                    <span class="customer-phone">
                                        {{ $project->client->phone ?? 'No phone' }}
                                    </span>

                                </td>


                                <td>
                                    {{ $project->project_name }}
                                </td>


                                <td>
                                    {{ $project->location ?? '-' }}
                                </td>


                                <td>
                                    {{ $project->start_date?->format('d M Y') ?? '-' }}
                                </td>


                                <td>

                                    <span class="status-badge status-pending">
                                        Pending
                                    </span>

                                </td>


                                <td>

                                    <a
                                        href="{{ route('admin.project-requests.show', $project->id) }}"
                                        class="view-btn"
                                    >
                                        View
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty-request">

                <h3>
                    No Pending Project Requests
                </h3>

                <p>
                    There are currently no new customer project requests.
                </p>

            </div>

        @endif


    </div>


</div>

@endsection