@extends('layouts.app')

@section('title', 'Shanthi Medical Home')

@section('content')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book an Appointment</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .af-body-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f9f9f9;
            margin: 0;
            padding: 1rem;
        }

        .af-form-container {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .af-form-container h1 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #333333;
            font-size: 1.8rem;
        }

        .af-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .af-form-container label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #555555;
        }

        .af-form-container input,
        .af-form-container select {
            width: 100%;
            max-width: 100%;
            padding: 0.8rem;
            margin-bottom: 1rem;
            border: 1px solid #dddddd;
            border-radius: 5px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        .af-form-container select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-color: #fff;
            padding-right: 2rem;
            background-image: url('data:image/svg+xml;utf8,<svg fill="%23007bff" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5.25 7.5l5 5 5-5" /></svg>');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 12px;
            cursor: pointer;
            overflow: hidden;
        }

        .af-form-container select:focus,
        .af-form-container input:focus {
            background-color: #eef7ff;
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.2);
        }

        .af-button-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 1.5rem;
        }

        .af-button-container button {
            background-color: #007bff;
            color: #ffffff;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            padding: 0.7rem 1.5rem;
            border-radius: 5px;
            font-size: 1rem;
        }

        .af-button-container button:hover {
            background-color: #0056b3;
        }
        .af-gender-container {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .af-gender-container input[type="radio"] {
            appearance: none;
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            border: 3px double #007bff;
            border-radius: 50%;
            outline: none;
            cursor: pointer;
            margin-right: 0.5rem;
            transition: all 0.3s ease-in-out;
        }

        .af-gender-container input[type="radio"]:checked {
            background-color: #007bff;
            border-color: #0056b3;
        }

        .af-gender-container input[type="radio"]:hover {
            border-color: #0056b3;
        }

        @media (max-width: 768px) {
            .af-form-grid {
                grid-template-columns: 1fr;
            }
            .af-button-container {
                justify-content: center;
            }
            .af-form-container h1 {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .af-body-container {
                padding: 0.5rem;
            }
            .af-form-container {
                padding: 1rem;
                max-width: 100%;
            }
            .af-form-container h1 {
                font-size: 1.2rem;
            }
            .af-button-container button {
                width: 100%;
            }

            .af-form-container select {
                width: 100%;
                max-width: 100%;
            }
        }

/* 🔹 Specialties Main Container */
.specialties-main {
    display: flex;
    align-items: center;
    justify-content: space-between;
    max-width: 1300px;
    margin: auto;
    padding: 40px 20px;
}

/* 🔹 Left Image */
.specialty-image {
    width: 450px;
    height: auto;
    border-radius: 12px;
    object-fit: cover;
    box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
}

.specialties-container {
    display: grid;
    grid-template-columns: repeat(5, 1fr); /* Ensure 5 equal columns */
    gap: 20px;
    max-width: 800px;
    overflow: visible; /* 👈 FIXED (Previously set to "hidden") */
    max-height: 470px; /* Ensures only 3 rows are visible */
    transition: max-height 0.4s ease-in-out;
    justify-content: center;
}

/* 🔹 Specialty Cards (Prevent Moving Effect) */
.specialty-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: white;
    padding: 18px;
    border-radius: 12px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease-in-out;
    cursor: pointer;
    text-align: center;
    width: 140px; /* Fixed width */
    height: 140px; /* Fixed height */
    position: relative;  /* Ensure it stays in place */
}

/* 🔹 Specialty Icons */
.specialty-icon {
    font-size: 2rem;
    color: #007bff; /* Primary blue */
    margin-bottom: 10px;
    transition: color 0.3s ease-in-out, transform 0.3s ease-in-out;
}

/* 🔹 Specialty Text */
.specialty-text {
    font-size: 14px;
    font-weight: 600;
    color: #444;
    text-align: center;
    transition: color 0.3s ease-in-out;
}

/* 🔹 Hover Effect Without Breaking Layout */
.specialty-card:hover {
    transform: scale(1.05); /* Slight enlargement */
    background-color: #007bff;
    box-shadow: 0px 12px 24px rgba(0, 123, 255, 0.3);
    z-index: 10; /* Keeps it above other elements */
}


/* 🔹 Hover Effect on Text & Icon */
.specialty-card:hover .specialty-text,
.specialty-card:hover .specialty-icon {
    color: white;
}

/* 🔹 View All Button */
.view-all-btn {
    text-align: center;
    font-size: 14px;
    font-weight: bold;
    color: #007bff;
    margin-top: 20px;
    cursor: pointer;
    transition: color 0.3s ease-in-out;
}

.view-all-btn:hover {
    color: #0056b3;
}

/* 🔹 Expand Full Grid on Click */
.specialties-container.expanded {
    max-height: 1000px; /* Expands to show all */
}

/* 🔹 Responsive Adjustments */
@media (max-width: 1200px) {
    .specialties-container {
        grid-template-columns: repeat(4, 1fr); /* 4 columns on medium screens */
    }
}

@media (max-width: 992px) {
    .specialties-main {
        flex-direction: column;
        text-align: center;
        gap: 30px;
    }

    .specialty-image {
        width: 90%;
        max-width: 500px;
    }

    .specialties-container {
        grid-template-columns: repeat(3, 1fr); /* 3 columns on tablets */
    }
}

@media (max-width: 768px) {
    .specialties-container {
        grid-template-columns: repeat(2, 1fr); /* 2 columns on smaller screens */
    }
}

@media (max-width: 480px) {
    .specialties-container {
        grid-template-columns: repeat(1, 1fr); /* 1 column on mobile */
    }
}


    </style>

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

        

<!-- 🔹 Specialties Section -->
<div class="specialties-main">
    <!-- Left Side Image -->
    <img src="{{ asset('images/specialties/docbg2.jpg') }}" alt="Doctor Consultation" class="specialty-image">

    <!-- Right Side Specialties Grid -->
    <div>
        <div class="specialties-container" id="specialtiesGrid">
        @foreach ([
    'Visiting Physician' => 'fa-user-doctor',
    'Cardiologist' => 'fa-heart-pulse',
    'Chest Physician / Pulmonologist' => 'fa-lungs',
    'Dental Surgeon' => 'fa-tooth',
    'Dermatologist' => 'fa-user-md',
    'Diabetologist & Endocrinologist' => 'fa-syringe',
    'ENT Surgeon / Otorhinolaryngologist' => 'fa-ear-listen',
    'General Surgeon' => 'fa-user-doctor',
    'Gynaecologist & Obstetrician' => 'fa-baby',
    'Neurosurgeon' => 'fa-brain',
    'Orthodontist' => 'fa-teeth',
    'Orthopaedic Surgeon' => 'fa-bone',
    'Paediatrician' => 'fa-child',
    'Psychiatrist' => 'fa-user-injured',
    'Rheumatologist' => 'fa-hand-dots',
    'Sports & Exercise Medicine Physician' => 'fa-dumbbell'
    
] as $specialty => $icon)
    <div class="specialty-card" onclick="window.location='{{ route('customer.doctorsBySpecialty', ['specialty' => $specialty]) }}'">
        <i class="fa-solid {{ $icon }} specialty-icon"></i> <!-- Icon Here -->
        <span class="specialty-text">{{ $specialty }}</span>
    </div>
@endforeach

        </div>

        <!-- View All Button -->
        <div class="view-all-btn" onclick="toggleSpecialties()">
            View All
        </div>
    </div>
</div>


        <section class="relative flex items-center min-h-screen bg-gradient-to-r from-white to-blue-100 py-12">
            <!-- Background Image on the Right -->
            <div class="absolute right-0 top-0 h-full w-2/5 hidden md:block">
                <img src="images/doctor2.jpg" alt="Doctor" class="h-full w-full object-cover">
            </div>
        
            <!-- Form Container Aligned to Left -->
            <div class="w-3/5 flex justify-center">
                <!-- Header -->
                 
                <div class="af-form-container">
            <h1>Book an Appointment</h1>

            <form id="appointment-form" >
                @csrf

                <div class="af-form-grid">
                    <div>
                        <label for="specialty">Specialty:</label>
                        <select name="specialty" id="specialty" required>
                            <option value="">Select Specialty</option>
                            @foreach($specialties as $specialty)
                                <option value="{{ $specialty }}">{{ $specialty }}</option>
                            @endforeach
                        </select>

                        <label for="doctor">Doctor:</label>
                        <select name="doctor" id="doctor" required>
                            <option value="">Select Doctor</option>
                        </select>

                        <label for="schedule">Available Date & Time:</label>
                        <select name="schedule" id="schedule" required>
                            <option value="">Select Date & Time</option>
                        </select>
                    </div>
                    <div>
                        <label for="patient_name">Name:</label>
                        <input type="text" name="patient_name" id="patient_name" required>

                        <label for="nic">NIC:</label>
                        <input type="text" name="nic" id="nic" required>

                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" 
                        title="Enter a valid email address">

                        <div class="af-gender-container">
                        <label for="gender">Gender:</label>
                        <input type="radio" name="gender" id="gender_male" value="Male" required>
                        <label for="gender_male">Male</label>
                        <input type="radio" name="gender" id="gender_female" value="Female" required>
                        <label for="gender_female">Female</label>
                        <input type="radio" name="gender" id="gender_other" value="Other" required>
                        <label for="gender_other">Other</label>
                        </div>

                        <label for="contact">Contact Number:</label>
                        <input type="text" name="contact" id="contact" maxlength="10" required>
                    </div>
                </div>
                <div class="af-button-container">
                <button type="button" id="next-button">Next</button>
                </div>
            </form>
        </div>
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
        document.getElementById('next-button').addEventListener('click', function () {
    const formData = new FormData(document.getElementById('appointment-form'));

    axios.post('/send-otp', {
        specialty: formData.get('specialty'),
        doctor: formData.get('doctor'),
        schedule: formData.get('schedule'),
        patient_name: formData.get('patient_name'),
        nic: formData.get('nic'),
        contact: formData.get('contact')
    })
    .then(response => {
        if (response.data.success) {
            alert(response.data.message);
            window.location.href = response.data.redirect; // Redirect to OTP verification page
        } else {
            alert('OTP sending failed: ' + response.data.message);
        }
    })
    .catch(error => {
        console.error('Error sending OTP:', error.response ? error.response.data : error.message);
        alert('Failed to send OTP. Please check the details and try again.');
    });
});

        // Fetch doctors based on the selected specialty
        document.getElementById('specialty').addEventListener('change', function () {
            const specialty = this.value; // Get the selected specialty

            if (specialty) {
                // Make an AJAX request to get doctors by specialty
                axios.get(`/get-doctors?specialty=${specialty}`)
                    .then(response => {
                        const doctorDropdown = document.getElementById('doctor'); // Target doctor dropdown
                        doctorDropdown.innerHTML = '<option value="">Select Doctor</option>'; // Reset doctor dropdown

                        // Populate dropdown with returned doctors
                        response.data.forEach(doctor => {
                            doctorDropdown.innerHTML += `<option value="${doctor.Doc_id}">${doctor.name}</option>`;
                        });

                        // Reset the schedule dropdown
                        document.getElementById('schedule').innerHTML = '<option value="">Select Date & Time</option>';
                    })
                    .catch(error => {
                        console.error("Error fetching doctors:", error);
                    });
            } else {
                // Reset doctor and schedule dropdowns if no specialty is selected
                document.getElementById('doctor').innerHTML = '<option value="">Select Doctor</option>';
                document.getElementById('schedule').innerHTML = '<option value="">Select Date & Time</option>';
            }
        });

        document.getElementById('doctor').addEventListener('change', function () {
    const doctorId = this.value; // Get the selected doctor ID

    if (doctorId) {
        // Make an AJAX request to get schedules by doctor ID
        axios.get(`/get-schedules?doctor_id=${doctorId}`)
            .then(response => {
                const scheduleDropdown = document.getElementById('schedule'); // Target schedule dropdown
                scheduleDropdown.innerHTML = '<option value="">Select Date & Time</option>'; // Reset schedule dropdown

                // Populate dropdown with formatted schedules
                response.data.forEach(schedule => {
                    const date = new Date(schedule.date); // Convert date to JS Date object
                    const formattedDate = date.toLocaleString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: '2-digit',
                    }); // Format date as "2025 Jan 23"

                    const startTime = formatTime(schedule.start_time); // Format start time
                    const endTime = formatTime(schedule.end_time); // Format end time

                    const combinedValue = `${formattedDate} ${startTime} - ${endTime}`; // Combine into desired format
                    const combinedKey = `${schedule.date},${schedule.start_time},${schedule.end_time}`; // Pass combined values

                    scheduleDropdown.innerHTML += `<option value="${combinedKey}">${combinedValue}</option>`;
                });
            })
            .catch(error => {
                console.error("Error fetching schedules:", error);
            });
    } else {
        // Reset schedule dropdown if no doctor is selected
        document.getElementById('schedule').innerHTML = '<option value="">Select Date & Time</option>';
    }
});

// Helper function to format time into "3pm", "4:30am", etc.
function formatTime(timeStr) {
    const [hour, minute] = timeStr.split(':').map(Number); // Split "HH:MM:SS" into parts
    const period = hour >= 12 ? 'pm' : 'am'; // Determine AM/PM
    const adjustedHour = hour % 12 || 12; // Convert 24-hour format to 12-hour format
    return `${adjustedHour}${minute !== 0 ? ':' + minute : ''}${period}`; // Format time
}
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

    function toggleSpecialties() {
            const grid = document.getElementById("specialtiesGrid");
            if (grid.classList.contains("expanded")) {
                grid.classList.remove("expanded");
                document.querySelector(".view-all-btn").innerText = "View All";
            } else {
                grid.classList.add("expanded");
                document.querySelector(".view-all-btn").innerText = "Show Less";
            }
        }
        

    
</script>

    

@endsection
