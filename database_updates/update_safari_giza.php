<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::table('safaris')
    ->where('title', 'LIKE', '%Bahariya%')
    ->update([
        'title' => 'Saqqara Desert Horseback Safari',
        'description' => 'A magical and serene guided horseback and camel riding safari through the pristine golden desert sands surrounding the Step Pyramid of Djoser in Saqqara, Giza.',
        'image' => '/images/destinations/giza/saqqara_safari.png',
        'price' => 60
    ]);

echo "Updated safari to Saqqara Desert Horseback Safari!\n";
