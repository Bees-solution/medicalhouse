<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DoctorScheduleController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\OTPController;

Route::resource('doctor', DoctorController::class);


// Display the dscreate view and handle actions
Route::get('doctor/{Doc_id}/schedule/create', [DoctorScheduleController::class, 'create'])->name('doctor.schedule.create');
Route::post('doctor/{Doc_id}/schedule/store', [DoctorScheduleController::class, 'store'])->name('doctor.schedule.store');
Route::delete('schedule/{date}/destroy', [DoctorScheduleController::class, 'destroyByDay'])->name('doctor.schedule.destroy');


Route::get('/', function () {
    return view('welcome');
});

Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');


Route::get('/select-payment', function () {
    return view('appointments.select_payment'); // Ensure this matches your view file
})->name('appointments.select-payment');

// Process "Pay at Counter" Booking
Route::post('/appointments/pay-at-counter', [AppointmentController::class, 'processPayAtCounter'])
    ->name('appointments.pay-at-counter');

Route::get('/appointment-success/{appointment}', function (App\Models\Appointment $appointment) {
    return view('appointments.success', compact('appointment'));
})->name('appointment.success');

Route::get('/get-doctors', [DoctorController::class, 'getDoctorsBySpecialty']);
Route::get('/get-schedules', [DoctorScheduleController::class, 'getSchedulesByDoctor']);

Route::post('/send-otp', [OTPController::class, 'sendOtp']);
Route::post('/verify-otp', [OTPController::class, 'verifyOtp']);

Route::get('/verify-otp', function () {
    return view('verify_otp');
});



