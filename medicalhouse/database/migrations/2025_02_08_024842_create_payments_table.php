<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // Payment ID (Primary Key)
            $table->unsignedBigInteger('appointment_id'); // Link to appointments table
            $table->decimal('amount', 10, 2); // Doctor's fee
            $table->string('payment_method')->default('Cash'); // Payment type
            $table->timestamp('payment_date')->useCurrent(); // Auto-set current timestamp
            $table->string('status')->default('Completed'); // Default 'Completed' for Pay Now
            $table->timestamps(); // created_at & updated_at

            // ✅ Foreign key constraint to `appointments`
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
