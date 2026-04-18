<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::table('events')->where('location', 'LIKE', '%Aswan%')->delete();

DB::table('events')->insert([
    [
        'title' => 'Abu Simbel Sun Festival (مهرجان تعامد الشمس)',
        'description' => 'A breathtaking biannual phenomenon where the sun aligns perfectly to illuminate the inner sanctuary of Ramses II at the magnificent Abu Simbel temple at dawn.',
        'image' => '/images/destinations/aswan/sun_festival.png',
        'location' => 'Aswan',
        'price' => 50,
        'date' => '2026-10-22',
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'title' => 'Philae Temple Sound and Light Show (عرض الصوت والضوء)',
        'description' => 'A magical evening experience narrating the legends of Goddess Isis while the beautiful island temple of Philae is spectacularly illuminated by lasers and lights.',
        'image' => '/images/destinations/aswan/philae_light.png',
        'location' => 'Aswan',
        'price' => 25,
        'date' => '2026-05-01',
        'created_at' => now(),
        'updated_at' => now()
    ]
]);

echo "Successfully updated Aswan events!\n";
