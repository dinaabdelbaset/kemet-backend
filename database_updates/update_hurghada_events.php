<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::table('events')->where('location', 'LIKE', '%Hurghada%')->delete();

DB::table('events')->insert([
    [
        'title' => 'El Gouna Film Festival (مهرجان الجونة السينمائي)',
        'description' => 'A glamorous world-class international film festival featuring red carpet events, celebrities, and movie screenings against the beautiful backdrop of El Gouna Marina.',
        'image' => '/images/destinations/hurghada/elgouna_filmfest.png',
        'location' => 'Hurghada / El Gouna',
        'price' => 150,
        'date' => '2026-10-14',
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'title' => 'Red Sea Beach Music Festival (مهرجان شاطئ البحر الأحمر)',
        'description' => 'An electrifying outdoor music festival and concert right on the sandy beaches of the Red Sea, featuring top DJs, laser lights, and an incredible seaside atmosphere.',
        'image' => '/images/destinations/hurghada/beach_concert.png',
        'location' => 'Hurghada',
        'price' => 45,
        'date' => '2026-08-05',
        'created_at' => now(),
        'updated_at' => now()
    ]
]);

echo "Successfully updated Hurghada events!\n";
