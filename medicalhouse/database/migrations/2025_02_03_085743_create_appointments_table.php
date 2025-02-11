<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id(); // Primary Key (Appointment ID)

            // Appointment Number: Auto-increment per doctor, date & time slot
            $table->unsignedInteger('appointment_no');

            // Appointment Type
            $table->enum('appointment_status', ['Online', 'Offline']); // Booking type

            // Patient Details
            $table->foreignId('patient_id')->nullable()->constrained('patients')->onDelete('set null');
            $table->string('patient_name');
            $table->string('contact_no');

            // Doctor Foreign Key (References `Doc_id` in `doctors`)
            $table->unsignedBigInteger('doctor_id');
            $table->foreign('doctor_id')->references('Doc_id')->on('doctors')->onDelete('cascade');

            // Explicitly Store Doctor Name
            $table->string('doctor_name'); // ✅ Ensures direct retrieval of doctor's name

            // Appointment Date & Time
            $table->dateTime('appointment_date_time');

            // Payment Status & Foreign Key
            $table->enum('payment_status', ['Done', 'Pending'])->default('Pending');
            $table->foreignId('payment_id')->nullable()->constrained('payments')->onDelete('set null');

            // Attendance Status
            $table->enum('attendance_status', ['Present', 'Absent'])->default('Absent');

            // Admin Username (Nullable for online bookings)
            $table->string('username')->nullable();

            $table->timestamps();

            // ✅ Unique constraint for doctor schedule
            $table->unique(['doctor_id', 'appointment_date_time', 'appointment_no'], 'unique_doctor_schedule');
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};
