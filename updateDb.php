<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$r = App\Models\Restaurant::where('name', 'LIKE', '%Arous El Bahr%')
     ->orWhere('name', 'LIKE', '%عروس البحر%')
     ->first();
     
if($r) {
    echo "Found: " . $r->name . "\n";
    $r->name = 'Zephyrion (زفيريون)';
    $r->cuisine = 'Seafood';
    $r->save();
    echo "Updated successfully to Zephyrion!\n";
} else {
    echo "Restaurant not found in DB.\n";
}
