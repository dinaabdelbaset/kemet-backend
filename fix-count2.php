<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$models = [
    \App\Models\Restaurant::class,
    \App\Models\Museum::class,
];

foreach ($models as $modelClass) {
    if (!class_exists($modelClass)) continue;
    $modelName = class_basename($modelClass);
    echo "Processing $modelName...\n";

    try {
        $locations = $modelClass::select('location')->distinct()->pluck('location');
        foreach ($locations as $loc) {
            if (!$loc) continue;
            // Get all items for this location ordered by id
            $items = $modelClass::where('location', $loc)->orderBy('id', 'asc')->get();
            $count = $items->count();
            
            if ($count > 6) {
                // Delete the excess
                $idsToDelete = $items->slice(6)->pluck('id');
                $modelClass::whereIn('id', $idsToDelete)->delete();
                echo "  $loc: deleted " . count($idsToDelete) . " excess records.\n";
            } elseif ($count < 6 && $count > 0) {
                // Duplicate records to make it exactly 6
                $toCreate = 6 - $count;
                $originalItems = $items->toArray();
                for ($i = 0; $i < $toCreate; $i++) {
                    $itemToDuplicate = $originalItems[$i % count($originalItems)];
                    unset($itemToDuplicate['id'], $itemToDuplicate['created_at'], $itemToDuplicate['updated_at']);
                    
                    if (isset($itemToDuplicate['name'])) {
                        $itemToDuplicate['name'] = $itemToDuplicate['name'] . ' ' . ($i + 2);
                    } elseif (isset($itemToDuplicate['title'])) {
                        $itemToDuplicate['title'] = $itemToDuplicate['title'] . ' ' . ($i + 2);
                    }
                    
                    $modelClass::create($itemToDuplicate);
                }
                echo "  $loc: duplicated $toCreate records.\n";
            } else {
                echo "  $loc: has exactly $count records.\n";
            }
        }
    } catch (\Exception $e) {
        echo "  Error processing $modelName: " . $e->getMessage() . "\n";
    }
}
echo "Done!\n";
