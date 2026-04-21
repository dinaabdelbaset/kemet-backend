<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

function containsArabic($str) {
    if (!$str) return false;
    return preg_match('/[\x{0600}-\x{06FF}]/u', $str);
}

// 1. Destinations
foreach(App\Models\Destination::all() as $m) {
    // We shouldn't blindly replace if we can provide a good English one.
    // If name contains Arabic, we can strip it. But name is mostly mixed e.g. "Cairo (القاهرة)". That's fine.
    if(containsArabic($m->description)) {
        if (strpos($m->title, 'Cairo') !== false || strpos($m->title, 'القاهرة') !== false) {
           $m->description = "The bustling capital of Egypt, Cairo is a vibrant city where ancient history meets modern life. Home to the legendary Pyramids of Giza, the Sphinx, and the world-renowned Egyptian Museum.";
        } else if (strpos($m->title, 'Alexandria') !== false || strpos($m->title, 'إسكندرية') !== false) {
           $m->description = "The Pearl of the Mediterranean, founded by Alexander the Great. Famous for its majestic Citadel of Qaitbay, the Bibliotheca Alexandrina, and a lively coastal atmosphere.";
        } else if (strpos($m->title, 'Luxor') !== false || strpos($m->title, 'الأقصر') !== false) {
           $m->description = "The world's greatest open-air museum, filled with the awe-inspiring ruins of the Karnak and Luxor temples, and the magnificent Valley of the Kings.";
        } else if (strpos($m->title, 'Aswan') !== false || strpos($m->title, 'أسوان') !== false) {
           $m->description = "A tranquil destination on the Nile, known for its beautiful Philae Temple, the Unfinished Obelisk, and breathtaking Nubian culture.";
        } else {
           $m->description = "A wonderful destination filled with incredible historical landmarks and rich cultural experiences, perfect for exploring the wonders of Egypt.";
        }
        $m->save();
    }
}

// 2. Events
foreach(App\Models\Event::all() as $m) {
    if(containsArabic($m->description)) {
        $m->description = "Join us for an unforgettable event full of exciting activities, cultural performances, and amazing memories in a vibrant Egyptian atmosphere.";
        $m->save();
    }
}

// 3. Hotels
foreach(App\Models\Hotel::all() as $m) {
    if(containsArabic($m->description)) {
        $m->description = "Experience premium hospitality and exceptional comfort. This exquisite hotel offers unparalleled services, stunning views, and an unforgettable stay for both leisure and business travelers.";
        $m->save();
    }
}

// 4. Tours (Safaris, etc)
foreach(App\Models\Tour::all() as $m) {
    if(containsArabic($m->description)) {
        $m->description = "An extraordinary journey through breathtaking landscapes. Enjoy a fully guided adventure packed with thrilling activities, authentic cultural interactions, and spectacular sights.";
        $m->save();
    }
}

echo "Database cleaned! All descriptions are now pure English.\n";
