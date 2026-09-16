<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $service->name }} | MODULARS</title>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Poppins", sans-serif;
            background: #f7faf6;
            color: #153d3d;
        }

        /* =========================
           NAVBAR
        ========================= */

        nav {
            width: 100%;
            padding: 20px 6%;

            display: flex;
            align-items: center;
            justify-content: space-between;

            background: #ffffff;
        }

        #logo {
            font-size: 22px;
            font-weight: 800;
            color: #153d3d;
            text-decoration: none;
        }

        nav ul {
            display: flex;
            align-items: center;
            gap: 32px;
            list-style: none;
        }

        nav ul li a {
            text-decoration: none;
            color: #153d3d;
            font-size: 14px;
            font-weight: 500;
            transition: 0.3s;
        }

        nav ul li a:hover {
            color: #286318;
        }

        .nav-button {
            padding: 11px 22px;

            background: #286318;
            color: #ffffff;

            border-radius: 10px;
            text-decoration: none;

            font-size: 13px;
            font-weight: 600;

            transition: 0.3s;
        }

        .nav-button:hover {
            background: #153d3d;
        }


        /* =========================
           PAGE
        ========================= */

        .service-page {
            max-width: 1250px;
            margin: auto;
            padding: 70px 25px 100px;
        }


        /* =========================
           BACK LINK
        ========================= */

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            margin-bottom: 30px;

            color: #286318;
            text-decoration: none;

            font-size: 14px;
            font-weight: 600;
        }

        .back-link:hover {
            color: #153d3d;
        }


        /* =========================
           SERVICE HERO
        ========================= */

        .service-hero {
            display: grid;
            grid-template-columns: 1.1fr 1fr;

            background: #ffffff;

            border-radius: 30px;
            overflow: hidden;

            box-shadow: 0 20px 60px rgba(21, 61, 61, 0.08);
        }


        /* IMAGE */

        .service-main-image {
            width: 100%;
            min-height: 520px;

            background: #e2eddf;
        }

        .service-main-image img {
            width: 100%;
            height: 100%;

            object-fit: cover;
            display: block;
        }

        .no-image {
            width: 100%;
            height: 100%;
            min-height: 520px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #286318;
            font-size: 25px;
            font-weight: 600;
        }


        /* CONTENT */

        .service-main-content {
            padding: 55px;

            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .service-label {
            display: inline-block;

            color: #286318;

            font-size: 12px;
            font-weight: 700;

            letter-spacing: 3px;

            margin-bottom: 15px;
        }

        .service-main-content h1 {
            font-size: 46px;
            line-height: 1.2;

            color: #153d3d;

            margin-bottom: 20px;
        }

        .service-description {
            color: #687878;

            font-size: 15px;
            line-height: 1.9;

            margin-bottom: 35px;
        }


        /* =========================
           SERVICE INFO
        ========================= */

        .service-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);

            gap: 15px;

            margin-bottom: 35px;
        }

        .detail-box {
            padding: 18px;

            background: #f4f8f2;

            border-radius: 14px;
        }

        .detail-box small {
            display: block;

            color: #7d8989;

            font-size: 11px;

            margin-bottom: 5px;
        }

        .detail-box strong {
            color: #286318;

            font-size: 17px;
        }


        /* =========================
           REQUEST BUTTON
        ========================= */

        .request-button {
            width: 100%;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 17px 22px;

            background: #153d3d;
            color: #ffffff;

            border-radius: 13px;

            text-decoration: none;

            font-size: 15px;
            font-weight: 600;

            transition: 0.3s;
        }

        .request-button:hover {
            background: #286318;
            transform: translateY(-2px);
        }

        .request-button span {
            font-size: 22px;
        }


        /* =========================
           DESCRIPTION SECTION
        ========================= */

        .description-section {
            margin-top: 45px;

            background: #ffffff;

            padding: 50px;

            border-radius: 25px;

            box-shadow: 0 15px 45px rgba(21, 61, 61, 0.06);
        }

        .description-section .section-label {
            color: #286318;

            font-size: 12px;
            font-weight: 700;

            letter-spacing: 3px;
        }

        .description-section h2 {
            margin: 10px 0 20px;

            color: #153d3d;

            font-size: 32px;
        }

        .description-section p {
            color: #687878;

            font-size: 15px;
            line-height: 2;

            white-space: pre-line;
        }


        /* =========================
           CTA
        ========================= */

        .service-cta {
            margin-top: 45px;

            padding: 55px;

            border-radius: 25px;

            background: #153d3d;

            text-align: center;
        }

        .service-cta h2 {
            color: #ffffff;

            font-size: 32px;

            margin-bottom: 12px;
        }

        .service-cta p {
            color: #cbd8d2;

            font-size: 14px;

            max-width: 650px;

            margin: 0 auto 25px;

            line-height: 1.8;
        }

        .cta-button {
            display: inline-block;

            padding: 14px 28px;

            background: #286318;
            color: #ffffff;

            border-radius: 10px;

            text-decoration: none;

            font-size: 14px;
            font-weight: 600;

            transition: 0.3s;
        }

        .cta-button:hover {
            background: #ffffff;
            color: #153d3d;
        }


        /* =========================
           FOOTER
        ========================= */

        footer {
            padding: 35px 20px;

            text-align: center;

            background: #ffffff;

            color: #7a8585;

            font-size: 13px;
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {

            nav {
                padding: 18px 25px;
            }

            nav ul {
                display: none;
            }

            .service-hero {
                grid-template-columns: 1fr;
            }

            .service-main-image {
                min-height: 400px;
            }

            .no-image {
                min-height: 400px;
            }

            .service-main-content {
                padding: 40px;
            }

            .service-main-content h1 {
                font-size: 38px;
            }

        }


        @media (max-width: 600px) {

            nav {
                padding: 16px 20px;
            }

            #logo {
                font-size: 19px;
            }

            .nav-button {
                padding: 9px 14px;
                font-size: 12px;
            }

            .service-page {
                padding: 35px 15px 70px;
            }

            .service-hero {
                border-radius: 20px;
            }

            .service-main-image {
                min-height: 280px;
            }

            .no-image {
                min-height: 280px;
            }

            .service-main-content {
                padding: 28px 22px;
            }

            .service-main-content h1 {
                font-size: 30px;
            }

            .service-description {
                font-size: 14px;
            }

            .service-details {
                grid-template-columns: 1fr;
            }

            .description-section {
                padding: 30px 22px;
                border-radius: 20px;
            }

            .description-section h2 {
                font-size: 26px;
            }

            .service-cta {
                padding: 40px 22px;
                border-radius: 20px;
            }

            .service-cta h2 {
                font-size: 25px;
            }

        }
    </style>
</head>

<body>


    <!-- =========================
         NAVBAR
    ========================= -->

    <nav>

        <a href="{{ url('/') }}" id="logo">
            MODULARS
        </a>

        <ul>

            <li>
                <a href="{{ url('/') }}">
                    Home
                </a>
            </li>

            <li>
                <a href="{{ url('/#services') }}">
                    Services
                </a>
            </li>

            <li>
                <a href="#">
                    About
                </a>
            </li>

            <li>
                <a href="#">
                    Contact
                </a>
            </li>

        </ul>

        <a
            href="{{ route('customer.register') }}"
            class="nav-button"
        >
            Request Project
        </a>

    </nav>



    <!-- =========================
         SERVICE PAGE
    ========================= -->

    <main class="service-page">

        <a
            href="{{ url('/#services') }}"
            class="back-link"
        >
            ← Back to Services
        </a>


        <!-- =========================
             SERVICE HERO
        ========================= -->

        <div class="service-hero">


            <!-- IMAGE -->

            <div class="service-main-image">

                @if($service->image)

                    <img
                        src="{{ asset('storage/' . $service->image) }}"
                        alt="{{ $service->name }}"
                    >

                @else

                    <div class="no-image">
                        Interior Design
                    </div>

                @endif

            </div>



            <!-- SERVICE CONTENT -->

            <div class="service-main-content">

                <span class="service-label">
                    OUR SERVICE
                </span>


                <h1>
                    {{ $service->name }}
                </h1>


                @if($service->short_description)

                    <p class="service-description">
                        {{ $service->short_description }}
                    </p>

                @endif


                <!-- SERVICE INFORMATION -->

                <div class="service-details">

                    @if($service->starting_budget !== null)

                        <div class="detail-box">

                            <small>
                                Starting From
                            </small>

                            <strong>
                                ৳ {{ number_format((float) $service->starting_budget) }}
                            </strong>

                        </div>

                    @endif


                    @if($service->estimated_duration_days)

                        <div class="detail-box">

                            <small>
                                Estimated Duration
                            </small>

                            <strong>
                                {{ $service->estimated_duration_days }} Days
                            </strong>

                        </div>

                    @endif

                </div>


                <!-- REQUEST SERVICE -->

                <a
                    href="{{ session()->has('customer_user_id')
        ? route('customer.project-request.create', ['service' => $service->slug])
        : route('customer.register', ['service' => $service->slug]) }}"
                    class="request-button"
                >
                    <span>
                        Request This Service
                    </span>

                    <span>
                        →
                    </span>
                </a>

            </div>

        </div>



        <!-- =========================
             FULL DESCRIPTION
        ========================= -->

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



        <!-- =========================
             CTA
        ========================= -->

        <section class="service-cta">

            <h2>
                Ready to Start Your Project?
            </h2>

            <p>
                Tell us about your project and our team will
                review your requirements and prepare the next steps.
            </p>

            <a
                href="{{ session()->has('customer_user_id')
        ? route('customer.project-request.create', ['service' => $service->slug])
        : route('customer.register', ['service' => $service->slug]) }}"
                class="cta-button"
            >
                Request This Service
            </a>

        </section>

    </main>



    <!-- =========================
         FOOTER
    ========================= -->

    <footer>

        © {{ date('Y') }} MODULARS. All rights reserved.

    </footer>


</body>
</html>