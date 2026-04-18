<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

DB::table('restaurants')->truncate();

$data = [
    // Cairo
    ['name' => 'Abou Tarek (كشري أبو طارق)', 'cuisine' => 'Egyptian (Koshary)', 'location' => 'Cairo', 'description' => 'أشهر مطعم كشري في مصر وعلامة تاريخية شعبية', 'price_range_min' => 30, 'price_range_max' => 100, 'rating' => 4.8, 'reviews_count' => 15000, 'opening_hours' => '09:00 - 02:00'],
    ['name' => 'El Prince (مطعم البرنس)', 'cuisine' => 'Authentic Egyptian', 'location' => 'Cairo', 'description' => 'أشهر أطباق الكبدة والطواجن المصرية الأصلية بالشارع المصري', 'price_range_min' => 150, 'price_range_max' => 600, 'rating' => 4.7, 'reviews_count' => 12000, 'opening_hours' => '12:00 - 04:00'],
    ['name' => 'Felfela (مطعم فلفلة)', 'cuisine' => 'Traditional Egyptian', 'location' => 'Cairo', 'description' => 'يقدم الأكلات المصرية الأصيلة في أجواء تراثية بوسط البلد', 'price_range_min' => 100, 'price_range_max' => 400, 'rating' => 4.5, 'reviews_count' => 8000, 'opening_hours' => '08:00 - 23:00'],

    // Alexandria
    ['name' => 'Kadoura (مطعم قدورة)', 'cuisine' => 'Seafood', 'location' => 'Alexandria', 'description' => 'أشهر وأقدم مطاعم المأكولات البحرية الطازجة على البحر في الإسكندرية', 'price_range_min' => 300, 'price_range_max' => 1500, 'rating' => 4.6, 'reviews_count' => 9000, 'opening_hours' => '11:00 - 02:00'],
    ['name' => 'Village Balbaa (قرية بلبع)', 'cuisine' => 'Grills & Seafood', 'location' => 'Alexandria', 'description' => 'مجمع مطاعم يقدم أفضل المشويات والمأكولات البحرية والأطباق المصرية', 'price_range_min' => 200, 'price_range_max' => 1000, 'rating' => 4.8, 'reviews_count' => 11000, 'opening_hours' => '10:00 - 03:00'],
    ['name' => 'Arous El Bahr (عروس البحر)', 'cuisine' => 'Alexandrian Egyptian', 'location' => 'Alexandria', 'description' => 'مأكولات إسكندرانية أصيلة من كبدة وأسماك بتتبيلة مميزة', 'price_range_min' => 80, 'price_range_max' => 300, 'rating' => 4.3, 'reviews_count' => 4000, 'opening_hours' => '12:00 - 01:00'],

    // Luxor
    ['name' => 'Sofra (مطعم سفرة)', 'cuisine' => 'Egyptian', 'location' => 'Luxor', 'description' => 'مطعم عريق في بيت مصري قديم يقدم وصفات الطبخ البيتي الأصلية', 'price_range_min' => 150, 'price_range_max' => 500, 'rating' => 4.9, 'reviews_count' => 5000, 'opening_hours' => '12:00 - 22:00'],
    ['name' => 'Al-Sahaby Lane (مطعم السحابي)', 'cuisine' => 'Egyptian', 'location' => 'Luxor', 'description' => 'إطلالة رائعة على الأقصر ويشتهر بطاجن الجمل والمأكولات التقليدية', 'price_range_min' => 250, 'price_range_max' => 600, 'rating' => 4.7, 'reviews_count' => 6000, 'opening_hours' => '11:00 - 23:30'],
    ['name' => 'El Kababgy (الكبابجي)', 'cuisine' => 'Oriental Grills', 'location' => 'Luxor', 'description' => 'مشويات مصرية أصيلة على ضفاف النيل مباشرة', 'price_range_min' => 200, 'price_range_max' => 800, 'rating' => 4.6, 'reviews_count' => 3500, 'opening_hours' => '13:00 - 00:00'],

    // Aswan
    ['name' => 'El Dokka (مطعم الدكة)', 'cuisine' => 'Nubian / Egyptian', 'location' => 'Aswan', 'description' => 'يقع على جزيرة ويعرض التراث النوبي الأصيل في الطعام مع إطلالة ساحرة', 'price_range_min' => 150, 'price_range_max' => 500, 'rating' => 4.8, 'reviews_count' => 4200, 'opening_hours' => '12:00 - 23:00'],
    ['name' => 'Makka (مطعم مكة)', 'cuisine' => 'Egyptian', 'location' => 'Aswan', 'description' => 'أشهر المطاعم المحلية في أسوان يقدم طواجن وأسماك نيلية ومشويات', 'price_range_min' => 100, 'price_range_max' => 400, 'rating' => 4.4, 'reviews_count' => 2500, 'opening_hours' => '10:00 - 01:00'],
    ['name' => 'Al Makkawey (أسمك المكاوي)', 'cuisine' => 'Nile Seafood', 'location' => 'Aswan', 'description' => 'أسماك نيلية طازجة وطواجن صعيدية لا مثيل لها', 'price_range_min' => 150, 'price_range_max' => 600, 'rating' => 4.5, 'reviews_count' => 1800, 'opening_hours' => '11:00 - 23:30'],

    // Sharm El-Sheikh
    ['name' => 'Fares Seafood (مطعم فارس)', 'cuisine' => 'Seafood / Egyptian', 'location' => 'Sharm El-Sheikh', 'description' => 'المطعم رقم واحد للمأكولات البحرية الطازجة وشوربة السي فود في شرم', 'price_range_min' => 300, 'price_range_max' => 1500, 'rating' => 4.8, 'reviews_count' => 10000, 'opening_hours' => '13:00 - 02:00'],
    ['name' => 'El Masrien (مطعم المصريين)', 'cuisine' => 'Egyptian Grills', 'location' => 'Sharm El-Sheikh', 'description' => 'يقدم أفضل المشويات والطواجن والمحاشي المصرية الكلاسيكية', 'price_range_min' => 200, 'price_range_max' => 800, 'rating' => 4.6, 'reviews_count' => 7500, 'opening_hours' => '12:00 - 03:00'],
    ['name' => 'Dananeer (مطعم دنانير)', 'cuisine' => 'Oriental / Egyptian', 'location' => 'Sharm El-Sheikh', 'description' => 'طعام مصري وشرقي بمذاق رائع في قلب خليج نعمة', 'price_range_min' => 150, 'price_range_max' => 600, 'rating' => 4.5, 'reviews_count' => 3200, 'opening_hours' => '14:00 - 02:00'],

    // Hurghada
    ['name' => 'Star Fish (ستار فيش)', 'cuisine' => 'Seafood', 'location' => 'Hurghada', 'description' => 'مطعم أسماك عالمي ومحلي من الأفضل والأشهر في مدينة الغردقة', 'price_range_min' => 250, 'price_range_max' => 1200, 'rating' => 4.7, 'reviews_count' => 8800, 'opening_hours' => '12:00 - 01:00'],
    ['name' => 'Gad (مطاعم جاد)', 'cuisine' => 'Traditional Fast Food', 'location' => 'Hurghada', 'description' => 'فول، طعمية، شاورما والمأكولات الشعبية المصرية السريعة الأصيلة', 'price_range_min' => 50, 'price_range_max' => 200, 'rating' => 4.2, 'reviews_count' => 5000, 'opening_hours' => '24 Hours'],
    ['name' => 'Darwish Kababgy (كبابجي درويش)', 'cuisine' => 'Egyptian Grills', 'location' => 'Hurghada', 'description' => 'يتميز بأفضل مشويات وكباب وكفتة مصرية على أصولها', 'price_range_min' => 200, 'price_range_max' => 900, 'rating' => 4.6, 'reviews_count' => 2100, 'opening_hours' => '13:00 - 02:00']
];

foreach ($data as $key => $r) {
    if ($key % 3 === 0) {
        $data[$key]['image'] = 'https://images.unsplash.com/photo-1544148103-0773bf10d330';
    } elseif ($key % 2 === 0) {
        $data[$key]['image'] = 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1';
    } else {
        $data[$key]['image'] = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c';
    }
    $data[$key]['created_at'] = now();
    $data[$key]['updated_at'] = now();
}

DB::table('restaurants')->insert($data);

echo "Successfully seeded 18 restaurants across 6 governorates.\n";
