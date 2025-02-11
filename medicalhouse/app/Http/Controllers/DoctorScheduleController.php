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
        // Ensure the Doctor ID is valid
        $doctor = Doctor::find($Doc_id);
        if (!$doctor) {
            return redirect()->back()->withErrors(['error' => 'Doctor not found.']);
        }

        // Validate request data
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
        $selectedWeekdays = [];

        // **Step 1: Delete old schedules**
        $this->deleteOldSchedules($today);

        // **Step 2: Store the selected schedules**
        foreach ($request->dates as $formattedDate) {
            $date = Carbon::createFromFormat('d.m.Y', $formattedDate);
            $dayOfWeek = $date->dayOfWeek; // Get weekday (0=Sunday, 1=Monday, ..., 6=Saturday)

            // Store selected weekdays for auto-filling
            if (!in_array($dayOfWeek, $selectedWeekdays)) {
                $selectedWeekdays[] = $dayOfWeek;
            }

            // **Check if schedule already exists before inserting**
            $existingSchedule = DoctorSchedule::where('Doc_id', $Doc_id)
                ->where('date', $date->format('Y-m-d'))
                ->where('start_time', $startTime)
                ->where('end_time', $endTime)
                ->exists();

            if ($existingSchedule) {
                $duplicateDates[] = $formattedDate;
            } else {
                DoctorSchedule::create([
                    'Doc_id' => $Doc_id,
                    'date' => $date->format('Y-m-d'),
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                ]);
            }
        }

        // **Step 3: Auto-fill missing schedules based on selected weekdays**
        $this->autoFillSchedules($Doc_id, $startTime, $endTime, $selectedWeekdays);

        if (!empty($duplicateDates)) {
            return redirect()->back()->withErrors([
                'error' => 'The following dates already exist: ' . implode(', ', $duplicateDates),
            ])->withInput();
        }

        return redirect()->back()->with('success', 'Schedules created successfully!');
    }


    /**
     * Deletes expired schedules (for all doctors).
     */
    private function deleteOldSchedules($today)
    {
        DoctorSchedule::whereDate('date', '<', $today)->delete();
    }

    /**
     * Automatically fills missing schedules for the next 2 weeks based on selected weekdays.
     */
    private function autoFillSchedules($Doc_id, $startTime, $endTime, $selectedWeekdays)
    {
        $today = Carbon::today();
        $twoWeeksLater = Carbon::today()->addWeeks(2);

        // Ensure the doctor exists before proceeding
        $doctor = Doctor::find($Doc_id);
        if (!$doctor) {
            return;
        }

        $dateRange = CarbonPeriod::create($today, $twoWeeksLater);

        foreach ($dateRange as $date) {
            $formattedDate = $date->format('Y-m-d');
            $dayOfWeek = $date->dayOfWeek;

            // Skip days that are not in the selected weekdays
            if (!in_array($dayOfWeek, $selectedWeekdays)) {
                continue;
            }

            // Check if schedule already exists for that day
            $existingSchedule = DoctorSchedule::where('Doc_id', $Doc_id)
                ->where('date', $formattedDate)
                ->exists();

            // If no schedule exists, create a new one
            if (!$existingSchedule) {
                DoctorSchedule::create([
                    'Doc_id' => $Doc_id,
                    'date' => $formattedDate,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                ]);
            }
        }
    }

    /**
     * Delete schedules by a specific day.
     */
    public function destroyByDay($date)
    {
        DoctorSchedule::whereDate('date', $date)->delete();
        return redirect()->back()->with('success', 'Schedules for ' . $date . ' deleted successfully!');
    }

    /**
     * Fetch schedules for a doctor within the next two weeks.
     */
    public function getSchedulesByDoctor(Request $request)
    {
        $request->validate(['doctor_id' => 'required|integer']);

        $today = now()->startOfDay();
        $twoWeeksLater = now()->addWeeks(2)->endOfDay();

        $schedules = DoctorSchedule::where('Doc_id', $request->doctor_id)
            ->whereBetween('date', [$today, $twoWeeksLater])
            ->orderBy('date')
            ->orderBy('start_time')
            ->get(['date', 'start_time', 'end_time']);

        return response()->json($schedules);
    }
}
