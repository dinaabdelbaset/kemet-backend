<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$rests = DB::table('restaurants')->where('location', 'LIKE', '%Giza%')->get();

if(count($rests) >= 2) {
    DB::table('restaurants')->where('id', $rests[0]->id)->update([
        'name' => 'Andrea Mariouteya (أندريا المريوطية)',
        'description' => 'The most famous authentic Egyptian outdoor grill restaurant in Giza, serving the best grilled chicken, freshly baked bread, and oriental mezze.',
        'image' => '/images/restaurants/giza_grill.png',
        'price_range_min' => 15,
        'price_range_max' => 45,
        'rating' => 4.8
    ]);
    
    DB::table('restaurants')->where('id', $rests[1]->id)->update([
        'name' => 'Koshary El Tahrir - Giza (كشري التحرير)',
        'description' => 'A highly popular, authentic local fast-food spot in Giza known for its legendary traditional Koshary bowls and vibrant local atmosphere.',
        'image' => '/images/restaurants/giza_popular.png',
        'price_range_min' => 2,
        'price_range_max' => 5,
        'rating' => 4.9
    ]);
}

// Ensure the others if exist also get valid local photos just in case
if(count($rests) > 2) {
    for($i = 2; $i < count($rests); $i++) {
        DB::table('restaurants')->where('id', $rests[$i]->id)->update([
             'image' => '/images/tour-cairo-food.png'
        ]);
    }
}

echo "Successfully updated Giza restaurants with authentic names and hyper-realistic images!\n";
