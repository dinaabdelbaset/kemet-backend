<?php
$models = [
    \App\Models\Restaurant::class, 
    \App\Models\Event::class, 
    \App\Models\Bazaar::class, 
    \App\Models\Museum::class, 
    \App\Models\Tour::class, 
    \App\Models\Safari::class, 
    \App\Models\TravelPackage::class, 
    \App\Models\Destination::class
];

foreach ($models as $model) {
    if (!class_exists($model)) continue;
    $items = $model::all();
    foreach ($items as $idx => $item) {
        if (!empty($item->image) && str_contains($item->image, 'unsplash')) {
            $item->image = 'https://picsum.photos/seed/' . strtolower(class_basename($model)) . $idx . '/800/600';
            $item->save();
        }
    }
}
echo "Fixed unsplash dead links to picsum!\n";
