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
        Schema::create('arab_countries', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_ar');
            $table->string('code')->unique(); // SA, AE, JO etc.
            $table->string('flag');
            $table->string('image');
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->timestamps();
        });

        Schema::create('arab_landmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained('arab_countries')->onDelete('cascade');
            $table->string('name_en');
            $table->string('name_ar');
            $table->string('location_en');
            $table->string('location_ar');
            $table->string('category'); // historical, modern, nature
            $table->string('image');
            $table->text('description_en');
            $table->text('description_ar');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->decimal('rating', 3, 2)->default(4.50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arab_landmarks');
        Schema::dropIfExists('arab_countries');
    }
};
