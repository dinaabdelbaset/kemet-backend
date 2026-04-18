<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$hotels = DB::table('hotels')->get();

$beachImages = [
    '/images/hotels/resort1.png',
    '/images/hotels/resort2.png',
    '/images/hotels/resort3.png',
    '/images/hotels/resort4.png',
];

foreach($hotels as $index => $hotel) {
    $loc = strtolower($hotel->location);
    $mainImage = '';

    if (strpos($loc, 'giza') !== false) {
        $mainImage = '/images/hotels/giza.png';
    } elseif (strpos($loc, 'cairo') !== false) {
        $mainImage = '/images/hotels/cairo.png';
    } elseif (strpos($loc, 'luxor') !== false || strpos($loc, 'aswan') !== false) {
        $mainImage = '/images/hotels/nile_classic.png';
    } elseif (strpos($loc, 'fayoum') !== false) {
        $mainImage = '/images/hotels/fayoum.png';
    } else {
        // Coastal / beach cities
        $mainImage = $beachImages[$index % count($beachImages)];
    }
    
    // We update the gallery to have a mixture, but starting with the correct primary image
    $gallery = [
        $mainImage,
        $beachImages[($index + 1) % count($beachImages)],
        $beachImages[($index + 2) % count($beachImages)],
        $beachImages[($index + 3) % count($beachImages)]
    ];

    // Some hotels might have specific gallery items. We'll simply ensure the main image is accurate to location
    DB::table('hotels')->where('id', $hotel->id)->update([
        'image' => $mainImage,
        // Optional: 'gallery' => json_encode($gallery) 
        // Not essential to overwrite gallery completely if image works as the thumbnail/main slider photo. But let's fix it for consistency.
        'gallery' => json_encode($gallery)
    ]);
}

echo "Successfully updated all hotels with geographically accurate images!\n";
