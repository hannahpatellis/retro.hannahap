<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

$cache_images = __DIR__ . '/../../fs.hannahap/retro-cache/images/';
$cache_pages = __DIR__ . '/../../fs.hannahap/retro-cache/pages/';

$domain = "https://hannahap.com/";
$page = $_GET['p'] ?? "index";
$page = $page . ".html";
$request_URL = $domain . $page;

/* if (!file_exists($request_URL)) {
    header("HTTP/1.0 404 Not Found");
    die("Page not found");
} */

$html = file_get_contents($request_URL);
$dom = Dom\HTMLDocument::createFromString($html);

foreach ($dom->getElementsByTagName('style') as $node) {
    $node->parentNode->removeChild($node);
}
foreach ($dom->getElementsByTagName('link') as $node) {
    if ($node->getAttribute('rel') === 'stylesheet') {
        $node->parentNode->removeChild($node);
    }
}
foreach ($dom->getElementsByTagName('script') as $node) {
    $node->parentNode->removeChild($node);
}

echo $dom->saveHTML();

?>