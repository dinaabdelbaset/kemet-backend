<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$cairoHotels = DB::table('hotels')->where('location', 'LIKE', '%Cairo%')->get();

$cairoImages = [
    '/images/hotels/cairo/ritz.png',
    '/images/hotels/cairo/marriott.png',
    '/images/hotels/cairo/fourseasons.png',
    '/images/hotels/cairo/kempinski.png'
];

foreach ($cairoHotels as $index => $hotel) {
    if (strpos(strtolower($hotel->title), 'ritz') !== false) {
        $img = '/images/hotels/cairo/ritz.png';
    } elseif (strpos(strtolower($hotel->title), 'marriott') !== false || strpos(strtolower($hotel->title), 'khayyam') !== false) {
        $img = '/images/hotels/cairo/marriott.png';
    } elseif (strpos(strtolower($hotel->title), 'four seasons') !== false || strpos(strtolower($hotel->title), 'fourseasons') !== false) {
        $img = '/images/hotels/cairo/fourseasons.png';
    } elseif (strpos(strtolower($hotel->title), 'kempinski') !== false) {
        $img = '/images/hotels/cairo/kempinski.png';
    } else {
        $img = $cairoImages[$index % count($cairoImages)];
    }

    DB::table('hotels')->where('id', $hotel->id)->update([
        'image' => $img
    ]);
}

echo "Successfully updated Cairo hotels with diverse, specific images!\n";
