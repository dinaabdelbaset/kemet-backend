<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::table('bazaars')->where('location', 'LIKE', '%Aswan%')->delete();

DB::table('bazaars')->insert([
    'title' => 'Aswan Souq & Spice Market (سوق أسوان السياحي)',
    'description' => 'The vibrant Aswan Souq is an incredibly colorful traditional market famous for its massive conical piles of aromatic spices, Nubian crafts, and vibrant local atmosphere.',
    'image' => '/images/destinations/aswan/bazaar.png',
    'location' => 'Aswan',
    'ticket_price' => 15,
    'created_at' => now(),
    'updated_at' => now()
]);

echo "Successfully updated Aswan Bazaars!\n";
