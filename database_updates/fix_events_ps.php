<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$psEvents = DB::table('events')->where('location', 'Port Said')->orderBy('id', 'desc')->limit(2)->get();

if ($psEvents->count() >= 2) {
   DB::table('events')->where('id', $psEvents[0]->id)->update([
       'title' => 'مهرجان بورسعيد الدولي لمراقبة الطيور',
       'description' => 'أكبر حدث بيئي وسياحي في مصر حيث تتجمع أسراب الطيور المهاجرة في بحيرات بورسعيد، يجذب المصورين ومحبي الطبيعة من كل مكان في تجربة لا تُنسى.',
       'image' => '/images/home/ps_bird_festival.jpg',
       'category' => 'Nature & Wildlife',
       'price' => 50,
       'date' => '2026-11-15'
   ]);

   DB::table('events')->where('id', $psEvents[1]->id)->update([
       'title' => 'كرنفال العيد القومي לבورسعيد',
       'description' => 'احتفالات شعبية وعروض كرنفالية ضخمة تجوب شوارع بورسعيد الساحلية بمناسبة العيد القومي، مع حفلات موسيقية مجانية وتجمعات عائلية رائعة.',
       'image' => '/images/home/ps_carnival.jpg',
       'category' => 'Culture & Music',
       'price' => 0,
       'date' => '2026-12-23'
   ]);
}
echo "Done Events Port Said Update\n";
