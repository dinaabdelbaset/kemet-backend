<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$lxrSafaris = DB::table('safaris')->where('location', 'Luxor')->orderBy('id', 'desc')->limit(2)->get();

if ($lxrSafaris->count() >= 2) {
   DB::table('safaris')->where('id', $lxrSafaris[0]->id)->update([
       'title' => 'رحلة البالون الطائر في الأقصر',
       'description' => 'أشهر مغامرة في الأقصر! تجربة لا تُنسى بالطيران في المنطاد وقت شروق الشمس فوق المعابد الأثرية، ووادي الملوك، ونهر النيل الساحر.',
       'image' => '/images/home/luxor_balloon.jpg',
       'price' => 1200,
       'duration' => '1.5 ساعة',
       'rating' => 4.9
   ]);

   DB::table('safaris')->where('id', $lxrSafaris[1]->id)->update([
       'title' => 'سفاري البر الغربي بالبيتش باجي',
       'description' => 'مغامرة سفاري بين الجبال والمناطق الأثرية بالبر الغربي للأقصر على دراجات الدفع الرباعي (البيتش باجي) وتجربة مشاهدة غروب الشمس وسط الصحراء.',
       'image' => '/images/home/luxor_quad.jpg',
       'price' => 600,
       'duration' => '3 ساعات',
       'rating' => 4.8
   ]);
} else if ($lxrSafaris->count() == 1) {
   DB::table('safaris')->insert([
       'title' => 'سفاري البر الغربي بالبيتش باجي',
       'location' => 'Luxor',
       'description' => 'مغامرة سفاري بين الجبال والمناطق الأثرية بالبر الغربي للأقصر على دراجات الدفع الرباعي.',
       'image' => '/images/home/luxor_quad.jpg',
       'price' => 600,
       'duration' => '3 ساعات',
       'rating' => 4.8
   ]);
   DB::table('safaris')->where('id', $lxrSafaris[0]->id)->update([
       'title' => 'رحلة البالون الطائر في الأقصر',
       'description' => 'أشهر مغامرة في الأقصر! تجربة لا تُنسى بالطيران في المنطاد وقت شروق الشمس...',
       'image' => '/images/home/luxor_balloon.jpg'
   ]);
}
echo "Done Safaris Luxor Update\n";
