<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::table('restaurants')->where('location', 'LIKE', '%Aswan%')
    ->where('name', 'LIKE', '%Dokka%')
    ->update([
        'image' => '/images/restaurants/aswan/el_dokka.png',
        'description' => 'A beautifully vibrant Nubian restaurant located on an island in the Nile, serving the most delicious authentic Nubian cuisine and fresh Nile fish.',
        'price_range_min' => 15,
        'price_range_max' => 50
    ]);

DB::table('restaurants')->where('location', 'LIKE', '%Aswan%')
    ->where('name', 'LIKE', '%Makka%')
    ->update([
        'image' => '/images/restaurants/aswan/makka.png',
        'description' => 'A famous local restaurant offering large and delicious authentic Egyptian platters of grilled meats, kofta, and Upper Egyptian cuisine.',
        'price_range_min' => 10,
        'price_range_max' => 30
    ]);

echo "Successfully updated Aswan restaurants images and descriptions!\n";
