<?php

header('Access-Control-Allow-Origin: *');
include_once dirname(__FILE__) . '/page.php';
include_once dirname(__FILE__) . '/../engine/session.php';
include_once dirname(__FILE__) . '/../../index/engine/config.php';

$page = new Page();

if ($page->getURI(1) == "game-world-list") {
    if ($page->getURI(3) == "registration") {
        echo json_encode(array(
            "list" => $engine->database->listServer(),
            "success" => true,
        ));
    }
} elseif ($page->getURI(1) == "game-world") {
    if ($page->getURI(2) == "join") {
        $engine->server = (object) $engine->database->getServerInfo($page->getURI(4));
        if ($engine->account->WSignup($engine->server->sid)) {
            $msid = $engine->database->msid($_SESSION['mellon_email']);
            if ($_SERVER['SERVER_ADDR'] == "::1" || $_SERVER['SERVER_ADDR'] == "localhost") {
                $redirect = "http://" . $domain . "/" . $game_dir . $engine->server->folder . "/api/login.php?token=" . md5($msid) . "&msid=" . $msid . "&msname=msid";
            } else {
                $redirect = $engine->server->folder . "/api/login.php?token=" . md5($msid) . "&msid=" . $msid . "&msname=msid";
            }
        } else {
            $redirect = "index.php";
        }
        include_once dirname(__FILE__) . '/template/redirect.php';
    }
} elseif ($page->getURI(1) == "session-validate") {
    echo json_encode(["isValid" => true]);
} else {

    echo "<pre>";
    var_dump($page->getURI());
    echo "</pre>";
}