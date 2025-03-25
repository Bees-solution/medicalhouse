<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id(); // Appointment ID (Primary Key)

            // Appointment Number will be incremented per doctor, per date & time slot
            $table->unsignedInteger('appointment_no'); 
            
            $table->enum('appointment_status', ['Online', 'On Counter']); // Online or Counter booking
            
            $table->foreignId('patient_id')->nullable()->constrained('patients')->onDelete('set null'); // Nullable if counter pay
            $table->string('patient_name'); // Patient's full name
            $table->string('contact_no'); // Patient's contact number
            
            $table->unsignedBigInteger('doctor_id'); // Ensure it is the correct type
            $table->foreign('doctor_id')->references('Doc_id')->on('doctors')->onDelete('cascade');
            
            $table->dateTime('appointment_date_time'); // Appointment Date & Time

            $table->enum('payment_status', ['Done', 'Pending'])->default('Pending'); // Payment done or pending
            $table->foreignId('payment_id')->nullable()->constrained('payments')->onDelete('set null'); // Nullable if not paid
            
            $table->enum('attendance_status', ['Present', 'Absent'])->default('Absent'); // If the patient attended or not
            
            $table->string('username')->nullable(); // Admin username, NULL if booked online

            $table->timestamps();

            // ✅ Unique constraint ensures appointment_no is unique for each doctor, date, and time
            $table->unique(['doctor_id', 'appointment_date_time', 'appointment_no']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};
