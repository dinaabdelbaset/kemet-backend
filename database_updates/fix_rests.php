<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::table('restaurants')->where('name', 'LIKE', '%Casten%')->update([
    'image' => '/food/kasten.jpg'
]);

DB::table('restaurants')->where('name', 'LIKE', '%El Borg%')->update([
    'image' => '/food/el_borg.jpg'
]);

echo "Done Restaurants Port Said Update\n";
