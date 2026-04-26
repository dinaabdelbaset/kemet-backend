<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->string('action_type')->default('create')->after('status'); // create, update, delete
            $table->text('rejection_reason')->nullable()->after('action_type');
        });

        // Set action_type to create for all existing pending
        DB::table('hotels')->where('status', 'pending')->update(['action_type' => 'create']);
    }

    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn('action_type');
            $table->dropColumn('rejection_reason');
        });
    }
};
