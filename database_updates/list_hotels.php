<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$hotels = DB::table('hotels')->get();
foreach($hotels as $h) {
    echo "{$h->id} | {$h->title} | {$h->location}\n";
}
