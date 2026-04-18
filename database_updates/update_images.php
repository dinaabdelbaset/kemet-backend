<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$map = [
    1 => '/food/koshary.png',
    2 => '/food/molokhia.png',
    3 => '/food/falafel.png',
    4 => '/food/seafood.png',
    5 => '/food/grills.png',
    6 => '/food/seafood.png',
    7 => '/food/chicken-tajine.png',
    8 => '/food/meat-tajine.png',
    9 => '/food/grills.png',
    10 => '/food/chicken-tajine.png',
    11 => '/food/rice_pudding.png',
    12 => '/food/seafood.png',
    13 => '/food/seafood.png',
    14 => '/food/hawawshi.png',
    15 => '/food/fatta.png',
    16 => '/food/seafood.png',
    17 => '/food/foul.png',
    18 => '/food/grills.png',
    19 => '/food/pigeon.png',
    20 => '/food/seafood.png',
    21 => '/food/grills.png',
    22 => '/food/seafood.png',
    23 => '/food/seafood.png',
    24 => '/food/fatta.png',
    25 => '/food/grills.png',
    26 => '/food/seafood.png',
    27 => '/food/hawawshi.png',
    28 => '/food/feteer.png',
    29 => '/food/foul.png',
    30 => '/food/meat-tajine.png',
    31 => '/food/chicken-tajine.png',
    32 => '/food/seafood.png',
    33 => '/food/grills.png',
    34 => '/food/foul.png',
    35 => '/food/chicken-tajine.png',
    36 => '/food/seafood.png'
];

foreach ($map as $id => $img) {
    \DB::table('restaurants')->where('id', $id)->update(['image' => $img]);
}

\DB::table('safaris')->where('id', 1)->update(['image' => '/images/pyramids-balloon.png']);
\DB::table('safaris')->where('id', 2)->update(['image' => '/images/events_hero.png']);

echo "Images mapped successfully!\n";
