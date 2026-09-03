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

    .approved {
        background: #dcfce7;
        color: #166534;
    }

    .rejected {
        background: #fee2e2;
        color: #991b1b;
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
    }

    .action-card p {
        color: #777;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .action-buttons {
        display: flex;
        gap: 12px;
    }

    .approve-btn,
    .reject-btn {
        border: none;
        padding: 11px 20px;
        border-radius: 7px;
        color: white;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
    }

    .approve-btn {
        background: #16a34a;
    }

    .approve-btn:hover {
        background: #15803d;
    }

    .reject-btn {
        background: #dc2626;
    }

    .reject-btn:hover {
        background: #b91c1c;
    }

    .action-form {
        display: inline-block;
    }

    .warning {
        margin-top: 15px;
        padding: 12px 15px;
        background: #fff7ed;
        color: #9a3412;
        border-radius: 7px;
        font-size: 13px;
    }


    /* =========================
       Responsive
    ========================= */

    @media (max-width: 750px) {

        .request-details-page {
            padding: 12px;
        }

        .details-grid {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
        }

        .action-form {
            width: 100%;
        }

        .approve-btn,
        .reject-btn {
            width: 100%;
        }

    }

</style>


<div class="request-details-page">


    {{-- Page Header --}}

    <div class="page-header">

        <h2>
            Project Request Details
        </h2>

        <p>
            Review customer information and project details.
        </p>

        <a
            href="{{ route('admin.project-requests.index') }}"
            class="back-btn"
        >
            ← Back to Requests
        </a>

    </div>



    {{-- Details --}}

    <div class="details-grid">


        {{-- Customer Information --}}

        <div class="details-card">

            <h3>
                Customer Information
            </h3>


            <div class="detail-item">

                <span class="detail-label">
                    Name
                </span>

                <span class="detail-value">
                    {{ $project->client->name ?? 'N/A' }}
                </span>

            </div>


            <div class="detail-item">

                <span class="detail-label">
                    Email
                </span>

                <span class="detail-value">
                    {{ $project->client->email ?? 'N/A' }}
                </span>

            </div>


            <div class="detail-item">

                <span class="detail-label">
                    Phone
                </span>

                <span class="detail-value">
                    {{ $project->client->phone ?? 'N/A' }}
                </span>

            </div>


            <div class="detail-item">

                <span class="detail-label">
                    Address
                </span>

                <span class="detail-value">
                    {{ $project->client->address ?? 'N/A' }}
                </span>

            </div>

        </div>



        {{-- Project Information --}}

        <div class="details-card">

            <h3>
                Project Information
            </h3>


            <div class="detail-item">

                <span class="detail-label">
                    Project Name
                </span>

                <span class="detail-value">
                    {{ $project->project_name }}
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


            <div class="detail-item">

                <span class="detail-label">
                    Approval Status
                </span>

                <span class="status-badge {{ $project->approval_status }}">
                    {{ ucfirst($project->approval_status) }}
                </span>

            </div>


            <div class="detail-item">

                <span class="detail-label">
                    Project Status
                </span>

                <span class="status-badge {{ $project->status }}">
                    {{ ucfirst($project->status) }}
                </span>

            </div>

        </div>


    </div>



    {{-- Action Section --}}

    @if($project->approval_status === 'pending')

        <div class="action-card">

            <h3>
                Review Request
            </h3>

            <p>
                Choose whether you want to approve or reject this project request.
            </p>


            <div class="action-buttons">


                {{-- Approve --}}

                <form
                    action="{{ route('admin.project-requests.approve', $project->id) }}"
                    method="POST"
                    class="action-form"
                >

                    @csrf

                    <button
                        type="submit"
                        class="approve-btn"
                        onclick="return confirm('Are you sure you want to approve this project request?')"
                    >
                        ✓ Approve Project
                    </button>

                </form>



                {{-- Reject --}}

                <form
                    action="{{ route('admin.project-requests.reject', $project->id) }}"
                    method="POST"
                    class="action-form"
                >

                    @csrf

                    <button
                        type="submit"
                        class="reject-btn"
                        onclick="return confirm('Are you sure you want to reject this project request?')"
                    >
                        ✕ Reject Request
                    </button>

                </form>


            </div>


            <div class="warning">

                <strong>Important:</strong>
                Once approved or rejected, this request cannot be processed again.

            </div>

        </div>

    @else

        <div class="action-card">

            <h3>
                Request Already Processed
            </h3>

            <p>
                This project request has already been
                <strong>{{ $project->approval_status }}</strong>.
            </p>

        </div>

    @endif


</div>

@endsection