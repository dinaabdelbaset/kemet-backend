<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Keep it minimal and safe to avoid column issues
DB::table('museums')->insert([
    [
        'name' => 'Grand Egyptian Museum (GEM)',
        'description' => 'The largest archaeological museum in the world dedicated to a single civilization, housing the complete Tutankhamun collection.',
        'image' => '/images/destinations/giza/gem.png',
        'location' => 'Giza',
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'name' => 'Agricultural Museum',
        'description' => 'A beautiful historic palace documenting the rich history of Egyptian agriculture and rural life since the Pharaonic era.',
        'image' => '/images/destinations/giza/agricultural.png',
        'location' => 'Giza',
        'created_at' => now(),
        'updated_at' => now()
    ]
]);

DB::table('bazaars')->insert([
    [
        'title' => 'Wissa Wassef Art Center',
        'description' => 'A world-renowned tapesty and carpet weaving village in Harraniya Giza, creating spectacular handmade oriental art.',
        'image' => '/images/destinations/giza/wissa_wassef.png',
        'location' => 'Giza',
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'title' => 'Nazlet El Samman Market',
        'description' => 'A bustling local market right next to the Pyramids offering beautiful handmade papyrus, alabaster carving, and perfumes.',
        'image' => '/images/destinations/giza/nazlet_market.png',
        'location' => 'Giza',
        'created_at' => now(),
        'updated_at' => now()
    ]
]);

DB::table('safaris')->insert([
    [
        'title' => 'Giza Pyramids Quad Bike Safari',
        'description' => 'A thrilling action-packed ATV quad bike and camel safari through the desert dunes staring straight at the Great Pyramids.',
        'image' => '/images/destinations/giza/quad_bike.png',
        'location' => 'Giza',
        'price' => 40,
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'title' => 'Bahariya Oasis Desert Expedition',
        'description' => 'An epic 4x4 desert trip originating from Giza to the unique chalk rock formations and hot springs of the Bahariya Oasis.',
        'image' => '/images/destinations/giza/bahariya.png',
        'location' => 'Giza',
        'price' => 120,
        'created_at' => now(),
        'updated_at' => now()
    ]
]);

DB::table('events')->insert([
    [
        'title' => 'Sound and Light Show Pyramids',
        'description' => 'Experience the majestic history of the Pharaohs through a spectacular narrated laser light show cast upon the Sphinx and Pyramids.',
        'image' => '/images/destinations/giza/sound_light.png',
        'location' => 'Giza',
        'date' => 'Daily at 7:00 PM',
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'title' => 'Live Concerts at Pyramids Plateau',
        'description' => 'A massive live music concert featuring world-famous artists performing under the magical backdrop of the Great Pyramids.',
        'image' => '/images/destinations/giza/pyramid_concert.png',
        'location' => 'Giza',
        'date' => 'Seasonal',
        'created_at' => now(),
        'updated_at' => now()
    ]
]);

echo "Successfully added missing Giza categories!\n";
