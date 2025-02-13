@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="text-center text-primary fw-bold">📅 Upcoming Appointments for Dr. {{ $doctor->name }}</h2>

    @if($upcomingAppointments->isEmpty())
        <div class="text-center text-muted">No upcoming appointments found. 🎉</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>Appointment ID</th>
                        <th>Patient Name</th>
                        <th>Contact</th>
                        <th>Date & Time</th>
                        <th>Payment Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($upcomingAppointments as $appointment)
                        <tr>
                            <td><strong>{{ $appointment->id }}</strong></td>
                            <td>{{ $appointment->patient_name }}</td>
                            <td>{{ $appointment->contact_no }}</td>
                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_date_time)->format('M d, h:i A') }}</td>
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
@endsection
