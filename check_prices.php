<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use Illuminate\Support\Facades\DB;

$tables = ['tours', 'hotels', 'safaris', 'museums', 'bazaars', 'deals', 'transportations'];
foreach($tables as $table) {
    if (DB::getSchemaBuilder()->hasTable($table)) {
        if ($table === 'hotels' || $table === 'transportations') {
            $price = DB::table($table)->value('price_per_night') ?? DB::table($table)->value('price');
        } else {
            $price = DB::table($table)->value('price');
        }
        echo $table . ' - sample price: ' . $price . PHP_EOL;
    }
}
