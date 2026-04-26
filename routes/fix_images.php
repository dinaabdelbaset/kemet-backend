<?php

use Illuminate\Support\Facades\Route;

// ===== Fix ALL images across the entire platform =====
Route::get('/fix-all-images', function () {
    $updated = [];

    // ─── TOURS ───────────────────────────────────────────────────────────────
    $tourKeywords = [
        'pyramids'       => '/images/tours/pyramids_giza.png',
        'giza'           => '/images/tours/pyramids_giza.png',
        'nile'           => '/images/tours/nile_cruise.png',
        'felucca'        => '/images/tours/nile_cruise.png',
        'luxor'          => '/images/tours/luxor_valley_kings.png',
        'valley'         => '/images/tours/luxor_valley_kings.png',
        'karnak'         => '/images/tours/luxor_valley_kings.png',
        'hatshepsut'     => '/images/tours/luxor_valley_kings.png',
        'abu simbel'     => '/images/tours/abu_simbel.png',
        'red sea'        => '/images/tours/red_sea_diving.png',
        'diving'         => '/images/tours/red_sea_diving.png',
        'snorkel'        => '/images/tours/red_sea_diving.png',
        'sharm'          => '/images/tours/red_sea_diving.png',
        'hurghada'       => '/images/tours/red_sea_diving.png',
        'aswan'          => '/images/tours/nile_cruise.png',
        'nubian'         => '/images/tours/nile_cruise.png',
        'food'           => '/images/tour-cairo-food.png',
        'cairo food'     => '/images/tour-cairo-food.png',
        'museum'         => '/images/tour-museum.png',
    ];
    $tourFallbacks = array_values(array_unique(array_values($tourKeywords)));
    $tc = 0;
    \App\Models\Tour::chunk(100, function ($tours) use ($tourKeywords, $tourFallbacks, &$tc, &$updated) {
        foreach ($tours as $tour) {
            $titleLc = strtolower($tour->title . ' ' . $tour->location);
            $img = null;
            foreach ($tourKeywords as $kw => $path) {
                if (str_contains($titleLc, $kw)) { $img = $path; break; }
            }
            if (!$img) $img = $tourFallbacks[$tc % count($tourFallbacks)];
            $tour->update(['image' => $img]);
            $tc++;
        }
        $updated['tours'] = $tc;
    });

    // ─── SAFARIS ─────────────────────────────────────────────────────────────
    $safariKeywords = [
        'white desert'  => '/images/safaris2/white_desert.png',
        'bahariya'      => '/images/safaris2/bahariya_oasis.png',
        'siwa'          => '/images/safaris2/siwa_oasis.png',
        'wadi'          => '/images/safaris2/wadi_rayan.png',
        'fayoum'        => '/images/safaris2/wadi_rayan.png',
        'hurghada'      => '/images/safaris2/hurghada_atv.png',
        'atv'           => '/images/safaris2/hurghada_atv.png',
        'quad'          => '/images/safaris2/hurghada_atv.png',
        'red sea'       => '/images/safaris2/hurghada_atv.png',
        'bedouin'       => '/images/safaris2/siwa_oasis.png',
        'giza'          => '/images/safaris2/bahariya_oasis.png',
        'saqqara'       => '/images/safaris2/bahariya_oasis.png',
        'horse'         => '/images/safaris2/bahariya_oasis.png',
        'camel'         => '/images/safaris2/siwa_oasis.png',
        'aswan'         => '/images/safaris2/siwa_oasis.png',
    ];
    $safariFallbacks = array_values(array_unique(array_values($safariKeywords)));
    $sc = 0;
    \App\Models\Safari::chunk(100, function ($safaris) use ($safariKeywords, $safariFallbacks, &$sc, &$updated) {
        foreach ($safaris as $safari) {
            $titleLc = strtolower($safari->title . ' ' . $safari->location);
            $img = null;
            foreach ($safariKeywords as $kw => $path) {
                if (str_contains($titleLc, $kw)) { $img = $path; break; }
            }
            if (!$img) $img = $safariFallbacks[$sc % count($safariFallbacks)];
            $safari->update(['image' => $img]);
            $sc++;
        }
        $updated['safaris'] = $sc;
    });

    // ─── MUSEUMS ─────────────────────────────────────────────────────────────
    $museumKeywords = [
        'karnak'          => '/images/museums2/karnak_temple.png',
        'luxor temple'    => '/images/museums2/karnak_temple.png',
        'luxor'           => '/images/museums2/karnak_temple.png',
        'grand egyptian'  => '/images/museums2/gem_giza.png',
        'gem'             => '/images/museums2/gem_giza.png',
        'imhotep'         => '/images/museums2/gem_giza.png',
        'egyptian museum' => '/images/museums2/gem_giza.png',
        'giza'            => '/images/museums2/gem_giza.png',
        'nubian'          => '/images/museums2/nubian_museum.png',
        'elephantine'     => '/images/museums2/nubian_museum.png',
        'aswan'           => '/images/museums2/nubian_museum.png',
        'islamic'         => '/images/museums2/islamic_art.png',
        'coptic'          => '/images/museums2/islamic_art.png',
        'cairo'           => '/images/museums2/islamic_art.png',
        'montaza'         => '/images/museums2/montaza_palace.png',
        'alexandria'      => '/images/museums2/montaza_palace.png',
    ];
    $museumFallbacks = array_values(array_unique(array_values($museumKeywords)));
    $mc = 0;
    \App\Models\Museum::chunk(100, function ($museums) use ($museumKeywords, $museumFallbacks, &$mc, &$updated) {
        foreach ($museums as $museum) {
            $titleLc = strtolower(($museum->name ?? '') . ' ' . ($museum->location ?? ''));
            $img = null;
            foreach ($museumKeywords as $kw => $path) {
                if (str_contains($titleLc, $kw)) { $img = $path; break; }
            }
            if (!$img) $img = $museumFallbacks[$mc % count($museumFallbacks)];
            $museum->update(['image' => $img]);
            $mc++;
        }
        $updated['museums'] = $mc;
    });

    // ─── EVENTS ──────────────────────────────────────────────────────────────
    $eventKeywords = [
        'pyramids'  => '/images/events2/pyramids_film_fest.png',
        'film'      => '/images/events2/pyramids_film_fest.png',
        'cinema'    => '/images/events2/pyramids_film_fest.png',
        'gouna'     => '/images/events2/gouna_film_fest.png',
        'hurghada'  => '/images/events2/gouna_film_fest.png',
        'opera'     => '/images/events2/cairo_opera.png',
        'aida'      => '/images/events2/cairo_opera.png',
        'whirling'  => '/images/events2/cairo_opera.png',
        'dervish'   => '/images/events2/cairo_opera.png',
        'book'      => '/images/events2/cairo_opera.png',
        'jazz'      => '/images/events2/nile_jazz.png',
        'music'     => '/images/events2/nile_jazz.png',
        'nile'      => '/images/events2/nile_jazz.png',
        'pottery'   => '/images/events2/tunis_pottery.png',
        'tunis'     => '/images/events2/tunis_pottery.png',
        'fayoum'    => '/images/events2/tunis_pottery.png',
        'craft'     => '/images/events2/tunis_pottery.png',
    ];
    $eventFallbacks = array_values(array_unique(array_values($eventKeywords)));
    $ev = 0;
    \App\Models\Event::chunk(100, function ($events) use ($eventKeywords, $eventFallbacks, &$ev, &$updated) {
        foreach ($events as $event) {
            $titleLc = strtolower(($event->title ?? '') . ' ' . ($event->location ?? '') . ' ' . ($event->category ?? ''));
            $img = null;
            foreach ($eventKeywords as $kw => $path) {
                if (str_contains($titleLc, $kw)) { $img = $path; break; }
            }
            if (!$img) $img = $eventFallbacks[$ev % count($eventFallbacks)];
            $event->update(['image' => $img]);
            $ev++;
        }
        $updated['events'] = $ev;
    });

    // ─── BAZAARS ─────────────────────────────────────────────────────────────
    $bazaarKeywords = [
        'aswan'      => '/images/bazaars2/aswan_souk.png',
        'nubian'     => '/images/bazaars2/aswan_souk.png',
        'khan'       => '/images/bazaars2/khan_khalili.png',
        'khalili'    => '/images/bazaars2/khan_khalili.png',
        'cairo'      => '/images/bazaars2/khan_khalili.png',
        'nazlet'     => '/images/bazaars2/khan_khalili.png',
        'wissa'      => '/images/bazaars2/khan_khalili.png',
        'giza'       => '/images/bazaars2/khan_khalili.png',
        'luxor'      => '/images/bazaars2/luxor_souk.png',
        'souk'       => '/images/bazaars2/luxor_souk.png',
        'fayoum'     => '/images/bazaars2/luxor_souk.png',
        'tunis'      => '/images/bazaars2/luxor_souk.png',
        'pottery'    => '/images/bazaars2/luxor_souk.png',
        'sharm'      => '/images/bazaars2/aswan_souk.png',
        'hurghada'   => '/images/bazaars2/aswan_souk.png',
    ];
    $bazaarFallbacks = ['/images/bazaars2/khan_khalili.png', '/images/bazaars2/aswan_souk.png', '/images/bazaars2/luxor_souk.png'];
    $bz = 0;
    \App\Models\Bazaar::chunk(100, function ($bazaars) use ($bazaarKeywords, $bazaarFallbacks, &$bz, &$updated) {
        foreach ($bazaars as $bazaar) {
            $titleLc = strtolower(($bazaar->title ?? '') . ' ' . ($bazaar->location ?? ''));
            $img = null;
            foreach ($bazaarKeywords as $kw => $path) {
                if (str_contains($titleLc, $kw)) { $img = $path; break; }
            }
            if (!$img) $img = $bazaarFallbacks[$bz % count($bazaarFallbacks)];
            $bazaar->update(['image' => $img]);
            $bz++;
        }
        $updated['bazaars'] = $bz;
    });

    // ─── HOTELS ──────────────────────────────────────────────────────────────
    $hotelByLoc = [
        'cairo'      => '/images/hotels2/cairo_nile.png',
        'giza'       => '/images/hotels2/cairo_nile.png',
        'sharm'      => '/images/hotels2/sharm_resort.png',
        'taba'       => '/images/hotels2/sharm_resort.png',
        'dahab'      => '/images/hotels2/sharm_resort.png',
        'hurghada'   => '/images/hotels2/hurghada_resort.png',
        'marsa'      => '/images/hotels2/hurghada_resort.png',
        'luxor'      => '/images/hotels2/luxor_nile.png',
        'aswan'      => '/images/hotels2/aswan_nubian.png',
        'siwa'       => '/images/hotels2/aswan_nubian.png',
        'alexandria' => '/images/hotels2/cairo_nile.png',
        'alex'       => '/images/hotels2/cairo_nile.png',
        'matrouh'    => '/images/hotels2/sharm_resort.png',
        'fayoum'     => '/images/hotels2/luxor_nile.png',
        'said'       => '/images/hotels2/cairo_nile.png',
    ];
    $allHotelImgs = [
        '/images/hotels2/cairo_nile.png',
        '/images/hotels2/sharm_resort.png',
        '/images/hotels2/luxor_nile.png',
        '/images/hotels2/aswan_nubian.png',
        '/images/hotels2/hurghada_resort.png',
    ];
    $hc = 0;
    \App\Models\Hotel::chunk(100, function ($hotels) use ($hotelByLoc, $allHotelImgs, &$hc, &$updated) {
        foreach ($hotels as $hotel) {
            $loc = strtolower($hotel->location ?? '');
            $img = null;
            foreach ($hotelByLoc as $kw => $path) {
                if (str_contains($loc, $kw)) { $img = $path; break; }
            }
            if (!$img) $img = $allHotelImgs[$hc % count($allHotelImgs)];
            $others = array_values(array_filter($allHotelImgs, fn($p) => $p !== $img));
            shuffle($others);
            $hotel->update([
                'image'   => $img,
                'gallery' => array_merge([$img], array_slice($others, 0, 3)),
            ]);
            $hc++;
        }
        $updated['hotels'] = $hc;
    });

    return response()->json(['status' => 'done', 'updated' => $updated]);
});
