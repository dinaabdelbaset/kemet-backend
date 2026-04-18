<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$rests = DB::table('restaurants')->where('location', 'LIKE', '%Giza%')->get();
foreach($rests as $r) {
    echo "{$r->id} | {$r->title}\n";
}
