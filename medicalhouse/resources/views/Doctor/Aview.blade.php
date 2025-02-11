<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Schedules</title>
    
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- FontAwesome for Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

    <!-- Google Font: Source Code Pro -->
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Source Code Pro', monospace;
        }
        .container {
            max-width: 900px;
        }
        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            font-size: 1.4rem;
            font-weight: 600;
            padding: 15px;
        }
        .list-group-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border: none;
            background: #fff;
            transition: all 0.3s ease;
        }
        .list-group-item:hover {
            background: #f8f9fa;
        }
        .badge {
            font-size: 0.9rem;
            padding: 10px 15px;
            border-radius: 12px;
        }
        .bg-today {
            background: linear-gradient(135deg, #007bff, #00d4ff);
            color: white;
        }
        .bg-upcoming {
            background: linear-gradient(135deg, #28a745, #00d4ff);
            color: white;
        }
        .doctor-name {
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
            color: #333;
            transition: color 0.3s ease;
        }
        .doctor-name:hover {
            color: #007bff;
        }
        .schedule-time {
            font-size: 0.9rem;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="container py-5">
        <h2 class="text-center mb-5 text-primary fw-bold">📅 Doctor Schedules</h2>

        <!-- Today's Schedules -->
        <div class="card mb-4">
            <div class="card-header bg-today text-white">
                <h4 class="mb-0"><i class="fas fa-calendar-day me-2"></i>Today's Schedules ({{ \Carbon\Carbon::today()->toFormattedDateString() }})</h4>
            </div>
            <div class="card-body">
                @if($todaysSchedules->isEmpty())
                    <div class="alert alert-warning text-center">No doctors are scheduled today. 🎉</div>
                @else
                    <ul class="list-group list-group-flush">
                        @foreach ($todaysSchedules as $schedule)
                            <li class="list-group-item">
                                <div class="doctor-info">
                                    <i class="fas fa-user-md text-primary"></i>
                                    <a href="{{ route('doctor.appointments', ['doc_id' => $schedule->doctor->Doc_id]) }}" class="doctor-name ms-2">
                                        Dr. {{ $schedule->doctor->name ?? 'Unknown' }}
                                    </a>
                                </div>
                                <span class="badge bg-success">
                                    <i class="far fa-clock"></i>
                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }} - 
                                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <!-- Upcoming Schedules -->
        <div class="card">
            <div class="card-header bg-upcoming text-white">
                <h4 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Upcoming Schedules</h4>
            </div>
            <div class="card-body">
                @if($upcomingSchedules->isEmpty())
                    <div class="alert alert-info text-center">No upcoming schedules. 📆</div>
                @else
                    <ul class="list-group list-group-flush">
                        @foreach ($upcomingSchedules->groupBy('doctor.Doc_id') as $doctorSchedules)
                            @php
                                $firstSchedule = $doctorSchedules->first();
                                $scheduleDate = \Carbon\Carbon::parse($firstSchedule->date)->format('M d, Y');
                                $startTime = $doctorSchedules->min('start_time');
                                $endTime = $doctorSchedules->max('end_time');
                            @endphp
                            <li class="list-group-item">
                                <div class="doctor-info">
                                    <i class="fas fa-user-md text-success"></i>
                                    <a href="#" class="doctor-name ms-2">
                                        Dr. {{ $firstSchedule->doctor->name ?? 'Unknown' }}
                                    </a>
                                </div>
                                <span class="badge bg-warning text-dark">
                                    <i class="far fa-calendar"></i>
                                    {{ $scheduleDate }},
                                    {{ \Carbon\Carbon::parse($startTime)->format('h:i A') }} - 
                                    {{ \Carbon\Carbon::parse($endTime)->format('h:i A') }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
