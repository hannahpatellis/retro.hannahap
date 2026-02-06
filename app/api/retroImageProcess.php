<?php

function retroImageProcess($originalPath, $altImages) {
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

    // Skips SVG files
    $ext = strtolower(pathinfo($originalFile, PATHINFO_EXTENSION));
    if ($ext === 'svg') {
        print("Found SVG");
        foreach ($altImages as $name) {
            print("Found file");
            if ($name === $originalFile) {
                return 'http://retro.hannahap.com/retro-cache/images/' . $filename . '.gif';
            }
        }
        return $originalPath;
    }

    // Convert image
    $image = imagecreatefromstring(file_get_contents($originalFile));
    $width = imagesx($image);
    $height = imagesy($image);

    // Resize if needed (max 400px wide)
    if ($width > 400) {
        $newWidth = 400;
        $newHeight = (int)($height * (400 / $width));
        $resized = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        $image = $resized;
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