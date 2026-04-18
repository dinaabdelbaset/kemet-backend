<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$data = [
    // Giza
    ['name' => 'Andrea El Mariouteya (أندريا المريوطية)', 'cuisine' => 'Egyptian Grills', 'location' => 'Giza', 'description' => 'أشهر مطعم يقدم الدجاج المشوي والأطباق المصرية التراثية في الجيزة', 'price_range_min' => 200, 'price_range_max' => 600, 'rating' => 4.7, 'reviews_count' => 8500, 'opening_hours' => '12:00 - 02:00'],
    ['name' => 'Christo Seafood (مطعم خريستو)', 'cuisine' => 'Seafood', 'location' => 'Giza', 'description' => 'يقدم أفضل المأكولات البحرية مع إطلالة ساحرة ومباشرة على أهرامات الجيزة', 'price_range_min' => 300, 'price_range_max' => 1200, 'rating' => 4.5, 'reviews_count' => 6000, 'opening_hours' => '13:00 - 01:00'],
    ['name' => 'Abu Shakra (مطعم أبو شقرة)', 'cuisine' => 'Authentic Egyptian', 'location' => 'Giza', 'description' => 'متخصص في الكباب والكفتة والأطباق المصرية الأصيلة من أمام الأهرامات', 'price_range_min' => 250, 'price_range_max' => 800, 'rating' => 4.6, 'reviews_count' => 10200, 'opening_hours' => '11:00 - 01:00'],

    // Port Said
    ['name' => 'Casten Seafood (مطعم كاستن)', 'cuisine' => 'Seafood', 'location' => 'Port Said', 'description' => 'أشهر وأقدم مطاعم بورسعيد للأسماك والسي فود الطازج بطرق الطهي البورسعيدية', 'price_range_min' => 200, 'price_range_max' => 1000, 'rating' => 4.8, 'reviews_count' => 5400, 'opening_hours' => '12:00 - 23:00'],
    ['name' => 'El Borg (مطعم البرج)', 'cuisine' => 'Port Said Seafood', 'location' => 'Port Said', 'description' => 'من المأكولات البحرية المتميزة جداً في بورسعيد مع تقديم وجبات بطارخ مبطرحة', 'price_range_min' => 250, 'price_range_max' => 1200, 'rating' => 4.9, 'reviews_count' => 7000, 'opening_hours' => '13:00 - 00:00'],
    ['name' => 'El-Dar Darak (مطعم الدار دارك)', 'cuisine' => 'Traditional Egyptian', 'location' => 'Port Said', 'description' => 'وصفات مصرية ومحاشي وطواجن تناسب العائلات بأسعار ممتازة', 'price_range_min' => 100, 'price_range_max' => 400, 'rating' => 4.4, 'reviews_count' => 3000, 'opening_hours' => '10:00 - 01:00'],

    // Marsa Matrouh
    ['name' => 'Hosny Grills & Seafood (مطعم حسني)', 'cuisine' => 'Grills & Seafood', 'location' => 'Marsa Matrouh', 'description' => 'المطعم الأكثر شهرة في مطروح، يوفر أشهى المشويات البدوية والمأكولات البحرية', 'price_range_min' => 150, 'price_range_max' => 700, 'rating' => 4.7, 'reviews_count' => 15000, 'opening_hours' => '11:00 - 04:00'],
    ['name' => 'Magdy Seafood (مطعم مجدي للأسماك)', 'cuisine' => 'Seafood', 'location' => 'Marsa Matrouh', 'description' => 'يقدم أفضل اختيارات الأسماك الطازجة المصطادة يومياً من البحر المتوسط', 'price_range_min' => 200, 'price_range_max' => 900, 'rating' => 4.6, 'reviews_count' => 4800, 'opening_hours' => '12:00 - 02:00'],
    ['name' => 'Kamona (مطعم كمونة)', 'cuisine' => 'Bedouin & Egyptian', 'location' => 'Marsa Matrouh', 'description' => 'أكلات بدوية أصلية ولحم ضأن على الطريقة المطروحية الأصيلة', 'price_range_min' => 150, 'price_range_max' => 600, 'rating' => 4.5, 'reviews_count' => 3200, 'opening_hours' => '14:00 - 03:00'],

    // Fayoum
    ['name' => 'Tunis Village Restaurant (مطعم قرية تونس)', 'cuisine' => 'Traditional Fayoumi', 'location' => 'Fayoum', 'description' => 'يوم ريفي كامل يقدم البط والملوخية والفطير المشلتت الفلاحي وسط المزارع', 'price_range_min' => 150, 'price_range_max' => 500, 'rating' => 4.8, 'reviews_count' => 4000, 'opening_hours' => '09:00 - 20:00'],
    ['name' => 'Wadi El Rayan Cafeteria (كافيتريا وادي الريان)', 'cuisine' => 'Bedouin Food', 'location' => 'Fayoum', 'description' => 'يقدم الفراخ المشوية على الفحم والأكل البدوي على شلالات وادي الريان', 'price_range_min' => 100, 'price_range_max' => 300, 'rating' => 4.3, 'reviews_count' => 2100, 'opening_hours' => '10:00 - 18:00'],
    ['name' => 'El Loloa (مطعم اللؤلؤة)', 'cuisine' => 'Fayoumi & Seafood', 'location' => 'Fayoum', 'description' => 'إطلالة مباشرة على بحيرة قارون مع أسماك البحيرة الشهية والأطباق الريفية', 'price_range_min' => 120, 'price_range_max' => 450, 'rating' => 4.5, 'reviews_count' => 3300, 'opening_hours' => '11:00 - 23:00']
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

echo "Successfully seeded missing 12 restaurants across Giza, Port Said, Marsa Matrouh, and Fayoum.\n";
