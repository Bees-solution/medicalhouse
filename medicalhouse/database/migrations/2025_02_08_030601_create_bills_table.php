<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id(); // Bill ID (Primary Key)
            $table->unsignedBigInteger('payment_id'); // Foreign Key to payments table
            $table->timestamp('bill_date')->useCurrent(); // Bill created timestamp
            $table->timestamps(); // created_at & updated_at

            // ✅ Foreign key constraint to `payments`
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
