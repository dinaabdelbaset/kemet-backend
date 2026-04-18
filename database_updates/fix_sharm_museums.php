<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$sharmMuseums = DB::table('museums')->where('location', 'LIKE', '%Sharm%')->orderBy('id', 'desc')->limit(2)->get();

if ($sharmMuseums->count() >= 2) {
   DB::table('museums')->where('id', $sharmMuseums[1]->id)->update([
       'name' => 'متحف الملك توت عنخ آمون',
       'description' => 'متحف فريد يقع في جنينة سيتي بشرم الشيخ، يضم نسخ مطابقة للأصل من كنوز ومقتنيات الملك توت عنخ آمون الذهبية التي تم اكتشافها في مقبرته، بتصميم وإضاءات مذهلة.',
       'image' => '/images/home/sharm_king_tut.jpg',
       'ticket_price' => 150,
       'opening_hours' => '16:00 - 23:00'
   ]);
}
echo "Done Sharm Museum Update\n";
