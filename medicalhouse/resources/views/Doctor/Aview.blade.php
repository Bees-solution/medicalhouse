@extends('layouts.admin')

@section('content')
    <!-- Sidebar Toggle Button -->
    <button id="sidebarToggle" class="btn btn-primary"><i class="fas fa-bars"></i></button>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container py-5">
            <h2 class="text-center mb-5 text-primary fw-bold">📅 Doctor Schedules</h2>

            <!-- Today's Schedules -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4><i class="fas fa-calendar-day me-2"></i>Today's Schedules</h4>
                </div>
                <div class="card-body">
                    @if($todaysSchedules->isEmpty())
                        <div class="alert alert-warning text-center">No doctors are scheduled today. 🎉</div>
                    @else
                        <ul class="list-group">
                            @foreach ($todaysSchedules as $schedule)
                                <li class="list-group-item d-flex justify-content-between">
                                    <a href="{{ route('doctor.appointments', ['doc_id' => $schedule->doctor->Doc_id]) }}" class="doctor-name">
                                        Dr. {{ $schedule->doctor->name ?? 'Unknown' }}
                                    </a>
                                    <span class="badge bg-success">{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <!-- Upcoming Schedules -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4><i class="fas fa-calendar-alt me-2"></i>Upcoming Schedules</h4>
                </div>
                <div class="card-body">
                    @if($upcomingSchedules->isEmpty())
                        <div class="alert alert-info text-center">No upcoming schedules. 📆</div>
                    @else
                        <ul class="list-group">
                            @foreach ($upcomingSchedules->groupBy('doctor.Doc_id') as $doctorSchedules)
                                @php $firstSchedule = $doctorSchedules->first(); @endphp
                                <li class="list-group-item d-flex justify-content-between">
                                    <a href="{{ route('doctor.upcomingAppointments', ['doctor_id' => $firstSchedule->doctor->Doc_id]) }}" class="doctor-name ms-2">
                                        Dr. {{ $firstSchedule->doctor->name ?? 'Unknown' }}
                                    </a>
                                    <span class="badge bg-warning text-dark">{{ \Carbon\Carbon::parse($firstSchedule->date)->format('M d, Y') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const sidebarToggle = document.getElementById("sidebarToggle");
            const sidebar = document.getElementById("sidebar");
            const mainContent = document.querySelector(".main-content");

            sidebarToggle.addEventListener("click", function () {
                sidebar.classList.toggle("hidden");
                mainContent.classList.toggle("collapsed");
            });
        });
    </script>
@endsection
