<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::table('safaris')
   ->where('location', 'Luxor')
   ->where('title', 'LIKE', '%البالون الطائر%')
   ->update([
       'title' => 'سفاري مناطق شروق وغروب الشمس',
       'description' => 'تجربة سفاري هادئة ولا تُنسى لاستكشاف أروع نقاط المشاهدة في جبال الأقصر، مصممة خصيصاً للاستمتاع بأجمل اللحظات وقت الشروق والغروب الساحر.',
       'image' => '/images/home/luxor_sunrise_sunset.jpg',
       'price' => 450,
       'duration' => 'ساعتين'
   ]);

echo "Done Safaris Luxor Update Sunrise\n";
