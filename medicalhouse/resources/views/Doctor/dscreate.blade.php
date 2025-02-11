<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Schedule</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .day-button {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            border: 2px solid #ddd;
            border-radius: 5px;
            background-color: #f8f9fa;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .day-button:hover {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }
        .day-button.selected {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Schedule for Dr. {{ $doctor->name }}</h2>
        <p class="text-center text-muted">Specialty: {{ $doctor->Specialty }}</p>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header text-center">Create a Weekly Schedule</div>
            <div class="card-body">
                <form id="scheduleForm" action="{{ route('doctor.schedule.store', $doctor->Doc_id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Select Days</label>
                        <div id="day-selector" class="d-flex flex-wrap">
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                <div class="day-button" data-day="{{ $day }}">{{ $day }}</div>
                            @endforeach
                        </div>
                        <div id="dateFields"></div>
                        <small class="form-text text-muted">Click on the days to select them.</small>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_time" class="form-label">Start Time</label>
                            <input type="time" name="start_time" id="start_time" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="end_time" class="form-label">End Time</label>
                            <input type="time" name="end_time" id="end_time" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Add Schedule</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header text-center">Weekly Schedules</div>
            <div class="card-body">
                @if($doctor->schedules->isEmpty())
                    <p class="text-muted text-center">No schedules available.</p>
                @else
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($doctor->schedules as $schedule)
                                <tr>
                                    <td>{{ $schedule->date }}</td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->date)->format('l') }}</td>
                                    <td>{{ $schedule->start_time }}</td>
                                    <td>{{ $schedule->end_time }}</td>
                                    <td>
                                        <form action="{{ route('doctor.schedule.destroy', ['Doc_id' => $doctor->Doc_id, 'date' => $schedule->date]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dayButtons = document.querySelectorAll('.day-button');
            const dateFieldsContainer = document.getElementById('dateFields');
            const selectedDays = new Set();

            dayButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const day = button.getAttribute('data-day');
                    if (selectedDays.has(day)) {
                        selectedDays.delete(day);
                        button.classList.remove('selected');
                    } else {
                        selectedDays.add(day);
                        button.classList.add('selected');
                    }
                    generateDates();
                });
            });

            function generateDates() {
                dateFieldsContainer.innerHTML = "";
                let today = new Date();
                let endDate = new Date();
                endDate.setDate(today.getDate() + 14); // Next two weeks

                selectedDays.forEach(day => {
                    let tempDate = new Date(today);
                    while (tempDate <= endDate) {
                        if (tempDate.toLocaleDateString('en-US', { weekday: 'long' }) === day) {
                            let formattedDate = tempDate.toLocaleDateString('en-GB').replace(/\//g, '.'); // Convert to DD.MM.YYYY
                            let input = document.createElement("input");
                            input.type = "hidden";
                            input.name = "dates[]";
                            input.value = formattedDate;
                            dateFieldsContainer.appendChild(input);
                        }
                        tempDate.setDate(tempDate.getDate() + 1);
                    }
                });
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
