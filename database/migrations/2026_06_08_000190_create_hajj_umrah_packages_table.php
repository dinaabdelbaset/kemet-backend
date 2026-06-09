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
        Schema::create('hajj_umrah_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_ar');
            $table->decimal('price', 10, 2);
            $table->string('hotel_makkah_en')->nullable();
            $table->string('hotel_makkah_ar')->nullable();
            $table->string('hotel_madinah_en')->nullable();
            $table->string('hotel_madinah_ar')->nullable();
            
            $table->foreignId('hotel_makkah_id')->nullable()->constrained('hotels')->nullOnDelete();
            $table->foreignId('hotel_madinah_id')->nullable()->constrained('hotels')->nullOnDelete();
            $table->foreignId('flight_id')->nullable()->constrained('flights')->nullOnDelete();
            $table->foreignId('transportation_id')->nullable()->constrained('transportations')->nullOnDelete();

            $table->integer('duration_days');
            $table->text('description_en');
            $table->text('description_ar');
            $table->string('image')->nullable();
            $table->json('features_en')->nullable();
            $table->json('features_ar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hajj_umrah_packages');
    }
};
