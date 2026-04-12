<?php
$valid_images = \App\Models\Hotel::where('image', '!=', '/hotels-live/cairo_boutique.png')->pluck('image')->unique()->values()->all();
$hotels = \App\Models\Hotel::where('image', '/hotels-live/cairo_boutique.png')->get();
foreach ($hotels as $hotel) {
    if (count($valid_images) > 0) {
        $hotel->image = $valid_images[array_rand($valid_images)];
        $hotel->save();
    }
}
echo "Fixed duplicates!\n";
