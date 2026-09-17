@extends('backend.layouts.admin')

@section('title', 'Previous Works')

@section('content')

<style>
    .previous-work-page {
        padding: 24px;
    }

    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 25px;
    }

    .page-title h1 {
        margin: 0;
        font-size: 26px;
        font-weight: 700;
        color: #111827;
    }

    .page-title p {
        margin: 6px 0 0;
        color: #6b7280;
        font-size: 14px;
    }

    .add-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 18px;
        background: #0056b3;
        color: #ffffff;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: 0.2s;
    }

    .add-btn:hover {
        background: #003d82;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .alert {
        padding: 13px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .alert-success {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }

    .works-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .works-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 950px;
    }

    .works-table thead {
        background: #f8fafc;
    }

    .works-table th {
        padding: 14px 16px;
        text-align: left;
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        border-bottom: 1px solid #e5e7eb;
        white-space: nowrap;
    }

    .works-table td {
        padding: 15px 16px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        font-size: 14px;
        color: #374151;
    }

    .works-table tbody tr:hover {
        background: #fafcff;
    }

    .serial {
        width: 55px;
        color: #64748b;
        font-weight: 600;
    }

    .main-image {
        width: 85px;
        height: 65px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        display: block;
    }

    .no-image {
        width: 85px;
        height: 65px;
        border-radius: 8px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 11px;
        border: 1px solid #e2e8f0;
    }

    .work-title {
        font-weight: 700;
        color: #111827;
        margin-bottom: 4px;
    }

    .work-slug {
        color: #94a3b8;
        font-size: 11px;
    }

    .location {
        color: #475569;
        white-space: nowrap;
    }

    .description {
        max-width: 280px;
        color: #64748b;
        line-height: 1.5;
    }

    .image-count {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 9px;
        background: #eff6ff;
        color: #0056b3;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .status {
        display: inline-flex;
        align-items: center;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
    }

    .status-active {
        background: #ecfdf5;
        color: #047857;
    }

    .status-inactive {
        background: #fef2f2;
        color: #b91c1c;
    }

    .actions {
        display: flex;
        align-items: center;
        gap: 7px;
        white-space: nowrap;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 7px;
        text-decoration: none;
        border: 1px solid transparent;
        cursor: pointer;
        transition: 0.2s;
        font-size: 13px;
    }

    .view-btn {
        background: #eff6ff;
        color: #0056b3;
        border-color: #dbeafe;
    }

    .view-btn:hover {
        background: #dbeafe;
    }

    .edit-btn {
        background: #fefce8;
        color: #a16207;
        border-color: #fef08a;
    }

    .edit-btn:hover {
        background: #fef08a;
    }

    .delete-btn {
        background: #fef2f2;
        color: #dc2626;
        border-color: #fecaca;
    }

    .delete-btn:hover {
        background: #fee2e2;
    }

    .empty-state {
        padding: 70px 20px;
        text-align: center;
    }

    .empty-icon {
        width: 65px;
        height: 65px;
        margin: 0 auto 15px;
        border-radius: 50%;
        background: #eff6ff;
        color: #0056b3;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
    }

    .empty-state h3 {
        margin: 0 0 7px;
        font-size: 18px;
        color: #111827;
    }

    .empty-state p {
        margin: 0 0 20px;
        color: #6b7280;
        font-size: 14px;
    }

    @media (max-width: 768px) {

        .previous-work-page {
            padding: 15px;
        }

        .page-header {
            align-items: flex-start;
        }

        .page-title h1 {
            font-size: 22px;
        }

        .add-btn {
            padding: 9px 13px;
            font-size: 12px;
        }
    }
</style>


<div class="previous-work-page">

    {{-- =========================================================
         PAGE HEADER
    ========================================================== --}}

    <div class="page-header">

        <div class="page-title">

            <h1>
                Previous Works
            </h1>

            <p>
                Manage your completed interior projects and gallery.
            </p>

        </div>


        <a
            href="{{ route('admin.previous-works.create') }}"
            class="add-btn"
        >
            <i class="fa-solid fa-plus"></i>

            Add Previous Work
        </a>

    </div>


    {{-- =========================================================
         SUCCESS MESSAGE
    ========================================================== --}}

    @if(session('success'))

        <div class="alert alert-success">

            <i class="fa-solid fa-circle-check"></i>

            {{ session('success') }}

        </div>

    @endif


    {{-- =========================================================
         PREVIOUS WORK TABLE
    ========================================================== --}}

    <div class="works-card">

        @if($previousWorks->count() > 0)

            <div class="table-wrapper">

                <table class="works-table">

                    <thead>

                        <tr>

                            <th>
                                #
                            </th>

                            <th>
                                Image
                            </th>

                            <th>
                                Previous Work
                            </th>

                            <th>
                                Location
                            </th>

                            <th>
                                Description
                            </th>

                            <th>
                                Gallery
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($previousWorks as $previousWork)

                            <tr>

                                {{-- =================================
                                     SERIAL
                                ================================== --}}

                                <td class="serial">

                                    {{ $loop->iteration }}

                                </td>


                                {{-- =================================
                                     MAIN IMAGE
                                ================================== --}}

                                <td>

                                    @php
                                        $mainImage = $previousWork->images->first();
                                    @endphp


                                    @if($mainImage)

                                        <img
                                            src="{{ asset('storage/' . $mainImage->image) }}"
                                            alt="{{ $previousWork->title }}"
                                            class="main-image"
                                        >

                                    @else

                                        <div class="no-image">

                                            No Image

                                        </div>

                                    @endif

                                </td>


                                {{-- =================================
                                     TITLE
                                ================================== --}}

                                <td>

                                    <div class="work-title">

                                        {{ $previousWork->title }}

                                    </div>

                                    <div class="work-slug">

                                        /{{ $previousWork->slug }}

                                    </div>

                                </td>


                                {{-- =================================
                                     LOCATION
                                ================================== --}}

                                <td>

                                    <span class="location">

                                        @if($previousWork->location)

                                            <i
                                                class="fa-solid fa-location-dot"
                                                style="margin-right: 5px;"
                                            ></i>

                                            {{ $previousWork->location }}

                                        @else

                                            —

                                        @endif

                                    </span>

                                </td>


                                {{-- =================================
                                     DESCRIPTION
                                ================================== --}}

                                <td>

                                    <div class="description">

                                        @if($previousWork->description)

                                            {{ Str::limit(
                                                $previousWork->description,
                                                90
                                            ) }}

                                        @else

                                            <span style="color:#94a3b8;">
                                                No description
                                            </span>

                                        @endif

                                    </div>

                                </td>


                                {{-- =================================
                                     IMAGE COUNT
                                ================================== --}}

                                <td>

                                    <span class="image-count">

                                        <i class="fa-regular fa-images"></i>

                                        {{ $previousWork->images->count() }}

                                        / 4

                                    </span>

                                </td>


                                {{-- =================================
                                     STATUS
                                ================================== --}}

                                <td>

                                    @if($previousWork->status === 'active')

                                        <span class="status status-active">

                                            Active

                                        </span>

                                    @else

                                        <span class="status status-inactive">

                                            Inactive

                                        </span>

                                    @endif

                                </td>


                                {{-- =================================
                                     ACTIONS
                                ================================== --}}

                               {{-- =========================================================
     ACTIONS
========================================================= --}}

<td>

    <div class="actions">

        {{-- =========================
             VIEW
        ========================== --}}
       


        {{-- =========================
             EDIT
        ========================== --}}
        <a
            href="{{ route('admin.previous-works.edit', $previousWork) }}"
            class="action-btn edit-btn"
            title="Edit"
            aria-label="Edit"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <path d="M12 20h9"/>
                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z"/>
            </svg>
        </a>


        {{-- =========================
             DELETE
        ========================== --}}
        <form
            action="{{ route('admin.previous-works.destroy', $previousWork) }}"
            method="POST"
            onsubmit="return confirm(
                'Are you sure you want to delete this Previous Work? All gallery images will also be deleted.'
            );"
            style="display:inline;"
        >
            @csrf

            <button
                type="submit"
                class="action-btn delete-btn"
                title="Delete"
                aria-label="Delete"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="M3 6h18"/>
                    <path d="M8 6V4h8v2"/>
                    <path d="M19 6l-1 14H6L5 6"/>
                    <path d="M10 11v5"/>
                    <path d="M14 11v5"/>
                </svg>
            </button>

        </form>

    </div>

</td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            {{-- =================================================
                 EMPTY STATE
            ================================================== --}}

            <div class="empty-state">

                <div class="empty-icon">

                    <i class="fa-regular fa-images"></i>

                </div>


                <h3>
                    No Previous Works Found
                </h3>


                <p>
                    Start adding your completed interior projects
                    to display them on your website.
                </p>


                <a
                    href="{{ route('admin.previous-works.create') }}"
                    class="add-btn"
                >

                    <i class="fa-solid fa-plus"></i>

                    Add Your First Previous Work

                </a>

            </div>

        @endif

    </div>

</div>

@endsection