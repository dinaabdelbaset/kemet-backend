<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use Illuminate\Support\Facades\DB;

$safaris = DB::table('safaris')->get();
echo "Count: " . count($safaris) . PHP_EOL;
foreach ($safaris as $s) {
    echo "ID: " . $s->id . " | Title: " . $s->title . " | Status: " . ($s->status ?? 'N/A') . PHP_EOL;
}
