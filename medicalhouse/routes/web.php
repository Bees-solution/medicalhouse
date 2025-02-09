<?php

use App\Http\Controllers\AdminAppointmentViewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DoctorListController;
use App\Http\Controllers\DoctorScheduleController;

Route::resource('doctor', DoctorController::class);

// Page showing all doctors (with search & filter)
Route::get('/doctorlist', [DoctorListController::class, 'customerList'])->name('customer.doctor.list');
Route::get('/doctor/view/{id}', [DoctorListController::class, 'view'])->name('customer.doctor.view');
Route::get('/doctor/{id}/schedule/{day}', [DoctorListController::class, 'schedule'])->name('customer.doctor.schedule');


// Page showing doctors inside a specialty
Route::get('/doctors/specialty', [DoctorListController::class, 'doctorsBySpecialty'])->name('customer.doctorsBySpecialty');

// Display the dscreate view and handle actions
Route::get('doctor/{Doc_id}/schedule/create', [DoctorScheduleController::class, 'create'])->name('doctor.schedule.create');
Route::post('doctor/{Doc_id}/schedule/store', [DoctorScheduleController::class, 'store'])->name('doctor.schedule.store');
Route::delete('schedule/{date}/destroy', [DoctorScheduleController::class, 'destroyByDay'])->name('doctor.schedule.destroy');

//admin appointment view 
Route::get('/adminview', [AdminAppointmentViewController::class, 'index'])->name('admin.index');
Route::get('/admin/doctor/{doc_id}/appointments', [AdminAppointmentViewController::class, 'showDoctorAppointments'])->name('doctor.appointments');

Route::get('/', function () {
    return view('welcome');
});