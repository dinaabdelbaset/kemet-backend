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
        Schema::table('hotels', function (Blueprint $table) {
            $table->foreignId('arab_country_id')->nullable()->constrained('arab_countries')->onDelete('cascade');
        });

        Schema::table('restaurants', function (Blueprint $table) {
            $table->foreignId('arab_country_id')->nullable()->constrained('arab_countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            if (Schema::hasColumn('hotels', 'arab_country_id')) {
                $table->dropForeign(['arab_country_id']);
                $table->dropColumn('arab_country_id');
            }
        });

        Schema::table('restaurants', function (Blueprint $table) {
            if (Schema::hasColumn('restaurants', 'arab_country_id')) {
                $table->dropForeign(['arab_country_id']);
                $table->dropColumn('arab_country_id');
            }
        });
    }
};
