<?php

$ignoreLoad = true;
include_once dirname(__FILE__) . '/../engine/engine.php';
if (isset($_GET['a'])) {
    if ($_GET['a'] == "createWorld") {
        $engine->world->generateMap();
        echo "Done!";
    } elseif ($_GET['a'] == "createVillage") {
        $vid = isset($_GET['id']) ? $_GET['id'] : $engine->world->bestPosition();
        $engine->village->createVillage($_SESSION[$engine->server->prefix . 'uid'], $_SESSION[$engine->server->prefix . 'username'], $vid[0]);
        setcookie("village", $vid[0], 0, $engine->page->baseURI() . '/');
        echo "Done!";
    } elseif ($_GET['a'] == "id2xy") {
        var_dump($engine->world->id2xy($_GET['id']));
    } elseif ($_GET['a'] == "xy2id") {
        var_dump($engine->world->xy2id($_GET['x'], $_GET['y']));
    }
}