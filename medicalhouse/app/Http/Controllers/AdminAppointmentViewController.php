<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DoctorSchedule;
use App\Models\Doctor;
use App\Models\Appointment;
use Carbon\Carbon;

class AdminAppointmentViewController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Get today's schedules
        $todaysSchedules = DoctorSchedule::with('doctor')
            ->whereDate('date', $today)
            ->orderBy('start_time', 'asc')
            ->get();

        // Get upcoming schedules
        $upcomingSchedules = DoctorSchedule::with('doctor')
            ->whereDate('date', '>', $today)
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        return view('Doctor.Aview', compact('todaysSchedules', 'upcomingSchedules'));
    }

    public function showDoctorAppointments($doc_id)
    {
        $today = Carbon::today();

        // Get doctor details
        $doctor = Doctor::where('Doc_id', $doc_id)->firstOrFail();

        // Get total available slots for today
        $availableSlots = DoctorSchedule::where('Doc_id', $doc_id)
            ->whereDate('date', $today)
            ->count();

        // Get ONLY today's booked appointments
        $todaysAppointments = Appointment::where('doctor_id', $doc_id)
            ->whereDate('appointment_date_time', $today)
            ->get();

        // Get ONLY upcoming appointments (after today)
        $upcomingAppointments = Appointment::where('doctor_id', $doc_id)
            ->whereDate('appointment_date_time', '>', $today)
            ->get();

        return view('Doctor.Apview', compact('doctor', 'availableSlots', 'todaysAppointments', 'upcomingAppointments'));
    }
}