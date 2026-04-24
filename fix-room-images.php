<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$rooms = \App\Models\Room::all();
$images = ['/images/hotels/resort1.png', '/images/hotels/resort2.png', '/images/hotels/resort3.png', '/images/hotels/resort4.png'];
foreach($rooms as $i => $room) {
    $room->image = $images[$i % 4];
    $room->save();
}
echo "Fixed room images!\n";
