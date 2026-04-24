<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$hotel = \App\Models\Hotel::first();
echo 'Before: ' . $hotel->price_starts_from . "\n";

$request = new \Illuminate\Http\Request();
$request->merge(['name' => 'Updated Hotel', 'price' => 9999, 'description' => 'Updated description']);

$controller = app(\App\Http\Controllers\AdminController::class);
$controller->updateHotel($request, $hotel->id);

$hotel->refresh();
echo 'After: ' . $hotel->price_starts_from . ' | ' . $hotel->title . ' | ' . $hotel->description . "\n";
