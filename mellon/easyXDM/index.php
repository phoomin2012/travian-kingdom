<?php

//include_once dirname(__FILE__) . '/api/page.php';
include_once dirname(__FILE__) . '/../engine/session.php';

$page = new Page();
$a = 0;
if ($page->getURI($a + 1) == "name.html") {
    include_once __DIR__.'/_name.php';
} elseif ($page->getURI($a + 1) == "proxy.html") {
    include_once __DIR__.'/_proxy.php';
} else {
    echo "<pre>";
    var_dump($page->getURI());
    echo "</pre>";
}