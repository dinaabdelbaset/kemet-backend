<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

DB::table('destinations')->where('title', 'Marsa Matrouh')->update(['src' => '/images/destinations/marsa-matrouh.png']);

echo "Updated Marsa Matrouh destination to use local generated HD image.\n";
