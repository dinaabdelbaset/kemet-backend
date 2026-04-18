<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::table('safaris')->where('location', 'LIKE', '%Hurghada%')->delete();

DB::table('safaris')->insert([
    [
        'title' => 'Bedouin Desert Camp & Dinner (سهرة وعشاء بدوي)',
        'description' => 'Experience an authentic Arabic night in the Eastern Desert of Hurghada. Enjoy traditional Bedouin floor seating, drink hot tea by the campfire, and watch a cultural show under the stars.',
        'image' => '/images/destinations/hurghada/bedouin.png',
        'location' => 'Hurghada',
        'price' => 35,
        'rating' => 4.9,
        'reviews_count' => 410,
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'title' => 'Red Sea Mountains ATV Safari (سفاري البيتش باجي جبال البحر الأحمر)',
        'description' => 'An adrenaline-filled adventure riding ATV Quad bikes through the rugged, rocky mountains and canyons of the Eastern Desert near Hurghada during the golden hour.',
        'image' => '/images/destinations/hurghada/atv.png',
        'location' => 'Hurghada',
        'price' => 30,
        'rating' => 4.8,
        'reviews_count' => 950,
        'created_at' => now(),
        'updated_at' => now()
    ]
]);

echo "Successfully updated Hurghada safaris!\n";
