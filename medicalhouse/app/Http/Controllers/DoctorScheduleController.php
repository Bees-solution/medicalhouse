<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DoctorScheduleController extends Controller
{
    /**
     * Display the schedule creation view for a specific doctor.
     */
    public function create($Doc_id)
    {
        // Fetch doctor details
        $doctor = Doctor::findOrFail($Doc_id);

        // Pass doctor details to the view
        return view('Doctor.dscreate', [
            'doctor' => $doctor,
        ]);
    }

    /**
     * Store the schedule for the doctor for the next 2 weeks.
     */
    public function store(Request $request, $Doc_id)
    {
        $request->validate([
            'dates' => 'required|array|min:1',
            'dates.*' => 'regex:/^\d{2}\.\d{2}\.\d{4}$/', // Validate DD.MM.YYYY format
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $startTime = $request->start_time;
        $endTime = $request->end_time;
        $duplicateDates = [];
        $today = Carbon::today();

        // **Step 1: Delete old schedules that are already finished**
        $this->deleteOldSchedules($Doc_id, $today);

        foreach ($request->dates as $formattedDate) {
            // Convert DD.MM.YYYY to YYYY-MM-DD
            $date = Carbon::createFromFormat('d.m.Y', $formattedDate)->format('Y-m-d');

            // Check if schedule already exists for this doctor on this date
            $existingSchedule = DoctorSchedule::where('Doc_id', $Doc_id)
                ->where('date', $date)
                ->exists();

            if ($existingSchedule) {
                $duplicateDates[] = $formattedDate; // Store duplicates for error message
            } else {
                DoctorSchedule::create([
                    'Doc_id' => $Doc_id,
                    'date' => $date,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                ]);
            }
        }

        // **Step 2: Auto refill past schedules**
        $this->refillSchedules($Doc_id, $today, $startTime, $endTime);

        // If duplicates were found, return an error message
        if (!empty($duplicateDates)) {
            return redirect()->back()->withErrors([
                'error' => 'The following dates already exist for this doctor: ' . implode(', ', $duplicateDates),
            ])->withInput();
        }

        return redirect()->back()->with('success', 'Schedules created successfully!');
    }

    /**
     * Deletes old schedules (schedules that have passed).
     */
    private function deleteOldSchedules($Doc_id, $today)
    {
        DoctorSchedule::where('Doc_id', $Doc_id)
            ->where('date', '<', $today)
            ->delete();
    }

    /**
     * Automatically refill expired schedules by adding new ones two weeks ahead.
     */
    private function refillSchedules($Doc_id, $today, $startTime, $endTime)
    {
        // Get all expired schedules (past schedules)
        $expiredSchedules = DoctorSchedule::where('Doc_id', $Doc_id)
            ->where('date', '<', $today)
            ->get();

        foreach ($expiredSchedules as $schedule) {
            // Calculate the new date two weeks ahead of the expired schedule
            $nextDate = Carbon::parse($schedule->date)->addWeeks(2);

            // Ensure the new schedule falls on the same weekday
            if ($nextDate->format('l') !== Carbon::parse($schedule->date)->format('l')) {
                continue;
            }

            // Check if the schedule already exists for the new date
            $existingSchedule = DoctorSchedule::where('Doc_id', $Doc_id)
                ->where('date', $nextDate->toDateString())
                ->where('start_time', $schedule->start_time)
                ->where('end_time', $schedule->end_time)
                ->exists();

            // Create the new schedule if it doesn't exist
            if (!$existingSchedule) {
                DoctorSchedule::create([
                    'Doc_id' => $Doc_id,
                    'date' => $nextDate->toDateString(),
                    'start_time' => $schedule->start_time,
                    'end_time' => $schedule->end_time,
                ]);
            }
        }
    }

    /**
     * Delete a schedule by a specific day.
     */
    public function destroyByDay($date)
    {
        DoctorSchedule::where('date', $date)->delete();
        return redirect()->back()->with('success', 'Schedules for ' . $date . ' deleted successfully!');
    }
}
