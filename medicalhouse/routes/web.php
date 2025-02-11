<?php

use App\Http\Controllers\AdminAppointmentViewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DoctorListController;
use App\Http\Controllers\DoctorScheduleController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\LabController;

Route::resource('doctor', DoctorController::class);

// Page showing all doctors (with search & filter)
Route::get('/doctorlist', [DoctorListController::class, 'customerList'])->name('customer.doctor.list');
Route::get('/doctor/view/{id}', [DoctorListController::class, 'view'])->name('customer.doctor.view');
//Route::get('/doctor/{id}/schedule/{day}', [DoctorListController::class, 'schedule'])->name('customer.doctor.schedule');


// Page showing doctors inside a specialty
Route::get('/doctors/specialty', [DoctorListController::class, 'doctorsBySpecialty'])->name('customer.doctorsBySpecialty');

// Display the schedule creation form
Route::get('doctor/{Doc_id}/schedule/create', [DoctorScheduleController::class, 'create'])->name('doctor.schedule.create');
Route::post('doctor/{Doc_id}/schedule/store', [DoctorScheduleController::class, 'store'])->name('doctor.schedule.store');
Route::delete('schedule/{date}/destroy', [DoctorScheduleController::class, 'destroyByDay'])->name('doctor.schedule.destroy');
Route::get('/get-schedules', [DoctorScheduleController::class, 'getSchedulesByDoctor'])->name('doctor.schedule.get');
Route::delete('/schedules/delete-old', [DoctorScheduleController::class, 'deleteOldSchedules'])->name('schedules.delete-old');

//admin appointment view 
Route::get('/adminview', [AdminAppointmentViewController::class, 'index'])->name('admin.index');
Route::get('/admin/doctor/{doc_id}/appointments', [AdminAppointmentViewController::class, 'showDoctorAppointments'])->name('doctor.appointments');

Route::get('/', function () {
    return view('homepage');
});
// Appointment  online pay later
Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');


Route::get('/select-payment', function () {
    return view('appointments.select_payment'); // Ensure this matches your view file
})->name('appointments.select-payment');


Route::post('/appointments/process-payment', [AppointmentController::class, 'processOnlineAppointment'])
    ->name('appointments.process-payment');


Route::get('/appointment-success/{appointment}', [AppointmentController::class, 'appointmentSuccess'])
    ->name('appointment.success');


Route::get('/get-doctors', [DoctorController::class, 'getDoctorsBySpecialty']);
Route::get('/get-schedules', [DoctorScheduleController::class, 'getSchedulesByDoctor']);

Route::post('/send-otp', [OTPController::class, 'sendOtp']);
Route::post('/verifythe-otp', [OTPController::class, 'verifyOtp']);

Route::get('/verify-otp', function () {
    return view('verify_otp');
});
Route::get('/appointments/offline/create', [AppointmentController::class, 'createOfflineAppointment'])->name('appointments.create_appointment_off');
Route::post('/process-offline-appointment', [AppointmentController::class, 'processOfflineAppointment']);

Route::get('/get-doctor-fee', [DoctorController::class, 'getDoctorFee']);

Route::post('/process-pay-now', [AppointmentController::class, 'processPayNowAppointment']);
Route::get('/download-bill/{billNo}', [AppointmentController::class, 'downloadBill']);

Route::get('/aboutus', function () {
    return view('aboutus');
});

//admin routes
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

//Laboratory Routes
Route::get('/lab', [LabController::class, 'index'])->name('lab.index');
Route::get('/lab/create', [LabController::class, 'create'])->name('lab.create');
Route::get('/lab/{labTest}', [LabController::class, 'show'])->name('lab.show');
Route::get('/lab/{labTest}/edit', [LabController::class, 'edit'])->name('lab.edit');
Route::post('/lab/store', [LabController::class, 'store'])->name('lab.store');
Route::put('/lab/{labTest}', [LabController::class, 'update'])->name('lab.update');
Route::delete('/lab/{labTest}', [LabController::class, 'destroy'])->name('lab.destroy');
