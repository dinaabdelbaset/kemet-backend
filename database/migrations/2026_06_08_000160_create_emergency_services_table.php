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
        Schema::create('emergency_services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['hospital', 'pharmacy', 'embassy', 'hotline']);
            $table->string('phone');
            $table->string('address')->nullable();
            $table->string('city'); // e.g. Cairo, Giza, Luxor, Aswan, Hurghada, Sharm El-Sheikh, All
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->text('details')->nullable(); // working hours, spoken languages, notes
            $table->string('status')->default('approved'); // approved, pending, rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_services');
    }
};
