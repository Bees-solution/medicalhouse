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

        <!-- Schedule Creation Form -->
        <div class="card mb-4">
            <div class="card-header text-center">Create a Weekly Schedule</div>
            <div class="card-body">
                <form action="{{ route('doctor.schedule.store', $doctor->Doc_id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Select Days</label>
                        <div id="day-selector" class="d-flex flex-wrap">
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                <div class="day-button" data-day="{{ $day }}">{{ $day }}</div>
                            @endforeach
                        </div>
                        <!-- Hidden inputs for multiple selected days -->
                        <div id="days-container"></div>
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

        <!-- Existing Schedules -->
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
            const daysContainer = document.getElementById('days-container');
            const selectedDays = new Set();

            dayButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const day = button.getAttribute('data-day');
                    if (selectedDays.has(day)) {
                        selectedDays.delete(day);
                        button.classList.remove('selected');
                        removeDayInput(day);
                    } else {
                        selectedDays.add(day);
                        button.classList.add('selected');
                        addDayInput(day);
                    }
                });
            });

            function addDayInput(day) {
                if (!document.getElementById(`day-${day}`)) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'days[]';
                    input.value = day;
                    input.id = `day-${day}`;
                    daysContainer.appendChild(input);
                }
            }

            function removeDayInput(day) {
                const input = document.getElementById(`day-${day}`);
                if (input) {
                    input.remove();
                }
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
