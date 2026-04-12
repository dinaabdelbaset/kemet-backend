<?php
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

$models = [
    \App\Models\Restaurant::class,
    \App\Models\Event::class,
    \App\Models\Bazaar::class,
    \App\Models\Museum::class,
    \App\Models\Tour::class,
    \App\Models\Safari::class,
    \App\Models\TravelPackage::class,
    \App\Models\Destination::class,
];

$save_path = 'e:\\اخر تحديث\\kemet-frontend-main\\public\\images\\downloads\\';
if (!file_exists($save_path)) {
    mkdir($save_path, 0777, true);
}

$success = 0;
foreach ($models as $modelClass) {
    if (!class_exists($modelClass)) continue;

    $items = $modelClass::all();
    $modelName = class_basename($modelClass);
    echo "Processing $modelName...\n";

    foreach ($items as $item) {
        $changed = false;

        // Handle single image
        if (!empty($item->image) && str_starts_with($item->image, 'http')) {
            $newPath = processImage($item->image, $save_path, $modelName, $item->id);
            if ($newPath) {
                $item->image = $newPath;
                $changed = true;
            }
        }

        // Handle gallery if exists
        if (!empty($item->gallery) && is_array($item->gallery)) {
            $newGallery = [];
            foreach ($item->gallery as $idx => $gImg) {
                if (str_starts_with($gImg, 'http')) {
                    $newPath = processImage($gImg, $save_path, $modelName, $item->id . '_g' . $idx);
                    if ($newPath) {
                        $newGallery[] = $newPath;
                        $changed = true;
                    } else {
                        $newGallery[] = $gImg;
                    }
                } else {
                    $newGallery[] = $gImg;
                }
            }
            if ($changed) {
                $item->gallery = $newGallery;
            }
        }

        if ($changed) {
            $item->save();
            $success++;
        }
    }
}

echo "\nTotal items securely downloaded & localized: $success\n";

function processImage($url, $save_path, $modelName, $id) {
    // Check if it's a localhost kamet-images api url
    if (str_contains($url, 'localhost:8000/api/kamet-images/')) {
        $filename = basename(parse_url($url, PHP_URL_PATH)); // "abou_el_sid"
        $storagePath = storage_path('app/kamet-images/' . $filename . '.png');
        if (file_exists($storagePath)) {
            $newFilename = strtolower($modelName) . '_' . $id . '_' . $filename . '.png';
            copy($storagePath, $save_path . $newFilename);
            return '/images/downloads/' . $newFilename;
        }
    }

    // Otherwise download it
    try {
        $response = Http::withHeaders(['User-Agent' => 'Mozilla/5.0'])->timeout(5)->get($url);
        if ($response->successful()) {
            $ext = 'jpg';
            if (str_contains($response->header('Content-Type'), 'png')) $ext = 'png';
            $newFilename = strtolower($modelName) . '_' . $id . '_' . Str::random(5) . '.' . $ext;
            file_put_contents($save_path . $newFilename, $response->body());
            return '/images/downloads/' . $newFilename;
        }
    } catch (\Exception $e) {
        // failed
    }
    return null; // Don't replace if failed
}
