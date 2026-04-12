<?php
$mapping = [
    2 => 'aswan_spice_1775870590110.png',
    3 => 'luxor_tourist_souq_1775867373048.png',
    4 => 'sharm_old_market_1775867387022.png',
    5 => 'mansheya_market_1775867401478.png',
    6 => 'shali_market_1775867415402.png',
];

foreach ($mapping as $id => $filename) {
    $src = 'C:/Users/Technologist/.gemini/antigravity/brain/fa2e4a4f-a4e0-4703-aebe-2384aaf10f93/' . $filename;
    $dest = 'e:/اخر تحديث/kemet-frontend-main/public/images/downloads/' . $filename;
    if (file_exists($src)) {
        copy($src, $dest);
        $bz = \App\Models\Bazaar::find($id);
        if ($bz) {
            $bz->image = '/images/downloads/' . $filename;
            $bz->save();
            echo "Fixed $id\n";
        }
    } else {
        echo "Missing artifact: $src\n";
    }
}
