<?php
$local_images = [
    '/hotels-live/alex.png',
    '/hotels-live/aswan.png',
    '/hotels-live/aswan_cruise.png',
    '/hotels-live/cairo_boutique.png',
    '/hotels-live/cairo_heritage.png',
    '/hotels-live/desert.png',
    '/hotels-live/luxor.png',
    '/hotels-live/luxor_sunset.png',
    '/hotels-live/marsa_lodge.png',
    '/hotels-live/matrouh.png',
    '/hotels-live/nile.png',
    '/hotels-live/north_coast.png',
    '/hotels-live/pyramids.png',
    '/hotels-live/redsea.png',
    '/hotels-live/sharm_bungalows.png',
    '/hotels-live/siwa.png'
];

$hotels = \App\Models\Hotel::all();
$index = 0;

foreach ($hotels as $hotel) {
    // Determine image based on location if possible
    $loc = strtolower($hotel->location);
    $selected_img = null;
    
    if (strpos($loc, 'cairo') !== false || strpos($loc, 'giza') !== false || strpos($loc, 'pyramid') !== false) {
        $opts = ['/hotels-live/cairo_boutique.png', '/hotels-live/cairo_heritage.png', '/hotels-live/pyramids.png', '/hotels-live/nile.png'];
        $selected_img = $opts[array_rand($opts)];
    } elseif (strpos($loc, 'luxor') !== false) {
        $opts = ['/hotels-live/luxor.png', '/hotels-live/luxor_sunset.png', '/hotels-live/nile.png'];
        $selected_img = $opts[array_rand($opts)];
    } elseif (strpos($loc, 'aswan') !== false) {
        $opts = ['/hotels-live/aswan.png', '/hotels-live/aswan_cruise.png', '/hotels-live/nile.png'];
        $selected_img = $opts[array_rand($opts)];
    } elseif (strpos($loc, 'sharm') !== false) {
        $selected_img = '/hotels-live/sharm_bungalows.png';
    } elseif (strpos($loc, 'dahab') !== false || strpos($loc, 'red sea') !== false) {
        $selected_img = '/hotels-live/redsea.png';
    } elseif (strpos($loc, 'marsa') !== false) {
        $selected_img = '/hotels-live/marsa_lodge.png';
    } elseif (strpos($loc, 'alexandria') !== false) {
        $selected_img = '/hotels-live/alex.png';
    } elseif (strpos($loc, 'matrouh') !== false) {
        $selected_img = '/hotels-live/matrouh.png';
    } elseif (strpos($loc, 'siwa') !== false) {
        $selected_img = '/hotels-live/siwa.png';
    } else {
        $selected_img = $local_images[$index % count($local_images)];
        $index++;
    }
    
    $hotel->image = $selected_img;
    $hotel->save();
}

echo "All images updated securely to existing local files.\n";
