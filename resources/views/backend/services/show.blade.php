@extends('backend.layouts.admin')

@section('title', 'Service Details')

@section('page_title', 'Service Details')

@section('content')


{{-- =====================================================
    PAGE HEADER
====================================================== --}}

<div class="page-header">

    <div>

        <h1>
            Service Details
        </h1>

        <p>
            View complete information about this service.
        </p>

    </div>


    <div style="
        display:flex;
        gap:10px;
        flex-wrap:wrap;
    ">

        <a
            href="{{ route('admin.services.edit', $service) }}"
            class="primary-btn"
        >
            Edit Service
        </a>

        <a
            href="{{ route('admin.services.index') }}"
            class="secondary-btn"
        >
            ← Back to Services
        </a>

    </div>

</div>



{{-- =====================================================
    SUCCESS MESSAGE
====================================================== --}}

@if(session('success'))

    <div class="alert alert-success">
        {{ session('success') }}
    </div>

@endif



{{-- =====================================================
    ERROR MESSAGE
====================================================== --}}

@if($errors->any())

    <div class="alert alert-danger">

        <strong>
            Unable to complete the action.
        </strong>

        <ul style="margin:10px 0 0 20px;">

            @foreach($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif



{{-- =====================================================
    SERVICE OVERVIEW
====================================================== --}}

<div
    style="
        display:grid;
        grid-template-columns:minmax(280px, 380px) 1fr;
        gap:20px;
        margin-bottom:20px;
    "
>


    {{-- =================================================
        SERVICE IMAGE
    ================================================== --}}

    <div class="panel">

        <div class="panel-header">

            <div>

                <h2>
                    Service Image
                </h2>

                <p>
                    Featured image for this service.
                </p>

            </div>

        </div>


        <div style="padding:20px;">

            @if($service->image)

                <img
                    src="{{ asset('storage/' . $service->image) }}"
                    alt="{{ $service->name }}"
                    style="
                        width:100%;
                        max-height:300px;
                        object-fit:cover;
                        border-radius:8px;
                        display:block;
                    "
                >

            @else

                <div
                    style="
                        height:260px;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        background:#f5f5f5;
                        border-radius:8px;
                    "
                >

                    <span
                        class="
                            status-badge
                            status-secondary
                        "
                    >
                        No Image Available
                    </span>

                </div>

            @endif

        </div>

    </div>



    {{-- =================================================
        BASIC INFORMATION
    ================================================== --}}

    <div class="panel">

        <div class="panel-header">

            <div>

                <h2>
                    Basic Information
                </h2>

                <p>
                    Main information of this service.
                </p>

            </div>

        </div>


        <div style="padding:20px;">


            {{-- SERVICE NAME --}}

            <div style="
                margin-bottom:20px;
            ">

                <div style="
                    font-size:12px;
                    text-transform:uppercase;
                    letter-spacing:.5px;
                    opacity:.65;
                    margin-bottom:5px;
                ">
                    Service Name
                </div>

                <div style="
                    font-size:20px;
                    font-weight:600;
                ">

                    {{ $service->name }}

                </div>

            </div>



            {{-- SLUG --}}

            <div style="
                margin-bottom:20px;
            ">

                <div style="
                    font-size:12px;
                    text-transform:uppercase;
                    letter-spacing:.5px;
                    opacity:.65;
                    margin-bottom:5px;
                ">
                    Slug
                </div>

                <div>
                    /{{ $service->slug }}
                </div>

            </div>



            {{-- STATUS --}}

            <div style="
                margin-bottom:20px;
            ">

                <div style="
                    font-size:12px;
                    text-transform:uppercase;
                    letter-spacing:.5px;
                    opacity:.65;
                    margin-bottom:5px;
                ">
                    Status
                </div>


                @if($service->status === 'active')

                    <span
                        class="
                            status-badge
                            status-success
                        "
                    >
                        Active
                    </span>

                @else

                    <span
                        class="
                            status-badge
                            status-secondary
                        "
                    >
                        Inactive
                    </span>

                @endif

            </div>



            {{-- PROJECT COUNT --}}

            <div>

                <div style="
                    font-size:12px;
                    text-transform:uppercase;
                    letter-spacing:.5px;
                    opacity:.65;
                    margin-bottom:5px;
                ">
                    Associated Projects
                </div>

                <div style="
                    font-size:20px;
                    font-weight:600;
                ">

                    {{ $service->projects_count }}

                </div>

            </div>


        </div>

    </div>


</div>



{{-- =====================================================
    SERVICE DETAILS
====================================================== --}}

<div class="panel">

    <div class="panel-header">

        <div>

            <h2>
                Service Details
            </h2>

            <p>
                Description, pricing and estimated duration.
            </p>

        </div>

    </div>


    <div style="padding:25px;">


        {{-- =============================================
            SHORT DESCRIPTION
        ============================================== --}}

        <div style="margin-bottom:25px;">

            <h3 style="
                margin-bottom:8px;
                font-size:16px;
            ">
                Short Description
            </h3>


            @if($service->short_description)

                <p style="
                    margin:0;
                    line-height:1.7;
                ">
                    {{ $service->short_description }}
                </p>

            @else

                <span
                    class="
                        status-badge
                        status-secondary
                    "
                >
                    Not Provided
                </span>

            @endif

        </div>



        {{-- =============================================
            FULL DESCRIPTION
        ============================================== --}}

        <div style="margin-bottom:25px;">

            <h3 style="
                margin-bottom:8px;
                font-size:16px;
            ">
                Full Description
            </h3>


            @if($service->description)

                <div style="
                    line-height:1.8;
                    white-space:pre-line;
                ">
                    {{ $service->description }}
                </div>

            @else

                <span
                    class="
                        status-badge
                        status-secondary
                    "
                >
                    Not Provided
                </span>

            @endif

        </div>



        {{-- =============================================
            BUDGET + DURATION
        ============================================== --}}

        <div
            style="
                display:grid;
                grid-template-columns:repeat(2, 1fr);
                gap:20px;
            "
        >


            {{-- STARTING BUDGET --}}

            <div
                style="
                    padding:20px;
                    border:1px solid rgba(0,0,0,.08);
                    border-radius:8px;
                "
            >

                <div style="
                    font-size:12px;
                    text-transform:uppercase;
                    letter-spacing:.5px;
                    opacity:.65;
                    margin-bottom:8px;
                ">
                    Starting Budget
                </div>


                @if($service->starting_budget !== null)

                    <div
                        class="amount"
                        style="
                            font-size:20px;
                            font-weight:600;
                        "
                    >

                        ৳ {{ number_format(
                            (float) $service->starting_budget,
                            2
                        ) }}

                    </div>

                @else

                    <span
                        class="
                            status-badge
                            status-secondary
                        "
                    >
                        Not Specified
                    </span>

                @endif


            </div>



            {{-- ESTIMATED DURATION --}}

            <div
                style="
                    padding:20px;
                    border:1px solid rgba(0,0,0,.08);
                    border-radius:8px;
                "
            >

                <div style="
                    font-size:12px;
                    text-transform:uppercase;
                    letter-spacing:.5px;
                    opacity:.65;
                    margin-bottom:8px;
                ">
                    Estimated Duration
                </div>


                @if($service->estimated_duration_days)

                    <div style="
                        font-size:20px;
                        font-weight:600;
                    ">

                        {{ $service->estimated_duration_days }}

                        day{{ $service->estimated_duration_days > 1 ? 's' : '' }}

                    </div>

                @else

                    <span
                        class="
                            status-badge
                            status-secondary
                        "
                    >
                        Not Specified
                    </span>

                @endif


            </div>


        </div>


    </div>

</div>



{{-- =====================================================
    SERVICE RECORD INFORMATION
====================================================== --}}

<div class="panel" style="margin-top:20px;">

    <div class="panel-header">

        <div>

            <h2>
                Record Information
            </h2>

            <p>
                Service creation and update information.
            </p>

        </div>

    </div>


    <div style="padding:20px;">

        <div
            style="
                display:grid;
                grid-template-columns:repeat(2, 1fr);
                gap:20px;
            "
        >


            {{-- CREATED AT --}}

            <div>

                <div style="
                    font-size:12px;
                    text-transform:uppercase;
                    opacity:.65;
                    margin-bottom:5px;
                ">
                    Created At
                </div>

                <div>

                    {{ $service->created_at
                        ? $service->created_at->format('d M Y, h:i A')
                        : 'N/A'
                    }}

                </div>

            </div>



            {{-- UPDATED AT --}}

            <div>

                <div style="
                    font-size:12px;
                    text-transform:uppercase;
                    opacity:.65;
                    margin-bottom:5px;
                ">
                    Last Updated
                </div>

                <div>

                    {{ $service->updated_at
                        ? $service->updated_at->format('d M Y, h:i A')
                        : 'N/A'
                    }}

                </div>

            </div>


        </div>

    </div>

</div>



{{-- =====================================================
    ACTIONS
====================================================== --}}

<div
    style="
        display:flex;
        gap:10px;
        margin-top:20px;
        flex-wrap:wrap;
    "
>


    {{-- EDIT --}}

    <a
        href="{{ route('admin.services.edit', $service) }}"
        class="primary-btn"
    >
        Edit Service
    </a>



    {{-- TOGGLE STATUS --}}

    <form
        action="{{ route(
            'admin.services.toggle-status',
            $service
        ) }}"
        method="POST"
        style="display:inline;"
    >

        @csrf

        <button
            type="submit"
            class="secondary-btn"
            onclick="return confirm(
                'Are you sure you want to change this service status?'
            )"
        >

            {{ $service->status === 'active'
                ? 'Deactivate Service'
                : 'Activate Service'
            }}

        </button>

    </form>



    {{-- DELETE --}}

    @if($service->projects_count == 0)

        <form
            action="{{ route(
                'admin.services.destroy',
                $service
            ) }}"
            method="POST"
            style="display:inline;"
        >

            @csrf

            @method('DELETE')

            <button
                type="submit"
                class="secondary-btn"
                onclick="return confirm(
                    'This service has no associated projects. Are you sure you want to permanently delete it?'
                )"
            >
                Delete Service
            </button>

        </form>

    @else

        <span
            class="
                status-badge
                status-warning
            "
            style="display:inline-flex; align-items:center;"
        >
            Cannot Delete — Used by Projects
        </span>

    @endif


</div>


@endsection