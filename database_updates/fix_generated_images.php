<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

DB::table('destinations')->where('title', 'Giza')->update(['src' => '/images/destinations/giza.png']);
DB::table('destinations')->where('title', 'Port Said')->update(['src' => '/images/destinations/port-said.png']);
DB::table('destinations')->where('title', 'Fayoum')->update(['src' => '/images/destinations/fayoum.png']);

echo "Updated destinations to use local generated HD images.\n";
