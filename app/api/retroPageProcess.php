<?php

function retroPageProcess($dom, $altImages, $site) {
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
    if($site === 'home') {    
        $dom->getElementById('mobi-nav')->remove();
    }
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

    return $dom;
}

?>