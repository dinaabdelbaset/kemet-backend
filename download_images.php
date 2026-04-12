<?php
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

$hotels = \App\Models\Hotel::all();
$save_path = 'e:\\اخر تحديث\\kemet-frontend-main\\public\\hotels-live\\';

$success = 0;
foreach ($hotels as $hotel) {
    if (str_starts_with($hotel->image, 'http')) {
        // Download the image
        try {
            $response = Http::withHeaders(['User-Agent' => 'Mozilla/5.0'])->get($hotel->image);
            if ($response->successful()) {
                $filename = 'hotel_' . $hotel->id . '_' . Str::slug($hotel->title) . '.jpg';
                $fullPath = $save_path . $filename;
                file_put_contents($fullPath, $response->body());
                
                // Update DB
                $hotel->image = '/hotels-live/' . $filename;
                $hotel->save();
                $success++;
                echo "Downloaded: $filename\n";
            } else {
                echo "Failed to download for: {$hotel->title} (Code: {$response->status()})\n";
                // Fallback to local image
                $hotel->image = '/hotels-live/cairo_boutique.png';
                $hotel->save();
            }
        } catch (\Exception $e) {
            echo "Error downloading for {$hotel->title}: " . $e->getMessage() . "\n";
            $hotel->image = '/hotels-live/cairo_boutique.png';
            $hotel->save();
        }
    }
}
echo "\nTotal downloaded successfully: $success\n";
