<?php
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$updates = [
    App\Models\Bazaar::class => [
        '%Sharm El-Sheikh%' => 'السوق القديم (Old Market)',
        '%Hurghada%' => 'بازار الدهار السياحي',
        '%Marsa Alam%' => 'سوق مرسى علم السياحي',
        '%Fayoum%1%' => 'سوق الفخار بقرية تونس',
        '%Fayoum%2%' => 'سوق الفيوم القومي',
        '%Luxor%' => 'سوق الأقصر السياحي الكبير',
        '%Aswan%' => 'سوق أسوان السياحي',
    ],
    App\Models\Event::class => [
        '%Sharm El-Sheikh%' => 'مهرجان شرم الشيخ الدولي',
        '%Hurghada%' => 'مهرجان الغردقة السنوي',
        '%Luxor%' => 'مهرجان الأقصر للسينما الأفريقية',
        '%Aswan%' => 'مهرجان أسوان الدولي',
        '%Fayoum%' => 'مهرجان الفيوم الفني',
        '%Marsa Alam%' => 'مهرجان مرسى علم للرياضات المائية',
    ],
    App\Models\Museum::class => [
        '%Sharm El-Sheikh%' => 'متحف شرم الشيخ القومي',
        '%Hurghada%' => 'متحف الغردقة',
        '%Luxor%' => 'متحف الأقصر',
        '%Aswan%' => 'متحف النوبة',
        '%Fayoum%' => 'متحف كوم أوشيم',
        '%Marsa Alam%' => 'محمية وادي الجمال',
    ],
    App\Models\Restaurant::class => [
        '%Sharm El-Sheikh%' => 'مطعم فارس للمأكولات البحرية',
        '%Hurghada%' => 'مطعم ستار فيش',
        '%Luxor%' => 'مطعم صوفرا التراثي',
        '%Aswan%' => 'مطعم الدوكة النوبي',
        '%Fayoum%' => 'مطعم بانوراما قرية تونس',
        '%Marsa Alam%' => 'مطعم بورت غالب',
    ]
];

foreach ($updates as $model => $replacements) {
    if ($model == App\Models\Museum::class || $model == App\Models\Restaurant::class) {
        $column = 'name';
    } else {
        $column = 'title';
    }

    foreach ($replacements as $search => $newName) {
        $model::where($column, 'like', $search)->update([$column => $newName]);
    }
}
echo "DB UPDATED SUCCESSFULLY\n";
