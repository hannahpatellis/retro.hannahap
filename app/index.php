<?php

$page = $_GET['page'] ?? "index";
if($page === '') {
    $page = "index";
}
$site = $_GET['site'] ?? "home";
if($site === '') {
    $site = "home";
}

header('Location: /retroify.php?page=' . $page . '&site=' . $site);

?>