<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$gizaHotels = DB::table('hotels')->where('location', 'LIKE', '%Giza%')->get();

$gizaImages = [
    '/images/hotels/giza/mena.png',
    '/images/hotels/giza/meridien.png',
    '/images/hotels/giza/steigen.png',
    '/images/hotels/giza/triumph.png'
];

foreach ($gizaHotels as $index => $hotel) {
    if (strpos(strtolower($hotel->title), 'mena house') !== false) {
        $img = '/images/hotels/giza/mena.png';
    } elseif (strpos(strtolower($hotel->title), 'meridien') !== false) {
        $img = '/images/hotels/giza/meridien.png';
    } elseif (strpos(strtolower($hotel->title), 'steigenberger') !== false) {
        $img = '/images/hotels/giza/steigen.png';
    } else {
        $img = $gizaImages[$index % count($gizaImages)];
    }

    DB::table('hotels')->where('id', $hotel->id)->update([
        'image' => $img
    ]);
}

echo "Successfully updated Giza hotels with diverse, specific, hyper-realistic images!\n";
