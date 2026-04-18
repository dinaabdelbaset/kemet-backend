<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

if (!Schema::hasColumn('bazaars', 'ticket_price')) {
    Schema::table('bazaars', function (Blueprint $table) {
        $table->decimal('ticket_price', 8, 2)->nullable();
    });
}

// Update the Giza bazaars to represent guided shopping tours instead of just general free areas.
// Wissa Wassef and Nazlet El Samman are beautiful, let's just make their ticket_price reflect a "Guided Tour Price" or "Entry & Workshop fee".
DB::table('bazaars')->where('title', 'LIKE', '%Wissa Wassef%')->update([
    'title' => 'Wissa Wassef Guided Tour & Workshop',
    'ticket_price' => 35
]);

DB::table('bazaars')->where('title', 'LIKE', '%Nazlet%')->update([
    'title' => 'Nazlet El Samman Private Guided Safari & Shopping',
    'ticket_price' => 25
]);

// Set a default ticket_price for all other bazaars so they don't show $0
DB::table('bazaars')->whereNull('ticket_price')->orWhere('ticket_price', 0)->update([
    'ticket_price' => 15
]);

echo "Bazaars updated to include ticket prices and changed to guided tours!\n";
