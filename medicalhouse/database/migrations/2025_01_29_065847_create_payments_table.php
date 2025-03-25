<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
{
    if (!Schema::hasTable('payments')) { // ✅ Prevents re-creating an existing table
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->enum('method', ['Online', 'Offline']);
            $table->decimal('amount', 10, 2);
            $table->decimal('total', 10, 2);
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->dateTime('date_time');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }
}


    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
