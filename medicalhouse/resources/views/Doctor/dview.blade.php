<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #eef2f7;
            font-family: 'Poppins', sans-serif;
        }
        .doctor-card {
            border-radius: 15px;
            padding: 25px;
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
        }
        .doctor-card:hover {
            transform: translateY(-5px);
        }
        .doctor-info {
            display: flex;
            align-items: center;
            gap: 30px;
        }
        .doctor-image {
            width: 160px;
            height: 160px;
            border-radius: 15px;
            object-fit: cover;
            border: 5px solid #007bff;
        }
        .schedule-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #007bff;
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            margin: 8px 0;
            cursor: pointer;
            transition: 0.3s;
            font-weight: bold;
        }
        .schedule-box:hover {
            background-color: #0056b3;
        }
        .schedule-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
        }
        .book-btn {
            background: linear-gradient(90deg, #28a745, #218838);
            color: white;
            padding: 14px 24px;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            transition: 0.3s;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .book-btn:hover {
            background: linear-gradient(90deg, #218838, #1e7e34);
        }
        @media (max-width: 768px) {
            .doctor-info {
                flex-direction: column;
                text-align: center;
            }
            .schedule-container {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4 text-primary">Doctor Profile</h1>
        <div class="doctor-card p-4">
            <div class="doctor-info">
                <img src="{{ asset('storage/' . $doctor->image) }}" alt="Doctor Image" class="doctor-image">
                <div>
                    <h3 class="text-primary">Dr. {{ $doctor->name }}</h3>
                    <h5 class="text-secondary">{{ $doctor->Specialty }}</h5>
                    <p><strong>Fee:</strong> RS. {{ number_format($doctor->Fee, 2) }}</p>
                    <p><strong>License:</strong> {{ $doctor->License }}</p>
                    <p><strong>Gender:</strong> {{ $doctor->gender }}</p>
                    <p><strong>Qualification:</strong> {{ $doctor->Qualification }}</p>
                    <p><strong>Remarks:</strong> {{ $doctor->remarks ?? 'No remarks' }}</p>
                </div>
            </div>
            
            <!-- Schedule Section -->
            <h4 class="mt-4 text-center">Available Days & Times</h4>
            <div class="schedule-container">
                @if($doctor->schedules->isNotEmpty())
                    @foreach($doctor->schedules->groupBy(fn($s) => \Carbon\Carbon::parse($s->date)->format('l')) as $day => $schedules)
                        <div class="schedule-box" onclick="window.location='{{ route('customer.doctor.schedule', ['id' => $doctor->Doc_id, 'day' => $day]) }}'">
                            <span>{{ $day }}</span>
                            <span>{{ $schedules->first()->start_time }} - {{ $schedules->first()->end_time }}</span>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center">No available schedules.</p>
                @endif
            </div>
            
            <div class="mt-4 text-center">
                <a href="#" class="btn book-btn">Book Appointment</a>
                <a href="{{ route('customer.doctor.list') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
</body>
</html>
