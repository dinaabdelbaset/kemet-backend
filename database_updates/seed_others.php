<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// MUSEUMS
DB::table('museums')->truncate();
$museums = [
    ['name' => 'المتحف المصري بالتحرير', 'location' => 'Cairo', 'address' => 'ميدان التحرير', 'description' => 'أقدم متحف أثري في الشرق الأوسط', 'ticket_price' => 300, 'highlights' => json_encode(['قناع توت عنخ آمون'])],
    ['name' => 'المتحف القومي للحضارة', 'location' => 'Cairo', 'address' => 'الفسطاط', 'description' => 'يعرض المومياوات الملكية وحضارة مصر', 'ticket_price' => 350, 'highlights' => json_encode(['قاعة المومياوات الملكية'])],
    ['name' => 'متحف الإسكندرية القومي', 'location' => 'Alexandria', 'address' => 'طريق الحرية', 'description' => 'يعرض تاريخ الإسكندرية بكافة طوابقه', 'ticket_price' => 150, 'highlights' => json_encode(['آثار أندرووتر'])],
    ['name' => 'مكتبة الإسكندرية', 'location' => 'Alexandria', 'address' => 'الشاطبي', 'description' => 'متحف الآثار داخل مكتبة الإسكندرية', 'ticket_price' => 100, 'highlights' => json_encode(['قطع أثرية نادرة'])],
    ['name' => 'متحف الأقصر', 'location' => 'Luxor', 'address' => 'الكورنيش', 'description' => 'أجمل المتاحف عرضاً للقطع الفرعونية', 'ticket_price' => 200, 'highlights' => json_encode(['تمثال تحتمس الثالث'])],
    ['name' => 'متحف التحنيط', 'location' => 'Luxor', 'address' => 'الكورنيش', 'description' => 'يشرح فنون التحنيط عند الفراعنة', 'ticket_price' => 150, 'highlights' => json_encode(['أدوات التحنيط'])],
    ['name' => 'متحف النوبة', 'location' => 'Aswan', 'address' => 'أسوان', 'description' => 'يوثق حضارة وتاريخ أهل النوبة وحياتهم', 'ticket_price' => 200, 'highlights' => json_encode(['تراث النوبة'])],
    ['name' => 'متحف شرم الشيخ', 'location' => 'Sharm El-Sheikh', 'address' => 'شرم الشيخ', 'description' => 'متحف شامل يعرض التاريخ المصري', 'ticket_price' => 250, 'highlights' => json_encode(['قطع نادرة من وادي الملوك'])],
    ['name' => 'متحف الغردقة للآثار', 'location' => 'Hurghada', 'address' => 'الغردقة', 'description' => 'أول متحف للآثار في محافظة البحر الأحمر', 'ticket_price' => 250, 'highlights' => json_encode(['تمثال الملكة ميريت آمون'])],
];
foreach($museums as &$m) {
    $m['image'] = 'https://images.unsplash.com/photo-1549488344-c5a452fc7007?w=400';
    $m['rating'] = 4.8;
    $m['reviews_count'] = 1000;
    $m['opening_hours'] = '09:00 - 17:00';
    $m['created_at'] = now();
    $m['updated_at'] = now();
}
DB::table('museums')->insert($museums);

// SAFARIS
DB::table('safaris')->truncate();
$safaris = [
    ['title' => 'سفاري أهرامات الجيزة بالبيتش باجي', 'location' => 'Cairo', 'description' => 'جولة بالدراجات النارية في صحراء الأهرامات', 'duration' => '2 hours', 'price' => 500, 'difficulty' => 'Easy'],
    ['title' => 'البالون الطائر', 'location' => 'Luxor', 'description' => 'مغامرة التحليق بالبالون فوق معابد البر الغربي', 'duration' => '1.5 hours', 'price' => 1500, 'difficulty' => 'Easy'],
    ['title' => 'سفاري غرب سهيل بالجمل', 'location' => 'Aswan', 'description' => 'جولة عبر رمال أسوان الساحرة على ظهور الجمال', 'duration' => '3 hours', 'price' => 450, 'difficulty' => 'Medium'],
    ['title' => 'سفاري الوادي الملون', 'location' => 'Sharm El-Sheikh', 'description' => 'استكشاف الأودية الملونة بسيارات الدفع الرباعي', 'duration' => '6 hours', 'price' => 800, 'difficulty' => 'Hard'],
    ['title' => 'عشاء بدوي وسفاري موتوسيكلات', 'location' => 'Sharm El-Sheikh', 'description' => 'جولة بيتش باجي وقت الغروب يعقبها عشاء بدوي وحفل سمر', 'duration' => '4 hours', 'price' => 600, 'difficulty' => 'Medium'],
    ['title' => 'سفاري صحراء الغردقة', 'location' => 'Hurghada', 'description' => 'يوم كامل من المغامرة في صحراء الغردقة مع ركوب الجمال', 'duration' => '5 hours', 'price' => 700, 'difficulty' => 'Medium'],
];
foreach($safaris as &$s) {
    $s['image'] = 'https://images.unsplash.com/photo-1551044431-7adbadf603c7?w=400';
    $s['rating'] = 4.7;
    $s['includes'] = json_encode(['Transport', 'Guide', 'Water']);
    $s['created_at'] = now();
    $s['updated_at'] = now();
}
DB::table('safaris')->insert($safaris);

// BAZAARS
DB::table('bazaars')->truncate();
$bazaars = [
    ['title' => 'خان الخليلي', 'location' => 'Cairo', 'description' => 'أشهر أقدم الأسواق التاريخية في الشرق الأوسط', 'specialty' => json_encode(['توابل', 'فضيات', 'تحف'])],
    ['title' => 'سوق الفسطاط', 'location' => 'Cairo', 'description' => 'مركز للحرف اليدوية والفخار التراثي', 'specialty' => json_encode(['فخار', 'مشغولات يدوية'])],
    ['title' => 'زنقة الستات', 'location' => 'Alexandria', 'description' => 'أشهر أسواق الإسكندرية التراثية للملبوسات', 'specialty' => json_encode(['أقمشة', 'إكسسوارات'])],
    ['title' => 'سوق الأقصر السياحي', 'location' => 'Luxor', 'description' => 'يعج بالتوابل والعطور والتماثيل الفرعونية المقلدة', 'specialty' => json_encode(['توابل', 'تماثيل', 'عطور'])],
    ['title' => 'سوق أسوان السياحي', 'location' => 'Aswan', 'description' => 'يتميز بالأعشاب والمنتجات السودانية والصناعات النوبية', 'specialty' => json_encode(['كركديه', 'أعشاب', 'مشغولات نوبية'])],
    ['title' => 'السوق القديم بشرم الشيخ', 'location' => 'Sharm El-Sheikh', 'description' => 'واجهة تسوق ليلية رائعة بجوار مسجد الصحابة', 'specialty' => json_encode(['هدايا تذكارية', 'أعشاب', 'ملابس'])],
    ['title' => 'بازار الدهار السياحي', 'location' => 'Hurghada', 'description' => 'منطقة حيوية للتسوق واقتناء الهدايا البحرية', 'specialty' => json_encode(['صدفيات', 'ملابس تقليدية'])],
];
foreach($bazaars as &$b) {
    $b['image'] = 'https://images.unsplash.com/photo-1574693998822-ba3cf77239fb?w=400';
    $b['created_at'] = now();
    $b['updated_at'] = now();
}
DB::table('bazaars')->insert($bazaars);

// EVENTS
DB::table('events')->truncate();
$events = [
    ['title' => 'حفلة الصوت والضوء بالأهرامات', 'location' => 'Cairo', 'description' => 'أمسية ساحرة تحكي تاريخ الفراعنة', 'venue' => 'أهرامات الجيزة', 'date' => '2026-10-01', 'time' => '19:00', 'price' => 300, 'category' => 'Cultural'],
    ['title' => 'مهرجان القلعة للموسيقى', 'location' => 'Cairo', 'description' => 'حفلات غنائية لأبرز النجوم', 'venue' => 'قلعة صلاح الدين', 'date' => '2026-08-15', 'time' => '20:00', 'price' => 50, 'category' => 'Music'],
    ['title' => 'حفلة الصوت والضوء بالكرنك', 'location' => 'Luxor', 'description' => 'تروي تاريخ معبد الكرنك العظيم', 'venue' => 'معبد الكرنك', 'date' => '2026-11-20', 'time' => '18:30', 'price' => 250, 'category' => 'Cultural'],
];
foreach($events as &$e) {
    $e['image'] = 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=400';
    $e['rating'] = 4.5;
    $e['created_at'] = now();
    $e['updated_at'] = now();
}
DB::table('events')->insert($events);

echo "Successfully seeded Museums, Safaris, Bazaars, and Events.\n";
