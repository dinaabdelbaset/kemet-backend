<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::table('museums')->where('location', 'LIKE', '%Aswan%')->delete();

DB::table('museums')->insert([
    [
        'name' => 'The Nubian Museum (متحف النوبة)',
        'description' => 'An award-winning museum dedicated specifically to Nubian culture and history, featuring magnificent ancient artifacts, statues, and traditional Nubian village models.',
        'image' => '/images/destinations/aswan/nubian_museum.png',
        'location' => 'Aswan',
        'ticket_price' => 15,
        'rating' => 4.9,
        'reviews_count' => 3200,
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'name' => 'Aswan Museum (متحف أسوان بإلفنتين)',
        'description' => 'Located on the beautiful Elephantine Island in an old colonial villa, this museum showcases historical artifacts found in Aswan and Nubia.',
        'image' => '/images/destinations/aswan/elephantine_museum.png',
        'location' => 'Aswan',
        'ticket_price' => 10,
        'rating' => 4.6,
        'reviews_count' => 840,
        'created_at' => now(),
        'updated_at' => now()
    ]
]);

echo "Successfully updated Aswan museums!\n";
