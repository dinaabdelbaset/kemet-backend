<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$alexEvents = App\Models\Event::where('location', 'like', '%Alex%')->get();
foreach($alexEvents as $e) {
    if (str_contains($e->title, 'الكورنيش')) {
        $e->title = 'Summer Corniche Open Concerts';
        $e->description = 'Wonderful summer evenings on the Mediterranean beach featuring fine dining and live open music for all visitors.';
    } elseif (str_contains($e->title, 'سيد درويش')) {
        $e->title = 'Sayed Darwish Theater Concerts';
        $e->description = 'Classic theatrical and musical performances in the elegant historical theater named after the great musician Sayed Darwish.';
    } elseif (str_contains($e->title, 'الدولي للأغنية')) {
        $e->title = 'Alexandria International Song Festival';
        $e->description = 'An international music festival bringing together Arab and global voices on a stage facing the Mediterranean Sea.';
    } elseif (str_contains($e->title, 'التشكيلية')) {
        $e->title = 'Alexandria Fine Arts Exhibition';
        $e->description = 'Annual exhibition of Alexandrian artists at the Arts Palace in Montaza, featuring paintings, sculptures, and photography.';
    } elseif (str_contains($e->title, 'ماراثون')) {
        $e->title = 'Alexandria International Marathon';
        $e->description = 'An international marathon along the Alexandria Corniche, featuring a 42km route with Mediterranean sea views.';
    } elseif (str_contains($e->title, 'للمسرح')) {
        $e->title = 'Alexandria Theater Festival';
        $e->description = 'Arab and international theatrical performances on famous Alexandria stages, featuring workshops and seminars.';
    }
    
    // Also update images to fallback generic images that exist!
    if (str_contains($e->title, 'Corniche') || str_contains($e->title, 'Song Festival')) {
        $e->image = '/images/events2/nile_jazz.png';
    } elseif (str_contains($e->title, 'Darwish') || str_contains($e->title, 'Theater')) {
        $e->image = '/images/events2/cairo_opera.png';
    } else {
        $e->image = '/images/events2/gouna_film_fest.png';
    }
    
    $e->save();
}
echo 'Updated ' . $alexEvents->count() . ' Alexandria events.';
