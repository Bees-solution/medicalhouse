<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmed</title>
    <style>
        .as-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f9f9f9;
        }

        .as-message-box {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        .as-message-box h2 {
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="as-container">
        <div class="as-message-box">
            <h2>Appointment Confirmed!</h2>

            <p>Appointment Number: <strong>{{ $appointment->appointment_no }}</strong></p>
            <p>Appointment ID: <strong>{{ $appointment->id }}</strong></p>
            <p>Doctor Name: <strong>{{ $appointment->doctor_name }}</strong></p>
            <p>Scheduled Date & Time: <strong>{{ date('M d, Y h:i A', strtotime($appointment->appointment_date_time)) }}</strong></p>

            <p>Please pay at the hospital counter before your consultation.</p>
        </div>
    </div>
</body>
</html>
