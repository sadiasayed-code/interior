<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Admin Panel') - Interior PMS
    </title>

    {{-- Load CSS directly from public folder --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>


<body>

    <div class="admin-layout">


        {{-- =====================================================
            SIDEBAR
        ====================================================== --}}

        <aside class="sidebar" id="sidebar">


            {{-- =================================================
                BRAND
            ================================================== --}}

            <div class="brand">

                <div class="brand-logo">
                    IP
                </div>

                <div>

                    <h2>
                        Interior PMS
                    </h2>

                    <span>
                        Management System
                    </span>

                </div>

            </div>


            {{-- =================================================
                MAIN MENU
            ================================================== --}}

            <div class="menu-section">

                <p class="menu-title">
                    MAIN MENU
                </p>


                {{-- =================================================
                    Dashboard
                ================================================== --}}

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="menu-item
                    {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                >

                    <span class="icon">
                        ⌂
                    </span>

                    <span>
                        Dashboard
                    </span>

                </a>


                {{-- =================================================
                    Services
                ================================================== --}}

                <a
                    href="{{ route('admin.services.index') }}"
                    class="menu-item
                    {{ request()->routeIs('admin.services.*') ? 'active' : '' }}"
                >

                    <span class="icon">
                        ◈
                    </span>

                    <span>
                        Services
                    </span>

                </a>


                {{-- =================================================
                    Previous Works
                ================================================== --}}

                <a
                    href="{{ route('admin.previous-works.index') }}"
                    class="menu-item
                    {{ request()->routeIs('admin.previous-works.*') ? 'active' : '' }}"
                >

                    <span class="icon">
                        ◫
                    </span>

                    <span>
                        Previous Works
                    </span>

                </a>


                {{-- =================================================
                    Clients
                ================================================== --}}

                <a
                    href="{{ route('admin.clients.index') }}"
                    class="menu-item
                    {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}"
                >

                    <span class="icon">
                        ♙
                    </span>

                    <span>
                        Clients
                    </span>

                </a>


                {{-- =================================================
                    Projects
                ================================================== --}}

                <a
                    href="{{ route('admin.projects.index') }}"
                    class="menu-item
                    {{ request()->routeIs('admin.projects.*') || request()->routeIs('admin.project-requests.*') ? 'active' : '' }}"
                >

                    <span class="icon">
                        ▣
                    </span>

                    <span>
                        Projects
                    </span>

                </a>


                {{-- =================================================
                    Project Requests
                ================================================== --}}

                @php

                    $pendingProjectRequests =
                        $pendingProjectRequests ?? 0;

                @endphp


                <a
                    href="{{ route('admin.project-requests.index') }}"
                    class="menu-item
                    {{ request()->routeIs('admin.project-requests.*') ? 'active' : '' }}"
                    style="
                        padding-left: 48px;
                        font-size: 13px;
                        display: flex;
                        align-items: center;
                    "
                >

                    <span class="icon">
                        ↳
                    </span>


                    <span
                        style="
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                            flex: 1;
                            min-width: 0;
                        "
                    >

                        <span>
                            Project Requests
                        </span>


                        {{-- Show badge only when pending requests exist --}}

                        @if($pendingProjectRequests > 0)

                            <span
                                style="
                                    display: inline-flex;
                                    align-items: center;
                                    justify-content: center;
                                    min-width: 22px;
                                    height: 22px;
                                    padding: 0 7px;
                                    margin-left: 10px;
                                    border-radius: 50px;
                                    background: #dc2626;
                                    color: #ffffff;
                                    font-size: 11px;
                                    font-weight: 700;
                                    line-height: 1;
                                    flex-shrink: 0;
                                "
                            >
                                {{ $pendingProjectRequests }}
                            </span>

                        @endif

                    </span>

                </a>


                {{-- =================================================
                    Materials
                ================================================== --}}

                <a
                    href="{{ route('admin.materials.index') }}"
                    class="menu-item
                    {{ request()->routeIs('admin.materials.*') ? 'active' : '' }}"
                >

                    <span class="icon">
                        ◆
                    </span>

                    <span>
                        Materials
                    </span>

                </a>


                {{-- =================================================
                    Suppliers
                ================================================== --}}

                <a
                    href="{{ route('admin.suppliers.index') }}"
                    class="menu-item
                    {{ request()->routeIs('admin.suppliers.*') ? 'active' : '' }}"
                >

                    <span class="icon">
                        ▤
                    </span>

                    <span>
                        Suppliers
                    </span>

                </a>


                {{-- =================================================
                    Project Materials
                ================================================== --}}

                <a
                    href="{{ route('admin.project-materials.index') }}"
                    class="menu-item
                    {{ request()->routeIs('admin.project-materials.*') ? 'active' : '' }}"
                >

                    <span class="icon">
                        ▦
                    </span>

                    <span>
                        Project Materials
                    </span>

                </a>


            </div>


            {{-- =====================================================
                MANAGEMENT MENU
            ====================================================== --}}

            <div class="menu-section">

                <p class="menu-title">
                    MANAGEMENT
                </p>


                {{-- =================================================
                    Budgets
                ================================================== --}}

                <a
                    href="{{ route('admin.budgets.index') }}"
                    class="menu-item
                    {{ request()->routeIs('admin.budgets.*') ? 'active' : '' }}"
                >

                    <span class="icon">
                        ৳
                    </span>

                    <span>
                        Budgets
                    </span>

                </a>


                {{-- =================================================
                    Payments
                ================================================== --}}

                <a
                    href="{{ route('admin.payments.index') }}"
                    class="menu-item
                    {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}"
                >

                    <span class="icon">
                        ▣
                    </span>

                    <span>
                        Payments
                    </span>

                </a>


                {{-- =================================================
                    Progress Reports
                ================================================== --}}

                <a
                    href="{{ route('admin.progress-reports.index') }}"
                    class="menu-item
                    {{ request()->routeIs('admin.progress-reports.*') ? 'active' : '' }}"
                >

                    <span class="icon">
                        ↗
                    </span>

                    <span>
                        Progress Reports
                    </span>

                </a>


                {{-- =================================================
                    Reports
                ================================================== --}}

                <a
                    href="{{ route('admin.reports.index') }}"
                    class="menu-item
                    {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"
                >

                    <span class="icon">
                        ▥
                    </span>

                    <span>
                        Reports
                    </span>

                </a>


            </div>


            {{-- =====================================================
                SIDEBAR BOTTOM
            ====================================================== --}}

            <div class="sidebar-bottom">

                <a
                    href="{{ route('logout') }}"
                    class="menu-item logout"
                >

                    <span class="icon">
                        ↪
                    </span>

                    <span>
                        Logout
                    </span>

                </a>

            </div>


        </aside>


        {{-- =====================================================
            MAIN CONTENT
        ====================================================== --}}

        <main class="main-content">


            {{-- TOPBAR --}}

            <header class="topbar">


                <div class="topbar-left">


                    {{-- Mobile menu button --}}

                    <button
                        type="button"
                        class="mobile-menu"
                        id="mobileMenuButton"
                    >
                        ☰
                    </button>


                    <div>

                        <h3>
                            @yield('page_title', 'Dashboard')
                        </h3>

                        <p>
                            Interior Project Management System
                        </p>

                    </div>

                </div>


                <div class="topbar-right">


                    {{-- Notification --}}

                    <button
                        type="button"
                        class="notification"
                    >

                        ♧

                        <span class="notification-dot"></span>

                    </button>


                    <div class="divider"></div>


                    {{-- Admin Profile --}}

                    <div class="profile">

                        <div class="profile-avatar">
                            A
                        </div>


                        <div class="profile-info">

                            <strong>
                                Admin
                            </strong>

                            <span>
                                Administrator
                            </span>

                        </div>


                        <span class="arrow">
                            ⌄
                        </span>

                    </div>

                </div>

            </header>


            {{-- =================================================
                PAGE CONTENT
            ================================================== --}}

            <section class="page-content">


                {{-- Success Message --}}

                @if(session('success'))

                    <div
                        class="alert alert-success"
                        id="successAlert"
                    >

                        <span>
                            {{ session('success') }}
                        </span>

                        <button
                            type="button"
                            class="alert-close"
                            onclick="closeAlert('successAlert')"
                        >
                            ×
                        </button>

                    </div>

                @endif


                {{-- Validation Errors --}}

                @if($errors->any())

                    <div
                        class="alert alert-error"
                        id="errorAlert"
                    >

                        <div>

                            <strong>
                                Please fix the following errors:
                            </strong>

                            <ul>

                                @foreach($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>


                        <button
                            type="button"
                            class="alert-close"
                            onclick="closeAlert('errorAlert')"
                        >
                            ×
                        </button>

                    </div>

                @endif


                {{-- Child page content will appear here --}}

                @yield('content')


            </section>


        </main>


    </div>


    {{-- Load JavaScript directly from public folder --}}

    <script src="{{ asset('js/app.js') }}"></script>

</body>

</html>