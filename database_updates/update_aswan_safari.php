<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$aswanSafaris = DB::table('safaris')->where('location', 'LIKE', '%Aswan%')->get();

if (count($aswanSafaris) > 0) {
    // Update the first one to Camel Safari
    if (isset($aswanSafaris[0])) {
        DB::table('safaris')->where('id', $aswanSafaris[0]->id)->update([
            'title' => 'Gharb Soheil Camel Safari (سفاري جمال لقرية غرب سهيل)',
            'description' => 'A magical adventure riding camels along the golden sands surrounding the Nile, heading towards the colorful and vibrant Nubian village of Gharb Soheil.',
            'image' => '/images/destinations/aswan/camel.png',
            'price' => 25
        ]);
    }
    
    // Update the second one to Felucca Nile Sailing Safari
    if (isset($aswanSafaris[1])) {
        DB::table('safaris')->where('id', $aswanSafaris[1]->id)->update([
            'title' => 'Felucca Nile Sailing Adventure (مغامرة الفلوكة النيلية)',
            'description' => 'A serene and stunning sunset sailing adventure on a traditional wooden Felucca boat navigating between the magnificent granite rocks of the Aswan Nile.',
            'image' => '/images/destinations/aswan/felucca.png',
            'price' => 20
        ]);
    }
} else {
    // Insert if missing
    DB::table('safaris')->insert([
        [
            'title' => 'Gharb Soheil Camel Safari (سفاري جمال لقرية غرب سهيل)',
            'description' => 'A magical adventure riding camels along the golden sands surrounding the Nile, heading towards the colorful and vibrant Nubian village of Gharb Soheil.',
            'image' => '/images/destinations/aswan/camel.png',
            'location' => 'Aswan',
            'price' => 25,
            'rating' => 4.8,
            'reviews_count' => 520,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'title' => 'Felucca Nile Sailing Adventure (مغامرة الفلوكة النيلية)',
            'description' => 'A serene and stunning sunset sailing adventure on a traditional wooden Felucca boat navigating between the magnificent granite rocks of the Aswan Nile.',
            'image' => '/images/destinations/aswan/felucca.png',
            'location' => 'Aswan',
            'price' => 20,
            'rating' => 4.9,
            'reviews_count' => 1100,
            'created_at' => now(),
            'updated_at' => now()
        ]
    ]);
}

echo "Successfully updated Aswan Safaris into realistic local adventures!\n";
