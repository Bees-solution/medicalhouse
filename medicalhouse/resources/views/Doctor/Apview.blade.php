<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's Appointments</title>
    
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- FontAwesome for Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            max-width: 900px;
        }
        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .stat-box {
            text-align: center;
            padding: 20px;
            border-radius: 12px;
            color: white;
            font-size: 1.4rem;
            font-weight: bold;
        }
        .available-slots { background: linear-gradient(135deg, #28a745, #00d4ff); }
        .today-appointments { background: linear-gradient(135deg, #ff5722, #ff9800); }
        .upcoming-appointments { background: linear-gradient(135deg, #007bff, #00d4ff); }
        .search-box {
            margin-bottom: 20px;
        }
        .appointment-card {
            border-radius: 12px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            padding: 15px;
            background: white;
            transition: transform 0.2s ease-in-out;
        }
        .appointment-card:hover {
            transform: scale(1.03);
        }
        .badge {
            font-size: 0.9rem;
            padding: 10px 15px;
            border-radius: 12px;
        }
        .paid { background-color: #28a745; color: white; }
        .pending { background-color: #ffc107; color: black; }
        .card-body p { margin-bottom: 8px; }
        .search-box input { width: 100%; padding: 8px; border-radius: 8px; border: 1px solid #ccc; }
    </style>
</head>
<body>

    <div class="container py-5">
        <h2 class="text-center mb-4 text-primary fw-bold">📅 Dr. {{ $doctor->name }}'s Appointments</h2>

        <!-- Stats Section -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stat-box available-slots">
                    🏥 Available Slots Today: {{ $availableSlots }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-box today-appointments">
                    📌 Today's Appointments: {{ $todaysAppointments->count() }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-box upcoming-appointments">
                    ⏳ Upcoming Appointments: {{ $upcomingAppointments->count() }}
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="🔍 Search by Patient Name or Appointment ID..." onkeyup="filterAppointments()">
        </div>

        <!-- Today's Appointments -->
        <h4 class="text-primary">📅 Today's Appointments</h4>
        <div class="row" id="appointmentList">
            @if($todaysAppointments->isEmpty())
                <div class="col-12">
                    <div class="alert alert-warning text-center">No appointments booked today. 🎉</div>
                </div>
            @else
                @foreach ($todaysAppointments as $appointment)
                    <div class="col-md-6 mb-4 appointment-item">
                        <div class="appointment-card p-3">
                            <h5>📌 Appointment ID: <strong>{{ $appointment->id }}</strong></h5>
                            <p>👤 <strong>Patient:</strong> {{ $appointment->patient_name }}</p>
                            <p>📞 <strong>Contact:</strong> {{ $appointment->contact_no }}</p>
                            <p>⏰ <strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date_time)->format('h:i A') }}</p>
                            <p>💳 <strong>Payment Status:</strong> 
                                <span class="badge {{ $appointment->payment_status == 'Done' ? 'paid' : 'pending' }}">
                                    {{ $appointment->payment_status }}
                                </span>
                            </p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Upcoming Appointments -->
        <h4 class="text-success">⏳ Upcoming Appointments</h4>
        <div class="row" id="appointmentList">
            @if($upcomingAppointments->isEmpty())
                <div class="col-12">
                    <div class="alert alert-info text-center">No upcoming appointments. 📆</div>
                </div>
            @else
                @foreach ($upcomingAppointments as $appointment)
                    <div class="col-md-6 mb-4 appointment-item">
                        <div class="appointment-card p-3">
                            <h5>📌 Appointment ID: <strong>{{ $appointment->id }}</strong></h5>
                            <p>👤 <strong>Patient:</strong> {{ $appointment->patient_name }}</p>
                            <p>📞 <strong>Contact:</strong> {{ $appointment->contact_no }}</p>
                            <p>📅 <strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date_time)->format('M d, Y') }}</p>
                            <p>⏰ <strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date_time)->format('h:i A') }}</p>
                            <p>💳 <strong>Payment Status:</strong> 
                                <span class="badge {{ $appointment->payment_status == 'Done' ? 'paid' : 'pending' }}">
                                    {{ $appointment->payment_status }}
                                </span>
                            </p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <script>
        function filterAppointments() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let items = document.querySelectorAll(".appointment-item");

            items.forEach(item => {
                let name = item.querySelector("p:nth-child(2)").textContent.toLowerCase();
                let appointmentId = item.querySelector("h5").textContent.toLowerCase();
                
                if (name.includes(input) || appointmentId.includes(input)) {
                    item.style.display = "block";
                } else {
                    item.style.display = "none";
                }
            });
        }
    </script>

</body>
</html>
