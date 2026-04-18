<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::table('restaurants')
    ->where('name', 'LIKE', '%Abou Tarek%')
    ->update([
        'image' => '/images/restaurants/cairo/abou_tarek.png',
        'price_range_min' => 2,
        'price_range_max' => 5
    ]);

DB::table('restaurants')
    ->where('name', 'LIKE', '%Prince%')
    ->update([
        'image' => '/images/restaurants/cairo/el_prince.png',
        'price_range_min' => 10,
        'price_range_max' => 30
    ]);

echo "Successfully updated Abou Tarek and El Prince images in Cairo!\n";
