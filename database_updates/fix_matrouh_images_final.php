<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Update Museums (uses name)
$museums = DB::table('museums')->where('location','LIKE','%Matrouh%')->get();
if(count($museums) >= 2) {
    DB::table('museums')->where('id', $museums[0]->id)->update([
        'name' => 'Rommel Cave Museum (متحف كهف روميل)',
        'image' => '/images/destinations/matrouh/rommel_cave.png'
    ]);
    DB::table('museums')->where('id', $museums[1]->id)->update([
        'name' => 'Matrouh Antiquities Museum (متحف مطروح للآثار)',
        'image' => '/images/destinations/matrouh/antiquities_museum.png'
    ]);
}

// Update Bazaars (uses title)
$bazaars = DB::table('bazaars')->where('location','LIKE','%Matrouh%')->get();
if(count($bazaars) >= 2) {
    DB::table('bazaars')->where('id', $bazaars[0]->id)->update([
        'title' => 'Souq Libya (سوق ليبيا الشهير)',
        'image' => '/images/destinations/matrouh/souq_libya.png'
    ]);
    DB::table('bazaars')->where('id', $bazaars[1]->id)->update([
        'title' => 'Alexandria Street Market (شارع الإسكندرية)',
        'image' => '/images/destinations/matrouh/alexandria_street.png'
    ]);
}

// Update Safaris (uses title)
$safaris = DB::table('safaris')->where('location','LIKE','%Matrouh%')->get();
if(count($safaris) >= 2) {
    DB::table('safaris')->where('id', $safaris[0]->id)->update([
        'title' => 'Siwa Oasis Desert Expedition (سفاري واحة سيوة)',
        'image' => '/images/destinations/matrouh/siwa_safari.png'
    ]);
    DB::table('safaris')->where('id', $safaris[1]->id)->update([
        'title' => 'Agiba Beach & Cleopatra Bath Tour (جولة عجيبة وكليوباترا)',
        'image' => '/images/destinations/matrouh/cleopatra_bath.png'
    ]);
}

// Update Events (uses title)
$events = DB::table('events')->where('location','LIKE','%Matrouh%')->get();
if(count($events) >= 2) {
    DB::table('events')->where('id', $events[0]->id)->update([
        'title' => 'Matrouh Summer Beach Festival (مهرجان مطروح الصيفي)',
        'image' => '/images/destinations/matrouh/beach_festival.png'
    ]);
    DB::table('events')->where('id', $events[1]->id)->update([
        'title' => 'Siwa Dates Festival (مهرجان التمور بسيوة)',
        'image' => '/images/destinations/matrouh/siwa_dates.png'
    ]);
}

// Update Restaurants handling
$restaurants = DB::table('restaurants')->where('location', 'LIKE', '%Matrouh%')->get();
foreach($restaurants as $r) {
    DB::table('restaurants')->where('id', $r->id)->update([
        'image' => '/images/destinations/matrouh/seafood.png'
    ]);
}

echo "Successfully updated Marsa Matrouh images dynamically to high-res accurately themed local images!\n";
