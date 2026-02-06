<?php

$page = $_GET['page'] ?? "index";
if($page === '') {
    $page = "index";
}

header('Location: /retroify.php?page=' . $page);

?>