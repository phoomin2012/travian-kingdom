<?php

if ($data['action'] == "ping") {
    echo json_encode(array(
        "response" => array("data" => 0),
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
        "cache" => array()
    ));
} elseif ($data['action'] == "selectTribe") {
    query("UPDATE `" . $engine->server->prefix . "user` SET `tribe`=? WHERE `uid`=?;", array($data['params']['tribeId'], $_SESSION[$engine->server->prefix . 'uid']));
    $json = array(
        'cache' => array(
            $engine->account->getAjax($_SESSION[$engine->server->prefix . 'uid']),
        ),
        'time' => round(microtime(true) * 1000),
        'serialNo' => $engine->session->serialNo(),
        'event' => array(
            array(
                'name' => 'clearCache',
                'data' =>
                array(
                ),
            ),
        ),
        'response' => array(),
    );

    echo json_encode($json);
    exit();
} elseif ($data['action'] == "selectVillageDirection") {
    $vid = $engine->world->bestPosition($data['params']['direction']);
    $vid = $vid[0];
    $_COOKIE['village'] = $vid;
    $engine->village->createVillage($_SESSION[$engine->server->prefix . 'uid'], $_SESSION[$engine->server->prefix . 'username'], $vid);

    setcookie("village", $vid, 0, $engine->page->baseURI() . '/');

    echo json_encode(array(
        'cache' => $engine->cache->getAll(),
        'time' => round(microtime(true) * 1000),
        'serialNo' => $engine->session->serialNo(),
        'event' => array(
            array(
                'name' => 'clearCache',
                'data' => []
            ),
        ),
        'response' => array(),
    ));
    exit();
} elseif ($data['action'] == "getAll") {
    echo json_encode(array(
        'cache' => $engine->cache->getAll(),
        'time' => round(microtime(true) * 1000),
        'serialNo' => $engine->session->serialNo(),
        'event' => [
            [
                'name' => 'clearCache',
                'data' => [],
            ],
        /* [
          'name' => 'ShowWelcomeScreen',
          'data' => [],
          ] */
        ],
        'response' => array(),
    ));
    exit();
} elseif ($data['action'] == "getInvitationRefLink") {
    echo json_encode(array(
        "response" => array("refLink" => "http:\/\/kingdoms.travian.com\/com\/#action=register;referral=V2999452"),
        "serialNo" => $engine->session->serialNo(),
    ));
} elseif ($data['action'] == "sendTrackingEvent") {
    echo json_encode(array(
        "response" => array(),
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "getSystemMessage") {
    echo json_encode(array(
        "response" => array(
            "title" => "Test - ทดสอบระบบ",
            "text" => "เซิฟเวอร์นี้กำลังอยู่ในขั้นตอนการทดสอบ ยังไม่สามารถให้บริการได้สมบูรณ์แบบ<br>มีปัญหาติดต่อ <a target='_blank' href='https://fb.com/phoomin2012'>Phumin Devp</a><hr>",
        ),
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "getPlayerInfo") {
    echo json_encode(array(
        "response" => array(
            "language" => "en",
            "populationRank" => $engine->ranking->getUserRank()-1,
        ),
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "getPrestigeConditions") {
    echo json_encode(array(
        "response" => $engine->account->getPrestige(),
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "getOpenChatWindows") {
    echo json_encode(array(
        "response" => [
            ["1.102.101"]
        ],
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "getRobberVillagesAmount") {
    echo json_encode(array(
        "response" => [
            "data" => 0
        ],
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "getActivityStreams") {
    echo json_encode(array(
        "response" => [],
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "deleteNotification") {
    $engine->notification->deleteByType($_SESSION[$engine->server->prefix . 'uid'], $data['params']['type']);
    echo json_encode(array(
        "response" => [],
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "deleteAllNotifications") {
    $engine->notification->delete($_SESSION[$engine->server->prefix . 'uid'], true);
    echo json_encode(array(
        "response" => [],
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "updatePlayerProfileContent") {
    echo json_encode(array(
        "response" => [],
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "getCardgameResult") {
    echo json_encode(array(
        "response" => [
            "result" => null,
        ],
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "changeSettings") {
    $engine->setting->change($data['params']['newSettings']);
    echo json_encode([
        "cache" => [
            $engine->setting->getAll(true)
        ],
        "response" => [],
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ]);
} elseif ($data['action'] == "editProfile") {
    $engine->account->edit('desc', $data['params']['description']);
    echo json_encode([
        "cache" => [
            $engine->account->getProfile()
        ],
        "response" => ["data" => true],
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ]);
}