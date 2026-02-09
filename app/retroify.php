<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/api/retroImageProcess.php';
require_once __DIR__ . '/api/retroPageProcess.php';

$cache_images = __DIR__ . '/retro-cache/images/';
$cache_pages = __DIR__ . '/retro-cache/pages/';
$altImages = array("logo.svg", "flickr.svg", "github.svg", "instagram.svg", "linkedin.svg", "mastodon.svg", "paypal.svg", "youtube.svg", "COSMO-mono.svg");
$site;

if(!isset($_GET['site']) || $_GET['site'] === 'home') {
    $domain = "https://hannahap.com/";
    $site = 'home';
    $page = $_GET['page'] ?? "index";
    $page = $page . ".html";
    $request_URL = $domain . $page;
} elseif($_GET['site'] === 'blog') {
    $domain = "https://blog.hannahap.com/";
    $site = 'blog';
    $page = $_GET['page'] ?? "/";
    $request_URL = $domain . $page;
} else {
    $domain = "https://hannahap.com/";
    $site = 'home';
    $page = $_GET['page'] ?? "index";
    $page = $page . ".html";
    $request_URL = $domain . $page;
}

// Doesn't work
// if (!file_exists($request_URL)) {
//     header("HTTP/1.0 404 Not Found");
//     die("Page not found");
// }

$html = file_get_contents($request_URL);
$dom = Dom\HTMLDocument::createFromString($html);

$dom = retroPageProcess($dom, $altImages, $site);

echo $dom->saveHTML();

?>