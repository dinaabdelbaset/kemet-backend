<?php
$hotels = \App\Models\Hotel::where('image', 'like', 'http%')->get();

foreach ($hotels as $hotel) {
    if (stripos($hotel->location, 'Dahab') !== false) {
        $hotel->image = '/hotels-live/redsea.png';
    } elseif (stripos($hotel->location, 'Sharm') !== false) {
        $hotel->image = '/hotels-live/sharm_bungalows.png';
    } elseif (stripos($hotel->location, 'Marsa Alam') !== false) {
        $hotel->image = '/hotels-live/marsa_lodge.png';
    } elseif (stripos($hotel->location, 'Aswan') !== false) {
        $hotel->image = '/hotels-live/aswan.png';
    } elseif (stripos($hotel->location, 'Luxor') !== false) {
        $hotel->image = '/hotels-live/luxor.png';
    } elseif (stripos($hotel->location, 'Alexandria') !== false) {
        $hotel->image = '/hotels-live/alex.png';
    } else {
        $hotel->image = '/hotels-live/cairo_boutique.png';
    }
    dump('Fixed: ' . $hotel->title . ' -> ' . $hotel->image);
    $hotel->save();
}
echo "All external images replaced with local safe images.\n";
