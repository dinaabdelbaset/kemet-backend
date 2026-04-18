<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$psMuseums = DB::table('museums')->where('location', 'Port Said')->orderBy('id', 'desc')->limit(2)->get();

if ($psMuseums->count() >= 2) {
   DB::table('museums')->where('id', $psMuseums[0]->id)->update([
       'name' => 'متحف بورسعيد الحربي',
       'description' => 'متحف يوثق تاريخ مدينة بورسعيد العسكري وتاريخ حرب العدوان الثلاثي عليها في 1956، ويحتوي على قاعات تعرض أسلحة ودبابات ومقتنيات عسكرية تعود لمختلف المعارك.',
       'image' => '/images/home/ps_military_museum.jpg',
       'ticket_price' => 20,
       'opening_hours' => '09:00 - 15:00',
       'highlights' => '["معدات عسكرية", "توثيق تاريخي"]'
   ]);

   DB::table('museums')->where('id', $psMuseums[1]->id)->update([
       'name' => 'متحف النصر للفن الحديث',
       'description' => 'متحف فني رائع في قلب بورسعيد بيضم تشكيلة كبيرة من لوحات الفن التشكيلي، وأعمال فنية لنخبة من أهم فنانين مصر، وبيعتبر وجهة رائعة لعشاق الفن والثقافة.',
       'image' => '/images/home/ps_nasr_museum.jpg',
       'ticket_price' => 10,
       'opening_hours' => '10:00 - 17:00',
       'highlights' => '["فن تشكيلي", "معارض فنون"]'
   ]);
}
echo "Done Museums Port Said Update\n";
