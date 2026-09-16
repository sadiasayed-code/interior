<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canvas & Corner Interiors - Modern Interior Design</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0056b3',
                        'primary-dark': '#003d82',
                        'offwhite': '#f9fbfc',
                    }
                }
            }
        }
    </script>
    <!-- Google Fonts & FontAwesome -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-white text-gray-800 antialiased">

    <!-- Header / Navigation Bar -->
    <header class="fixed top-0 left-0 w-full bg-white/90 backdrop-blur-md shadow-sm z-50 px-6 lg:px-16 py-4 flex justify-between items-center">
        <a href="#home" class="text-xl font-bold text-primary tracking-tight">
            Canvas & Corner <span class="text-gray-800 font-light text-sm block tracking-normal">Interiors</span>
        </a>
        <nav class="hidden md:flex space-x-8 font-medium text-sm text-gray-700">
            <a href="#home" class="hover:text-primary transition">Home</a>
            <a href="#services" class="hover:text-primary transition">Services</a>
            <a href="#gallery" class="hover:text-primary transition">Portfolio</a>
            <a href="#contact" class="hover:text-primary transition">Contact</a>
        </nav>
        <a href="#contact" class="hidden md:inline-block bg-primary hover:bg-primary-dark text-white text-sm font-medium px-5 py-2.5 rounded transition shadow-sm">
            Book Consultation
        </a>
    </header>

    <!-- 1. Hero / Banner Section (Full Width & Height) -->
    <section id="home" class="relative w-full h-screen bg-cover bg-center flex flex-col justify-center items-center text-center px-4" style="background-image: linear-gradient(rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.45)), url('https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=1920&q=80');">
        <h1 class="text-4xl md:text-6xl font-bold text-white max-w-4xl mb-6 leading-tight">
            Crafting timeless interiors with modern elegance
        </h1>
        <p class="text-lg text-gray-200 max-w-xl mb-8 font-light">
            Elevate your lifestyle with exquisite interior designs tailored uniquely to your taste, comfort, and space.
        </p>
        <a href="#contact" class="bg-primary hover:bg-primary-dark text-white font-semibold px-8 py-4 rounded transition shadow-lg transform hover:-translate-y-0.5">
            Get Started
        </a>
    </section>

    <!-- 2. Services Section (4 Column Cards with Image, Budget, Time, & 2 Buttons) -->
    <section id="services" class="py-24 px-6 lg:px-16 bg-offwhite">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3 relative inline-block">
                Our Services
                <span class="absolute left-1/2 -bottom-2 -translate-x-1/2 w-16 h-1 bg-primary"></span>
            </h2>
            <p class="text-gray-500 mt-4 text-sm md:text-base">Comprehensive and transparent design solutions tailored for your space.</p>
        </div>

        <!-- 4 Column Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Service Card 1 -->
            <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-xl transition flex flex-col justify-between border border-gray-100">
                <div>
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=600&q=80" alt="Living Room" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Living Room Design</h3>
                        <p class="text-gray-600 text-xs mb-4 leading-relaxed">Create welcoming, stylish, and functional living areas tailored for comfort and modern gatherings.</p>
                        <div class="border-t border-gray-100 pt-3 space-y-1.5 text-xs text-gray-500">
                            <p class="flex justify-between"><span class="font-medium text-gray-700">Est. Budget:</span> <span class="text-primary font-semibold">$2,500 - $6,000</span></p>
                            <p class="flex justify-between"><span class="font-medium text-gray-700">Approx. Time:</span> <span>3 - 5 Weeks</span></p>
                        </div>
                    </div>
                </div>
                <div class="p-5 pt-0 grid grid-cols-2 gap-2">
                    <button onclick="alert('Viewing details for Living Room Design')" class="w-full py-2 border border-primary text-primary hover:bg-primary hover:text-white rounded text-xs font-semibold transition">
                        View Details
                    </button>
                    <a href="#contact" class="w-full py-2 bg-primary hover:bg-primary-dark text-white rounded text-xs font-semibold text-center transition">
                        Get Quote
                    </a>
                </div>
            </div>

            <!-- Service Card 2 -->
            <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-xl transition flex flex-col justify-between border border-gray-100">
                <div>
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1556911220-e15b29be8c8f?auto=format&fit=crop&w=600&q=80" alt="Modular Kitchen" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Modular Kitchen</h3>
                        <p class="text-gray-600 text-xs mb-4 leading-relaxed">Optimize your culinary workspace with sleek, space-efficient, and contemporary kitchen layouts.</p>
                        <div class="border-t border-gray-100 pt-3 space-y-1.5 text-xs text-gray-500">
                            <p class="flex justify-between"><span class="font-medium text-gray-700">Est. Budget:</span> <span class="text-primary font-semibold">$4,000 - $10,000</span></p>
                            <p class="flex justify-between"><span class="font-medium text-gray-700">Approx. Time:</span> <span>4 - 6 Weeks</span></p>
                        </div>
                    </div>
                </div>
                <div class="p-5 pt-0 grid grid-cols-2 gap-2">
                    <button onclick="alert('Viewing details for Modular Kitchen')" class="w-full py-2 border border-primary text-primary hover:bg-primary hover:text-white rounded text-xs font-semibold transition">
                        View Details
                    </button>
                    <a href="#contact" class="w-full py-2 bg-primary hover:bg-primary-dark text-white rounded text-xs font-semibold text-center transition">
                        Get Quote
                    </a>
                </div>
            </div>

            <!-- Service Card 3 -->
            <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-xl transition flex flex-col justify-between border border-gray-100">
                <div>
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1595526114035-0d45ed16cfbf?auto=format&fit=crop&w=600&q=80" alt="Bedroom Styling" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Bedroom Styling</h3>
                        <p class="text-gray-600 text-xs mb-4 leading-relaxed">Design peaceful, serene personal retreats optimized for relaxation and restorative sleep.</p>
                        <div class="border-t border-gray-100 pt-3 space-y-1.5 text-xs text-gray-500">
                            <p class="flex justify-between"><span class="font-medium text-gray-700">Est. Budget:</span> <span class="text-primary font-semibold">$2,000 - $4,500</span></p>
                            <p class="flex justify-between"><span class="font-medium text-gray-700">Approx. Time:</span> <span>2 - 4 Weeks</span></p>
                        </div>
                    </div>
                </div>
                <div class="p-5 pt-0 grid grid-cols-2 gap-2">
                    <button onclick="alert('Viewing details for Bedroom Styling')" class="w-full py-2 border border-primary text-primary hover:bg-primary hover:text-white rounded text-xs font-semibold transition">
                        View Details
                    </button>
                    <a href="#contact" class="w-full py-2 bg-primary hover:bg-primary-dark text-white rounded text-xs font-semibold text-center transition">
                        Get Quote
                    </a>
                </div>
            </div>

            <!-- Service Card 4 -->
            <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-xl transition flex flex-col justify-between border border-gray-100">
                <div>
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=600&q=80" alt="Office Interiors" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Office Interiors</h3>
                        <p class="text-gray-600 text-xs mb-4 leading-relaxed">Build inspiring, productive commercial spaces that reflect your brand identity and corporate culture.</p>
                        <div class="border-t border-gray-100 pt-3 space-y-1.5 text-xs text-gray-500">
                            <p class="flex justify-between"><span class="font-medium text-gray-700">Est. Budget:</span> <span class="text-primary font-semibold">$6,000 - $15,000+</span></p>
                            <p class="flex justify-between"><span class="font-medium text-gray-700">Approx. Time:</span> <span>6 - 10 Weeks</span></p>
                        </div>
                    </div>
                </div>
                <div class="p-5 pt-0 grid grid-cols-2 gap-2">
                    <button onclick="alert('Viewing details for Office Interiors')" class="w-full py-2 border border-primary text-primary hover:bg-primary hover:text-white rounded text-xs font-semibold transition">
                        View Details
                    </button>
                    <a href="#contact" class="w-full py-2 bg-primary hover:bg-primary-dark text-white rounded text-xs font-semibold text-center transition">
                        Get Quote
                    </a>
                </div>
            </div>

        </div>
    </section>

    <!-- 3. Gallery Section (Previous Work) -->
    <section id="gallery" class="py-24 px-6 lg:px-16 bg-white">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3 relative inline-block">
                Previous Work
                <span class="absolute left-1/2 -bottom-2 -translate-x-1/2 w-16 h-1 bg-primary"></span>
            </h2>
            <p class="text-gray-500 mt-4 text-sm md:text-base">A glimpse into our recent design transformations.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Gallery Item 1 -->
            <div class="relative group overflow-hidden rounded-lg h-72 shadow-sm">
                <img src="https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=800&q=80" alt="Minimalist Living" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                <div class="absolute inset-0 bg-primary/85 flex flex-col justify-center items-center text-white opacity-0 group-hover:opacity-100 transition duration-300 p-6 text-center">
                    <h3 class="text-lg font-semibold mb-1">Minimalist Living Room</h3>
                    <p class="text-xs font-light text-blue-100">Urban Residence, Dhaka</p>
                </div>
            </div>

            <!-- Gallery Item 2 -->
            <div class="relative group overflow-hidden rounded-lg h-72 shadow-sm">
                <img src="https://images.unsplash.com/photo-1556911220-e15b29be8c8f?auto=format&fit=crop&w=800&q=80" alt="Contemporary Kitchen" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                <div class="absolute inset-0 bg-primary/85 flex flex-col justify-center items-center text-white opacity-0 group-hover:opacity-100 transition duration-300 p-6 text-center">
                    <h3 class="text-lg font-semibold mb-1">Contemporary Kitchen</h3>
                    <p class="text-xs font-light text-blue-100">Gulshan Villa</p>
                </div>
            </div>

            <!-- Gallery Item 3 -->
            <div class="relative group overflow-hidden rounded-lg h-72 shadow-sm">
                <img src="https://images.unsplash.com/photo-1595526114035-0d45ed16cfbf?auto=format&fit=crop&w=800&q=80" alt="Master Bedroom" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                <div class="absolute inset-0 bg-primary/85 flex flex-col justify-center items-center text-white opacity-0 group-hover:opacity-100 transition duration-300 p-6 text-center">
                    <h3 class="text-lg font-semibold mb-1">Master Bedroom Suite</h3>
                    <p class="text-xs font-light text-blue-100">Banani Apartment</p>
                </div>
            </div>

            <!-- Gallery Item 4 -->
            <div class="relative group overflow-hidden rounded-lg h-72 shadow-sm">
                <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80" alt="Creative Office" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                <div class="absolute inset-0 bg-primary/85 flex flex-col justify-center items-center text-white opacity-0 group-hover:opacity-100 transition duration-300 p-6 text-center">
                    <h3 class="text-lg font-semibold mb-1">Creative Office Space</h3>
                    <p class="text-xs font-light text-blue-100">Tech Hub Office</p>
                </div>
            </div>

            <!-- Gallery Item 5 -->
            <div class="relative group overflow-hidden rounded-lg h-72 shadow-sm">
                <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=800&q=80" alt="Dining Area" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                <div class="absolute inset-0 bg-primary/85 flex flex-col justify-center items-center text-white opacity-0 group-hover:opacity-100 transition duration-300 p-6 text-center">
                    <h3 class="text-lg font-semibold mb-1">Elegant Dining Area</h3>
                    <p class="text-xs font-light text-blue-100">Dhanmondi Residence</p>
                </div>
            </div>

            <!-- Gallery Item 6 -->
            <div class="relative group overflow-hidden rounded-lg h-72 shadow-sm">
                <img src="https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=800&q=80" alt="Bathroom" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                <div class="absolute inset-0 bg-primary/85 flex flex-col justify-center items-center text-white opacity-0 group-hover:opacity-100 transition duration-300 p-6 text-center">
                    <h3 class="text-lg font-semibold mb-1">Luxury Spa Bathroom</h3>
                    <p class="text-xs font-light text-blue-100">Uttara Penthouse</p>
                </div>
            </div>

        </div>
    </section>

    <!-- 4. Contact Section -->
    <section id="contact" class="py-24 px-6 lg:px-16 bg-offwhite">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3 relative inline-block">
                Get In Touch
                <span class="absolute left-1/2 -bottom-2 -translate-x-1/2 w-16 h-1 bg-primary"></span>
            </h2>
            <p class="text-gray-500 mt-4 text-sm md:text-base">Let's discuss your next dream interior project.</p>
        </div>

        <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 bg-white p-8 md:p-12 rounded-xl shadow-sm border border-gray-100">
            <!-- Contact Details -->
            <div class="flex flex-col justify-center space-y-8">
                <div class="flex items-start space-x-4">
                    <div class="text-primary text-xl mt-1"><i class="fa-solid fa-location-dot"></i></div>
                    <div>
                        <h4 class="font-semibold text-gray-900 text-base">Our Location</h4>
                        <p class="text-gray-500 text-sm mt-1">House 12, Road 5, Gulshan-1, Dhaka</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <div class="text-primary text-xl mt-1"><i class="fa-solid fa-envelope"></i></div>
                    <div>
                        <h4 class="font-semibold text-gray-900 text-base">Email Us</h4>
                        <p class="text-gray-500 text-sm mt-1">info@canvasandcorner.com</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <div class="text-primary text-xl mt-1"><i class="fa-solid fa-phone"></i></div>
                    <div>
                        <h4 class="font-semibold text-gray-900 text-base">Call Us</h4>
                        <p class="text-gray-500 text-sm mt-1">+880 1234 567890</p>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <form class="space-y-4" onsubmit="event.preventDefault(); alert('Thank you! We will get back to you soon.');">
                <div>
                    <input type="text" placeholder="Your Name" required class="w-full px-4 py-3 border border-gray-200 rounded focus:outline-none focus:border-primary text-sm bg-gray-50/50">
                </div>
                <div>
                    <input type="email" placeholder="Your Email" required class="w-full px-4 py-3 border border-gray-200 rounded focus:outline-none focus:border-primary text-sm bg-gray-50/50">
                </div>
                <div>
                    <textarea placeholder="Tell us about your project..." required rows="4" class="w-full px-4 py-3 border border-gray-200 rounded focus:outline-none focus:border-primary text-sm bg-gray-50/50 resize-none"></textarea>
                </div>
                <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-3.5 rounded transition shadow-sm text-sm">
                    Send Message
                </button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8 text-center text-xs font-light">
        <p>&copy; 2026 Canvas & Corner Interiors. All Rights Reserved.</p>
    </footer>

</body>
</html>