<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add role to users
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('user')->after('email'); // super_admin, hotel_admin, tour_admin, etc.
            }
        });

        // Set the first user to super_admin as default
        DB::table('users')->where('id', 1)->update(['role' => 'super_admin']);

        $tables = ['tours', 'restaurants', 'museums', 'bazaars', 'events', 'safaris', 'transportations'];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                if (!Schema::hasColumn($table->getTable(), 'status')) {
                    $table->string('status')->default('pending');
                    $table->string('action_type')->default('create'); // create, update, delete
                    $table->text('rejection_reason')->nullable();
                }
            });

            // Set existing records to approved so the site doesn't break
            DB::table($tableName)->update([
                'status' => 'approved',
                'action_type' => 'create'
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        $tables = ['tours', 'restaurants', 'museums', 'bazaars', 'events', 'safaris', 'transportations'];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn(['status', 'action_type', 'rejection_reason']);
            });
        }
    }
};
