<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$categories = ['hotels', 'museums', 'restaurants', 'bazaars', 'events', 'safaris'];
foreach($categories as $cat) {
    echo "--- $cat in Giza ---\n";
    $items = DB::table($cat)->where('location', 'LIKE', '%Giza%')->get();
    foreach($items as $i) {
        $name = $i->title ?? $i->name ?? 'NO_NAME';
        echo "{$i->id} | {$name} | {$i->location}\n";
    }
}
