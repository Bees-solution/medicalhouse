<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Appointment Bill</title>
    <style>
        body { font-family: sans-serif; }
        .container { border: 1px solid #ccc; padding: 20px; width: 100%; }
        .title { text-align: center; font-size: 20px; font-weight: bold; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">Appointment Bill</div>

        <p><strong>Bill No:</strong> {{ $bill->bill_no }}</p>
        <p><strong>Bill Date:</strong> {{ $bill->bill_date }}</p>
        <p><strong>Payment ID:</strong> {{ $payment->id ?? '-' }}</p>

        <p><strong>Doctor:</strong> {{ $doctor->name ?? '' }} ({{ $doctor->Specialty ?? '' }})</p>
        <p><strong>Appointment Date:</strong> {{ $appointment->appointment_date_time ?? '' }}</p>
        <p><strong>Patient:</strong> {{ $appointment->patient_name ?? '' }}</p>
        <p><strong>Appointment No:</strong> {{ $appointment->appointment_no ?? '' }}</p>
        <p><strong>Amount Paid:</strong> ${{ $payment->amount ?? '' }}</p>
    </div>
</body>
</html>
