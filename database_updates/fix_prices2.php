<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Replace Agricultural Museum with Imhotep
DB::table('museums')
    ->where('name', 'LIKE', '%Agricultural%')
    ->update([
        'name' => 'Imhotep Museum (متحف إيمحتب بسقارة)',
        'description' => 'A beautifully renovated modern museum in Saqqara, displaying extraordinary masterpieces of the ancient builder Imhotep.',
        'image' => '/images/destinations/giza/imhotep.png',
        'ticket_price' => 12
    ]);

// Museums
DB::table('museums')->whereNull('ticket_price')->orWhere('ticket_price', 0)->update(['ticket_price' => 15]);

// Safaris
DB::table('safaris')->whereNull('price')->orWhere('price', 0)->update(['price' => 45]);

// Events
DB::table('events')->whereNull('price')->orWhere('price', 0)->update(['price' => 30]);

// Hotels
DB::table('hotels')->whereNull('price_starts_from')->orWhere('price_starts_from', 0)->update(['price_starts_from' => 120]);

// Restaurants (Giza ones)
DB::table('restaurants')->whereNull('price_range_min')->orWhere('price_range_min', 0)->update(['price_range_min' => 15, 'price_range_max' => 50]);

echo "Successfully updated Imhotep Museum and fixed all ZERO prices!\n";
