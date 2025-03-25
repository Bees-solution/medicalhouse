<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Doctors List</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
.af-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); /* Dark transparent background */
    z-index: 998; /* Ensure it's behind the form but above everything else */
    display: none; /* Initially hidden */
}

.af-form-container {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
    z-index: 999; /* Above the overlay */
    display: none; /* Initially hidden */
    animation: fadeIn 0.3s ease-in-out;

}


/* Smooth fade-in effect */
@keyframes fadeIn {
    from { opacity: 0; transform: translate(-50%, -60%); }
    to { opacity: 1; transform: translate(-50%, -50%); }
}

.close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #ff4d4d;
    color: white;
    border: none;
    padding: 6px 12px;
    cursor: pointer;
    border-radius: 50%;
    font-size: 18px;
    transition: 0.3s ease-in-out;
}

.close-btn:hover {
    background: #cc0000;
    transform: scale(1.1);
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
    width: 20%;
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
/* Doctor Card Styling (Smaller & Compact) */
.doctor-card {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    background: white;
    padding: 12px; /* Reduced padding */
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    text-align: center;
    transition: all 0.3s ease-in-out;
    min-height: 220px; /* Smaller card height */
    height: 100%;
    border: 1px solid #e0e0e0;
}

/* Doctor Icon (Smaller Size) */
.doctor-icon {
    font-size: 50px; /* Reduced from 65px */
    color: rgb(171, 201, 233) !important;
    margin-bottom: 8px;
}

/* Doctor Name (Smaller Font) */
.doctor-card h4 {
    font-size: 1rem; /* Reduced from 1.2rem */
    font-weight: bold;
    color: #333;
    margin-bottom: 3px;
}

/* Specialty Text (Smaller & Compact) */
.doctor-card p.text-muted {
    font-size: 0.8rem; /* Reduced from 0.9rem */
    color: #666;
    flex-grow: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}
/* General Button Styling */
.channel-now-btn {
    display: block;
    width: 100%;
    padding: 8px;
    text-decoration: none;
    font-weight: bold;
    border-radius: 6px;
    transition: all 0.3s ease-in-out;
    font-size: 0.85rem;
    text-align: center;
    color: white !important;
}

/* Alternating Colors (Better Selector) */
.channel-now-btn:nth-of-type(odd) {
    background-color: #5c9ded !important; /* Soft Blue */
}

.channel-now-btn:nth-of-type(even) {
    background-color: #007bff !important; /* Original Blue */
}

/* Specialty-based Colors (Fixed Selector) */
.channel-now-btn[data-specialty*="Psychiatrist"] {
    background-color: #6c757d !important; /* Soft Gray */
}

.channel-now-btn[data-specialty*="Orthopaedic"] {
    background-color: #f4a261 !important; /* Soft Orange */
}

.channel-now-btn[data-specialty*="Pulmonologist"] {
    background-color: #2a9d8f !important; /* Soft Green */
}

/* Hover Effect */
.channel-now-btn:hover {
    filter: brightness(1.2) !important;
    transform: scale(1.05) !important;
}

/* Hover Effect - Keeps It Interactive */
.doctor-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

/* Adjusts Grid for Small Cards */
@media (min-width: 1200px) {
    .col-lg-2 {
        flex: 0 0 18%; /* Slightly reduced width */
        max-width: 18%;
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

                <h4>Dr. {{ $doctor->name }}</h4>
                <p class="text-muted">{{ $doctor->Specialty }}</p>
                

                <a href="#" 
   class="channel-now-btn" 
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
            <input type="hidden" name="doctor_id" id="doctor_id">

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
            <button type="button" id="next-button">Next</button>
        </div>
    </form>

    <!-- Hidden input to store doctor fee -->
    <input type="hidden" id="fee">
</div>

<!-- 🔹 Move Confirmation Popup Here -->
<div class="af-form-container" id="confirmation-popup" style="display: none;">
    <h1>Confirm Your Appointment</h1>
    <p><strong>Doctor:</strong> <span id="confirm-doctor"></span></p>
    <p><strong>Specialty:</strong> <span id="confirm-specialty"></span></p>
    <p><strong>Schedule:</strong> <span id="confirm-schedule"></span></p>
    <p><strong>Patient Name:</strong> <span id="confirm-patient"></span></p>
    <p><strong>Doctor's Fee:</strong> <span id="confirm-fee"></span></p>

    <div class="af-button-container">
        <button id="cancel-button" class="btn btn-danger">Cancel</button>
        <button id="ok-button" class="btn btn-success">OK</button>
    </div>
</div>

<!-- OTP Verification Popup -->
<div class="af-form-container" id="otp-verification-popup" style="display: none;">
    <h1>Verify OTP</h1>
    <p>A 6-digit OTP has been sent to <span id="otp-contact-number"></span></p>

    <label for="otp-input">Enter OTP:</label>
    <input type="text" id="otp-input" required>

    <div class="af-button-container">
        <button id="otp-cancel-button" class="btn btn-danger">Cancel</button>
        <button id="resend-otp-btn" class="btn btn-secondary" style="display: none;">Resend OTP</button>

        <button id="verify-otp-button" class="btn btn-success">Verify OTP</button>
    </div>
</div>
<!-- Payment Selection Popup -->
<div class="af-form-container" id="payment-selection-popup" style="display: none;">
    <h1>Select Payment Method</h1>
    <p>Please choose your preferred payment option.</p>

    <div class="af-button-container">
        <button id="pay-now-button" class="btn btn-success">Pay Now</button>
        <button id="pay-counter-button" class="btn btn-primary">Pay at Counter</button>
    </div>
</div>
<!-- Hidden Payment Form -->
<form id="payment-form" method="POST" action="{{ route('appointments.process-payment') }}">
    @csrf
    <input type="hidden" name="payment_method" id="payment-method">
    <input type="hidden" name="appointment_status" value="Online">
</form>




     <script>

document.getElementById('nic').addEventListener('input', function () {
    const nicPattern = /^[0-9]{9}[VXvx]?$/;
    if (!nicPattern.test(this.value)) {
        this.setCustomValidity('Enter a valid NIC (e.g., 123456789V or 200012345678)');
    } else {
        this.setCustomValidity('');
    }
});

         
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById('appointment-form-container');
    const overlay = document.getElementById('overlay');
    const closeModal = document.getElementById('close-btn');
    const confirmationPopup = document.getElementById('confirmation-popup');
    const confirmDoctor = document.getElementById('confirm-doctor');
    const confirmSpecialty = document.getElementById('confirm-specialty');
    const confirmSchedule = document.getElementById('confirm-schedule');
    const confirmPatient = document.getElementById('confirm-patient');
    const confirmFee = document.getElementById('confirm-fee');
    const cancelBtn = document.getElementById('cancel-button');
    const okBtn = document.getElementById('ok-button');
    const verifyBtn = document.getElementById('verify-otp-button');
    const resendOtp = document.getElementById('resend-otp-btn');
    const payNowBtn = document.getElementById('pay-now-button');
    const payCounterBtn = document.getElementById('pay-counter-button');


    document.querySelectorAll('.channel-now-btn').forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();

            const doctorId = this.getAttribute('data-doctor-id');
            document.getElementById('doctor_id').value = doctorId; 
            document.getElementById('doctor').value = this.getAttribute('data-doctor-name');
            document.getElementById('specialty').value = this.getAttribute('data-specialty');

            modal.style.display = 'block';
            overlay.style.display = 'block';

            fetchAvailableSchedules(doctorId);
            fetchDoctorFee(doctorId); // Fetch doctor's fee
        });
    });

    closeModal.addEventListener('click', closeAllModals);
    overlay.addEventListener('click', closeAllModals);
    cancelBtn.addEventListener('click', closeAllModals);

    document.getElementById('next-button').addEventListener('click', function (event) {
        event.preventDefault();

        const doctorName = document.getElementById('doctor').value;
        const specialty = document.getElementById('specialty').value;
        const scheduleDropdown = document.getElementById('schedule');
        const schedule = scheduleDropdown.options[scheduleDropdown.selectedIndex].text;
        const patientName = document.getElementById('patient_name').value;
        const doctorFee = document.getElementById('fee').value || 'Not Available';

        if (!scheduleDropdown.value) {
            alert('Please select a schedule before proceeding.');
            return;
        }

        confirmDoctor.textContent = doctorName;
        confirmSpecialty.textContent = specialty;
        confirmSchedule.textContent = schedule;
        confirmPatient.textContent = patientName;
        confirmFee.textContent = `Rs. ${doctorFee}`;

        modal.style.display = 'none';
        confirmationPopup.style.display = 'block';
    });

    okBtn.addEventListener('click', function () {
    const specialty = document.getElementById('specialty').value;
    const doctor = document.getElementById('doctor').value;
    const schedule = document.getElementById('schedule').value;
    const patientName = document.getElementById('patient_name').value;
    const nic = document.getElementById('nic').value;
    const contact = document.getElementById('contact').value;

    if (!specialty || !doctor || !schedule || !patientName || !nic || !contact) {
        alert("Please fill in all the required fields.");
        return;
    }

    const doctorId = document.getElementById('doctor_id').value;

    fetch('/send-otp', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ 
            specialty: specialty,
            doctor: doctor,
            doctor_id: doctorId, 
            schedule: schedule,
            patient_name: patientName,
            nic: nic,
            contact: contact
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('otp-contact-number').textContent = contact;

            // Hide confirmation popup & show OTP verification popup
            document.getElementById('confirmation-popup').style.display = 'none';
            document.getElementById('otp-verification-popup').style.display = 'block';
        } else {
            alert(data.message || "Failed to send OTP. Please try again.");
        }
    })
    .catch(error => {
        console.error("Error sending OTP:", error);
        alert("An error occurred. Please try again.");
    });
});


document.getElementById('verify-otp-button').addEventListener('click', function () {
    const otp = document.getElementById('otp-input').value;

    if (!otp) {
        alert("Please enter the OTP.");
        return;
    }

    const appointmentData = {
        doctor_id: document.querySelector('.channel-now-btn[data-doctor-id]').getAttribute('data-doctor-id'),
        doctor: document.getElementById('doctor').value,
        specialty: document.getElementById('specialty').value,
        schedule: document.getElementById('schedule').value,
        patient_name: document.getElementById('patient_name').value,
        nic: document.getElementById('nic').value,
        contact: document.getElementById('contact').value
    };

    fetch('/verify-otp', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ otp: otp, appointment_data: appointmentData })
    })
    .then(response => response.json())
    .then(data => {
        if (data.verified) {
            alert("OTP verified successfully!");
            document.getElementById('otp-verification-popup').style.display = 'none';
            document.getElementById('payment-selection-popup').style.display = 'block';
        } else {
            alert(data.message || "Invalid OTP. Please try again.");
            if (data.expired) {
                alert("OTP has expired. Please request a new one.");
                document.getElementById('resend-otp-btn').style.display = 'block';
            }
        }
    })
    .catch(error => {
        console.error("Error verifying OTP:", error);
        alert("An error occurred. Please try again.");
    });
});


resendOtp.addEventListener('click', function () {

    document.getElementById('resend-otp-btn').addEventListener('click', function () {
    const contact = document.getElementById('contact').value;

    fetch('/send-otp', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({ 
        specialty: specialty,
        doctor: doctor,
        doctor_id: doctorId,
        schedule: schedule,
        patient_name: patientName,
        nic: nic,
        contact: contact
    })
})

    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("New OTP sent successfully.");
            document.getElementById('resend-otp-btn').style.display = 'none'; // Hide resend button
        } else {
            alert("Failed to resend OTP. Try again.");
        }
    })
    .catch(error => {
        console.error("Error resending OTP:", error);
        alert("An error occurred. Please try again.");
    });
});

});

        payNowBtn.addEventListener('click', function () {
            window.location.href = `/payment-path`; // Update this path as needed
        });

        payCounterBtn.addEventListener('click', function () {
    const token = document.querySelector('meta[name="csrf-token"]').content;

    fetch('/appointments/process-payment', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            payment_method: 'Pending',
            appointment_status: 'Online'
        })
    })
    .then(response => {
        // Handle non-200 responses gracefully
        if (!response.ok) {
            return response.json().then(err => {
                throw err;
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // ✅ Show success in the same popup
            document.getElementById('payment-selection-popup').innerHTML = `
                <h1 class="text-success">🎉 Appointment Confirmed!</h1>
                <p><strong>Appointment ID:</strong> ${data.appointment_id}</p>
                <p>Your appointment has been successfully booked. Please arrive 15 minutes early.</p>
                <div class="af-button-container">
                    <button class="btn btn-primary" onclick="location.reload()">OK</button>
                </div>
            `;
        }
    })
    .catch(err => {
        console.error("Appointment Booking Error:", err);

        // ❌ Show session expiration or general error message in the same popup
        document.getElementById('payment-selection-popup').innerHTML = `
            <h1 class="text-danger">❌ Error</h1>
            <p>${err.message || 'Something went wrong. Please try again.'}</p>
            <div class="af-button-container">
                <button class="btn btn-secondary" onclick="location.reload()">Try Again</button>
            </div>
        `;
    });
});





    function fetchAvailableSchedules(doctorId) {
        fetch(`/get-doctor-schedules/${doctorId}`)
            .then(response => response.json())
            .then(data => {
                const scheduleDropdown = document.getElementById('schedule');
                scheduleDropdown.innerHTML = '<option value="">Select Date & Time</option>';

                data.forEach(schedule => {
                    const formattedDate = new Date(schedule.date).toLocaleDateString('en-US', {
                        year: 'numeric', month: 'short', day: '2-digit'
                    });
                    const startTime = formatTime(schedule.start_time);
                    const endTime = formatTime(schedule.end_time);

                    const combinedValue = `${formattedDate} ${startTime} - ${endTime}`;
                    const combinedKey = `${schedule.date},${schedule.start_time},${schedule.end_time}`;

                    scheduleDropdown.innerHTML += `<option value="${combinedKey}">${combinedValue}</option>`;
                });
            })
            .catch(error => console.error("Error fetching schedules:", error));
    }

    function fetchDoctorFee(doctorId) {
    fetch(`/get-doctor-fee/${doctorId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error("Failed to fetch doctor's fee");
            }
            return response.json();
        })
        .then(data => {
            console.log("Fetched Fee Data:", data); // Debugging log
            if (data && data.fee) {
                document.getElementById('fee').value = data.fee;
            } else {
                document.getElementById('fee').value = 'Not Available';
            }
        })
        .catch(error => {
            console.error("Error fetching fee:", error);
            document.getElementById('fee').value = 'Not Available';
        });
}

    function formatTime(timeString) {
        const [hours, minutes] = timeString.split(':');
        const period = hours >= 12 ? 'PM' : 'AM';
        const formattedHours = hours % 12 || 12;
        return `${formattedHours}:${minutes} ${period}`;
    }

    function closeAllModals() {
        modal.style.display = 'none';
        overlay.style.display = 'none';
        confirmationPopup.style.display = 'none';
    }
});

</script>

</body>
</html>
