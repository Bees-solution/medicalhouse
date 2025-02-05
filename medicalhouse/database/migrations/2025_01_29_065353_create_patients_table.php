<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id(); // Primary Key (patient_id)
            $table->string('name'); // Patient's full name
            $table->string('contact_no')->unique(); // Patient's contact number (Unique)
            $table->string('nic')->unique(); // NIC (Unique)
            $table->string('email')->nullable(); // Email (Nullable)
            $table->string('gender', 10)->nullable();
            $table->timestamps(); // Created & Updated timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('patients');
    }
};
