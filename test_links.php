<?php
use Illuminate\Support\Facades\Http;

$hotels = \App\Models\Hotel::all();
foreach ($hotels as $hotel) {
    if (str_starts_with($hotel->image, 'http')) {
        try {
            $resp = Http::timeout(3)->withHeaders(['Referer' => 'http://localhost:5173/'])->get($hotel->image);
            if ($resp->failed()) {
                dump('BROKEN: ' . $hotel->title . ' -> ' . $hotel->image);
            }
        } catch (\Exception $e) {
            dump('TIMEOUT/ERR: ' . $hotel->title . ' -> ' . $hotel->image);
        }
    }
}
