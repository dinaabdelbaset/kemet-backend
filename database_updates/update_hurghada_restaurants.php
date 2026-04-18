<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::table('restaurants')->where('location', 'LIKE', '%Hurghada%')
    ->where('name', 'LIKE', '%Star%')
    ->update([
        'image' => '/images/restaurants/hurghada/starfish.png',
        'description' => 'The most famous seafood restaurant in Hurghada, known for its incredible fresh fish display, massive grilled seafood platters, and authentic Red Sea coastal atmosphere.',
        'price_range_min' => 20,
        'price_range_max' => 60
    ]);

DB::table('restaurants')->where('location', 'LIKE', '%Hurghada%')
    ->where('name', 'LIKE', '%Gad%')
    ->update([
        'image' => '/images/restaurants/hurghada/gad.png',
        'description' => 'A highly popular and authentic Egyptian local chain serving the best traditional foul, falafel, shawarma, and fulfilling local street food platters.',
        'price_range_min' => 5,
        'price_range_max' => 15
    ]);

echo "Successfully updated Hurghada restaurants!\n";
