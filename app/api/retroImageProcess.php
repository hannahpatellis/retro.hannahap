<?php

function retroImageProcess($originalPath, $altImages) {
    $filename = basename($originalPath);
    $originalFile = $originalPath;
    if (str_starts_with($originalPath, '/')) {
        $originalFile = "/var/www/hannahap/public" . $originalPath;
    }
    
    // if (!file_exists($originalFile)) return $originalPath;
    
    // // Cache key includes file modification time
    // $mtime = filemtime($originalFile);
    // $cacheFilename = pathinfo($filename, PATHINFO_FILENAME) . '_' . $mtime . '.gif';
    // $cachePath = __DIR__ . '/retro-cache/images/' . $cacheFilename;
    
    // if (file_exists($cachePath)) {
    //     return '/retro-cache/images/' . $cacheFilename;
    // }

    // Skips SVG files
    $ext = strtolower(pathinfo($originalFile, PATHINFO_EXTENSION));
    if ($ext === 'svg') {
        foreach ($altImages as $name) {
            if ($name === $filename) {
                return 'http://retro.hannahap.com/retro-cache/images/' . pathinfo($filename, PATHINFO_FILENAME) . '.gif';
            }
        }
        return null;
    }

    // Convert image
    $image = imagecreatefromstring(file_get_contents($originalFile));
    $width = imagesx($image);
    $height = imagesy($image);

    /* // Resize if needed (max 300px wide)
    if ($width > 300) {
        $newWidth = 300;
        $newHeight = (int)($height * (300 / $width));
        $resized = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        $image = $resized;
    } */

    
    if ($width > 300) {
        $newWidth = 300;
        $newHeight = (int)($height * (300 / $width));
        $resized = imagecreatetruecolor($newWidth, $newHeight);
    
        // Fill with white
        $white = imagecolorallocate($resized, 255, 255, 255);
        imagefill($resized, 0, 0, $white);
    
        // Copy with the white background
        imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        $image = $resized;
    } else {
        // Even if not resizing, handle transparency
        $temp = imagecreatetruecolor($width, $height);
        $white = imagecolorallocate($temp, 255, 255, 255);
        imagefill($temp, 0, 0, $white);
        imagecopy($temp, $image, 0, 0, 0, 0, $width, $height);
        $image = $temp;
    }
    
    // Reduce to 256 colors
    imagetruecolortopalette($image, true, 256);

    // Save as GIF
    // imagegif($image, $cachePath); <- for caching
    imagegif($image, "/var/www/retro.hannahap/app/retro-cache/images/" . $filename . ".gif");
    
    // return '/var/www/fs.hannahap/retro-cache/images/' . $cacheFilename; <- for caching
    return 'http://retro.hannahap.com/retro-cache/images/' . $filename . '.gif';
}

?>