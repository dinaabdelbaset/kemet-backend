<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$updates = [
    1 => 'http://localhost:8000/api/kamet-images/abou_el_sid',
    2 => 'http://localhost:8000/api/kamet-images/felfela',
    3 => 'http://localhost:8000/api/kamet-images/zooba',
    4 => 'http://localhost:8000/api/kamet-images/naguib_mahfouz',
    5 => 'http://localhost:8000/api/kamet-images/sofra_luxor',
    6 => 'http://localhost:8000/api/kamet-images/farhat_seafood',
];

foreach ($updates as $id => $url) {
    if ($restaurant = \App\Models\Restaurant::find($id)) {
        $restaurant->image = $url;
        $restaurant->save();
        echo "Updated $id to $url\n";
    }
}
echo "Done.";
