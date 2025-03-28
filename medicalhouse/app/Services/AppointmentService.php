<?php

namespace App\Services;

use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppointmentService
{
    /**
     * ✅ Generate Safe Appointment Number
     */
    public function generateAppointmentNumber($doctorId, $appointmentDate, $startTime)
    {
        DB::beginTransaction();

        try {
            $existingAppointments = DB::table('appointments')
                ->where('doctor_id', $doctorId)
                ->whereDate('appointment_date_time', $appointmentDate)
                ->whereTime('appointment_date_time', $startTime)
                ->lockForUpdate()
                ->count();

            $appointmentNo = $existingAppointments + 1;

            DB::commit();

            return $appointmentNo;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error generating appointment number:', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * ✅ Send SMS Confirmation
     */
    public function sendAppointmentConfirmationSMS($patientName, $doctorName, Appointment $appointment, $paymentStatus)
    {
        $formattedPhone = $appointment->contact_no;
        if (preg_match('/^0\d{9}$/', $formattedPhone)) {
            $formattedPhone = '94' . substr($formattedPhone, 1);
        }

        $paymentMessage = ($paymentStatus === 'Done') 
            ? "Payment is completed successfully." 
            : "Please pay at the hospital counter before your consultation.";

        $message = "Dear {$patientName}, your appointment with Dr. {$doctorName} is confirmed. 
        Appointment ID: {$appointment->id}
        Date: {$appointment->appointment_date_time}, 
        Appointment No: {$appointment->appointment_no}. 
        {$paymentMessage}";

        app('App\Services\NotifyService')->sendAppointmentMessage($formattedPhone, $message);
    }
}
