<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::table('events')->where('location', 'LIKE', '%Cairo%')
    ->where('title', 'LIKE', '%حفلة الصوت والضوء%')
    ->update([
        'title' => 'Cairo Opera House Performances (عروض دار الأوبرا)',
        'description' => 'Experience a magical evening of world-class classical music, ballet, and opera performances in the grand halls of the historic Cairo Opera House.',
        'image' => '/images/destinations/cairo/opera_event.png',
        'price' => 45
    ]);

DB::table('events')->where('location', 'LIKE', '%Cairo%')
    ->where('title', 'LIKE', '%مهرجان القلعة%')
    ->update([
        'image' => '/images/destinations/cairo/citadel_festival.png',
        'price' => 10
    ]);

// Also update english names if they exist
DB::table('events')->where('location', 'LIKE', '%Cairo%')
    ->where('title', 'LIKE', '%Sound and Light%')
    ->update([
        'title' => 'Cairo Opera House Performances (عروض دار الأوبرا)',
        'description' => 'Experience a magical evening of world-class classical music, ballet, and opera performances in the grand halls of the historic Cairo Opera House.',
        'image' => '/images/destinations/cairo/opera_event.png',
        'price' => 45
    ]);

DB::table('events')->where('location', 'LIKE', '%Cairo%')
    ->where('title', 'LIKE', '%Citadel Music%')
    ->update([
        'image' => '/images/destinations/cairo/citadel_festival.png',
        'price' => 10
    ]);

echo "Successfully updated Cairo events (Opera and Citadel)!\n";
