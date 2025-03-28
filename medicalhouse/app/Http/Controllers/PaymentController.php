<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\PayherePayment;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\AppointmentService;


class PaymentController extends Controller
{

    protected $appointmentService;

public function __construct(AppointmentService $appointmentService)
{
    $this->appointmentService = $appointmentService;
}



public function initiatePayNow(Request $request)
{
    try {
        // Validate incoming request
        $validated = $request->validate([
            'patient_name' => 'required|string',
            'contact_no' => 'required|string',
            'doctor_id' => 'required|exists:doctors,Doc_id',
            'schedule' => 'required|string', // format: '2025-03-30,10:00:00'
            'amount' => 'required|numeric|min:1',
        ]);

        // Generate a unique order ID
        $orderId = 'MH' . strtoupper(Str::random(10));

        // Create the payment record
        $record = PayherePayment::create([
            'order_id' => $orderId,
            'patient_name' => $validated['patient_name'],
            'contact_no' => $validated['contact_no'],
            'doctor_id' => $validated['doctor_id'],
            'schedule' => $validated['schedule'],
            'amount' => $validated['amount'],
            'status' => 'pending',
        ]);

        // ✅ Log the data for debugging
        Log::info('Initiating PayHere Checkout', [
            'order_id' => $record->order_id,
            'amount' => $record->amount,
            'patient_name' => $record->patient_name,
            'contact_no' => $record->contact_no,
        ]);

        // Pass all necessary data to the Blade view
        return view('payhere.checkout', [
            'order_id' => $record->order_id,
            'amount' => $record->amount,
            'patient_name' => $record->patient_name,
            'contact_no' => $record->contact_no,
            'schedule' => $record->schedule,
            
        ]);
    } catch (\Throwable $e) {
        Log::error('PayHere Payment Error: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json([
            'success' => false,
            'message' => 'An unexpected error occurred. Please try again.',
        ], 500);
    }
}




public function handlePayhereNotification(Request $request)
{
    $orderId = $request->order_id;
    $status_code = $request->status_code;
    $merchant_id = $request->merchant_id;
    $amount = $request->payhere_amount;
    $currency = $request->payhere_currency;
    $md5sig = $request->md5sig;

    $merchant_secret = env('PAYHERE_MERCHANT_SECRET');

    $calculated_md5sig = strtoupper(md5(
        $merchant_id . $orderId . $amount . $currency . $status_code . strtoupper(md5($merchant_secret))
    ));

    if ($md5sig !== $calculated_md5sig || $status_code != 2) {
        Log::warning("PayHere payment failed or invalid for order: $orderId");
        return response('Payment verification failed', 400);
    }

    DB::beginTransaction();

    try {
        $payNow = PayherePayment::where('order_id', $orderId)->firstOrFail();
        $payNow->update(['status' => 'paid']);

        // Handle patient
        $patient = Patient::updateOrCreate(
            ['contact_no' => $payNow->contact_no],
            ['name' => $payNow->patient_name]
        );

        $doctor = Doctor::findOrFail($payNow->doctor_id);
        [$date, $time] = explode(',', $payNow->schedule);

        // ✅ Use AppointmentService for appointment number
        $appointmentNo = $this->appointmentService->generateAppointmentNumber($doctor->id, $date, $time);

        // Create appointment
        $appointment = Appointment::create([
            'appointment_no' => $appointmentNo,
            'appointment_status' => 'Online',
            'patient_id' => $patient->id,
            'patient_name' => $patient->name,
            'contact_no' => $patient->contact_no,
            'doctor_id' => $doctor->id,
            'doctor_name' => $doctor->name,
            'appointment_date_time' => "$date $time",
            'payment_status' => 'Done',
            'attendance_status' => 'Absent',
            'username' => null,
        ]);

        // Create main payment record
        Payment::create([
            'appointment_id' => $appointment->id,
            'amount' => $payNow->amount,
            'payment_method' => 'Online',
            'payment_date' => now(),
            'status' => 'paid',
        ]);

        

        // Send SMS
        $this->appointmentService->sendAppointmentConfirmationSMS(
            $patient->name,
            $doctor->name,
            $appointment,
            'Done'
        );

        DB::commit();
        return response('Payment successful', 200);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('PayHere post-payment error:', ['error' => $e->getMessage()]);
        return response('Server error', 500);
    }
}


}
