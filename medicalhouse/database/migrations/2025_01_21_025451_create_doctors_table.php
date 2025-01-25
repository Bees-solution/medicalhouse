<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id('Doc_id'); // Primary key
            $table->string('name'); // Doctor's name
            $table->enum('Type', ['Special', 'Normal']); // Type of doctor
            $table->decimal('Fee', 8, 2); // Doctor's fee (e.g., 99999.99)
            $table->integer('No_of_patients'); // Number of patients
            $table->string('License'); // License number
            $table->enum('gender', ['Male', 'Female', 'Other']); // Gender
            $table->date('dob'); // Date of birth
            $table->string('Qualification'); // Qualification
            $table->string('Specialty'); // Specialty
            $table->text('remarks')->nullable(); // Remarks (optional)
            $table->string('image')->nullable(); // Doctor's profile image (optional)
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
