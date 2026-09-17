<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        {{ $service->name }} | Canvas & Corner Interiors
    </title>


    <!-- =====================================================
         TAILWIND CSS
    ====================================================== -->

    <script src="https://cdn.tailwindcss.com"></script>


    <script>

        tailwind.config = {

            theme: {

                extend: {

                    colors: {

                        primary: '#0056b3',

                        'primary-dark': '#003d82',

                        offwhite: '#f9fbfc'

                    }

                }

            }

        }

    </script>


    <!-- =====================================================
         GOOGLE FONT
    ====================================================== -->

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet"
    >


    <!-- =====================================================
         FONT AWESOME
    ====================================================== -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    >


    <style>

        * {
            box-sizing: border-box;
        }


        html {
            scroll-behavior: smooth;
        }


        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background: #ffffff;
            color: #1f2937;
        }


        /* =====================================================
           NAVBAR
        ====================================================== */

        .main-navbar {

            position: fixed;

            top: 0;
            left: 0;

            width: 100%;

            z-index: 999;

            background:
                rgba(255, 255, 255, 0.94);

            backdrop-filter:
                blur(14px);

            -webkit-backdrop-filter:
                blur(14px);

            box-shadow:
                0 4px 20px rgba(0, 0, 0, 0.05);

        }


        .navbar-inner {

            width: 100%;

            padding:
                16px 6%;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 30px;

        }


        /* =====================================================
           LOGO
        ====================================================== */

        .company-logo {

            text-decoration: none;

            display: inline-block;

            line-height: 1.1;

            flex-shrink: 0;

        }


        .company-logo-main {

            font-size: 21px;

            font-weight: 800;

            color: #0056b3;

            letter-spacing: -0.5px;

        }


        .company-logo-sub {

            display: block;

            font-size: 12px;

            font-weight: 300;

            color: #374151;

            letter-spacing: 0;

            margin-top: 3px;

        }


        /* =====================================================
           NAV LINKS
        ====================================================== */

        .nav-links {

            display: flex;

            align-items: center;

            gap: 32px;

            list-style: none;

            margin: 0;

            padding: 0;

        }


        .nav-links a {

            text-decoration: none;

            color: #374151;

            font-size: 14px;

            font-weight: 500;

            transition: 0.25s ease;

        }


        .nav-links a:hover {

            color: #0056b3;

        }


        /* =====================================================
           NAV BUTTON
        ====================================================== */

        .nav-consultation {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            padding:
                10px 19px;

            background: #0056b3;

            color: #ffffff;

            text-decoration: none;

            border-radius: 7px;

            font-size: 13px;

            font-weight: 600;

            white-space: nowrap;

            transition: 0.25s ease;

            box-shadow:
                0 5px 15px rgba(0, 86, 179, 0.18);

        }


        .nav-consultation:hover {

            background: #003d82;

            transform:
                translateY(-1px);

        }


        /* =====================================================
           MAIN PAGE
        ====================================================== */

        .service-page {

            max-width: 1280px;

            margin:
                0 auto;

            padding:
                125px 24px 80px;

        }


        /* =====================================================
           BREADCRUMB / BACK LINK
        ====================================================== */

        .back-link {

            display: inline-flex;

            align-items: center;

            gap: 9px;

            margin-bottom: 28px;

            color: #0056b3;

            text-decoration: none;

            font-size: 13px;

            font-weight: 600;

            transition: 0.25s ease;

        }


        .back-link:hover {

            color: #003d82;

            transform:
                translateX(-2px);

        }


        /* =====================================================
           SERVICE HERO
        ====================================================== */

        .service-hero {

            display: grid;

            grid-template-columns:
                1.08fr
                1fr;

            background: #ffffff;

            border:
                1px solid #e5e7eb;

            border-radius: 22px;

            overflow: hidden;

            box-shadow:
                0 20px 55px rgba(0, 0, 0, 0.07);

        }


        /* =====================================================
           IMAGE
        ====================================================== */

        .service-image-wrapper {

            min-height: 540px;

            background:
                linear-gradient(
                    135deg,
                    #eef5fb,
                    #dceafa
                );

            overflow: hidden;

        }


        .service-image-wrapper img {

            width: 100%;

            height: 100%;

            min-height: 540px;

            object-fit: cover;

            display: block;

            transition:
                transform 0.6s ease;

        }


        .service-hero:hover
        .service-image-wrapper img {

            transform:
                scale(1.025);

        }


        .no-image {

            width: 100%;

            min-height: 540px;

            display: flex;

            align-items: center;

            justify-content: center;

            flex-direction: column;

            gap: 12px;

            color: #0056b3;

            background:
                linear-gradient(
                    135deg,
                    #f3f8fc,
                    #e6f0f9
                );

        }


        .no-image i {

            font-size: 48px;

        }


        .no-image span {

            font-size: 15px;

            font-weight: 600;

        }


        /* =====================================================
           SERVICE CONTENT
        ====================================================== */

        .service-content {

            padding:
                55px 52px;

            display: flex;

            flex-direction: column;

            justify-content: center;

        }


        .service-label {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            color: #0056b3;

            font-size: 11px;

            font-weight: 700;

            letter-spacing: 2.5px;

            margin-bottom: 16px;

        }


        .service-label::before {

            content: "";

            width: 25px;

            height: 2px;

            background: #0056b3;

        }


        .service-content h1 {

            margin: 0 0 18px;

            color: #111827;

            font-size: 43px;

            line-height: 1.2;

            font-weight: 700;

            letter-spacing: -1px;

        }


        .service-description {

            color: #6b7280;

            font-size: 14px;

            line-height: 1.9;

            margin:
                0 0 30px;

        }


        /* =====================================================
           SERVICE DETAILS
        ====================================================== */

        .service-details {

            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 12px;

            margin-bottom: 30px;

        }


        .detail-box {

            background: #f7fafc;

            border:
                1px solid #e5edf5;

            border-radius: 10px;

            padding:
                17px 18px;

            transition:
                0.25s ease;

        }


        .detail-box:hover {

            border-color:
                #b9d4ed;

            transform:
                translateY(-2px);

        }


        .detail-box small {

            display: block;

            color: #6b7280;

            font-size: 10px;

            font-weight: 500;

            margin-bottom: 5px;

            text-transform: uppercase;

            letter-spacing: 0.6px;

        }


        .detail-box strong {

            display: block;

            color: #0056b3;

            font-size: 17px;

            font-weight: 700;

        }


        /* =====================================================
           REQUEST BUTTON
        ====================================================== */

        .request-button {

            width: 100%;

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding:
                15px 20px;

            background: #0056b3;

            color: #ffffff;

            border-radius: 8px;

            text-decoration: none;

            font-size: 14px;

            font-weight: 600;

            box-shadow:
                0 8px 20px
                rgba(0, 86, 179, 0.18);

            transition:
                0.25s ease;

        }


        .request-button:hover {

            background: #003d82;

            transform:
                translateY(-2px);

            box-shadow:
                0 12px 25px
                rgba(0, 61, 130, 0.22);

        }


        .request-button i {

            font-size: 14px;

            transition:
                transform 0.25s ease;

        }


        .request-button:hover i {

            transform:
                translateX(4px);

        }


        /* =====================================================
           FULL DESCRIPTION
        ====================================================== */

        .description-section {

            margin-top: 35px;

            padding:
                48px 50px;

            background: #ffffff;

            border:
                1px solid #e8edf2;

            border-radius: 18px;

            box-shadow:
                0 12px 40px
                rgba(0, 0, 0, 0.045);

        }


        .section-label {

            display: inline-block;

            color: #0056b3;

            font-size: 11px;

            font-weight: 700;

            letter-spacing: 2.5px;

            margin-bottom: 8px;

        }


        .description-section h2 {

            margin:
                5px 0 17px;

            color: #111827;

            font-size: 30px;

            line-height: 1.3;

        }


        .description-section p {

            margin: 0;

            color: #6b7280;

            font-size: 14px;

            line-height: 2;

            white-space: pre-line;

        }


        /* =====================================================
           CTA
        ====================================================== */

        .service-cta {

            margin-top: 35px;

            padding:
                55px 30px;

            border-radius: 18px;

            background:
                linear-gradient(
                    135deg,
                    #003d82,
                    #0056b3
                );

            text-align: center;

            position: relative;

            overflow: hidden;

        }


        .service-cta::before {

            content: "";

            position: absolute;

            width: 250px;

            height: 250px;

            border-radius: 50%;

            background:
                rgba(255,255,255,0.06);

            top: -130px;

            right: -80px;

        }


        .service-cta::after {

            content: "";

            position: absolute;

            width: 180px;

            height: 180px;

            border-radius: 50%;

            background:
                rgba(255,255,255,0.05);

            bottom: -100px;

            left: -50px;

        }


        .service-cta h2 {

            position: relative;

            z-index: 2;

            color: #ffffff;

            font-size: 30px;

            margin:
                0 0 10px;

        }


        .service-cta p {

            position: relative;

            z-index: 2;

            color: #dbeafe;

            font-size: 14px;

            max-width: 650px;

            margin:
                0 auto 25px;

            line-height: 1.8;

        }


        .cta-button {

            position: relative;

            z-index: 2;

            display: inline-flex;

            align-items: center;

            gap: 9px;

            padding:
                13px 25px;

            background: #ffffff;

            color: #0056b3;

            border-radius: 7px;

            text-decoration: none;

            font-size: 13px;

            font-weight: 700;

            transition:
                0.25s ease;

        }


        .cta-button:hover {

            background: #f0f7ff;

            transform:
                translateY(-2px);

        }


        /* =====================================================
           FOOTER
        ====================================================== */

        footer {

            padding:
                30px 20px;

            text-align: center;

            background: #f9fbfc;

            border-top:
                1px solid #edf1f5;

            color: #6b7280;

            font-size: 12px;

        }


        footer strong {

            color: #0056b3;

            font-weight: 600;

        }


        /* =====================================================
           MOBILE NAV
        ====================================================== */

        .mobile-menu-button {

            display: none;

            border: none;

            background: transparent;

            color: #0056b3;

            font-size: 21px;

            cursor: pointer;

        }


        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 950px) {

            .navbar-inner {

                padding:
                    15px 25px;

            }


            .nav-links {

                gap: 20px;

            }


            .service-hero {

                grid-template-columns: 1fr;

            }


            .service-image-wrapper {

                min-height: 420px;

            }


            .service-image-wrapper img {

                min-height: 420px;

            }


            .no-image {

                min-height: 420px;

            }


            .service-content {

                padding:
                    42px;

            }


            .service-content h1 {

                font-size: 36px;

            }

        }


        @media (max-width: 720px) {

            .navbar-inner {

                padding:
                    14px 20px;

            }


            .nav-links {

                display: none;

            }


            .nav-consultation {

                display: none;

            }


            .mobile-menu-button {

                display: block;

            }


            .service-page {

                padding:
                    105px 15px 60px;

            }


            .back-link {

                margin-bottom: 20px;

            }


            .service-hero {

                border-radius: 16px;

            }


            .service-image-wrapper {

                min-height: 300px;

            }


            .service-image-wrapper img {

                min-height: 300px;

            }


            .no-image {

                min-height: 300px;

            }


            .service-content {

                padding:
                    30px 22px;

            }


            .service-content h1 {

                font-size: 30px;

                letter-spacing: -0.5px;

            }


            .service-description {

                font-size: 13px;

                line-height: 1.8;

            }


            .service-details {

                grid-template-columns: 1fr;

            }


            .description-section {

                padding:
                    30px 22px;

                border-radius: 15px;

            }


            .description-section h2 {

                font-size: 25px;

            }


            .description-section p {

                font-size: 13px;

                line-height: 1.9;

            }


            .service-cta {

                padding:
                    42px 20px;

                border-radius: 15px;

            }


            .service-cta h2 {

                font-size: 24px;

            }


            .service-cta p {

                font-size: 13px;

            }

        }


        @media (max-width: 420px) {

            .company-logo-main {

                font-size: 18px;

            }


            .company-logo-sub {

                font-size: 10px;

            }


            .service-content h1 {

                font-size: 27px;

            }


            .request-button {

                padding:
                    14px 16px;

                font-size: 13px;

            }

        }

    </style>

</head>


<body>


    <!-- =====================================================
         NAVBAR
         SAME STYLE AS HOME PAGE
    ====================================================== -->

    <header class="main-navbar">

        <div class="navbar-inner">


            <!-- COMPANY LOGO -->

            <a
                href="{{ url('/#home') }}"
                class="company-logo"
            >

                <span class="company-logo-main">
                    Canvas & Corner
                </span>

                <span class="company-logo-sub">
                    Interiors
                </span>

            </a>



            <!-- NAVIGATION -->

            <nav>

                <ul class="nav-links">

                    <li>

                        <a href="{{ url('/#home') }}">
                            Home
                        </a>

                    </li>


                    <li>

                        <a href="{{ url('/#services') }}">
                            Services
                        </a>

                    </li>


                    <li>

                        <a href="{{ url('/#gallery') }}">
                            Portfolio
                        </a>

                    </li>


                    <li>

                        <a href="{{ url('/#contact') }}">
                            Contact
                        </a>

                    </li>

                </ul>

            </nav>



            <!-- BOOK CONSULTATION -->

            <a
                href="{{ url('/#contact') }}"
                class="nav-consultation"
            >

                Book Consultation

            </a>


            <!-- MOBILE ICON -->

            <button
                type="button"
                class="mobile-menu-button"
                onclick="window.location.href='{{ url('/#services') }}'"
                aria-label="Services"
            >

                <i class="fa-solid fa-bars"></i>

            </button>


        </div>

    </header>



    <!-- =====================================================
         MAIN SERVICE PAGE
    ====================================================== -->

    <main class="service-page">


        <!-- =================================================
             BACK TO SERVICES
        ================================================== -->

        <a
            href="{{ url('/#services') }}"
            class="back-link"
        >

            <i class="fa-solid fa-arrow-left"></i>

            Back to Services

        </a>



        <!-- =================================================
             SERVICE HERO
        ================================================== -->

        <div class="service-hero">


            <!-- =================================================
                 SERVICE IMAGE
            ================================================== -->

            <div class="service-image-wrapper">

                @if($service->image)

                    @if(
                        \Illuminate\Support\Str::startsWith(
                            $service->image,
                            ['http://', 'https://']
                        )
                    )

                        <img
                            src="{{ $service->image }}"
                            alt="{{ $service->name }}"
                        >

                    @else

                        <img
                            src="{{ asset('storage/' . $service->image) }}"
                            alt="{{ $service->name }}"
                        >

                    @endif

                @else

                    <div class="no-image">

                        <i class="fa-solid fa-house-chimney"></i>

                        <span>
                            Interior Design Service
                        </span>

                    </div>

                @endif

            </div>



            <!-- =================================================
                 SERVICE CONTENT
            ================================================== -->

            <div class="service-content">


                <!-- LABEL -->

                <span class="service-label">
                    OUR SERVICE
                </span>



                <!-- SERVICE NAME -->

                <h1>
                    {{ $service->name }}
                </h1>



                <!-- SHORT DESCRIPTION -->

                @if($service->short_description)

                    <p class="service-description">

                        {{ $service->short_description }}

                    </p>

                @elseif($service->description)

                    <p class="service-description">

                        {{ \Illuminate\Support\Str::limit(
                            $service->description,
                            220
                        ) }}

                    </p>

                @else

                    <p class="service-description">

                        Professional interior design solutions
                        tailored to your space, lifestyle and
                        requirements.

                    </p>

                @endif



                <!-- =================================================
                     SERVICE INFORMATION
                ================================================== -->

                @if(
                    $service->starting_budget !== null ||
                    $service->estimated_duration_days
                )

                    <div class="service-details">


                        <!-- STARTING BUDGET -->

                        @if($service->starting_budget !== null)

                            <div class="detail-box">

                                <small>
                                    Starting From
                                </small>

                                <strong>

                                    ৳ {{ number_format(
                                        (float) $service->starting_budget
                                    ) }}

                                </strong>

                            </div>

                        @endif



                        <!-- ESTIMATED DURATION -->

                        @if($service->estimated_duration_days)

                            <div class="detail-box">

                                <small>
                                    Estimated Duration
                                </small>

                                <strong>

                                    {{ $service->estimated_duration_days }}

                                    {{
                                        $service->estimated_duration_days == 1
                                            ? 'Day'
                                            : 'Days'
                                    }}

                                </strong>

                            </div>

                        @endif


                    </div>

                @endif



                <!-- =================================================
                     REQUEST SERVICE
                ================================================== -->

                <a
                    href="{{ session()->has('customer_user_id')
                        ? route(
                            'customer.project-request.create',
                            ['service' => $service->slug]
                        )
                        : route(
                            'customer.register',
                            ['service' => $service->slug]
                        )
                    }}"
                    class="request-button"
                >

                    <span>
                        Request This Service
                    </span>


                    <i class="fa-solid fa-arrow-right"></i>

                </a>


            </div>

        </div>



        <!-- =================================================
             FULL DESCRIPTION
        ================================================== -->

        @if($service->description)

            <section class="description-section">


                <span class="section-label">
                    SERVICE DETAILS
                </span>


                <h2>
                    About This Service
                </h2>


                <p>
                    {{ $service->description }}
                </p>


            </section>

        @endif



        <!-- =================================================
             CTA
        ================================================== -->

        <section class="service-cta">


            <h2>
                Ready to Start Your Project?
            </h2>


            <p>
                Tell us about your project and our team will
                review your requirements and prepare the next
                steps for your interior project.
            </p>


            <a
                href="{{ session()->has('customer_user_id')
                    ? route(
                        'customer.project-request.create',
                        ['service' => $service->slug]
                    )
                    : route(
                        'customer.register',
                        ['service' => $service->slug]
                    )
                }}"
                class="cta-button"
            >

                Request This Service

                <i class="fa-solid fa-arrow-right"></i>

            </a>


        </section>


    </main>



    <!-- =====================================================
         FOOTER
    ====================================================== -->

    <footer>

        &copy; {{ date('Y') }}

        <strong>
            Canvas & Corner Interiors
        </strong>

        . All Rights Reserved.

    </footer>



</body>

</html>