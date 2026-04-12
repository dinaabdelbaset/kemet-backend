<?php
use Illuminate\Support\Str;

$models = [
    \App\Models\Bazaar::class,
    \App\Models\Event::class,
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

    foreach ($items as $item) {
        $changed = false;

        // Handle single image
        if (!empty($item->image) && str_starts_with($item->image, 'http')) {
            $newPath = processImageWithCurl($item->image, $save_path, $modelName, $item->id);
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
                    $newPath = processImageWithCurl($gImg, $save_path, $modelName, $item->id . '_g' . $idx);
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

echo "\nTotal items securely downloaded & localized using cURL: $success\n";

function processImageWithCurl($url, $save_path, $modelName, $id) {
    echo "Downloading: $url\n";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    
    $data = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    curl_close($ch);

    if ($httpCode == 200 && $data) {
        $ext = 'jpg';
        if (str_contains(strtolower($contentType), 'png')) $ext = 'png';
        if (str_contains(strtolower($contentType), 'webp')) $ext = 'webp';
        
        $newFilename = strtolower($modelName) . '_' . $id . '_' . Str::random(5) . '.' . $ext;
        file_put_contents($save_path . $newFilename, $data);
        return '/images/downloads/' . $newFilename;
    }
    
    echo "Failed curl for $url - Code: $httpCode\n";
    return null;
}
