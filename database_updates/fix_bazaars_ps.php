<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$psBazaars = DB::table('bazaars')->where('location', 'Port Said')->orderBy('id', 'desc')->limit(2)->get();

if ($psBazaars->count() >= 2) {
   DB::table('bazaars')->where('id', $psBazaars[0]->id)->update([
       'title' => 'سوق الملابس والبضائع الأجنبية',
       'description' => 'أشهر أسواق بورسعيد للمنطقة الحرة، بيقدم ملابس وبضائع شعبية وماركات عالمية بأسعار مميزة، بيعتبر وجهة أساسية لكل السياح والزوار للتسوق.',
       'image' => '/images/home/port_said_clothes.jpg',
       'specialty' => '["Textiles", "Clothes"]'
   ]);

   DB::table('bazaars')->where('id', $psBazaars[1]->id)->update([
       'title' => 'بازار الهدايا والمنتجات البحرية',
       'description' => 'سوق رائع متخصص في التذكارات، الهدايا، المصنوعات اليدوية البسيطة، والتحف المصنوعة من الأصداف والمنتجات الخاصة بمدينة بورسعيد الساحلية.',
       'image' => '/images/home/port_said_souvenirs.jpg',
       'specialty' => '["Antiques", "Souvenirs", "Marine Crafts"]'
   ]);
}
echo "Done Bazaar Port Said Update\n";
