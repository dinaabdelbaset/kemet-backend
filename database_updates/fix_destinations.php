<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Delete duplicate Marsa Matruh and New Capital
DB::table('destinations')->whereIn('id', [9, 10])->delete();

// Fix Giza image
DB::table('destinations')->where('id', 11)->update([
    'src' => 'https://images.unsplash.com/photo-1553587815-53860bb4a6db?auto=format&fit=crop&q=80&w=800'
]);

echo "Cleaned up destinations: removed duplicates and fixed images.\n";
