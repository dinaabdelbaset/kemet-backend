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
        $tables = [
            'tours',
            'events',
            'flights',
            'safaris',
            'travel_packages',
            'museums',
            'transportations',
            'restaurants'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'available_count')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->integer('available_count')->default(50); // Default to 50 items available
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'tours',
            'events',
            'flights',
            'safaris',
            'travel_packages',
            'museums',
            'transportations',
            'restaurants'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'available_count')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropColumn('available_count');
                });
            }
        }
    }
};
