<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tables = ['hotels', 'museums', 'restaurants', 'bazaars', 'events', 'safaris'];
foreach($tables as $table) {
    echo "--- $table ---\n";
    $items = DB::table($table)->where('location','LIKE','%Matrouh%')->get();
    foreach($items as $i) {
        $title = $i->title ?? $i->name ?? 'NO_TITLE';
        echo "$title | {$i->location} | {$i->image}\n";
    }
}
