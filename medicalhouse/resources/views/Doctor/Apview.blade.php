<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Doctor's Appointments</title>
    
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- FontAwesome for Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

    <!-- Google Font: Source Code Pro -->
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fc;
            font-family: 'Source Code Pro', monospace;
        }
        .container {
            max-width: 1100px;
        }
        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }
        .badge {
            font-size: 0.9rem;
            padding: 8px 12px;
            border-radius: 12px;
        }
        .paid { background-color: #28a745; color: white; }
        .pending { background-color: #ffc107; color: black; }
        .btn-edit {
            background-color: #007bff;
            color: white;
            border-radius: 8px;
            padding: 5px 10px;
            font-size: 14px;
        }
        .btn-edit:hover {
            background-color: #0056b3;
        }
        .checkbox {
            width: 20px;
            height: 20px;
        }
        .header-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .appointment-info-box {
            display: flex;
            gap: 10px;
        }
        .appointment-count, .next-appointment {
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: bold;
            font-size: 1rem;
            text-align: center;
        }
        .next-appointment {
            background: #ff6b6b; /* Red color for next appointment */
        }
    </style>
</head>
<body>

    <div class="container py-4">
        
        <!-- Header Section -->
        <div class="header-box mb-4">
            <!-- Add Appointment Button -->
            <a href="{{ route('appointments.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Add Appointment
            </a>

            <!-- Appointment Info Box -->
            <div class="appointment-info-box">
                <div class="appointment-count">
                    📅 Today: {{ $todaysAppointments->count() }}
                </div>
                <div class="next-appointment">
                    ⏭ Next: 
                    @if($todaysAppointments->isNotEmpty())
                        {{ $todaysAppointments->sortBy('appointment_date_time')->first()->id }}
                    @else
                        No upcoming appointment today
                    @endif
                </div>
            </div>
        </div>

        <h2 class="text-center mb-4 text-primary fw-bold">📅 Admin - Dr. {{ $doctor->name }}'s Appointments</h2>

        <!-- Search Bar -->
        <div class="mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="🔍 Search by Patient Name or Appointment ID...">
        </div>

        <!-- Today's Appointments Table -->
        <div class="card p-3">
            <h4 class="text-primary">📅 Today's Appointments</h4>
            @if($todaysAppointments->isEmpty())
                <div class="text-center text-muted">No appointments booked today. 🎉</div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-primary">
                            <tr>
                                <th>
                                    <input type="checkbox" id="selectAllToday" class="checkbox">
                                </th>
                                <th>Appointment ID</th>
                                <th>Patient Name</th>
                                <th>Contact</th>
                                <th>Time</th>
                                <th>Payment Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="appointmentList">
                            @foreach ($todaysAppointments->sortBy('appointment_date_time') as $appointment)
                                <tr class="appointment-item">
                                    <td><input type="checkbox" class="checkbox today-checkbox"></td>
                                    <td><strong>{{ $appointment->id }}</strong></td>
                                    <td>{{ $appointment->patient_name }}</td>
                                    <td>{{ $appointment->contact_no }}</td>
                                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date_time)->format('h:i A') }}</td>
                                    <td>
                                        <span class="badge {{ $appointment->payment_status == 'Done' ? 'paid' : 'pending' }}">
                                            {{ $appointment->payment_status }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById("searchInput");
            searchInput.addEventListener("keyup", filterAppointments);

            function filterAppointments() {
                let input = searchInput.value.toLowerCase();
                let rows = document.querySelectorAll("#appointmentList tr");

                rows.forEach(row => {
                    let name = row.cells[2]?.textContent.toLowerCase() || ""; // Patient Name
                    let appointmentId = row.cells[1]?.textContent.toLowerCase() || ""; // Appointment ID
                    
                    row.style.display = (name.includes(input) || appointmentId.includes(input)) ? "table-row" : "none";
                });
            }

            document.getElementById("selectAllToday").addEventListener("change", function () {
                toggleSelectAll("today-checkbox", this.checked);
            });

            function toggleSelectAll(className, checked) {
                document.querySelectorAll("." + className).forEach(checkbox => checkbox.checked = checked);
            }
        });
    </script>

</body>
</html>
