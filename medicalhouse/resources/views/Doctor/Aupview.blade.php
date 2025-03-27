<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Appointments</title>

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- FontAwesome Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <style>
        body { background-color: #f8f9fa; font-family: 'Arial', sans-serif; }
        .container { max-width: 1200px; }
        .btn-add { background-color: #007bff; color: white; padding: 6px 12px; border-radius: 5px; }
        .btn-add:hover { background-color: #0056b3; }
        .btn-delete { background-color: #dc3545; color: white; padding: 6px 12px; border-radius: 5px; display: none; }
        .btn-delete:hover { background-color: #b02a37; }
        .badge.paid { background-color: #28a745; color: white; }
        .badge.pending { background-color: #ffc107; color: black; }
        .table th, .table td { text-align: center; vertical-align: middle; }
        .checkbox { width: 18px; height: 18px; cursor: pointer; }
        .table-container { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body>

<div class="container py-4">
    <h2 class="text-primary fw-bold text-center mb-4">📅 Upcoming Appointments for Dr. {{ $doctor->name }}</h2>

    <!-- Action Buttons -->
    <div class="d-flex justify-content-between mb-3">
       <a href="{{ route('admin.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Schedules
        </a>
        <div>
            <button id="deleteSelectedBtn" class="btn btn-delete">
                <i class="fas fa-trash"></i> Delete Selected
            </button>
            </a>
        </div>
    </div>

    <!-- Table Container -->
    <div class="table-container">
        <div class="mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="🔍 Search by Patient Name or Appointment ID...">
        </div>

        @if($upcomingAppointments->isEmpty())
            <div class="text-center text-muted py-4">
                <i class="fas fa-info-circle"></i> No upcoming appointments found. 🎉
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="appointmentsTable">
                    <thead class="table-primary">
                        <tr>
                            <th><input type="checkbox" id="selectAll" class="checkbox"></th>
                            <th>ID</th>
                            <th>Patient Name</th>
                            <th>Age</th>
                            <th>Doctor Name</th>
                            <th>Department</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Payment Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($upcomingAppointments as $appointment)
                            <tr>
                                <td><input type="checkbox" class="rowCheckbox checkbox"></td>
                                <td><strong>{{ $appointment->id }}</strong></td>
                                <td>
                                    <img src="/images/user-avatar.png" alt="Avatar" class="rounded-circle" width="30">
                                    {{ $appointment->patient_name }}
                                </td>
                                <td>{{ $appointment->age }}</td>
                                <td>{{ $appointment->doctor->name }}</td>
                                <td>{{ $appointment->doctor->department }}</td>
                                <td>{{ \Carbon\Carbon::parse($appointment->appointment_date_time)->format('M d, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($appointment->appointment_date_time)->format('h:i A') }}</td>
                                <td>
                                    <span class="badge {{ $appointment->payment_status == 'Done' ? 'paid' : 'pending' }}">
                                        {{ $appointment->payment_status }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<!-- Bootstrap & jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        let table = $('#appointmentsTable').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "lengthMenu": [10, 25, 50, 100]
        });

        // Search Functionality
        $('#searchInput').on('keyup', function () {
            table.search(this.value).draw();
        });

        // Select All Checkboxes
        $('#selectAll').on('change', function () {
            $('.rowCheckbox').prop('checked', this.checked);
            toggleDeleteButton();
        });

        // Show Delete Button When Rows Are Selected
        $('.rowCheckbox').on('change', function () {
            toggleDeleteButton();
        });

        function toggleDeleteButton() {
            let anyChecked = $('.rowCheckbox:checked').length > 0;
            $('#deleteSelectedBtn').toggle(anyChecked);
        }
    });
</script>

</body>
</html>
