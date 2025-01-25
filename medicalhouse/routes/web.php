<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DoctorScheduleController;

Route::resource('doctor', DoctorController::class);


// Display the dscreate view and handle actions
Route::get('doctor/{Doc_id}/schedule/create', [DoctorScheduleController::class, 'create'])->name('doctor.schedule.create');
Route::post('doctor/{Doc_id}/schedule/store', [DoctorScheduleController::class, 'store'])->name('doctor.schedule.store');
Route::delete('schedule/{date}/destroy', [DoctorScheduleController::class, 'destroyByDay'])->name('doctor.schedule.destroy');


Route::get('/', function () {
    return view('welcome');
});