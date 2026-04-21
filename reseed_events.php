<?php
use Illuminate\Contracts\Console\Kernel;
use App\Models\Event;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

Event::truncate();

$data = [
    [
        'title' => 'مهرجان القاهرة السينمائي الدولي',
        'description' => 'أحد أعرق المهرجانات السينمائية في العالم العربي، يضم نخبة من صناع السينما العالمية لعرض أحدث الأفلام.',
        'location' => 'Cairo',
        'venue' => 'دار الأوبرا المصرية',
        'date' => '2026-11-15',
        'time' => '7:00 PM',
        'price' => 500,
        'category' => 'Art',
        'image' => '/events/film_celeb_1.png',
        'rating' => 4.9,
    ],
    [
        'title' => 'معرض القاهرة الدولي للكتاب',
        'description' => 'الحدث الثقافي الأكبر في الشرق الأوسط، يضم آلاف الناشرين والمؤلفين من مختلف أنحاء العالم.',
        'location' => 'Cairo',
        'venue' => 'مركز مصر للمعارض الدولية',
        'date' => '2026-01-25',
        'time' => '10:00 AM',
        'price' => 50,
        'category' => 'Cultural',
        'image' => '/events/event_book_fair.png',
        'rating' => 4.8,
    ],
    [
        'title' => 'حفلة الصوت والضوء بالهرم',
        'description' => 'عرض أسطوري يحكي تاريخ الفراعنة العظيم باستخدام أحدث تقنيات الليزر والإضاءة على أهرامات الجيزة في المساء.',
        'location' => 'Giza',
        'venue' => 'أهرامات الجيزة',
        'date' => '2026-05-15',
        'time' => '8:00 PM',
        'price' => 350,
        'category' => 'Show',
        'image' => '/events/event_pyramids_light_show.png',
        'rating' => 4.9,
    ],
    [
        'title' => 'مهرجان الإسكندرية السينمائي لدول البحر المتوسط',
        'description' => 'مهرجان دولي يهدف لنشر الثقافة السينمائية بين دول حوض البحر الأبيض المتوسط برعاية كبار نجوم الفن.',
        'location' => 'Alexandria',
        'venue' => 'مكتبة الإسكندرية',
        'date' => '2026-09-10',
        'time' => '6:00 PM',
        'price' => 400,
        'category' => 'Art',
        'image' => '/events/alex_event_1.png',
        'rating' => 4.7,
    ],
    [
        'title' => 'مهرجان الأقصر للسينما الأفريقية',
        'description' => 'مهرجان يعزز الروابط بين شعوب القارة السمراء من خلال لغة السينما وسحر الحضارة المصرية.',
        'location' => 'Luxor',
        'venue' => 'معبد الأقصر',
        'date' => '2026-02-09',
        'time' => '7:00 PM',
        'price' => 200,
        'category' => 'Art',
        'image' => '/events/luxor_film_1.png',
        'rating' => 4.8,
    ],
    [
        'title' => 'حفلة الصوت والضوء بالكرنك',
        'description' => 'اكتشف أسرار طيبة القديمة مع العرض المذهل داخل معبد الكرنك ليلاً بأصوات درامية وإضاءات مبهرة.',
        'location' => 'Luxor',
        'venue' => 'معبد الكرنك',
        'date' => '2026-03-12',
        'time' => '8:30 PM',
        'price' => 300,
        'category' => 'Show',
        'image' => '/events/karnak_show_1.png',
        'rating' => 4.9,
    ],
    [
        'title' => 'مهرجان تعامد الشمس على وجه رمسيس',
        'description' => 'ظاهرة فلكية وهندسية فريدة تحدث مرتين سنوياً حيث تتعامد أشعة الشمس على قدس الأقداس في المعبد.',
        'location' => 'Aswan',
        'venue' => 'معبد أبو سمبل',
        'date' => '2026-02-22',
        'time' => '5:30 AM',
        'price' => 45,
        'category' => 'Historical',
        'image' => '/events/abu_simbel_festival.png',
        'rating' => 5.0,
    ],
    [
        'title' => 'مهرجان شرم الشيخ الدولي للمسرح الإبداعي',
        'description' => 'منصة عالمية للفرق المسرحية المستقلة وعروض الشارع، يجمع ثقافات مختلفة في مدينة السلام شرم الشيخ.',
        'location' => 'Sharm El-Sheikh',
        'venue' => 'مسرح سوهو سكوير',
        'date' => '2026-11-20',
        'time' => '8:00 PM',
        'price' => 250,
        'category' => 'Art',
        'image' => '/events/concert_stage.png',
        'rating' => 4.6,
    ],
    [
        'title' => 'حفلات سوهو سكوير الموسيقية الصيفية',
        'description' => 'أشهر الفعاليات الموسيقية الراقصة بالبحر الأحمر تتميز بحضور فرق دجى عالمية في أجواء شبابية.',
        'location' => 'Sharm El-Sheikh',
        'venue' => 'ميدان سوهو سكوير',
        'date' => '2026-07-15',
        'time' => '9:00 PM',
        'price' => 400,
        'category' => 'Music',
        'image' => '/events/concert_fireworks.png',
        'rating' => 4.8,
    ],
    [
        'title' => 'مهرجان الجونة السينمائي (GFF)',
        'description' => 'من أهم المهرجانات السينمائية في المنطقة، يستقطب نجوم العالم في منتجع الجونة الساحر لحضور عروض الأفلام الحصرية.',
        'location' => 'Hurghada',
        'venue' => 'منتجع الجونة',
        'date' => '2026-10-24',
        'time' => '6:00 PM',
        'price' => 2000,
        'category' => 'Art',
        'image' => '/events/film_celeb_3.png',
        'rating' => 4.8,
    ],
    [
        'title' => 'مهرجان الفخار والحرف بقرية تونس',
        'description' => 'مهرجان سنوي يحتفي بجمال وأصالة صناعة الفخار والحرف اليدوية في قرية تونس بمحافظة الفيوم.',
        'location' => 'Fayoum',
        'venue' => 'قرية تونس',
        'date' => '2026-11-05',
        'time' => '10:00 AM',
        'price' => 100,
        'category' => 'Cultural',
        'image' => '/bazaars/spices.png',
        'rating' => 4.5,
    ]
];

foreach ($data as $item) {
    Event::create($item);
}

echo "Events deeply re-seeded successfully!";
