<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::table('events')->insert([
    [
        'title' => 'Sound and Light Show Pyramids',
        'description' => 'Experience the majestic history of the Pharaohs through a spectacular narrated laser light show cast upon the Sphinx and Pyramids.',
        'image' => '/images/destinations/giza/sound_light.png',
        'location' => 'Giza',
        'date' => '2026-05-01',
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'title' => 'Live Concerts at Pyramids Plateau',
        'description' => 'A massive live music concert featuring world-famous artists performing under the magical backdrop of the Great Pyramids.',
        'image' => '/images/destinations/giza/pyramid_concert.png',
        'location' => 'Giza',
        'date' => '2026-06-15',
        'created_at' => now(),
        'updated_at' => now()
    ]
]);

echo "Successfully added missing Giza categories!\n";
