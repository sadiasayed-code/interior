@extends('backend.layouts.admin')

@section('title', 'Services')

@section('page_title', 'Services')

@section('content')


{{-- =====================================================
    PAGE HEADER
====================================================== --}}

<div class="page-header">

    <div>

        <h1>
            Services
        </h1>

        <p>
            Manage interior design services available to customers.
        </p>

    </div>


    <a
        href="{{ route('admin.services.create') }}"
        class="primary-btn"
    >
        + Add Service
    </a>

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
    SERVICE LIST PANEL
====================================================== --}}

<div class="panel">


    {{-- =================================================
        PANEL HEADER
    ================================================== --}}

    <div class="panel-header">

        <div>

            <h2>
                Service List
            </h2>

            <p>
                View and manage all services.
            </p>

        </div>


        <span class="table-count">

            {{ $services->count() }}

            {{ $services->count() === 1 ? 'Service' : 'Services' }}

        </span>

    </div>



    {{-- =================================================
        TABLE
    ================================================== --}}

    @if($services->count() > 0)

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>
                            #
                        </th>

                        <th>
                            IMAGE
                        </th>

                        <th>
                            SERVICE
                        </th>

                        <th>
                            STARTING BUDGET
                        </th>

                        <th>
                            DURATION
                        </th>

                        <th>
                            STATUS
                        </th>

                        <th>
                            ACTION
                        </th>

                    </tr>

                </thead>


                <tbody>


                    @foreach($services as $service)


                        <tr>


                            {{-- =====================================
                                SERIAL
                            ====================================== --}}

                            <td>

                                {{ $loop->iteration }}

                            </td>



                            {{-- =====================================
                                IMAGE
                            ====================================== --}}

                            <td>

                                @if($service->image)

                                    <img
                                        src="{{ asset('storage/' . $service->image) }}"
                                        alt="{{ $service->name }}"
                                        style="
                                            width:70px;
                                            height:50px;
                                            object-fit:cover;
                                            border-radius:6px;
                                            display:block;
                                        "
                                    >

                                @else

                                    <span
                                        class="
                                            status-badge
                                            status-secondary
                                        "
                                    >
                                        No Image
                                    </span>

                                @endif

                            </td>



                            {{-- =====================================
                                SERVICE
                            ====================================== --}}

                            <td>

                                <span class="project-name">

                                    {{ $service->name }}

                                </span>


                                @if($service->short_description)

                                    <span class="client-name">

                                        {{ Str::limit(
                                            $service->short_description,
                                            10
                                        ) }}

                                    </span>

                                @endif


                                <span
                                    class="client-name"
                                    style="margin-top:3px;"
                                >

                                    /{{ $service->slug }}

                                </span>

                            </td>



                            {{-- =====================================
                                STARTING BUDGET
                            ====================================== --}}

                            <td>

                                @if($service->starting_budget !== null)

                                    <span class="amount">

                                        ৳ {{ number_format(
                                            (float) $service->starting_budget,
                                            2
                                        ) }}

                                    </span>

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

                            </td>



                            {{-- =====================================
                                DURATION
                            ====================================== --}}

                            <td>

                                @if($service->estimated_duration_days)

                                    {{ $service->estimated_duration_days }}

                                    day{{ $service->estimated_duration_days > 1 ? 's' : '' }}

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

                            </td>



                            {{-- =====================================
                                STATUS
                            ====================================== --}}

                            <td>

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

                            </td>



                            {{-- =====================================
                                ACTION
                            ====================================== --}}

                            <td>

                                <div
                                    style="
                                        display:flex;
                                        gap:6px;
                                        flex-wrap:wrap;
                                    "
                                >


                                    {{-- VIEW --}}

                                    <a
                                        href="{{ route(
                                            'admin.services.show',
                                            $service
                                        ) }}"
                                        class="btn-view"
                                    >
                                        View
                                    </a>



                                    {{-- EDIT --}}

                                    <a
                                        href="{{ route(
                                            'admin.services.edit',
                                            $service
                                        ) }}"
                                        class="btn-view"
                                    >
                                        Edit
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
                                            class="btn-view"
                                            onclick="return confirm(
                                                'Are you sure you want to change this service status?'
                                            )"
                                        >

                                            {{ $service->status === 'active'
                                                ? 'Deactivate'
                                                : 'Activate'
                                            }}

                                        </button>

                                    </form>



                                    {{-- DELETE --}}

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
                                            class="btn-view"
                                            onclick="return confirm(
                                                'Are you sure you want to delete this service?'
                                            )"
                                        >

                                            Delete

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

            <h3>
                No Services Found
            </h3>

            <p>
                No service has been created yet.
            </p>


            <a
                href="{{ route('admin.services.create') }}"
                class="primary-btn"
            >

                + Create First Service

            </a>

        </div>


    @endif


</div>


@endsection