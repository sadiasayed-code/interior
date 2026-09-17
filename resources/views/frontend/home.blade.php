<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Canvas & Corner Interiors - Modern Interior Design
    </title>


    <!-- Tailwind CSS CDN -->

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


    <!-- Google Fonts & FontAwesome -->

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >


    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    >


    <style>

        body {
            font-family: 'Poppins', sans-serif;
        }


        .service-image-placeholder {
            background:
                linear-gradient(
                    135deg,
                    #f3f4f6,
                    #e5e7eb
                );
        }

    </style>

</head>


<body class="bg-white text-gray-800 antialiased">


    <!-- =====================================================
         HEADER / NAVIGATION
    ====================================================== -->

    <header
        class="fixed top-0 left-0 w-full bg-white/90 backdrop-blur-md shadow-sm z-50 px-6 lg:px-16 py-4 flex justify-between items-center"
    >

        <a
            href="#home"
            class="text-xl font-bold text-primary tracking-tight"
        >

            Canvas & Corner

            <span
                class="text-gray-800 font-light text-sm block tracking-normal"
            >
                Interiors
            </span>

        </a>


        <nav
            class="hidden md:flex space-x-8 font-medium text-sm text-gray-700"
        >

            <a
                href="#home"
                class="hover:text-primary transition"
            >
                Home
            </a>


            <a
                href="#services"
                class="hover:text-primary transition"
            >
                Services
            </a>


            <a
                href="#gallery"
                class="hover:text-primary transition"
            >
                Portfolio
            </a>


            <a
                href="#contact"
                class="hover:text-primary transition"
            >
                Contact
            </a>

        </nav>


        <a
            href="#services"
            class="hidden md:inline-block bg-primary hover:bg-primary-dark text-white text-sm font-medium px-5 py-2.5 rounded transition shadow-sm"
        >
            Book Service
        </a>

    </header>



    <!-- =====================================================
         HERO / BANNER
    ====================================================== -->

    <section
        id="home"
        class="relative w-full h-screen bg-cover bg-center flex flex-col justify-center items-center text-center px-4"
        style="
            background-image:
            linear-gradient(
                rgba(0, 0, 0, 0.45),
                rgba(0, 0, 0, 0.45)
            ),
            url('https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=1920&q=80');
        "
    >

        <h1
            class="text-4xl md:text-6xl font-bold text-white max-w-4xl mb-6 leading-tight"
        >
            Crafting timeless interiors with modern elegance
        </h1>


        <p
            class="text-lg text-gray-200 max-w-xl mb-8 font-light"
        >
            Elevate your lifestyle with exquisite interior designs tailored uniquely to your taste, comfort, and space.
        </p>


        <a
            href="#services"
            class="bg-primary hover:bg-primary-dark text-white font-semibold px-8 py-4 rounded transition shadow-lg transform hover:-translate-y-0.5"
        >
            Explore Services
        </a>

    </section>



    <!-- =====================================================
         SERVICES SECTION
         DYNAMIC FROM DATABASE
    ====================================================== -->

    <section
        id="services"
        class="py-24 px-6 lg:px-16 bg-offwhite"
    >

        <div
            class="text-center max-w-2xl mx-auto mb-16"
        >

            <h2
                class="text-3xl md:text-4xl font-bold text-gray-900 mb-3 relative inline-block"
            >

                Our Services

                <span
                    class="absolute left-1/2 -bottom-2 -translate-x-1/2 w-16 h-1 bg-primary"
                ></span>

            </h2>


            <p
                class="text-gray-500 mt-4 text-sm md:text-base"
            >
                Comprehensive and transparent design solutions tailored for your space.
            </p>

        </div>



        <!-- =================================================
             DYNAMIC SERVICE GRID
        ================================================== -->

        <div
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6"
        >


            @forelse($services as $service)


                <!-- =================================================
                     SERVICE CARD
                ================================================== -->

                <div
                    class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-xl transition flex flex-col justify-between border border-gray-100"
                >


                    <div>


                        <!-- SERVICE IMAGE -->

                        <div
                            class="h-48 overflow-hidden service-image-placeholder"
                        >

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
                                        class="w-full h-full object-cover hover:scale-105 transition duration-500"
                                    >

                                @else

                                    <img
                                        src="{{ asset('storage/' . $service->image) }}"
                                        alt="{{ $service->name }}"
                                        class="w-full h-full object-cover hover:scale-105 transition duration-500"
                                    >

                                @endif

                            @else

                                <div
                                    class="w-full h-full flex items-center justify-center text-gray-400"
                                >

                                    <div class="text-center">

                                        <i
                                            class="fa-solid fa-house-chimney text-4xl mb-2"
                                        ></i>

                                        <p class="text-xs">
                                            No Image
                                        </p>

                                    </div>

                                </div>

                            @endif

                        </div>



                        <!-- SERVICE INFORMATION -->

                        <div class="p-5">


                            <!-- SERVICE NAME -->

                            <h3
                                class="text-lg font-semibold text-gray-900 mb-2"
                            >
                                {{ $service->name }}
                            </h3>



                            <!-- SHORT DESCRIPTION -->

                            <p
                                class="text-gray-600 text-xs mb-4 leading-relaxed"
                            >

                                {{ $service->short_description
                                    ?: \Illuminate\Support\Str::limit(
                                        $service->description,
                                        120
                                    )
                                    ?: 'Professional interior design service tailored to your space and requirements.'
                                }}

                            </p>



                            <!-- SERVICE META -->

                            <div
                                class="border-t border-gray-100 pt-3 space-y-1.5 text-xs text-gray-500"
                            >


                                <!-- STARTING BUDGET -->

                                @if($service->starting_budget !== null)

                                    <p
                                        class="flex justify-between gap-3"
                                    >

                                        <span
                                            class="font-medium text-gray-700"
                                        >
                                            Starting Budget:
                                        </span>


                                        <span
                                            class="text-primary font-semibold text-right"
                                        >

                                            ৳{{ number_format(
                                                $service->starting_budget,
                                                2
                                            ) }}

                                        </span>

                                    </p>

                                @else

                                    <p
                                        class="flex justify-between"
                                    >

                                        <span
                                            class="font-medium text-gray-700"
                                        >
                                            Budget:
                                        </span>

                                        <span>
                                            Contact Us
                                        </span>

                                    </p>

                                @endif



                                <!-- ESTIMATED DURATION -->

                                @if($service->estimated_duration_days)

                                    <p
                                        class="flex justify-between"
                                    >

                                        <span
                                            class="font-medium text-gray-700"
                                        >
                                            Approx. Time:
                                        </span>


                                        <span>

                                            {{ $service->estimated_duration_days }}

                                            {{ $service->estimated_duration_days == 1 ? 'Day' : 'Days' }}

                                        </span>

                                    </p>

                                @endif


                            </div>


                        </div>

                    </div>



                    <!-- =================================================
                         SERVICE BUTTONS
                    ================================================== -->

                    <div
                        class="p-5 pt-0 grid grid-cols-2 gap-2"
                    >


                        <!-- VIEW DETAILS -->

                        <a
                            href="{{ route('services.show', $service->slug) }}"
                            class="w-full py-2 border border-primary text-primary hover:bg-primary hover:text-white rounded text-xs font-semibold text-center transition"
                        >
                            View Details
                        </a>



                        <!-- GET QUOTE -->

                        <a
                            href="{{ route('customer.register', [
                                'service' => $service->slug
                            ]) }}"
                            class="w-full py-2 bg-primary hover:bg-primary-dark text-white rounded text-xs font-semibold text-center transition"
                        >
                            Get Quote
                        </a>


                    </div>


                </div>


            @empty


                <!-- =================================================
                     NO SERVICE
                ================================================== -->

                <div
                    class="col-span-1 md:col-span-2 lg:col-span-4 text-center py-16"
                >

                    <div
                        class="text-gray-400"
                    >

                        <i
                            class="fa-solid fa-layer-group text-5xl mb-4"
                        ></i>


                        <h3
                            class="text-lg font-semibold text-gray-600"
                        >
                            No Services Available
                        </h3>


                        <p
                            class="text-sm mt-2"
                        >
                            Our services will appear here soon.
                        </p>

                    </div>

                </div>


            @endforelse


        </div>

    </section>



    <!-- =====================================================
         GALLERY SECTION
    ====================================================== -->

<!-- =====================================================
     PREVIOUS WORK / PORTFOLIO SECTION
     DYNAMIC FROM DATABASE
====================================================== -->

<section
    id="gallery"
    class="py-24 px-6 lg:px-16 bg-white"
>

    <!-- =================================================
         SECTION HEADER
    ================================================== -->

    <div
        class="text-center max-w-2xl mx-auto mb-16"
    >

        <h2
            class="text-3xl md:text-4xl font-bold text-gray-900 mb-3 relative inline-block"
        >

            Previous Work

            <span
                class="absolute left-1/2 -bottom-2 -translate-x-1/2 w-16 h-1 bg-primary"
            ></span>

        </h2>


        <p
            class="text-gray-500 mt-4 text-sm md:text-base"
        >
            A glimpse into our recent design transformations.
        </p>

    </div>



    <!-- =================================================
         DYNAMIC PREVIOUS WORK GRID
    ================================================== -->

    <div
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
    >

        @forelse($previousWorks as $previousWork)

            @php

                $mainImage =
                    $previousWork->images->first();

            @endphp


            <!-- =================================================
                 CLICKABLE PREVIOUS WORK CARD
            ================================================== -->

            <a
                href="{{ route(
                    'previous-works.show',
                    $previousWork->slug
                ) }}"
                class="group block relative overflow-hidden rounded-lg bg-white shadow-sm border border-gray-100 hover:shadow-xl transition duration-300"
            >


                <!-- =================================================
                     IMAGE
                ================================================== -->

                <div
                    class="relative h-72 overflow-hidden bg-gray-100"
                >

                    @if($mainImage)

                        <img
                            src="{{ asset(
                                'storage/' . $mainImage->image
                            ) }}"
                            alt="{{ $previousWork->title }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                        >

                    @else

                        <div
                            class="w-full h-full flex flex-col items-center justify-center text-gray-400"
                        >

                            <i
                                class="fa-regular fa-images text-4xl mb-3"
                            ></i>


                            <p class="text-xs">
                                No Image
                            </p>

                        </div>

                    @endif



                    <!-- =================================================
                         HOVER OVERLAY
                    ================================================== -->

                    <div
                        class="absolute inset-0 bg-primary/90 flex flex-col justify-center items-center text-white opacity-0 group-hover:opacity-100 transition duration-300 p-6 text-center"
                    >

                        <h3
                            class="text-xl font-semibold mb-2"
                        >
                            {{ $previousWork->title }}
                        </h3>


                        @if($previousWork->location)

                            <p
                                class="text-sm font-light text-blue-100 mb-3"
                            >

                                <i
                                    class="fa-solid fa-location-dot mr-1"
                                ></i>

                                {{ $previousWork->location }}

                            </p>

                        @endif


                        @if($previousWork->description)

                            <p
                                class="text-xs leading-relaxed text-blue-50 max-w-sm"
                            >

                                {{ \Illuminate\Support\Str::limit(
                                    $previousWork->description,
                                    180
                                ) }}

                            </p>

                        @endif


                        <!-- VIEW PROJECT -->

                        <span
                            class="mt-5 inline-flex items-center gap-2 bg-white text-primary px-4 py-2 rounded-lg text-xs font-semibold"
                        >

                            View Project

                            <i
                                class="fa-solid fa-arrow-right"
                            ></i>

                        </span>

                    </div>

                </div>



                <!-- =================================================
                     WORK INFORMATION
                ================================================== -->

                <div class="p-5">


                    <!-- TITLE -->

                    <h3
                        class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-primary transition"
                    >

                        {{ $previousWork->title }}

                    </h3>



                    <!-- LOCATION -->

                    @if($previousWork->location)

                        <p
                            class="text-xs text-gray-500 mb-3"
                        >

                            <i
                                class="fa-solid fa-location-dot text-primary mr-1"
                            ></i>

                            {{ $previousWork->location }}

                        </p>

                    @endif



                    <!-- DESCRIPTION -->

                    @if($previousWork->description)

                        <p
                            class="text-sm text-gray-500 leading-relaxed"
                        >

                            {{ \Illuminate\Support\Str::limit(
                                $previousWork->description,
                                120
                            ) }}

                        </p>

                    @else

                        <p
                            class="text-sm text-gray-400"
                        >
                            Professional interior design project.
                        </p>

                    @endif



                    <!-- =================================================
                         BOTTOM INFORMATION
                    ================================================== -->

                    <div
                        class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between"
                    >

                        <!-- IMAGE COUNT -->

                        <span
                            class="text-xs text-gray-500"
                        >

                            <i
                                class="fa-regular fa-images text-primary mr-1"
                            ></i>

                            {{ $previousWork->images->count() }}

                            {{ $previousWork->images->count() == 1
                                ? 'Image'
                                : 'Images'
                            }}

                        </span>



                        <!-- VIEW -->

                        <span
                            class="text-xs font-semibold text-primary group-hover:underline"
                        >

                            View Project

                            <i
                                class="fa-solid fa-arrow-right ml-1"
                            ></i>

                        </span>

                    </div>

                </div>

            </a>


        @empty


            <!-- =================================================
                 NO PREVIOUS WORK
            ================================================== -->

            <div
                class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-16"
            >

                <div
                    class="text-gray-400"
                >

                    <i
                        class="fa-regular fa-images text-5xl mb-4"
                    ></i>


                    <h3
                        class="text-lg font-semibold text-gray-600"
                    >
                        No Previous Works Available
                    </h3>


                    <p
                        class="text-sm mt-2"
                    >
                        Our completed projects will appear here soon.
                    </p>

                </div>

            </div>


        @endforelse

    </div>

</section>


    <!-- =====================================================
         CONTACT SECTION
    ====================================================== -->

    <section
        id="contact"
        class="py-24 px-6 lg:px-16 bg-offwhite"
    >

        <div
            class="text-center max-w-2xl mx-auto mb-16"
        >

            <h2
                class="text-3xl md:text-4xl font-bold text-gray-900 mb-3 relative inline-block"
            >

                Get In Touch

                <span
                    class="absolute left-1/2 -bottom-2 -translate-x-1/2 w-16 h-1 bg-primary"
                ></span>

            </h2>


            <p
                class="text-gray-500 mt-4 text-sm md:text-base"
            >
                Let's discuss your next dream interior project.
            </p>

        </div>



        <div
            class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 bg-white p-8 md:p-12 rounded-xl shadow-sm border border-gray-100"
        >


            <!-- CONTACT DETAILS -->

            <div
                class="flex flex-col justify-center space-y-8"
            >


                <div
                    class="flex items-start space-x-4"
                >

                    <div
                        class="text-primary text-xl mt-1"
                    >
                        <i class="fa-solid fa-location-dot"></i>
                    </div>


                    <div>

                        <h4
                            class="font-semibold text-gray-900 text-base"
                        >
                            Our Location
                        </h4>


                        <p
                            class="text-gray-500 text-sm mt-1"
                        >
                            House 12, Road 5, Gulshan-1, Dhaka
                        </p>

                    </div>

                </div>



                <div
                    class="flex items-start space-x-4"
                >

                    <div
                        class="text-primary text-xl mt-1"
                    >
                        <i class="fa-solid fa-envelope"></i>
                    </div>


                    <div>

                        <h4
                            class="font-semibold text-gray-900 text-base"
                        >
                            Email Us
                        </h4>


                        <p
                            class="text-gray-500 text-sm mt-1"
                        >
                            info@canvasandcorner.com
                        </p>

                    </div>

                </div>



                <div
                    class="flex items-start space-x-4"
                >

                    <div
                        class="text-primary text-xl mt-1"
                    >
                        <i class="fa-solid fa-phone"></i>
                    </div>


                    <div>

                        <h4
                            class="font-semibold text-gray-900 text-base"
                        >
                            Call Us
                        </h4>


                        <p
                            class="text-gray-500 text-sm mt-1"
                        >
                            +880 1234 567890
                        </p>

                    </div>

                </div>


            </div>



            <!-- CONTACT FORM -->

           


        </div>

    </section>



    <!-- =====================================================
         FOOTER
    ====================================================== -->

    <footer
        class="bg-gray-900 text-white py-8 text-center text-xs font-light"
    >

        <p>
            &copy; {{ date('Y') }} Canvas & Corner Interiors.
            All Rights Reserved.
        </p>

    </footer>


</body>

</html>