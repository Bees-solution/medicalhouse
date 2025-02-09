<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book an Appointment</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            padding: 0.8rem;
            margin-bottom: 1rem;
            border: 1px solid #dddddd;
            border-radius: 5px;
            font-size: 1rem;
            box-sizing: border-box;
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

        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        .modal-content h2 {
            margin-bottom: 1rem;
        }

        .modal-content button {
            width: 100%;
            padding: 1rem;
            margin: 0.5rem 0;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
        }

        .btn-pay-now {
            background-color: #28a745;
            color: white;
        }

        .btn-pay-later {
            background-color: #007bff;
            color: white;
        }

        .btn-close {
            background-color: #dc3545;
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .af-form-grid {
                grid-template-columns: 1fr;
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

            .af-button-container button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="af-body-container">
        <div class="af-form-container">
            <h1>Book an Appointment</h1>

            <form id="appointment-form">
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

    <!-- Payment Selection Modal -->
<div class="modal" id="payment-modal">
    <div class="modal-content">
        <h2>Select Payment Method</h2>
        <p>Choose how you would like to pay for your appointment.</p>
        <button class="btn-pay-now" onclick="showPaymentDetails()">Pay Now</button>
        <button class="btn-pay-later" onclick="submitAppointment('Pending')">Pay Later</button>
        <button class="btn-close" onclick="closeModal()">Cancel</button>
    </div>
</div>

<!-- Payment Confirmation Modal (For Pay Now) -->
<div class="modal" id="payment-confirmation-modal">
    <div class="modal-content">
        <h2>Confirm Payment</h2>
        <div id="payment-details"></div>
        <button class="btn-pay-now" onclick="processPayNow()">Confirm & Pay</button>
        <button class="btn-close" onclick="closePaymentModal()">Cancel</button>
    </div>
</div>

<!-- Bill Display Modal -->
<div class="modal" id="bill-modal">
    <div class="modal-content">
        <h2>Bill Details</h2>
        <div id="bill-content"></div>
        <button onclick="downloadBill()">Download</button>
        <button onclick="finishBill()">Finish</button>
    </div>
</div>


    <script>
        document.getElementById('next-button').addEventListener('click', function () {
            const formData = new FormData(document.getElementById('appointment-form'));

            if (!formData.get('specialty') || !formData.get('doctor') || !formData.get('schedule') || !formData.get('patient_name') || !formData.get('contact')) {
                alert("Please fill in all required fields.");
                return;
            }

            // Store data temporarily
            sessionStorage.setItem('appointmentData', JSON.stringify(Object.fromEntries(formData.entries())));

            // Show payment selection modal
            document.getElementById('payment-modal').style.display = 'flex';
        });

    function submitAppointment(paymentStatus) {
    const appointmentData = JSON.parse(sessionStorage.getItem('appointmentData'));
    appointmentData.payment_status = paymentStatus;

    axios.post('/process-offline-appointment', appointmentData)
  
        .then(response => {
            if (response.data.success) {
                // ✅ Show alert ONLY if successfully stored in the database
                alert('Appointment successfully made! You will receive an SMS confirmation shortly.');
              
                window.location.reload();
            } else {
                alert('Error: ' + response.data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error.response ? error.response.data : error.message);
            alert('Failed to proceed. Please try again.');
        });
}


function showPaymentDetails() {
    const appointmentData = JSON.parse(sessionStorage.getItem('appointmentData'));

    axios.get(`/get-doctor-fee?doctor_id=${appointmentData.doctor}`)
        .then(response => {
            const doctorFee = response.data.fee;

            document.getElementById('payment-details').innerHTML = `
                <p><strong>Doctor:</strong> ${response.data.name} (${response.data.specialty})</p>
                <p><strong>Appointment Date:</strong> ${appointmentData.schedule}</p>
                <p><strong>Patient:</strong> ${appointmentData.patient_name}</p>
                <p><strong>Contact:</strong> ${appointmentData.contact}</p>
                <p><strong>Total Fee:</strong> $${doctorFee}</p>
            `;

            sessionStorage.setItem('doctorFee', doctorFee);
            document.getElementById('payment-confirmation-modal').style.display = 'flex';
        })
        .catch(error => {
            console.error("Error fetching doctor fee:", error);
            alert("Failed to retrieve fee details.");
        });
}

function processPayNow() {
    const appointmentData = JSON.parse(sessionStorage.getItem('appointmentData'));
    const doctorFee = sessionStorage.getItem('doctorFee');

    if (!appointmentData || !doctorFee) {
        alert("Session expired. Please restart.");
        return;
    }

    if (!appointmentData.doctor) {
        alert("Error: Doctor ID is missing.");
        return;
    }

    appointmentData.payment_status = "Done";
    appointmentData.amount = doctorFee; // ✅ Ensure amount is passed

    axios.post('/process-pay-now', appointmentData)
        .then(response => {
            if (response.data.success) {
                const bill = response.data.bill;

                document.getElementById('bill-content').innerHTML = `
                    <p><strong>Bill No:</strong> ${bill.bill_no}</p>
                    <p><strong>Doctor:</strong> ${bill.doctor_name} (${bill.specialty})</p>
                    <p><strong>Appointment Date:</strong> ${bill.appointment_date_time}</p>
                    <p><strong>Patient:</strong> ${bill.patient_name}</p>
                    <p><strong>Appointment No:</strong> ${bill.appointment_no}</p>
                    <p><strong>Amount Paid:</strong> $${bill.amount_paid}</p>
                `;

                document.getElementById('bill-modal').style.display = 'flex';
            } else {
                alert('Error: ' + response.data.message);
            }
        })
        .catch(error => {
            console.error('Payment error:', error);
            alert('Failed to process payment.');
        });
}


function downloadBill() {
    const billNo = document.querySelector('#bill-content p strong').innerText;
    window.location.href = `/download-bill/${billNo}`;
}


function finishBill() {
    document.getElementById('bill-modal').style.display = 'none';
    sessionStorage.removeItem('appointmentData');
    sessionStorage.removeItem('doctorFee');
    window.location.reload();
}

function closeModal() {
    document.getElementById('payment-modal').style.display = 'none';
}

function closePaymentModal() {
    document.getElementById('payment-confirmation-modal').style.display = 'none';
}


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
    </script>
</body>
</html>
