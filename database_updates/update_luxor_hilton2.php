<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::table('hotels')->where('location', 'LIKE', '%Luxor%')
    ->where('title', 'LIKE', '%Hilton%')
    ->update([
        'image' => '/images/hotels/luxor/hilton.png',
        'description' => 'A luxurious absolute waterfront resort famous for its stunning infinity pools blending seamlessly with the River Nile, offering world-class spa facilities and breathtaking views of the West Bank.'
    ]);

echo "Successfully updated Hilton Luxor hotel!\n";
