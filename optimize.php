<?php
// Script to compress and convert large images to reduce page load time
$dir = __DIR__ . '/../kemet-frontend-main/public/images/home/';
$files = glob($dir . '*.{jpg,png}', GLOB_BRACE);

foreach ($files as $file) {
    if (filesize($file) > 1 * 1024 * 1024) { // larger than 1MB
        echo "Processing: " . basename($file) . "\n";
        $info = getimagesize($file);
        if ($info['mime'] == 'image/jpeg') {
            $image = imagecreatefromjpeg($file);
        } elseif ($info['mime'] == 'image/png') {
            $image = imagecreatefrompng($file);
        } else {
            continue;
        }

        // Calculate new size (scale down by 30%)
        $width = imagesx($image);
        $height = imagesy($image);
        if ($width > 1200) {
            $new_width = 1200;
            $new_height = floor($height * ($new_width / $width));
            
            $tmp = imagecreatetruecolor($new_width, $new_height);
            // Preserve transparency if png but we are converting to jpeg anyway
            imagecopyresampled($tmp, $image, 0,0,0,0, $new_width, $new_height, $width, $height);
            
            // Overwrite as highly compressed JPEG
            imagejpeg($tmp, $file, 75); // 75 quality
            imagedestroy($tmp);
            echo "-> Compressed and resized\n";
        } else {
            imagejpeg($image, $file, 75);
            echo "-> Compressed\n";
        }
        imagedestroy($image);
    }
}
echo "Done optimizing images.\n";
