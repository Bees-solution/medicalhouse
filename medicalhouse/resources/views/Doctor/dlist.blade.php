<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors List</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
//* Dark Overlay for Modal Background */
.af-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    display: none;
    z-index: 999;
}

/* Centered & Compact Modal */
.af-form-container {
    background-color: #ffffff;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    width: 90%;
    max-width: 500px;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1000;
    display: none;
    animation: fadeIn 0.3s ease-in-out;
    max-height: 80vh; /* Prevents overflow on small screens */
    overflow-y: auto;
}

/* Smooth fade-in effect */
@keyframes fadeIn {
    from { opacity: 0; transform: translate(-50%, -60%); }
    to { opacity: 1; transform: translate(-50%, -50%); }
}

/* Close Button */
.close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #ff4d4d;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 50%;
    font-size: 16px;
    transition: 0.3s ease-in-out;
}

.close-btn:hover {
    background: #cc0000;
}

/* Form Title */
.af-form-container h1 {
    text-align: center;
    font-size: 1.5rem;
    margin-bottom: 15px;
    color: #333;
}

/* Two-column Grid */
.af-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

/* Labels & Inputs */
.af-form-container label {
    font-weight: bold;
    color: #444;
    font-size: 0.9rem;
    margin-bottom: 3px;
    display: block;
}

.af-form-container input,
.af-form-container select {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 0.9rem;
    transition: border-color 0.3s ease-in-out;
}

.af-form-container input:focus,
.af-form-container select:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 6px rgba(0, 123, 255, 0.2);
}

/* Gender Radio Buttons */
.af-gender-container {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.9rem;
}

.af-gender-container input[type="radio"] {
    width: 16px;
    height: 16px;
    accent-color: #007bff;
    cursor: pointer;
}

/* Submit Button */
.af-button-container {
    text-align: center;
    margin-top: 15px;
}

.af-button-container button {
    background-color: #007bff;
    color: white;
    font-weight: bold;
    border: none;
    cursor: pointer;
    transition: 0.3s ease;
    padding: 10px;
    border-radius: 6px;
    font-size: 1rem;
    width: 100%;
}

.af-button-container button:hover {
    background-color: #0056b3;
}

/* Responsive: Stack columns on small screens */
@media (max-width: 576px) {
    .af-form-grid {
        grid-template-columns: 1fr;
    }
}
/* Doctor Card Styling (Clean & Modern) */
.doctor-card {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    background: white;
    padding: 18px;
    border-radius: 15px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
    text-align: center;
    transition: all 0.3s ease-in-out;
    min-height: 280px; /* Ensures all cards have the same height */
    height: 100%;
    border: 1px solid #e0e0e0;
}

/* Doctor Icon (Brighter & More Visible) */
.doctor-icon {
    font-size: 65px;
    color:rgb(171, 201, 233) !important; /* Ensures vibrant blue */
    margin-bottom: 10px;
}

/* Doctor Name */
.doctor-card h4 {
    font-size: 1.2rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 5px;
}

/* Specialty Text */
.doctor-card p.text-muted {
    font-size: 0.9rem;
    color: #666;
    flex-grow: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}

/* Button - Ensures It's Always at the Bottom */
.channel-now-btn {
    display: block;
    width: 100%;
    background-color: #007bff;
    color: white;
    padding: 10px;
    text-decoration: none;
    font-weight: bold;
    border-radius: 8px;
    transition: all 0.3s ease-in-out;
    font-size: 0.95rem;
    margin-top: auto;
}

/* Button Hover Effect */
.channel-now-btn:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}

/* Hover Effect - Makes Cards More Interactive */
.doctor-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
}

/* Ensures a Perfect Grid Layout */
@media (min-width: 1200px) {
    .col-lg-2 {
        flex: 0 0 20%;
        max-width: 20%;
    }
}



    </style>
</head>
<body>

    <div class="container mt-5">
        <h1 class="text-center mb-4 text-primary">Find Your Doctor</h1>

        <!-- Search Form -->
        <form action="{{ route('customer.doctor.list') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-8">
                    <input type="text" name="search" class="form-control" placeholder="Search by name or specialty" value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
            </div>
        </form>

        <div class="row">
    @foreach ($doctors as $doctor)
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="doctor-card">
                <!-- Doctor Icon (Ensuring it is visible) -->
                <div class="doctor-icon-container">
                    <i class="fas fa-user-md doctor-icon"></i>
                </div>

                <h4>{{ $doctor->name }}</h4>
                <p class="text-muted">{{ $doctor->Specialty }}</p>
                

                <a href="#" 
                   class="btn btn-primary channel-now-btn" 
                   data-doctor-name="{{ $doctor->name }}" 
                   data-specialty="{{ $doctor->Specialty }}" 
                   data-doctor-id="{{ $doctor->Doc_id }}">
                   Channel Now
                </a>
            </div>
        </div>
    @endforeach
</div>




<!-- Modal Overlay -->
<div class="af-overlay" id="overlay"></div>

<!-- Appointment Form -->
<div class="af-form-container" id="appointment-form-container">
    <button class="close-btn" id="close-btn">&times;</button>
    <h1>Book an Appointment</h1>

    <form id="appointment-form">
        @csrf
        <div class="af-form-grid">
            <!-- Left Column: Doctor Details -->
            <div>
                <label for="specialty">Specialty:</label>
                <input type="text" id="specialty" name="specialty" readonly>

                <label for="doctor">Doctor:</label>
                <input type="text" id="doctor" name="doctor" readonly>

                <label for="schedule">Available Date & Time:</label>
                <select name="schedule" id="schedule" required>
                    <option value="">Select Date & Time</option>
                </select>
            </div>

            <!-- Right Column: Patient Details -->
            <div>
                <label for="patient_name">Name:</label>
                <input type="text" name="patient_name" id="patient_name" required>

                <label for="nic">NIC:</label>
                <input type="text" name="nic" id="nic" required>

                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>

                <div class="af-gender-container">
                    <label>Gender:</label>
                    <input type="radio" name="gender" value="Male" required> Male
                    <input type="radio" name="gender" value="Female" required> Female
                    <input type="radio" name="gender" value="Other" required> Other
                </div>

                <label for="contact">Contact Number:</label>
                <input type="text" name="contact" id="contact" required>
            </div>
        </div>

        <div class="af-button-container">
            <button type="submit">Book Appointment</button>
        </div>
   
     </form>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById('appointment-form-container');
            const overlay = document.getElementById('overlay');
            const closeModal = document.getElementById('close-btn');

            document.querySelectorAll('.channel-now-btn').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();

                    document.getElementById('doctor').value = this.getAttribute('data-doctor-name');
                    document.getElementById('specialty').value = this.getAttribute('data-specialty');

                    modal.style.display = 'block';
                    overlay.style.display = 'block';

                    fetchAvailableSchedules(this.getAttribute('data-doctor-id'));
                });
            });

            closeModal.addEventListener('click', function() {
                modal.style.display = 'none';
                overlay.style.display = 'none';
            });

            function fetchAvailableSchedules(doctorId) {
                fetch(`/get-doctor-schedules/${doctorId}`)
                    .then(response => response.json())
                    .then(data => {
                        let scheduleDropdown = document.getElementById('schedule');
                        scheduleDropdown.innerHTML = '<option value="">Select Date & Time</option>';
                        data.forEach(schedule => {
                            scheduleDropdown.innerHTML += `<option value="${schedule.id}">${schedule.date} - ${schedule.time}</option>`;
                        });
                    });
            }
        });

        
    </script>

</body>
</html>
