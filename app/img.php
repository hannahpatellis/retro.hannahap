<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

function getRetroImage($originalPath) {
    $filename = basename($originalPath);
    $originalFile = "/var/www/hannahap/public" . $originalPath;
    
    // if (!file_exists($originalFile)) return $originalPath;
    
    // // Cache key includes file modification time
    // $mtime = filemtime($originalFile);
    // $cacheFilename = pathinfo($filename, PATHINFO_FILENAME) . '_' . $mtime . '.gif';
    // $cachePath = __DIR__ . '/retro-cache/images/' . $cacheFilename;
    
    // if (file_exists($cachePath)) {
    //     return '/retro-cache/images/' . $cacheFilename;
    // }
    
    print("Before convert");

    // Convert image
    $image = imagecreatefromstring(file_get_contents($originalFile));
    $width = imagesx($image);
    $height = imagesy($image);
    
print("Before resize");

    // Resize if needed (max 640px wide)
    if ($width > 640) {
        $newWidth = 640;
        $newHeight = (int)($height * (640 / $width));
        $resized = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagedestroy($image);
        $image = $resized;
    }
    
print("Before reduce");

    // Reduce to 256 colors
    imagetruecolortopalette($image, true, 256);
    
print("Before save");

    // Save as GIF
    // imagegif($image, $cachePath);
    imagegif($image, "/var/www/fs.hannahap/retro-cache/images" . $filename . '.gif');
    imagedestroy($image);
    
    // return '/var/www/fs.hannahap/retro-cache/images/' . $cacheFilename;

    return '/var/www/fs.hannahap/retro-cache/images/' . $filename . '.gif';
}

$result = getRetroImage("/images/zines/petfurpalace_full.jpeg");

print($result);

?>