<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$outputFile = __DIR__.'/database_report.txt';
$fp = fopen($outputFile, 'w');

// 1. Write Seeders Section
fwrite($fp, "=== SEEDERS ===\n");
fwrite($fp, "Seeder: ActivitySeeder\nDescription: Seeds activities database table with predefined activities/experiences\n\n");
fwrite($fp, "Seeder: DatabaseSeeder\nDescription: Main database seeder that calls all other seeders to populate the entire database\n\n");
fwrite($fp, "Seeder: DestinationSeeder\nDescription: Seeds destinations table with locations such as Cairo, Luxor, Aswan, etc.\n\n");
fwrite($fp, "Seeder: HomepageSeeder\nDescription: Seeds homepage sections data for the frontend display\n\n");
fwrite($fp, "Seeder: HotelSeeder\nDescription: Seeds hotels table with available accommodation options\n\n");
fwrite($fp, "Seeder: ProductSeeder\nDescription: Seeds products table for the shop/bazaar section with artifacts/souvenirs\n\n");
fwrite($fp, "Seeder: TourSeeder\nDescription: Seeds tours table with pre-configured tour packages\n\n");

// 2. Table Overview
try {
    $tablesObj = DB::select('SHOW TABLES'); 
    $tableNames = array_map(function($t) { return array_values((array)$t)[0]; }, $tablesObj);
} catch (\Exception $e) {
    // Fallback if sqlite for some reason
    $tablesObj = DB::select("SELECT name FROM sqlite_master WHERE type='table'");
    $tableNames = array_map(function($t) { return $t->name; }, $tablesObj);
}


fwrite($fp, "=== DATABASE TABLES OVERVIEW ===\n");
foreach($tableNames as $tableName) {
    fwrite($fp, "- " . $tableName . "\n");
}
fwrite($fp, "\n");

// 3. Full Data Dump
foreach($tableNames as $tableName) {
    try {
        fwrite($fp, "=== TABLE: {$tableName} ===\n");
        $records = DB::table($tableName)->get();
        
        if ($records->isEmpty()) {
            fwrite($fp, "Data: (Empty)\n\n");
            continue;
        }
        
        $columns = array_keys((array) $records->first());
        fwrite($fp, "Columns: " . implode(', ', $columns) . "\n");
        fwrite($fp, "Data:\n");
        
        foreach($records as $record) {
            $values = [];
            foreach($columns as $col) {
                $val = $record->$col ?? null;
                if (is_null($val)) {
                    $values[] = 'NULL';
                } elseif (is_string($val)) {
                    // Truncate safely only if it's super large, but requirements didn't specify to truncate so we will try to keep most of it intact, just remove line breaks
                    $stringVal = str_replace(["\r", "\n", "\t"], " ", $val);
                    if(mb_strlen($stringVal) > 600) {
                        $stringVal = mb_substr($stringVal, 0, 600) . '...[TRUNCATED]';
                    }
                    $values[] = '"' . $stringVal . '"';
                } elseif (is_bool($val)) {
                    $values[] = $val ? '1' : '0';
                } else {
                    $values[] = (string)$val;
                }
            }
            fwrite($fp, implode(' | ', $values) . "\n");
        }
        fwrite($fp, "\n");
    } catch (\Exception $e) {
        fwrite($fp, "Error reading table: " . $e->getMessage() . "\n\n");
    }
}

fclose($fp);
echo "Report successfully generated at: " . $outputFile . "\n";
