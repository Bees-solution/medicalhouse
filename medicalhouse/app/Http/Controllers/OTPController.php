<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NotifyService;
use App\Models\OTP;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session; // ✅ Ensure Session is imported
use Illuminate\Support\Facades\Log;

class OTPController extends Controller
{
    protected $notifyService;

    // Constructor to inject NotifyService
    public function __construct(NotifyService $notifyService)
    {
        $this->notifyService = $notifyService;
    }

    // Send OTP and return JSON response for frontend
    public function sendOtp(Request $request)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'specialty' => 'required',
                'doctor' => 'required',
                'schedule' => 'required',
                'patient_name' => 'required',
                'nic' => 'required',
                'contact' => 'required|numeric|digits:10',
            ]);

            // Format phone number for Sri Lanka (Example: '0712345678' → '94712345678')
            $phoneNumber = $validated['contact'];
            $formattedPhoneNumber = '94' . substr($phoneNumber, 1);

            // Generate a 6-digit OTP
            $otp = rand(100000, 999999);

            // Store OTP in the database
            OTP::updateOrCreate(
                ['phone_number' => $formattedPhoneNumber],
                [
                    'otp' => $otp,
                    'expires_at' => Carbon::now()->addMinutes(5), // OTP expires in 5 minutes
                ]
            );

            // Send OTP via Notify.lk using NotifyService
            $sent = $this->notifyService->sendOTP($formattedPhoneNumber, $otp);

            if (!$sent) {
                Log::error('Failed to send OTP via Notify.lk', ['phone_number' => $formattedPhoneNumber]);

                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send OTP. Please try again later.'
                ], 500);
            }

            // ✅ Store appointment data and OTP in session
            Session::put('appointment_data', $validated);
            Session::put('otp', $otp);
            Session::save(); // ✅ Ensure session is saved properly

            Log::info("OTP successfully sent to: $formattedPhoneNumber | OTP: $otp");

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully.',
                'redirect' => '/verify-otp'
            ]);

        } catch (\Exception $e) {
            Log::error('Error processing OTP:', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred. Please try again.'
            ], 500);
        }
    }


    public function verifyOtp(Request $request)
    {
        // Validate OTP input
        $request->validate([
            'otp' => 'required|digits:6',
        ]);
    
        // Retrieve stored OTP and appointment data
        $storedOtp = Session::get('otp');
        $appointmentData = Session::get('appointment_data');
    
        if (!$storedOtp || !$appointmentData) {
            return response()->json([
                'verified' => false,
                'message' => 'Session expired. Please start again.'
            ], 400);
        }
    
        // Fetch OTP record from the database
        $otpRecord = OTP::where('phone_number', '94' . substr($appointmentData['contact'], 1))
                        ->where('otp', $request->otp)
                        ->first();
    
        if (!$otpRecord) {
            return response()->json([
                'verified' => false,
                'message' => 'Invalid OTP. Please try again.'
            ], 400);
        }
    
        // Check if OTP has expired
        if (Carbon::now()->greaterThan($otpRecord->expires_at)) {
            return response()->json([
                'verified' => false,
                'message' => 'OTP expired. Please request a new one.'
            ], 400);
        }
    
        // OTP is verified ✅ → Proceed to Payment Selection
        Session::forget('otp'); // Remove OTP from session after verification
        Session::put('verified_appointment', $appointmentData); // ✅ Ensure appointment data persists
    
        return response()->json([
            'verified' => true,
            'message' => 'OTP verified successfully.',
            'redirect' => '/select-payment' // ✅ Ensure proper redirect
        ]);
    }
}
