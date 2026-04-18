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
        'description' => 'A unique military museum located in the actual cave used by the German Field Marshal Erwin Rommel during WWII.',
        'image' => '/images/era-modern.png'
    ]);
    DB::table('museums')->where('id', $museums[1]->id)->update([
        'name' => 'Matrouh Antiquities Museum (متحف مطروح للآثار)',
        'description' => 'A beautiful regional museum showcasing artifacts across Pharaonic, Roman, Coptic, and Islamic eras found in the Matrouh region.',
        'image' => '/images/tour-museum.png'
    ]);
}

// Update Bazaars (uses title)
$bazaars = DB::table('bazaars')->where('location','LIKE','%Matrouh%')->get();
if(count($bazaars) >= 2) {
    DB::table('bazaars')->where('id', $bazaars[0]->id)->update([
        'title' => 'Souq Libya (سوق ليبيا الشهير)',
        'description' => 'The most famous shopping destination in Matrouh, originally offering Libyan and imported goods, spices, and bedouin crafts.',
        'image' => '/images/luxor-souk.png'
    ]);
    DB::table('bazaars')->where('id', $bazaars[1]->id)->update([
        'title' => 'Alexandria Street Market (شارع الإسكندرية)',
        'description' => 'The vibrant main street of Marsa Matrouh packed with local vendors, cafes, and souvenir shops perfect for evening strolls.',
        'image' => '/images/era-islamic.png'
    ]);
}

// Update Safaris (uses title)
$safaris = DB::table('safaris')->where('location','LIKE','%Matrouh%')->get();
if(count($safaris) >= 2) {
    DB::table('safaris')->where('id', $safaris[0]->id)->update([
        'title' => 'Siwa Oasis Desert Expedition (سفاري واحة سيوة)',
        'description' => 'An unforgettable 4x4 desert safari journey from Matrouh to the magical Siwa Oasis, featuring Great Sand Sea dune bashing.',
        'image' => '/images/siwa-safari.png'
    ]);
    DB::table('safaris')->where('id', $safaris[1]->id)->update([
        'title' => 'Agiba Beach & Cleopatra Bath Tour (جولة عجيبة وكليوباترا)',
        'description' => 'Explore the dramatic coastal cliffs of Agiba Beach and the historic natural rock pools of Cleopatra\'s Bath.',
        'image' => '/images/destinations/marsa-matrouh.png'
    ]);
}

// Update Events (uses title)
$events = DB::table('events')->where('location','LIKE','%Matrouh%')->get();
if(count($events) >= 2) {
    DB::table('events')->where('id', $events[0]->id)->update([
        'title' => 'Matrouh Summer Beach Festival (مهرجان مطروح الصيفي)',
        'description' => 'An annual vibrant summer festival bringing beachside concerts, bedouin folklore performances, and celebrations.',
        'image' => '/images/home/events.jpg'
    ]);
    DB::table('events')->where('id', $events[1]->id)->update([
        'title' => 'Siwa Dates Festival (مهرجان التمور بسيوة)',
        'description' => 'An internationally recognized traditional agricultural festival celebrating the rich harvest of dates and olives in the nearby Siwa oasis.',
        'image' => '/images/destinations/port-said.png'
    ]);
}

echo "Successfully updated Marsa Matrouh data with REAL places!\n";
