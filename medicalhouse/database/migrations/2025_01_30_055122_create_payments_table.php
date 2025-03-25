<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign key to users table
            $table->decimal('amount', 10, 2); // Payment amount with 2 decimal places
            $table->string('payment_method'); // e.g., cash, card, online transfer
            $table->string('transaction_id')->nullable(); // Optional for online payments
            $table->timestamp('payment_date')->useCurrent(); // Defaults to current timestamp
            $table->string('status')->default('pending'); // pending, completed, failed
            $table->timestamps(); // created_at & updated_at

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
