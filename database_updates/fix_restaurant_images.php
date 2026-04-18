<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$restaurantImages = [
    'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=1200&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1550966871-3ed3cdb5ed0c?q=80&w=1200&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1559339352-11d035aa65de?q=80&w=1200&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?q=80&w=1200&auto=format&fit=crop',
];

$restaurants = DB::table('restaurants')->get();

foreach($restaurants as $index => $res) {
    if (!$res->image || strpos($res->image, 'unsplash') === false) {
        $mainImage = $restaurantImages[$index % count($restaurantImages)];
        DB::table('restaurants')->where('id', $res->id)->update([
            'image' => $mainImage
        ]);
    }
}

echo "Done updating all restaurants to real Unsplash images!\n";
