<?php

namespace App\Services;

use GuzzleHttp\Client;

class NotifyService
{
    protected $client;
    protected $userId;
    protected $apiKey;
    protected $senderId;

    public function __construct()
    {
        $this->client = new Client();

        // ✅ Use config() not env()
        $this->userId = config('services.notifylk.user_id');
        $this->apiKey = config('services.notifylk.api_key');
        $this->senderId = config('services.notifylk.sender_id', 'NotifyDEMO');
    }

    

    // ✅ Send OTP (For Authentication)
    public function sendOTP($to, $otp)
    {
        $url = "https://app.notify.lk/api/v1/send";

        // Format phone number to Sri Lankan standard
        $to = $this->formatPhoneNumber($to);

        try {
            $response = $this->client->post($url, [
                'form_params' => [
                    'user_id' => $this->userId,
                    'api_key' => $this->apiKey,
                    'sender_id' => $this->senderId,
                    'to' => $to,
                    'message' => "Your OTP is: $otp",
                ],
            ]);

            $result = json_decode($response->getBody(), true);

            // Log the API response for debugging
            \Log::info('Notify.lk OTP Response', ['response' => $result]);

            return isset($result['status']) && $result['status'] === 'success';
        } catch (\Exception $e) {
            \Log::error('Notify.lk OTP Error', ['error' => $e->getMessage()]);
            return false;
        }
    }

    // ✅ Send Appointment Confirmation Message
    public function sendAppointmentMessage($to, $appointmentDetails)
    {
        $url = "https://app.notify.lk/api/v1/send";

        // Format phone number to Sri Lankan standard
        $to = $this->formatPhoneNumber($to);

        try {
            $response = $this->client->post($url, [
                'form_params' => [
                    'user_id' => $this->userId,
                    'api_key' => $this->apiKey,
                    'sender_id' => $this->senderId,
                    'to' => $to,
                    'message' => $appointmentDetails, // Send exact message provided
                ],
            ]);

            $result = json_decode($response->getBody(), true);

            // Log the API response for debugging
            \Log::info('Notify.lk Appointment Message Response', ['response' => $result]);

            return isset($result['status']) && $result['status'] === 'success';
        } catch (\Exception $e) {
            \Log::error('Notify.lk Appointment Message Error', ['error' => $e->getMessage()]);
            return false;
        }
    }

    // ✅ Helper Function to Format Phone Numbers Correctly
    private function formatPhoneNumber($phone)
    {
        if (preg_match('/^0\d{9}$/', $phone)) { // Matches Sri Lankan numbers starting with 0
            return '94' . substr($phone, 1); // Convert '0712345678' → '94712345678'
        }
        return $phone; // Return as is if already in correct format
    }
}
