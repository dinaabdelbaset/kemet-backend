<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$restaurants = \App\Models\Restaurant::all();
foreach ($restaurants as $r) {
    echo $r->id . ' | ' . $r->name . ' | ' . $r->cuisine . "\n";
}
