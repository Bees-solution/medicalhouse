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
        Schema::create('lab_tests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('fname');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->foreignId('lab_category_id')->nullable()->onDelete('cascade')->constrained('lab_categories');
            $table->timestamps();
            $table->string('slug')->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_tests');
    }
};
