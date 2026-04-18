<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$sharmSafaris = DB::table('safaris')->where('location', 'LIKE', '%Sharm%')->orderBy('id', 'desc')->limit(2)->get();

if ($sharmSafaris->count() >= 2) {
   DB::table('safaris')->where('id', $sharmSafaris[0]->id)->update([
       'title' => 'كافيه فرشة (التريند الأكبر في شرم)',
       'description' => 'مكانك المفضل للهدوء بجو بوهيمي لا مثيل له على منحدر جبل بيطل على البحر الأحمر. يعتبر أشهر كافيه ومزار سياحي في شرم الشيخ لإطلالته الساحرة والفوانيس المضيئة بالليل.',
       'image' => '/images/home/sharm_farsha.jpg',
       'price' => 10,
       'duration' => 'مفتوح'
   ]);

   DB::table('safaris')->where('id', $sharmSafaris[1]->id)->update([
       'title' => 'عشاء بدوي وسفاري موتوسيكلات',
       'description' => 'المغامرة الأشهر في صحراء شرم الشيخ! جولة مثيرة بالبيتش باجي وسط الجبال ورمال الصحراء الذهبية وقت الغروب، بتنتهي بقعدة بدوية أصيلة وعشاء تحت النجوم.',
       'image' => '/images/home/sharm_quad_bed.jpg',
       'price' => 450,
       'duration' => '3 ساعات'
   ]);
}
echo "Done Safaris Sharm Update\n";
