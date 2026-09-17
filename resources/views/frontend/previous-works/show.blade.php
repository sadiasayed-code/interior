<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        {{ $previousWork->title }} - Canvas & Corner Interiors
    </title>


    <!-- Tailwind CSS -->
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


    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >


    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    >


    <style>

        body {
            font-family: 'Poppins', sans-serif;
        }

        .gallery-thumb {
            transition: all 0.25s ease;
        }

        .gallery-thumb:hover {
            transform: translateY(-2px);
        }

        .gallery-thumb.active {
            border-color: #0056b3;
            box-shadow: 0 0 0 2px rgba(0, 86, 179, 0.15);
        }

        .main-gallery-image {
            transition: opacity 0.2s ease;
        }

    </style>

</head>


<body class="bg-white text-gray-800 antialiased">


    <!-- =====================================================
         HEADER / NAVIGATION
    ====================================================== -->

    <header
        class="fixed top-0 left-0 w-full bg-white/95 backdrop-blur-md shadow-sm z-50 px-6 lg:px-16 py-4"
    >

        <div
            class="flex justify-between items-center"
        >

            <!-- LOGO -->

            <a
                href="/"
                class="text-xl font-bold text-primary tracking-tight"
            >

                Canvas & Corner

                <span
                    class="text-gray-800 font-light text-sm block tracking-normal"
                >
                    Interiors
                </span>

            </a>


            <!-- NAVIGATION -->

            <nav
                class="hidden md:flex space-x-8 font-medium text-sm text-gray-700"
            >

                <a
                    href="/#home"
                    class="hover:text-primary transition"
                >
                    Home
                </a>


                <a
                    href="/#services"
                    class="hover:text-primary transition"
                >
                    Services
                </a>


                <a
                    href="/#gallery"
                    class="text-primary font-semibold"
                >
                    Portfolio
                </a>


                <a
                    href="/#contact"
                    class="hover:text-primary transition"
                >
                    Contact
                </a>

            </nav>


            <!-- CONSULTATION BUTTON -->

            <a
                href="/#contact"
                class="hidden md:inline-block bg-primary hover:bg-primary-dark text-white text-sm font-medium px-5 py-2.5 rounded transition shadow-sm"
            >
                Book Consultation
            </a>

        </div>

    </header>



    <!-- =====================================================
         PAGE CONTENT
    ====================================================== -->

    <main
        class="pt-32 pb-24 px-6 lg:px-16"
    >

        <div
            class="max-w-6xl mx-auto"
        >


            <!-- =================================================
                 BACK TO PORTFOLIO
            ================================================== -->

            <a
                href="/#gallery"
                class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-primary transition mb-8"
            >

                <i class="fa-solid fa-arrow-left"></i>

                Back to Previous Works

            </a>



            <!-- =================================================
                 PROJECT HEADER
            ================================================== -->

            <div
                class="mb-10"
            >

                <div
                    class="flex flex-wrap items-center gap-3 mb-4"
                >

                    @if($previousWork->location)

                        <span
                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 text-primary rounded-full text-xs font-medium"
                        >

                            <i class="fa-solid fa-location-dot"></i>

                            {{ $previousWork->location }}

                        </span>

                    @endif


                    <span
                        class="inline-flex items-center gap-2 px-3 py-1.5 bg-gray-100 text-gray-600 rounded-full text-xs font-medium"
                    >

                        <i class="fa-regular fa-images"></i>

                        {{ $previousWork->images->count() }}

                        {{ $previousWork->images->count() == 1 ? 'Image' : 'Images' }}

                    </span>

                </div>


                <h1
                    class="text-3xl md:text-5xl font-bold text-gray-900 leading-tight"
                >
                    {{ $previousWork->title }}
                </h1>

            </div>



            <!-- =================================================
                 GALLERY
            ================================================== -->

            @if($previousWork->images->count() > 0)

                <div
                    class="grid grid-cols-1 lg:grid-cols-12 gap-5"
                >


                    <!-- =============================================
                         MAIN IMAGE
                    ============================================== -->

                    <div
                        class="lg:col-span-9"
                    >

                        <div
                            class="relative bg-gray-100 rounded-2xl overflow-hidden shadow-sm"
                        >

                            <img
                                id="mainGalleryImage"
                                src="{{ asset('storage/' . $previousWork->images->first()->image) }}"
                                alt="{{ $previousWork->title }}"
                                class="main-gallery-image w-full h-[420px] md:h-[550px] object-cover"
                            >


                            <!-- IMAGE COUNTER -->

                            <div
                                class="absolute bottom-4 right-4 bg-black/70 text-white px-3 py-1.5 rounded-full text-xs"
                            >

                                <span id="currentImageNumber">
                                    1
                                </span>

                                /

                                {{ $previousWork->images->count() }}

                            </div>

                        </div>

                    </div>



                    <!-- =============================================
                         THUMBNAILS
                    ============================================== -->

                    <div
                        class="lg:col-span-3"
                    >

                        <div
                            class="grid grid-cols-2 lg:grid-cols-1 gap-4"
                        >

                            @foreach($previousWork->images as $index => $image)

                                <button
                                    type="button"
                                    class="gallery-thumb {{ $index === 0 ? 'active' : '' }} border-2 border-transparent rounded-xl overflow-hidden bg-gray-100 focus:outline-none"
                                    data-image="{{ asset('storage/' . $image->image) }}"
                                    data-index="{{ $index + 1 }}"
                                >

                                    <img
                                        src="{{ asset('storage/' . $image->image) }}"
                                        alt="{{ $previousWork->title }} - Image {{ $index + 1 }}"
                                        class="w-full h-28 lg:h-32 object-cover"
                                    >

                                </button>

                            @endforeach

                        </div>

                    </div>

                </div>

            @else

                <!-- =============================================
                     NO IMAGE
                ============================================== -->

                <div
                    class="w-full h-96 bg-gray-100 rounded-2xl flex flex-col items-center justify-center text-gray-400"
                >

                    <i
                        class="fa-regular fa-images text-5xl mb-4"
                    ></i>

                    <p class="text-sm">
                        No gallery images available.
                    </p>

                </div>

            @endif



            <!-- =================================================
                 PROJECT INFORMATION
            ================================================== -->

            <div
                class="grid grid-cols-1 lg:grid-cols-3 gap-10 mt-14"
            >


                <!-- =============================================
                     DESCRIPTION
                ============================================== -->

                <div
                    class="lg:col-span-2"
                >

                    <h2
                        class="text-2xl font-bold text-gray-900 mb-5"
                    >

                        Project Description

                        <span
                            class="block mt-2 w-12 h-1 bg-primary"
                        ></span>

                    </h2>


                    @if($previousWork->description)

                        <div
                            class="text-gray-600 text-sm md:text-base leading-8"
                        >
                            {!! nl2br(e($previousWork->description)) !!}
                        </div>

                    @else

                        <p
                            class="text-gray-400 text-sm"
                        >
                            No description available for this project.
                        </p>

                    @endif

                </div>



                <!-- =============================================
                     PROJECT DETAILS
                ============================================== -->

                <div>

                    <div
                        class="bg-offwhite rounded-xl border border-gray-100 p-6"
                    >

                        <h3
                            class="text-lg font-semibold text-gray-900 mb-5"
                        >
                            Project Details
                        </h3>


                        <!-- LOCATION -->

                        @if($previousWork->location)

                            <div
                                class="flex items-start gap-4 pb-5 mb-5 border-b border-gray-200"
                            >

                                <div
                                    class="w-10 h-10 rounded-lg bg-blue-50 text-primary flex items-center justify-center flex-shrink-0"
                                >

                                    <i
                                        class="fa-solid fa-location-dot"
                                    ></i>

                                </div>


                                <div>

                                    <p
                                        class="text-xs text-gray-400 mb-1"
                                    >
                                        Location
                                    </p>

                                    <p
                                        class="text-sm font-medium text-gray-800"
                                    >
                                        {{ $previousWork->location }}
                                    </p>

                                </div>

                            </div>

                        @endif



                        <!-- GALLERY -->

                        <div
                            class="flex items-start gap-4 pb-5 mb-5 border-b border-gray-200"
                        >

                            <div
                                class="w-10 h-10 rounded-lg bg-blue-50 text-primary flex items-center justify-center flex-shrink-0"
                            >

                                <i
                                    class="fa-regular fa-images"
                                ></i>

                            </div>


                            <div>

                                <p
                                    class="text-xs text-gray-400 mb-1"
                                >
                                    Gallery
                                </p>

                                <p
                                    class="text-sm font-medium text-gray-800"
                                >

                                    {{ $previousWork->images->count() }}

                                    {{ $previousWork->images->count() == 1 ? 'Image' : 'Images' }}

                                </p>

                            </div>

                        </div>



                        <!-- STATUS -->

                        <div
                            class="flex items-start gap-4"
                        >

                            <div
                                class="w-10 h-10 rounded-lg bg-green-50 text-green-600 flex items-center justify-center flex-shrink-0"
                            >

                                <i
                                    class="fa-solid fa-circle-check"
                                ></i>

                            </div>


                            <div>

                                <p
                                    class="text-xs text-gray-400 mb-1"
                                >
                                    Project Status
                                </p>

                                <p
                                    class="text-sm font-medium text-green-600"
                                >
                                    Completed Work
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>



            <!-- =================================================
                 CTA
            ================================================== -->

            <div
                class="mt-16 bg-primary rounded-2xl px-6 py-10 md:px-12 text-center text-white"
            >

                <h2
                    class="text-2xl md:text-3xl font-bold mb-3"
                >
                    Have a Similar Project in Mind?
                </h2>


                <p
                    class="text-blue-100 text-sm md:text-base mb-7"
                >
                    Let's create a beautiful interior space tailored to your needs.
                </p>


                <a
                    href="/#services"
                    class="inline-flex items-center gap-2 bg-white text-primary hover:bg-blue-50 font-semibold px-6 py-3 rounded-lg transition"
                >

                    Book a Service

                    <i class="fa-solid fa-arrow-right"></i>

                </a>

            </div>

        </div>

    </main>



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



    <!-- =====================================================
         GALLERY JAVASCRIPT
    ====================================================== -->

    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                const mainImage =
                    document.getElementById(
                        'mainGalleryImage'
                    );

                const currentNumber =
                    document.getElementById(
                        'currentImageNumber'
                    );

                const thumbnails =
                    document.querySelectorAll(
                        '.gallery-thumb'
                    );


                thumbnails.forEach(
                    function (thumbnail) {

                        thumbnail.addEventListener(
                            'click',
                            function () {

                                const image =
                                    this.dataset.image;

                                const index =
                                    this.dataset.index;


                                /*
                                |--------------------------------------------------------------------------
                                | Change Main Image
                                |--------------------------------------------------------------------------
                                */

                                mainImage.style.opacity = '0';


                                setTimeout(
                                    function () {

                                        mainImage.src =
                                            image;

                                        mainImage.style.opacity = '1';

                                    },
                                    150
                                );


                                /*
                                |--------------------------------------------------------------------------
                                | Change Counter
                                |--------------------------------------------------------------------------
                                */

                                currentNumber.textContent =
                                    index;


                                /*
                                |--------------------------------------------------------------------------
                                | Active Thumbnail
                                |--------------------------------------------------------------------------
                                */

                                thumbnails.forEach(
                                    function (item) {

                                        item.classList.remove(
                                            'active'
                                        );

                                    }
                                );


                                this.classList.add(
                                    'active'
                                );

                            }
                        );

                    }
                );

            }
        );

    </script>


</body>

</html>