<?php

print_r($_GET['page']);

$page = $_GET['page'] ?? "index";
if($page === '') {
    $page = "index";
}

print_r($page);

// header('Location: /retroify.php?page=' . $page);

?>