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
        Schema::create('attractions', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('nameAr');
            $table->string('era')->nullable();
            $table->string('eraAr')->nullable();
            $table->string('location');
            $table->string('governorate');
            $table->float('rating')->default(5.0);
            $table->integer('reviews')->default(0);
            $table->text('description');
            $table->text('longDescription');
            $table->string('image');
            $table->json('gallery')->nullable();
            $table->json('ticketPrices')->nullable();
            $table->string('openingHours')->nullable();
            $table->string('bestTime')->nullable();
            $table->string('duration')->nullable();
            $table->json('highlights')->nullable();
            $table->json('tips')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attractions');
    }
};
