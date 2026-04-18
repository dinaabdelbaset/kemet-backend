<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::table('hotels')->where('location', 'LIKE', '%Aswan%')
    ->where('title', 'LIKE', '%Cataract%')
    ->update([
        'image' => '/images/hotels/aswan/old_cataract.png'
    ]);

DB::table('hotels')->where('location', 'LIKE', '%Aswan%')
    ->where('title', 'LIKE', '%pick%') // Mövenpick
    ->update([
        'image' => '/images/hotels/aswan/movenpick.png'
    ]);

echo "Successfully updated Aswan hotels images!\n";
