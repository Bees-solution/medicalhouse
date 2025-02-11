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
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->unsignedBigInteger('Doc_id'); // Foreign key referencing doctors table
            $table->date('date'); // Schedule date
            $table->time('start_time'); // Start time of the schedule
            $table->time('end_time'); // End time of the schedule

            // Ensure each doctor only has one schedule per time slot
            $table->unique(['Doc_id', 'date', 'start_time', 'end_time']);

            // Foreign key constraint
            $table->foreign('Doc_id')->references('Doc_id')->on('doctors')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_schedules');
    }
};
