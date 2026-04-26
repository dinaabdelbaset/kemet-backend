<?php

use Illuminate\Support\Facades\Route;

// ===== Restore ALL original images =====
Route::get('/restore-original-images', function () {
    $updated = [];

    // ─── TOURS: Restore original seeder images ────────────────────────────────
    $tourKeywords = [
        'Pyramids'        => '/images/tour-pyramids.png',
        'Cairo City'      => '/images/tour-pyramids.png',
        'Nile Dinner'     => '/images/tour-nile-cruise.png',
        'Nile Cruise'     => '/images/tour-nile-cruise.png',
        'Felucca'         => '/images/tour-nile-cruise.png',
        'Red Sea Snorkel' => '/images/tour-red-sea.png',
        'Red Sea'         => '/images/tour-red-sea.png',
        'Desert Safari'   => '/images/tour-desert-safari.png',
        'ATV'             => '/images/tour-desert-safari.png',
        'Cairo Food'      => '/images/tour-cairo-food.png',
        'Food Tour'       => '/images/tour-cairo-food.png',
        'Museum'          => '/images/tour-museum.png',
        'Valley of'       => '/images/tour-pyramids.png',
        'Luxor'           => '/images/tour-pyramids.png',
        'Aswan'           => '/images/tour-nile-cruise.png',
        'Nubian'          => '/images/tour-nile-cruise.png',
    ];
    $tourFallbacks = [
        '/images/tour-pyramids.png',
        '/images/tour-nile-cruise.png',
        '/images/tour-red-sea.png',
        '/images/tour-desert-safari.png',
        '/images/tour-cairo-food.png',
        '/images/tour-museum.png',
    ];
    $tc = 0;
    \App\Models\Tour::chunk(100, function ($tours) use ($tourKeywords, $tourFallbacks, &$tc, &$updated) {
        foreach ($tours as $tour) {
            $img = null;
            foreach ($tourKeywords as $kw => $path) {
                if (str_contains($tour->title, $kw)) { $img = $path; break; }
            }
            if (!$img) $img = $tourFallbacks[$tc % count($tourFallbacks)];
            $tour->update(['image' => $img]);
            $tc++;
        }
        $updated['tours'] = $tc;
    });

    // ─── SAFARIS: Restore original images ────────────────────────────────────
    $safariKeywords = [
        'Bahariya'      => '/images/safaris/bahariya-oasis.jpg',
        'White Desert'  => '/images/safaris/white-desert.jpg',
        'Siwa'          => '/images/safaris/siwa-adventure.jpg',
        'Wadi El Rayan' => '/images/safaris/wadi-el-rayan.jpg',
        'Wadi'          => '/images/safaris/wadi-el-rayan.jpg',
        'Hurghada'      => '/images/safaris/hurghada-quad.jpg',
        'ATV'           => '/images/safaris/hurghada-quad.jpg',
        'Quad'          => '/images/safaris/hurghada-quad.jpg',
        'Red Sea'       => '/images/safaris/hurghada-quad.jpg',
        'Giza'          => '/images/safaris/bahariya-oasis.jpg',
        'Saqqara'       => '/images/safaris/bahariya-oasis.jpg',
        'Bedouin'       => '/images/safaris/siwa-adventure.jpg',
        'Fayoum'        => '/images/safaris/wadi-el-rayan.jpg',
    ];
    $safariFallbacks = [
        '/images/safaris/bahariya-oasis.jpg',
        '/images/safaris/hurghada-quad.jpg',
        '/images/safaris/siwa-adventure.jpg',
        '/images/safaris/wadi-el-rayan.jpg',
        '/images/safaris/white-desert.jpg',
    ];
    $sc = 0;
    \App\Models\Safari::chunk(100, function ($safaris) use ($safariKeywords, $safariFallbacks, &$sc, &$updated) {
        foreach ($safaris as $safari) {
            $img = null;
            $titleLc = $safari->title . ' ' . $safari->location;
            foreach ($safariKeywords as $kw => $path) {
                if (str_contains($titleLc, $kw)) { $img = $path; break; }
            }
            if (!$img) $img = $safariFallbacks[$sc % count($safariFallbacks)];
            $safari->update(['image' => $img]);
            $sc++;
        }
        $updated['safaris'] = $sc;
    });

    // ─── MUSEUMS: Restore original images ────────────────────────────────────
    $museumKeywords = [
        'Karnak'           => '/museums/karnak_hero.png',
        'Luxor Museum'     => '/museums/luxor_1.png',
        'Kom Ombo'         => '/museums/kom_1.png',
        'National Museum'  => '/museums/nmec_1.jpg',
        'NMEC'             => '/museums/nmec_1.jpg',
        'Grand Egyptian'   => '/images/destinations/giza/gem.png',
        'GEM'              => '/images/destinations/giza/gem.png',
        'Imhotep'          => '/images/destinations/giza/imhotep.png',
        'Nubian Museum'    => '/images/destinations/aswan/nubian_museum.png',
        'Elephantine'      => '/images/destinations/aswan/elephantine_museum.png',
        'Montaza'          => '/museums/montaza_1.png',
        'Islamic'          => '/images/home/museums.jpg',
        'Coptic'           => '/images/home/museums.jpg',
        'Egyptian Museum'  => '/museums/nmec_1.jpg',
    ];
    $museumFallbacks = [
        '/museums/karnak_hero.png',
        '/museums/nmec_1.jpg',
        '/museums/montaza_1.png',
        '/museums/kom_1.png',
        '/images/home/museums.jpg',
    ];
    $mc = 0;
    \App\Models\Museum::chunk(100, function ($museums) use ($museumKeywords, $museumFallbacks, &$mc, &$updated) {
        foreach ($museums as $museum) {
            $img = null;
            $titleLc = ($museum->name ?? '') . ' ' . ($museum->location ?? '');
            foreach ($museumKeywords as $kw => $path) {
                if (str_contains($titleLc, $kw)) { $img = $path; break; }
            }
            if (!$img) $img = $museumFallbacks[$mc % count($museumFallbacks)];
            $museum->update(['image' => $img]);
            $mc++;
        }
        $updated['museums'] = $mc;
    });

    // ─── EVENTS: Restore original images ─────────────────────────────────────
    $eventKeywords = [
        'Book Fair'         => '/events/event_book_fair.png',
        'Cairo Jazz'        => '/events/event_cairo_jazz.png',
        'Jazz'              => '/events/event_cairo_jazz.png',
        'Opera'             => '/events/event_opera_aida.png',
        'Aida'              => '/events/event_opera_aida.png',
        'Pyramids'          => '/events/event_pyramids_light_show.png',
        'Sound'             => '/events/event_pyramids_light_show.png',
        'Light Show'        => '/events/event_pyramids_light_show.png',
        'EDM'               => '/events/event_red_sea_edm.png',
        'Red Sea'           => '/events/event_red_sea_edm.png',
        'Hurghada'          => '/events/event_red_sea_edm.png',
        'Gouna'             => '/events/event_red_sea_edm.png',
        'Film'              => '/events/event_red_sea_edm.png',
        'Whirling'          => '/events/event_whirling_dervishes.png',
        'Dervish'           => '/events/event_whirling_dervishes.png',
        'Pottery'           => '/images/bazaars/spices.png',
        'Tunis'             => '/images/bazaars/spices.png',
        'Fayoum'            => '/images/bazaars/spices.png',
    ];
    $eventFallbacks = [
        '/events/event_book_fair.png',
        '/events/event_cairo_jazz.png',
        '/events/event_opera_aida.png',
        '/events/event_pyramids_light_show.png',
        '/events/event_red_sea_edm.png',
        '/events/event_whirling_dervishes.png',
    ];
    $ev = 0;
    \App\Models\Event::chunk(100, function ($events) use ($eventKeywords, $eventFallbacks, &$ev, &$updated) {
        foreach ($events as $event) {
            $img = null;
            $titleLc = ($event->title ?? '') . ' ' . ($event->category ?? '');
            foreach ($eventKeywords as $kw => $path) {
                if (str_contains($titleLc, $kw)) { $img = $path; break; }
            }
            if (!$img) $img = $eventFallbacks[$ev % count($eventFallbacks)];
            $event->update(['image' => $img]);
            $ev++;
        }
        $updated['events'] = $ev;
    });

    // ─── BAZAARS: Restore original seeder images ──────────────────────────────
    $bazaarKeywords = [
        'Khan'          => '/images/bazaars/khan-el-khalili.jpg',
        'Khalili'       => '/images/bazaars/khan-el-khalili.jpg',
        'Cairo'         => '/images/bazaars/khan-el-khalili.jpg',
        'Wissa'         => '/images/bazaars/khan-el-khalili.jpg',
        'Nazlet'        => '/images/bazaars/khan-el-khalili.jpg',
        'Giza'          => '/images/bazaars/khan-el-khalili.jpg',
        'Aswan'         => '/images/bazaars/aswan-spice.jpg',
        'Nubian'        => '/images/bazaars/aswan-spice.jpg',
        'Luxor'         => '/images/bazaars/luxor-souq.jpg',
        'Sharm'         => '/images/bazaars/sharm-old-market.jpg',
        'Siwa'          => '/images/bazaars/shali-market.jpg',
        'Shali'         => '/images/bazaars/shali-market.jpg',
        'Mansheya'      => '/images/bazaars/mansheya-market.jpg',
        'Alexandria'    => '/images/bazaars/mansheya-market.jpg',
        'Fayoum'        => '/images/bazaars/luxor-souq.jpg',
        'Tunis'         => '/images/bazaars/luxor-souq.jpg',
        'Hurghada'      => '/images/bazaars/aswan-spice.jpg',
    ];
    $bazaarFallbacks = [
        '/images/bazaars/khan-el-khalili.jpg',
        '/images/bazaars/aswan-spice.jpg',
        '/images/bazaars/luxor-souq.jpg',
        '/images/bazaars/sharm-old-market.jpg',
        '/images/bazaars/shali-market.jpg',
        '/images/bazaars/mansheya-market.jpg',
    ];
    $bz = 0;
    \App\Models\Bazaar::chunk(100, function ($bazaars) use ($bazaarKeywords, $bazaarFallbacks, &$bz, &$updated) {
        foreach ($bazaars as $bazaar) {
            $img = null;
            $titleLc = ($bazaar->title ?? '') . ' ' . ($bazaar->location ?? '');
            foreach ($bazaarKeywords as $kw => $path) {
                if (str_contains($titleLc, $kw)) { $img = $path; break; }
            }
            if (!$img) $img = $bazaarFallbacks[$bz % count($bazaarFallbacks)];
            $bazaar->update(['image' => $img]);
            $bz++;
        }
        $updated['bazaars'] = $bz;
    });

    // ─── HOTELS: Restore original location-based images ──────────────────────
    $hotelByLoc = [
        'cairo'      => ['/images/hotels/cairo.png', '/hotels/pyramids.png', '/hotels/cairo_boutique.png', '/hotels/cairo_heritage.png'],
        'giza'       => ['/images/hotels/giza.png', '/hotels/pyramids.png', '/hotels/nile.png'],
        'sharm'      => ['/hotels/redsea.png', '/hotels/sharm_bungalows.png'],
        'hurghada'   => ['/hotels/redsea.png', '/hotels/marsa_lodge.png'],
        'marsa'      => ['/hotels/redsea.png', '/hotels/marsa_lodge.png'],
        'luxor'      => ['/hotels/luxor.png', '/hotels/luxor_sunset.png'],
        'aswan'      => ['/hotels/aswan.png', '/hotels/aswan_cruise.png'],
        'siwa'       => ['/hotels/siwa.png'],
        'fayoum'     => ['/images/hotels/fayoum.png', '/hotels/siwa.png'],
        'alexandria' => ['/hotels/alex.png', '/hotels/north_coast.png'],
        'alex'       => ['/hotels/alex.png'],
        'matrouh'    => ['/hotels/matrouh.png', '/hotels/north_coast.png'],
        'dahab'      => ['/hotels/redsea.png'],
        'taba'       => ['/hotels/redsea.png'],
        'said'       => ['/hotels/nile.png'],
    ];
    $allHotelImgs = [
        '/hotels/pyramids.png', '/hotels/nile.png', '/hotels/redsea.png',
        '/hotels/luxor.png', '/hotels/siwa.png', '/hotels/aswan.png',
        '/hotels/alex.png', '/hotels/cairo_boutique.png', '/hotels/matrouh.png',
        '/hotels/desert.png', '/hotels/luxor_sunset.png', '/hotels/sharm_bungalows.png',
        '/hotels/cairo_heritage.png', '/hotels/aswan_cruise.png', '/hotels/marsa_lodge.png',
        '/hotels/north_coast.png',
    ];
    $hc = 0;
    \App\Models\Hotel::chunk(100, function ($hotels) use ($hotelByLoc, $allHotelImgs, &$hc, &$updated) {
        foreach ($hotels as $hotel) {
            $loc = strtolower($hotel->location ?? '');
            $pool = null;
            foreach ($hotelByLoc as $kw => $paths) {
                if (str_contains($loc, $kw)) { $pool = $paths; break; }
            }
            if (!$pool) $pool = [$allHotelImgs[$hc % count($allHotelImgs)]];
            $img = $pool[$hc % count($pool)];
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

    return response()->json(['status' => 'restored ✅', 'updated' => $updated]);
});
