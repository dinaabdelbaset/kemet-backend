<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$rests = DB::table('restaurants')->get();
foreach($rests as $r) {
    echo "ID: $r->id | Name: $r->name | Loc: $r->location | Image: $r->image | Reviews: $r->reviews_count\n";
}
