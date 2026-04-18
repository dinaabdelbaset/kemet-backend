<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$cairoSafaris = DB::table('safaris')->where('location', 'LIKE', '%Cairo%')->get();

if(count($cairoSafaris) >= 2) {
    DB::table('safaris')->where('id', $cairoSafaris[0]->id)->update([
        'title' => 'Cairo Morning Cycling Tour (جولة عجل في الزمالك)',
        'description' => 'A refreshing early morning guided cycling adventure exploring the beautiful tree-lined streets of Zamalek and the scenic Nile corniche.',
        'image' => '/images/destinations/cairo/cycling.png',
        'price' => 12
    ]);

    DB::table('safaris')->where('id', $cairoSafaris[1]->id)->update([
        'title' => 'Nile River Kayaking Adventure (كياك النيل)',
        'description' => 'An exciting water sports adventure where you kayak at sunset over the grand Nile River right in the heart of downtown Cairo.',
        'image' => '/images/destinations/cairo/kayaking.png',
        'price' => 15
    ]);
} else {
    // If not enough Safari items exist, just delete existing ones and insert these two cleanly
    DB::table('safaris')->where('location', 'LIKE', '%Cairo%')->delete();
    
    DB::table('safaris')->insert([
        [
            'title' => 'Cairo Morning Cycling Tour (جولة عجل في الزمالك)',
            'description' => 'A refreshing early morning guided cycling adventure exploring the beautiful tree-lined streets of Zamalek and the scenic Nile corniche.',
            'image' => '/images/destinations/cairo/cycling.png',
            'location' => 'Cairo',
            'price' => 12,
            'rating' => 4.8,
            'reviews_count' => 310,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'title' => 'Nile River Kayaking Adventure (كياك النيل)',
            'description' => 'An exciting water sports adventure where you kayak at sunset over the grand Nile River right in the heart of downtown Cairo.',
            'image' => '/images/destinations/cairo/kayaking.png',
            'location' => 'Cairo',
            'price' => 15,
            'rating' => 4.9,
            'reviews_count' => 480,
            'created_at' => now(),
            'updated_at' => now()
        ]
    ]);
}

echo "Successfully updated Cairo Safaris into urban adventures!\n";
