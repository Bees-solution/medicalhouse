<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .doctor-image {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ddd;
        }
        .table-dark th {
            text-align: center;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f3f5;
        }
        .btn {
            font-size: 0.9rem;
        }
        .schedule-list {
            padding-left: 0;
            list-style: none;
        }
        .schedule-list li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Top Bar -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary">Doctors</h1>
            <a href="{{ route('doctor.create') }}" class="btn btn-primary btn-lg">Add Doctor</a>
        </div>

        <!-- Search Bar -->
        <form action="{{ route('doctor.index') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search by name or ID" value="{{ request('search') }}">
                <button type="submit" class="btn btn-secondary">Search</button>
            </div>
        </form>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Doctors Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Image</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Fee (RS.)</th>
                        <th>Patients</th>
                        <th>Specialty</th>
                        <th>Gender</th>
                        <th>Schedules</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($doctors as $doctor)
                        <tr>
                            <!-- Image -->
                            <td class="text-center">
                                @if ($doctor->image && file_exists(public_path('storage/' . $doctor->image)))
                                    <img src="{{ asset('storage/' . $doctor->image) }}" alt="Doctor Image" class="doctor-image">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <!-- ID -->
                            <td class="text-center"><strong>{{ $doctor->Doc_id }}</strong></td>
                            <!-- Name -->
                            <td>
                                <strong>{{ $doctor->name }}</strong><br>
                                <small class="text-muted">License: {{ $doctor->License }}</small>
                            </td>
                            <!-- Type -->
                            <td class="text-center">{{ $doctor->Type }}</td>
                            <!-- Fee -->
                            <td class="text-center">RS. {{ number_format($doctor->Fee, 2) }}</td>
                            <!-- Patients -->
                            <td class="text-center">{{ $doctor->No_of_patients }}</td>
                            <!-- Specialty -->
                            <td class="text-center">{{ $doctor->Specialty }}</td>
                            <!-- Gender -->
                            <td class="text-center">{{ $doctor->gender }}</td>
                            <!-- Schedules -->
                            <td>
                                @if ($doctor->schedules->isNotEmpty())
                                    <ul class="schedule-list">
                                        @foreach ($doctor->schedules as $schedule)
                                            <li>{{ \Carbon\Carbon::parse($schedule->available_date)->format('l') }}: {{ $schedule->start_time }} - {{ $schedule->end_time }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted">No schedules available</span>
                                @endif
                            </td>
                            <!-- Actions -->
                            <td class="text-center">
                                <a href="{{ route('doctor.edit', $doctor->Doc_id) }}" class="btn btn-warning btn-sm mb-1">Update</a>
                                <a href="{{ route('doctor.schedule.create', $doctor->Doc_id) }}" class="btn btn-success btn-sm mb-1">Schedule</a>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-docid="{{ $doctor->Doc_id }}">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">No doctors available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>To confirm deletion, type <strong>delete</strong> in the box below:</p>
                    <input type="text" id="confirmInput" class="form-control" placeholder="Type 'delete' to confirm">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="confirmDeleteButton" class="btn btn-danger" disabled>Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const deleteModal = document.getElementById('deleteModal');
        const confirmInput = document.getElementById('confirmInput');
        const confirmDeleteButton = document.getElementById('confirmDeleteButton');
        const deleteForm = document.getElementById('deleteForm');

        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const doctorId = button.getAttribute('data-docid');
            const actionUrl = `/doctor/${doctorId}`;
            deleteForm.setAttribute('action', actionUrl);
        });

        confirmInput.addEventListener('input', function () {
            confirmDeleteButton.disabled = confirmInput.value.trim().toLowerCase() !== 'delete';
        });

        deleteModal.addEventListener('hidden.bs.modal', function () {
            confirmInput.value = '';
            confirmDeleteButton.disabled = true;
        });
    </script>
</body>
</html>
