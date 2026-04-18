<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$data = [
    // Marsa Alam
    ['name' => 'Coraya Restaurant (مطعم كورايا)', 'cuisine' => 'International & Seafood', 'location' => 'Marsa Alam', 'description' => 'إطلالة خلابة على البحر الأحمر ويقدم مأكولات بحرية طازجة وعالمية', 'price_range_min' => 300, 'price_range_max' => 1200, 'rating' => 4.7, 'reviews_count' => 2100, 'opening_hours' => '12:00 - 23:00'],
    ['name' => 'El Quseir Fish Market (مطعم أسماك القصير)', 'cuisine' => 'Seafood', 'location' => 'Marsa Alam', 'description' => 'أفضل أسماك البحر الأحمر يتم صيدها وطهيها يومياً بأسلوب محلي مذهل', 'price_range_min' => 200, 'price_range_max' => 800, 'rating' => 4.8, 'reviews_count' => 1500, 'opening_hours' => '13:00 - 22:00'],
    ['name' => 'Gorgonia Grill (مشويات جورجونيا)', 'cuisine' => 'Grills', 'location' => 'Marsa Alam', 'description' => 'مشويات شرقية وكباب وكفتة لمحبي اللحوم في منتجعات مرسى علم', 'price_range_min' => 250, 'price_range_max' => 700, 'rating' => 4.5, 'reviews_count' => 900, 'opening_hours' => '18:00 - 00:00'],

    // Dahab
    ['name' => 'Ali Baba (مطعم علي بابا)', 'cuisine' => 'Seafood & Egyptian', 'location' => 'Dahab', 'description' => 'أشهر المطاعم على حافة البحر الأبيض المتوسط (الممشى السياحي) في دهب', 'price_range_min' => 150, 'price_range_max' => 600, 'rating' => 4.6, 'reviews_count' => 8500, 'opening_hours' => '10:00 - 01:00'],
    ['name' => 'King Chicken (كينج تشيكن)', 'cuisine' => 'Egyptian Grills', 'location' => 'Dahab', 'description' => 'أسطورة الفراخ المشوية في دهب والأشهر بين الزوار الدائمين', 'price_range_min' => 100, 'price_range_max' => 300, 'rating' => 4.9, 'reviews_count' => 12000, 'opening_hours' => '12:00 - 03:00'],
    ['name' => 'Shark Restaurant (مطعم القرش)', 'cuisine' => 'Seafood', 'location' => 'Dahab', 'description' => 'أطباق بحرية ممتازة بالممشى بأسعار تنافسية وجلسة مريحة جداً', 'price_range_min' => 150, 'price_range_max' => 500, 'rating' => 4.4, 'reviews_count' => 3100, 'opening_hours' => '11:00 - 00:00']
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

echo "Successfully seeded missing 6 restaurants for Marsa Alam and Dahab.\n";
