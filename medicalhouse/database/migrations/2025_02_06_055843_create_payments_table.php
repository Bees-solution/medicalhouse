<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // Payment ID (Primary Key)
            $table->enum('method', ['Online', 'Offline']); // Payment method
            $table->decimal('amount', 10, 2); // Amount paid
            $table->decimal('total', 10, 2); // Total amount due

            // Foreign Key - Doctor
            $table->unsignedBigInteger('doc_id');
            $table->foreign('doc_id')->references('Doc_id')->on('doctors')->onDelete('cascade');

            // Remarks (Optional)
            $table->text('remarks')->nullable();

            // Timestamps
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
