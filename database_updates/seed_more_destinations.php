<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$data = [
    [
        'title' => 'Giza',
        'src' => 'https://images.unsplash.com/photo-1539650116574-8efeb43e2b00?w=500&q=80',
        'alt' => 'Giza Pyramids',
        'tours' => 1150,
        'created_at' => now(), 'updated_at' => now()
    ],
    [
        'title' => 'Marsa Matrouh',
        'src' => 'https://images.unsplash.com/photo-1548574505-5e239809ee19?w=500&q=80',
        'alt' => 'Marsa Matrouh Beaches',
        'tours' => 450,
        'created_at' => now(), 'updated_at' => now()
    ],
    [
        'title' => 'Port Said',
        'src' => 'https://images.unsplash.com/photo-1627727714658-9d62db4155a4?w=500&q=80',
        'alt' => 'Port Said Lighthouse',
        'tours' => 320,
        'created_at' => now(), 'updated_at' => now()
    ],
    [
        'title' => 'Fayoum',
        'src' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=500&q=80',
        'alt' => 'Fayoum Oasis',
        'tours' => 280,
        'created_at' => now(), 'updated_at' => now()
    ]
];

DB::table('destinations')->insert($data);

echo "Successfully seeded missing 4 destinations.\n";
