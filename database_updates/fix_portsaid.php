<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$psSafaris = DB::table('safaris')->where('location', 'Port Said')->orderBy('id', 'desc')->limit(2)->get();

if ($psSafaris->count() >= 2) {
   DB::table('safaris')->where('id', $psSafaris[0]->id)->update([
       'title' => 'مغامرة جبال الملح الثلجية ببورفؤاد',
       'description' => 'تجربة تصوير ومغامرة استثنائية فوق جبال الملح البيضاء الشاهقة التي تشبه جبال الجليد في أوروبا، مع جولات ممتعة بالمنطقة.',
       'image' => '/images/home/port_fouad_salt.jpg',
       'price' => 200,
       'duration' => '2 - 3 ساعات',
       'rating' => 4.9
   ]);

   DB::table('safaris')->where('id', $psSafaris[1]->id)->update([
       'title' => 'جولة قوارب بحيرة المنزلة والطيور',
       'description' => 'رحلة استكشافية بالقوارب الخشبية وسط طبيعة بحيرة المنزلة الساحرة، ومشاهدة أسراب الطيور المهاجرة وقت الغروب.',
       'image' => '/images/home/manzala_lake_boats.jpg',
       'price' => 350,
       'duration' => '3 - 4 ساعات',
       'rating' => 4.7
   ]);
}
echo "Done Port Said Update\n";
