<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$hotelImages = [
    '/images/hotels/resort1.png',
    '/images/hotels/resort2.png',
    '/images/hotels/resort3.png',
    '/images/hotels/resort4.png',
];

$hotels = DB::table('hotels')->get();

foreach($hotels as $index => $hotel) {
    $mainImage = $hotelImages[$index % count($hotelImages)];
    
    // Create a robust gallery of 4 images
    $gallery = [
        $mainImage,
        $hotelImages[($index + 1) % count($hotelImages)],
        $hotelImages[($index + 2) % count($hotelImages)],
        $hotelImages[($index + 3) % count($hotelImages)]
    ];

    DB::table('hotels')->where('id', $hotel->id)->update([
        'image' => $mainImage,
        'gallery' => json_encode($gallery)
    ]);
}

echo "Done updating all hotels to local generated images!\n";
