<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Move all Dahab data to Sharm El-Sheikh
$tables = ['restaurants', 'museums', 'bazaars', 'events', 'safaris', 'hotels', 'travel_packages'];

foreach ($tables as $table) {
    if (Schema::hasTable($table)) {
        if (Schema::hasColumn($table, 'location')) {
            DB::table($table)->where('location', 'Dahab')->update(['location' => 'Sharm El-Sheikh']);
        }
        if (Schema::hasColumn($table, 'city')) {
            DB::table($table)->where('city', 'Dahab')->update(['city' => 'Sharm El-Sheikh']);
        }
    }
}

// Delete Dahab from destinations
DB::table('destinations')->where('title', 'Dahab')->delete();

echo "Successfully merged Dahab into Sharm El-Sheikh and removed Dahab from destinations.\n";
