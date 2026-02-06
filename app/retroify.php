<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/api/retroImageProcess.php';

$cache_images = __DIR__ . '/retro-cache/images/';
$cache_pages = __DIR__ . '/retro-cache/pages/';
$altImages = array("logo.svg", "flickr.svg", "github.svg", "instagram.svg", "linkedin.svg", "mastodon.svg", "paypal.svg", "youtube.svg", "COSMO-mono.svg");

$domain = "https://hannahap.com/";
$page = $_GET['page'] ?? "index";
$page = $page . ".html";
$request_URL = $domain . $page;

print_r($request_URL);

// if (!file_exists($request_URL)) {
//     header("HTTP/1.0 404 Not Found");
//     die("Page not found");
// }

$html = file_get_contents($request_URL);
$dom = Dom\HTMLDocument::createFromString($html);

// Remove <style> tags
foreach (iterator_to_array($dom->getElementsByTagName('style')) as $node) {
    $node->parentNode->removeChild($node);
}
// Remove <link rel=stylesheet> tags
foreach (iterator_to_array($dom->getElementsByTagName('link')) as $node) {
    if ($node->getAttribute('rel') === 'stylesheet') {
        $node->parentNode->removeChild($node);
    }
}
// Remove <script> tags
foreach (iterator_to_array($dom->getElementsByTagName('script')) as $node) {
    $node->remove();
}
// Reformat hrefs in <a> tags if local
foreach (iterator_to_array($dom->getElementsByTagName('a')) as $node) {
    $href = $node->getAttribute('href');
    if (str_starts_with($href, "/")) {
        $new_href = ltrim($href, '/');
        $new_href = preg_replace("/\.html$/", "", $new_href);
        $node->setAttribute("href", "/retroify.php?page=" . $new_href);    
    }
}    
// Remove div#mobi-menu        
$dom->getElementById('mobi-nav')->remove();
// Process <img> tags
foreach ($dom->getElementsByTagName('img') as $img) {
    $src = $img->getAttribute('src');
    $retroSrc = retroImageProcess($src, $altImages);
    $img->setAttribute('src', $retroSrc);
    // Strip modern attributes
    $img->removeAttribute('srcset');
    $img->removeAttribute('loading');
    $img->removeAttribute('width');
    $img->removeAttribute('height');
}

echo $dom->saveHTML();

?>