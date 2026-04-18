<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

DB::table('destinations')->where('title', 'Giza')->update([
    'src' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/af/All_Gizah_Pyramids.jpg/800px-All_Gizah_Pyramids.jpg'
]);

DB::table('destinations')->where('title', 'Port Said')->update([
    'src' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d3/Port_Said_Suez_Canal_Authority.jpg/800px-Port_Said_Suez_Canal_Authority.jpg'
]);

DB::table('destinations')->where('title', 'Marsa Matrouh')->update([
    'src' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/07/Rommel_Beach.jpg/800px-Rommel_Beach.jpg'
]);

DB::table('destinations')->where('title', 'Fayoum')->update([
    'src' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/29/Wadi_El_Rayan_waterfalls.jpg/800px-Wadi_El_Rayan_waterfalls.jpg'
]);

echo "Updated images using reliable Wikimedia Commons URLs.\n";
