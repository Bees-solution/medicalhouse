@extends('layouts.app')

@section('title', 'Shanthi Medical Home')

@section('content')

    <!-- Hero Section (Carousel) -->
    <div class="carousel-container w-full h-[60vh] md:h-[90vh] overflow-hidden relative">
        <div class="carousel">
            <div><img src="images/ad1.jpg" alt="Ad 1" class="w-full h-[60vh] md:h-[90vh] object-cover"></div>
            <div><img src="images/ad2.jpg" alt="Ad 2" class="w-full h-[60vh] md:h-[90vh] object-cover"></div>
            <div><img src="images/ad3.jpg" alt="Ad 3" class="w-full h-[60vh] md:h-[90vh] object-cover"></div>
        </div>
        {{-- <div class="carousel-overlay absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center bg-black bg-opacity-50 px-6 py-4 rounded text-white">
            <h1 class="text-lg md:text-3xl font-bold">Welcome to Shanthi Medical Home</h1>
            <p class="text-sm md:text-lg">Providing world-class healthcare with cutting-edge technology.</p>
        </div> --}}
    </div>

    <div>
        <section class="relative w-full flex items-center bg-gradient-to-r from-white to-blue-100">
            <!-- Left Side Image - Full Screen Height -->
            <div class="relative left-0 top-0 h-screen w-1/2 hidden md:block">
                <img src="images/doctor.jpg" alt="Doctor" class="h-full w-full object-cover">
            </div>
        
            <!-- Right Side Content -->
            <div class="w-full md:w-1/2 ml-auto px-6 md:px-16 py-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800">What Makes Us Different</h2>
                <p class="mt-2 text-sm md:text-lg text-gray-600">
                    On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of the moment.
                </p>
        
                <!-- Features Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 mt-6 text-gray-800">
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-user-md text-4xl text-blue-400"></i>
                        <p class="font-semibold text-lg">Free Consultation</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-wallet text-4xl text-blue-400"></i>
                        <p class="font-semibold text-lg">Affordable Prices</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-user-nurse text-4xl text-blue-400"></i>
                        <p class="font-semibold text-lg">Qualified Doctors</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-laptop-medical text-4xl text-blue-400"></i>
                        <p class="font-semibold text-lg">Professional Staff</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-clock text-4xl text-blue-400"></i>
                        <p class="font-semibold text-lg">24/7 Opened</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-thumbs-up text-4xl text-blue-400"></i>
                        <p class="font-semibold text-lg">~500000 Happy Clients</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
    

        <section class="relative w-full bg-cover bg-center py-16" style="background-image: url('images/medical-bg.jpg');">
            <!-- Overlay for better readability -->
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        
            <div class="relative z-10 text-center text-white px-4 md:px-12">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-400">Our Medical Services</h2>
                <p class="mt-2 text-sm md:text-lg max-w-3xl mx-auto">
                    Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae.
                </p>
            </div>
        
            <!-- Full-Width Grid Layout -->
            <div class="relative z-10 mt-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 px-6 md:px-20 text-white">
                <!-- Service Item -->
                <div class="flex flex-col items-center text-center transition duration-300 hover:text-blue-400">
                    <i class="fas fa-heartbeat text-5xl text-blue-400"></i>
                    <h3 class="mt-4 text-lg font-semibold">Cardio Monitoring</h3>
                    <p class="mt-2 text-sm">These cases are perfectly simple and easy to distinguish a free hour when our power.</p>
                </div>
        
                <div class="flex flex-col items-center text-center transition duration-300 hover:text-blue-400">
                    <i class="fas fa-briefcase-medical text-5xl text-blue-400"></i>
                    <h3 class="mt-4 text-lg font-semibold">Medical Treatment</h3>
                    <p class="mt-2 text-sm">These cases are perfectly simple and easy to distinguish a free hour when our power.</p>
                </div>
        
                <div class="flex flex-col items-center text-center transition duration-300 hover:text-blue-400">
                    <i class="fas fa-user-injured text-5xl text-blue-400"></i>
                    <h3 class="mt-4 text-lg font-semibold">Emergency Help</h3>
                    <p class="mt-2 text-sm">These cases are perfectly simple and easy to distinguish a free hour when our power.</p>
                </div>
        
                <div class="flex flex-col items-center text-center transition duration-300 hover:text-blue-400">
                    <i class="fas fa-notes-medical text-5xl text-blue-400"></i>
                    <h3 class="mt-4 text-lg font-semibold">Symptom Check</h3>
                    <p class="mt-2 text-sm">These cases are perfectly simple and easy to distinguish a free hour when our power.</p>
                </div>
        
                <div class="flex flex-col items-center text-center transition duration-300 hover:text-blue-400">
                    <i class="fas fa-vial text-5xl text-blue-400"></i>
                    <h3 class="mt-4 text-lg font-semibold">Laboratory Test</h3>
                    <p class="mt-2 text-sm">These cases are perfectly simple and easy to distinguish a free hour when our power.</p>
                </div>
        
                <div class="flex flex-col items-center text-center transition duration-300 hover:text-blue-400">
                    <i class="fas fa-microscope text-5xl text-blue-400"></i>
                    <h3 class="mt-4 text-lg font-semibold">General Analysis</h3>
                    <p class="mt-2 text-sm">These cases are perfectly simple and easy to distinguish a free hour when our power.</p>
                </div>
            </div>
        </section>


        <section class="relative flex items-center min-h-screen bg-gradient-to-r from-white to-blue-100 py-12">
            <!-- Background Image on the Right -->
            <div class="absolute right-0 top-0 h-full w-1/2 hidden md:block">
                <img src="images/doctor2.jpg" alt="Doctor" class="h-full w-full object-cover">
            </div>
        
            <!-- Form Container Aligned to Left -->
            <div class="w-full max-w-lg bg-white shadow-lg rounded-lg overflow-hidden relative z-10 ml-10 md:ml-20">
                <!-- Header -->
                <div class="bg-blue-800 text-white text-center py-5">
                    <h2 class="text-xl font-bold uppercase tracking-wide">BOOK AN APPOINTMENT</h2>
                </div>
        
                <!-- Form -->
                <form class="p-6 space-y-4">
                    <!-- Clinic Selection -->
                    <select class="w-full p-3 border border-gray-300 rounded-lg bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-500">
                        <option value="" disabled selected hidden>Select the Doctor Speciality</option>
                        <option value="cardiac">Cardiac Clinic</option>
                        <option value="surgery">General Surgery</option>
                        <option value="rehabilitation">Rehabilitation</option>
                    </select>
                    
                    <select class="w-full p-3 border border-gray-300 rounded-lg bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-500">
                        <option value="" disabled selected hidden>Select the Doctor</option>
                        <option value="cardiac">Dr. Kobiram</option>
                        <option value="surgery">Dr. Sukitha</option>
                        <option value="rehabilitation">Dr. Dewmini</option>
                    </select>
                    
                    <input type="text" placeholder="Available Time Slots" class="w-full p-3 border border-gray-300 rounded-lg bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <!-- Full Name -->
                    <input type="text" placeholder="Your Full Name" class="w-full p-3 border border-gray-300 rounded-lg bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
        
                    <!-- Phone Number -->
                    <input type="text" placeholder="Your Phone Number" class="w-full p-3 border border-gray-300 rounded-lg bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
        
                    <!-- Message -->
                    <textarea placeholder="Your Message" rows="4" class="w-full p-3 border border-gray-300 rounded-lg bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
        
                    <!-- Submit Button with Gradient Hover -->
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-800 text-white py-3 rounded-lg font-semibold transition duration-300 hover:from-blue-800 hover:to-blue-600 hover:shadow-lg">
                        VERIFY MY NUMBER
                    </button>
                </form>
            </div>
        </section>
        
        <section class="py-12 bg-cover bg-center relative" style="background-image: url('images/reviews-bg.jpg');">
            <!-- Dark Overlay -->
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        
            <!-- Review Section Content -->
            <div class="relative z-10 max-w-5xl mx-auto text-center text-white px-6">
                <h2 class="text-3xl font-bold text-white-400">What Patients Say About Shanthi Medical Home</h2>
        
                <!-- Blurred Background for Reviews -->
                <div class="mt-8 p-6 bg-white bg-opacity-10 backdrop-blur-lg rounded-lg shadow-lg">
                    <div id="elfsight-container" class="filter brightness-200 contrast-200">
                        <div class="elfsight-app-ac0ecadf-9268-4b34-aedd-99cbc4553ccb"></div>
                    </div>
                </div>
            </div>
        </section>

        <a href="{{ url('/appointment') }}" class="floating-btn">
            <span class="icon">📅</span>
            <span class="text">Book an Appointment</span>
        </a>
        
        <!-- Elfsight Script -->
        <script src="https://static.elfsight.com/platform/platform.js" async></script>
        
        <!-- Force White Text in Elfsight Widget -->
        <style>
            #elfsight-container * {
                color: white !important;
            }
        </style>        
    

    <!-- Mobile-Responsive JavaScript -->
    <script>
        // Toggle Mobile Menu
        document.getElementById('menuToggle').addEventListener('click', function() {
            var menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        });

        // Sticky Navigation
        window.addEventListener("scroll", function() {
            var nav = document.getElementById("mobileMenu");
            var header = document.querySelector(".header");

            if (window.scrollY > header.offsetHeight) {
                nav.classList.add("sticky");
            } else {
                nav.classList.remove("sticky");
            }
        });

        // Initialize Slick Carousel
        document.addEventListener("DOMContentLoaded", function() {
            $('.carousel').slick({
                dots: true,
                arrows: false,  // Hide arrows on mobile
                infinite: true,
                speed: 600,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 3000,
                fade: true,
                cssEase: 'ease-in-out'
            });
        });

        window.addEventListener("scroll", function () {
        let nav = document.querySelector(".nav-menu");
        let header = document.querySelector(".top-header");

        if (window.scrollY > header.offsetHeight) {
            nav.classList.add("sticky");
            document.body.style.paddingTop = nav.offsetHeight + "px"; // Prevent content jump
        } else {
            nav.classList.remove("sticky");
            document.body.style.paddingTop = "0px";
        }
    });

    </script>

@endsection
