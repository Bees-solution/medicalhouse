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
        // Validate the input
        $request->validate([
            'days' => 'required|array|distinct',
            'days.*' => 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);
    
        $days = $request->days;
        $startTime = $request->start_time;
        $endTime = $request->end_time;
    
        $today = Carbon::today();
        $endDate = $today->copy()->addWeeks(2);
    
        // ** Step 1: Refill Logic **
        $this->refillSchedules($Doc_id, $today, $startTime, $endTime);
    
        // ** Step 2: Create New Schedules **
        foreach ($days as $day) {
            // Generate dates for the selected day within the two-week period
            $dates = CarbonPeriod::create($today, $endDate)
                ->filterByDays([$day]);
    
            foreach ($dates as $date) {
                // Check if the schedule already exists
                DoctorSchedule::firstOrCreate([
                    'Doc_id' => $Doc_id,
                    'date' => $date->toDateString(),
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                ]);
            }
        }
    
        return redirect()->back()->with('success', 'Schedules created and refilled successfully!');
    }
    
    private function refillSchedules($Doc_id, $today, $startTime, $endTime)
    {
        // Get all expired schedules (past schedules)
        $expiredSchedules = DoctorSchedule::where('Doc_id', $Doc_id)
            ->where('date', '<', $today)
            ->get();
    
        foreach ($expiredSchedules as $schedule) {
            // Calculate the new date two weeks ahead of the expired schedule
            $nextDate = Carbon::parse($schedule->date)->addWeeks(2);
    
            // Check if the schedule already exists for the new date
            $existingSchedule = DoctorSchedule::where('Doc_id', $Doc_id)
                ->where('date', $nextDate->toDateString())
                ->where('start_time', $startTime)
                ->where('end_time', $endTime)
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
        // Delete schedules matching the given date
        DoctorSchedule::where('date', $date)->delete();

        return redirect()->back()->with('success', 'Schedules for ' . $date . ' deleted successfully!');
    }
}
    