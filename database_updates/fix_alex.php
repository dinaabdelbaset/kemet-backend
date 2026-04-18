<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::table('safaris')->where('location', 'LIKE', '%Alex%')->delete();

$alexMuseums = DB::table('museums')->where('location', 'LIKE', '%Alex%')->orderBy('id', 'desc')->limit(2)->get();

if ($alexMuseums->count() >= 2) {
   DB::table('museums')->where('id', $alexMuseums[0]->id)->update([
       'name' => 'Catacombs of Kom El Shoqafa (مقابر كوم الشقافة)',
       'description' => 'مقابر أثرية قديمة تحت الأرض في إسكندرية معمولة من العصر الروماني تعتبر من عجائب الدنيا السبع في العصور الوسطى، تصميمها مزيج بين الطابع المصري واليوناني والروماني، فيها سراديب وغرف دفن وتماثيل وتتميز بتجربة النزول بسلالم تحت الأرض.',
       'image' => '/images/home/kom_shoqafa.jpg',
       'ticket_price' => 150,
       'rating' => 4.9,
       'opening_hours' => '09:00 - 17:00'
   ]);

   DB::table('museums')->where('id', $alexMuseums[1]->id)->update([
       'name' => 'Montaza Palace Gardens (حدائق المنتزه)',
       'description' => 'حدائق قصر المنتزه الملكية، المساحات الخضراء الشاسعة والأشجار التاريخية بإطلالة بانورامية ساحرة على البحر الأبيض المتوسط، تجربة مختلفة جداً لقضاء وقت ممتع.',
       'image' => '/images/home/montaza_palace.jpg',
       'ticket_price' => 50,
       'rating' => 4.8,
       'opening_hours' => '08:00 - 00:00'
   ]);
} else {
   DB::table('museums')->insert([
       ['name' => 'Catacombs of Kom El Shoqafa (مقابر كوم الشقافة)', 'location' => 'Alexandria', 'description' => 'مقابر أثرية قديمة', 'image' => '/images/home/kom_shoqafa.jpg', 'ticket_price' => 150, 'rating' => 4.9],
       ['name' => 'Montaza Palace Gardens (حدائق المنتزه)', 'location' => 'Alexandria', 'description' => 'حدائق المنتزه', 'image' => '/images/home/montaza_palace.jpg', 'ticket_price' => 50, 'rating' => 4.8]
   ]);
}
echo "Done";
