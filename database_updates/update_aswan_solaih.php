<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::table('restaurants')->where('location', 'LIKE', '%Aswan%')
    ->where('name', 'LIKE', '%Makka%')
    ->update([
        'name' => 'Solaih Nubian Restaurant (مطعم صُليح بجزيرة بيجه)',
        'image' => '/images/restaurants/aswan/solaih.png',
        'description' => 'A world-class aesthetic Nubian dining experience situated on Bigeh Island, offering exquisite food directly overlooking the majestic Philae Temple.',
        'price_range_min' => 25,
        'price_range_max' => 80
    ]);

echo "Successfully updated Makka to Solaih!\n";
