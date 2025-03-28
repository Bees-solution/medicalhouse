<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayherePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payhere_payments', function (Blueprint $table) {
            $table->id();

            $table->string('order_id')->unique(); // Used by PayHere as order_id
            $table->string('patient_name');
            $table->string('contact_no');
            $table->unsignedBigInteger('doctor_id');
            $table->string('schedule'); // Format: 'YYYY-MM-DD,hh:mm AM/PM'
            $table->decimal('amount', 10, 2);

            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');

            $table->timestamps();

            // Optional: foreign key constraint
            // $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payhere_payments');
    }
}
