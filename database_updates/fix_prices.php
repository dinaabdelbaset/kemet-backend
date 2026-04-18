<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Replace Agricultural Museum with Imhotep
DB::table('museums')
    ->where('name', 'LIKE', '%Agricultural%')
    ->update([
        'name' => 'Imhotep Museum (Saqqara)',
        'description' => 'A recently beautifully renovated modern museum in Saqqara, Giza, displaying extraordinary masterpieces and architecture of the ancient builder Imhotep.',
        'image' => '/images/destinations/giza/imhotep.png',
        'ticket_price' => 12
    ]);

// Now for the 0 prices:

// Museums (ticket_price)
DB::table('museums')->whereNull('ticket_price')->orWhere('ticket_price', 0)->update(['ticket_price' => 15]);

// Bazaars (the UI ExplorePage fetches ticket_price or price from Bazaars, we'll patch ticket_price since bazaars schema doesn't have `price` natively but we can check if it exists or just add a price_level)
// Wait! Let's check if ticket_price exists in bazaars using try catch.
try {
    DB::table('bazaars')->whereNull('ticket_price')->orWhere('ticket_price', 0)->update(['ticket_price' => 20]);
} catch (Exception $e) {
    // If ticket_price doesn't exist, explore page falls back to price, let's try price:
    try {
        DB::table('bazaars')->whereNull('price')->orWhere('price', 0)->update(['price' => 20]);
    } catch (Exception $e2) {
       // Just update price_level if that's all there is
       DB::table('bazaars')->whereNull('price_level')->orWhere('price_level', 0)->update(['price_level' => 3]);
    }
}

// Safaris (price)
DB::table('safaris')->whereNull('price')->orWhere('price', 0)->update(['price' => 45]);

// Events (price)
DB::table('events')->whereNull('price')->orWhere('price', 0)->update(['price' => 30]);

// Hotels (price_starts_from)
DB::table('hotels')->whereNull('price_starts_from')->orWhere('price_starts_from', 0)->update(['price_starts_from' => 120]);

// Restaurants (price_range_min / price_range_max)
DB::table('restaurants')->whereNull('price_range_min')->orWhere('price_range_min', 0)->update(['price_range_min' => 15, 'price_range_max' => 50]);

echo "Successfully updated Imhotep Museum and fixed all ZERO prices!\n";
