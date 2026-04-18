<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$lxrBazaars = DB::table('bazaars')->where('location', 'Luxor')->orderBy('id', 'desc')->limit(2)->get();

if ($lxrBazaars->count() >= 2) {
   DB::table('bazaars')->where('id', $lxrBazaars[0]->id)->update([
       'title' => 'سوق الأقصر السياحي الكبير',
       'description' => 'أشهر أسواق الأقصر الشعبية المفتوحة اللي بيعشقها السياح، مليان بمحلات العطارة الملونة، التوابل، الأقمشة المصرية الأصيلة والتذكارات الفرعونية.',
       'image' => '/images/home/luxor_souq.jpg',
       'specialty' => '["توابل", "عطارة", "ملابس تقليدية"]'
   ]);

   DB::table('bazaars')->where('id', $lxrBazaars[1]->id)->update([
       'title' => 'ورش ومصانع الألباستر',
       'description' => 'أشهر مكان في البر الغربي للأقصر لشراء التحف الفرعونية والأواني المضيئة المصنوعة يدوياً من حجر الألباستر (المرمر) الطبيعي الفاخر.',
       'image' => '/images/home/luxor_alabaster.jpg',
       'specialty' => '["تحف ألباستر", "صناعات يدوية فرعونية"]'
   ]);
}
echo "Done Bazaars Luxor Update\n";
