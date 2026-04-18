<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$locations = ['Cairo', 'Alexandria', 'Sharm El-Sheikh', 'Luxor', 'Aswan', 'Hurghada', 'Marsa Alam', 'Port Said', 'Marsa Matrouh', 'Fayoum'];

foreach ($locations as $loc) {
    // 1. Museums
    $c = DB::table('museums')->where('location', $loc)->count();
    if ($c < 2) {
        for ($i=$c; $i<2; $i++) {
            DB::table('museums')->insert([
                'name' => 'متحف ' . $loc . ' التراثية ' . ($i+1),
                'location' => $loc, 'address' => 'وسط المدينة ' . $loc,
                'description' => 'مكان رائع يعرض تراث المدينة والتحف الفنية المتميزة للمكان.',
                'image' => '/images/home/museums.jpg',
                'ticket_price' => rand(50, 200), 'opening_hours' => '10:00 - 18:00',
                'rating' => 4.7, 'reviews_count' => rand(500, 2000), 'highlights' => '["جولات مرشدين"]',
                'created_at' => now(), 'updated_at' => now()
            ]);
        }
    }

    // 2. Safaris
    $c = DB::table('safaris')->where('location', $loc)->count();
    if ($c < 2) {
        for ($i=$c; $i<2; $i++) {
            DB::table('safaris')->insert([
                'title' => 'مغامرة سفاري ' . $loc . ' ' . str_repeat('⭐', $i+1),
                'location' => $loc, 'description' => 'أجمل رحلات المغامرة في طبيعة ' . $loc . ' مع عشاء رائع.',
                'image' => '/images/home/safari.jpg',
                'price' => rand(300, 1500), 'duration' => '4 - 6 ساعات',
                'rating' => 4.8,
                'created_at' => now(), 'updated_at' => now()
            ]);
        }
    }

    // 3. Bazaars
    $c = DB::table('bazaars')->where('location', $loc)->count();
    if ($c < 2) {
        for ($i=$c; $i<2; $i++) {
            DB::table('bazaars')->insert([
                'title' => 'أسواق ' . $loc . ' الشعبية ' . ($i+1),
                'location' => $loc, 'description' => 'اكتشف أفضل الهدايا والحِرف اليدوية في روح مدينة ' . $loc,
                'image' => '/images/home/bazaars.jpg',
                'specialty' => '["Textiles"]', // JSON
                'created_at' => now(), 'updated_at' => now()
            ]);
        }
    }

    // 4. Events
    $c = DB::table('events')->where('location', $loc)->count();
    if ($c < 2) {
        for ($i=$c; $i<2; $i++) {
            DB::table('events')->insert([
                'title' => 'مهرجان ' . $loc . ' السنوي ' . ($i+1),
                'location' => $loc, 'description' => 'احتفالية كبرى تجمع الفنون والثقافة في قلب ' . $loc,
                'image' => '/images/home/events.jpg',
                'date' => '2026-05-10', 'time' => '18:00', 'price' => rand(100, 500), 'category' => 'Music',
                'rating' => 4.9,
                'created_at' => now(), 'updated_at' => now()
            ]);
        }
    }

    // 5. Hotels
    $c = DB::table('hotels')->where('location', $loc)->count();
    if ($c < 2) {
        for ($i=$c; $i<2; $i++) {
            DB::table('hotels')->insert([
                'title' => 'فندق ومنتجع ' . $loc . ' الفاخر ' . ($i+1),
                'location' => $loc, 'description' => 'إقامة مريحة جداً تطل على أفضل المعالم السياحية',
                'image' => '/images/home/hotels.jpg',
                'price_starts_from' => rand(1000, 4000), 'rating' => 4.8,
                'reviews_count' => rand(500, 1000),
                'created_at' => now(), 'updated_at' => now()
            ]);
        }
    }
}
echo "Data enriched for all locations.\n";
