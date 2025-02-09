<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book an Appointment</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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
    </style>
</head>
<body>
    <div class="af-body-container">
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
</body>
</html>



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
</script>

</html>
