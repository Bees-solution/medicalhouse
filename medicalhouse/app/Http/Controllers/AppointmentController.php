<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Payment; 
use App\Models\Bill;


class AppointmentController extends Controller
{
    public function create()
    {
        $specialties = Doctor::select('Specialty')->distinct()->pluck('Specialty');
        return view('appointments.create', compact('specialties'));
    }

    public function createOfflineAppointment()
{
    // Fetch distinct specialties from the doctors table
    $specialties = Doctor::select('Specialty')->distinct()->pluck('Specialty');

    // Return the view for offline appointment creation
    return view('appointments.create_appointment_off', compact('specialties'));
}

    /**
     * ✅ Generate Safe Appointment Number (Prevents Race Conditions)
     */
    private function generateAppointmentNumber($doctorId, $appointmentDate, $startTime)
    {
        // Start Transaction
        DB::beginTransaction();

        try {
            // Lock the row for the given doctor, date, and time slot
            $existingAppointments = DB::table('appointments')
                ->where('doctor_id', $doctorId)
                ->whereDate('appointment_date_time', $appointmentDate)
                ->whereTime('appointment_date_time', $startTime)
                ->lockForUpdate() // ✅ Prevents race conditions
                ->count();

            // Calculate the next appointment number
            $appointmentNo = $existingAppointments + 1;

            // Commit transaction
            DB::commit();

            return $appointmentNo;
        } catch (\Exception $e) {
            // Rollback on error
            DB::rollBack();
            Log::error('Error generating appointment number:', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * ✅ Process Online Appointments (Pay Now & Pay At Counter)
     */
    public function processOnlineAppointment(Request $request)
    {
        try {
            DB::beginTransaction();

            // Retrieve appointment details from session
            $appointmentData = Session::get('verified_appointment');
            if (!$appointmentData) {
                return redirect()->route('appointments.create')->with('error', 'Session expired. Please start again.');
            }

            // Extract details
            $doctorId = $appointmentData['doctor'];
            $scheduleDetails = explode(',', $appointmentData['schedule']);
            $appointmentDate = $scheduleDetails[0];
            $startTime = $scheduleDetails[1];

            // Fetch doctor details
            $doctor = Doctor::find($doctorId);
            if (!$doctor) {
                return redirect()->route('appointments.create')->with('error', 'Doctor not found.');
            }

            // Generate unique appointment number
            $appointmentNo = $this->generateAppointmentNumber($doctorId, $appointmentDate, $startTime);
            if (!$appointmentNo) {
                return redirect()->route('appointments.create')->with('error', 'Could not assign appointment number. Please try again.');
            }

            // Store patient data
            $patient = Patient::updateOrCreate(
                ['contact_no' => $appointmentData['contact']],
                ['name' => $appointmentData['patient_name']]
            );

            // Determine payment status
            $paymentStatus = $request->input('payment_method') === 'Done' ? 'Done' : 'Pending';

            // Save appointment
            $appointment = new Appointment();
            $appointment->appointment_no = $appointmentNo;
            $appointment->appointment_status = 'Online';
            $appointment->patient_id = $patient->id;
            $appointment->patient_name = $appointmentData['patient_name'];
            $appointment->contact_no = $appointmentData['contact'];
            $appointment->doctor_id = $doctorId;
            $appointment->doctor_name = $doctor->name;
            $appointment->appointment_date_time = $appointmentDate . ' ' . $startTime;
            $appointment->payment_status = $paymentStatus;
            $appointment->attendance_status = 'Absent';
            $appointment->username = null; // Online bookings have no admin username
            $appointment->save();

            DB::commit();

            // ✅ Send SMS Notification
            $this->sendAppointmentConfirmationSMS($patient->name, $doctor->name, $appointment, $paymentStatus);

            // Clear session
            Session::forget('verified_appointment');

            return redirect()->route('appointment.success', ['appointment' => $appointment->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error booking online appointment:', ['error' => $e->getMessage()]);
            return redirect()->route('appointments.create')->with('error', 'An error occurred. Please try again.');
        }
    }

    /**
     * ✅ Process Offline Appointments (Pay Now & Pay Later)
     */
    public function processOfflineAppointment(Request $request)
{
    try {
        DB::beginTransaction();

        // ✅ Fetch appointment data from request (instead of session)
        $appointmentData = $request->all();

        $doctorId = $appointmentData['doctor'];
        $scheduleDetails = explode(',', $appointmentData['schedule']);
        $appointmentDate = $scheduleDetails[0];
        $startTime = $scheduleDetails[1];

        $doctor = Doctor::find($doctorId);
        if (!$doctor) {
            return response()->json(['success' => false, 'message' => 'Doctor not found.']);
        }

        // ✅ Generate appointment number
        $appointmentNo = $this->generateAppointmentNumber($doctorId, $appointmentDate, $startTime);
        if (!$appointmentNo) {
            return response()->json(['success' => false, 'message' => 'Could not assign appointment number. Please try again.']);
        }

        // ✅ Get Payment Status from the request
        $paymentStatus = $request->input('payment_status', 'Pending'); // Default is 'Pending'

        // ✅ Save appointment in the database
        $appointment = new Appointment();
        $appointment->appointment_no = $appointmentNo;
        $appointment->appointment_status = 'Offline';
        $appointment->patient_id = null; // ❌ No patient record needed
        $appointment->patient_name = $appointmentData['patient_name'];
        $appointment->contact_no = $appointmentData['contact'];
        $appointment->doctor_id = $doctorId;
        $appointment->doctor_name = $doctor->name;
        $appointment->appointment_date_time = $appointmentDate . ' ' . $startTime;
        $appointment->payment_status = $paymentStatus;
        $appointment->attendance_status = 'Absent';
        $appointment->username = auth()->user()->name ?? null;
        $appointment->save();

        DB::commit();

        // ✅ Send SMS Notification
        $this->sendAppointmentConfirmationSMS(
            $appointmentData['patient_name'], 
            $doctor->name, 
            $appointment, 
            $paymentStatus
        );

        return response()->json([
            'success' => true,
            'message' => 'Appointment successfully made!',
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error booking offline appointment:', ['error' => $e->getMessage()]);
        return response()->json(['success' => false, 'message' => 'An error occurred. Please try again.']);
    }
}

    
    /**
     * ✅ Send SMS Confirmation
     */
    private function sendAppointmentConfirmationSMS($patientName, $doctorName, $appointment, $paymentStatus)
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

    /**
     * ✅ Show Appointment Success Page
     */
    public function appointmentSuccess($appointmentId)
    {
        $appointment = Appointment::with('doctor')->find($appointmentId);
        if (!$appointment) {
            return redirect()->route('appointments.create')->with('error', 'Appointment not found.');
        }
        return view('appointments.success', compact('appointment'));
    }

    public function getDoctorFee(Request $request)
{
    $doctor = Doctor::where('Doc_id', $request->doctor_id)->first();

    if (!$doctor) {
        return response()->json(['error' => 'Doctor not found.'], 404);
    }

    return response()->json([
        'name' => $doctor->name,
        'specialty' => $doctor->Specialty,
        'fee' => $doctor->Fee
    ]);
}


public function processPayNowAppointment(Request $request)
{
    try {
        DB::beginTransaction();

        // ✅ Log the incoming request data
        Log::info('Processing Pay Now Request:', $request->all());

        // ✅ Check if required fields exist
        if (
            !isset($request->doctor) || empty($request->doctor) ||
            !isset($request->schedule) || empty($request->schedule) ||
            !isset($request->patient_name) || empty($request->patient_name) ||
            !isset($request->contact) || empty($request->contact) ||
            !isset($request->amount) || empty($request->amount)
        ) {
            Log::error('Missing required fields in request:', $request->all());
            return response()->json(['success' => false, 'message' => 'Missing required fields.']);
        }

        // ✅ Fetch doctor using `Doc_id`
        $doctor = Doctor::where('Doc_id', $request->doctor)->first();
        if (!$doctor) {
            Log::error('Doctor not found with ID:', ['doctor_id' => $request->doctor]);
            return response()->json(['success' => false, 'message' => 'Doctor not found.']);
        }

        // ✅ Extract schedule details
        $scheduleDetails = explode(',', $request->schedule);
        if (count($scheduleDetails) < 2) {
            Log::error('Invalid schedule format:', ['schedule' => $request->schedule]);
            return response()->json(['success' => false, 'message' => 'Invalid schedule format.']);
        }

        $appointmentDate = $scheduleDetails[0];
        $startTime = $scheduleDetails[1];

        // ✅ Generate appointment number
        $appointmentNo = $this->generateAppointmentNumber($doctor->Doc_id, $appointmentDate, $startTime);
        if (!$appointmentNo) {
            Log::error('Failed to generate appointment number.');
            return response()->json(['success' => false, 'message' => 'Failed to assign appointment number.']);
        }

        // ✅ Save Appointment
        $appointment = new Appointment();
        $appointment->appointment_no = $appointmentNo;
        $appointment->appointment_status = 'Offline';
        $appointment->patient_name = $request->patient_name;
        $appointment->contact_no = $request->contact;
        $appointment->doctor_id = $doctor->Doc_id; // ✅ Correct column
        $appointment->doctor_name = $doctor->name;
        $appointment->appointment_date_time = "$appointmentDate $startTime";
        $appointment->payment_status = 'Done';
        $appointment->attendance_status = 'Absent';
        $appointment->username = auth()->user()->name ?? null;
        $appointment->save();
        Log::info('Appointment saved successfully', ['appointment_id' => $appointment->id]);

        // ✅ Ensure amount is a valid number
        $amount = floatval($request->amount);
        if ($amount <= 0) {
            Log::error('Invalid amount value:', ['amount' => $request->amount]);
            return response()->json(['success' => false, 'message' => 'Invalid amount value.']);
        }

        // ✅ Save Payment
        $payment = new Payment();
        $payment->appointment_id = $appointment->id;
        $payment->amount = $amount;
        $payment->payment_method = 'Cash';
        $payment->status = 'Completed';
        $payment->save();
        Log::info('Payment saved successfully', ['payment_id' => $payment->id]);

        // ✅ Save Bill
        $bill = new Bill();
        $bill->payment_id = $payment->id;
        $bill->bill_date = now();
        $bill->save();
        Log::info('Bill saved successfully', ['bill_id' => $bill->id]);

        DB::commit();

        return response()->json([
            'success' => true,
            'bill' => [
                'bill_no' => $bill->id,
                'doctor_name' => $doctor->name,
                'specialty' => $doctor->Specialty,
                'appointment_date_time' => $appointment->appointment_date_time,
                'patient_name' => $appointment->patient_name,
                'appointment_no' => $appointment->appointment_no,
                'amount_paid' => $amount
            ]
        ]);

    } catch (\Exception $e) {
        DB::rollBack();

        Log::error('Error processing Pay Now:', [
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile()
        ]);

        return response()->json(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
    }
}
public function downloadBill($billNo)
{
    // ✅ Fetch bill details using bill ID
    $bill = Bill::where('id', $billNo)->first();

    if (!$bill) {
        return response()->json(['error' => 'Bill not found'], 404);
    }

    // ✅ Fetch related payment and appointment details
    $payment = Payment::where('id', $bill->payment_id)->first();
    $appointment = Appointment::where('id', $payment->appointment_id)->first();
    $doctor = Doctor::where('Doc_id', $appointment->doctor_id)->first();

    // ✅ Generate Bill Content
    $billContent = "
        BILL NO: {$bill->id} \n
        Payment ID: {$payment->id} \n
        Doctor: {$doctor->name} ({$doctor->Specialty}) \n
        Appointment Date & Time: {$appointment->appointment_date_time} \n
        Patient: {$appointment->patient_name} \n
        Appointment No: {$appointment->appointment_no} \n
        Amount Paid: $ {$payment->amount} \n
    ";

    // ✅ Create PDF File
    $pdf = \PDF::loadHTML(nl2br($billContent));

    // ✅ Return PDF as download
    return $pdf->download("Bill_{$bill->id}.pdf");
}


}
