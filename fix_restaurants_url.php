<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$restaurants = \App\Models\Restaurant::all();
foreach ($restaurants as $r) {
    if (str_contains($r->image, 'https://127.0.0.1:8000')) {
        $r->image = str_replace('https://127.0.0.1:8000', 'http://localhost:8000', $r->image);
        $r->save();
        echo "Updated restaurant {$r->id}\n";
    }
}
echo "Done.";
