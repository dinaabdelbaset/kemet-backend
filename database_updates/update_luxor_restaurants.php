<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::table('restaurants')->where('location', 'LIKE', '%Luxor%')
    ->where('name', 'LIKE', '%Sofra%')
    ->update([
        'image' => '/images/restaurants/luxor/sofra.png',
        'description' => 'A beautifully authentic historic Egyptian house serving the finest traditional local cuisine with exquisite oriental decor, ancient tiles, and a very warm atmosphere.',
        'price_range_min' => 15,
        'price_range_max' => 50
    ]);

DB::table('restaurants')->where('location', 'LIKE', '%Luxor%')
    ->where('name', 'LIKE', '%Sahaby%')
    ->update([
        'image' => '/images/restaurants/luxor/sahaby.png',
        'description' => 'A famous spectacular rooftop restaurant offering an incredible panoramic view directly overlooking the illuminated ancient Luxor Temple and the magnificent Nile River.',
        'price_range_min' => 20,
        'price_range_max' => 60
    ]);

echo "Successfully updated Luxor restaurants!\n";
