<?php

if ($data['action'] == "ping") {
    echo json_encode(array(
        "response" => array("data" => 0),
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
        "cache" => array()
    ));
} elseif ($data['action'] == "chooseTribe") {
    if ($_SESSION[$engine->server->prefix . 'tutorial'] != 1) {
        query("UPDATE `" . $engine->server->prefix . "user` SET `tribe`=? WHERE `uid`=?;", array($data['params']['tribeId'], $_SESSION[$engine->server->prefix . 'uid']));
        query("UPDATE `" . $engine->server->prefix . "user` SET `tutorial`=? WHERE `uid`=?;", array(1, $_SESSION[$engine->server->prefix . 'uid']));
        $_SESSION[$engine->server->prefix . 'tutorial'] = 1;
        $_SESSION[$engine->server->prefix . 'tribe'] = $data['params']['tribeId'];

        $vid = - 10000 - $_SESSION[$engine->server->prefix . 'uid'];
        $engine->village->createVillage($_SESSION[$engine->server->prefix . 'uid'], $_SESSION[$engine->server->prefix . 'username'], $vid);
        $engine->building->setBuilding($vid, 20, 10, 0, true);
        $engine->building->setBuilding($vid, 23, 8, 0, true);
        $engine->building->setBuilding($vid, 27, 15, 3);
        $engine->building->setBuilding($vid, 31, 22, 0, true);
        $engine->building->setBuilding($vid, 32, 16, 1);
        $engine->building->setBuilding($vid, 33, 33, 0);
        $engine->building->setBuilding($vid, 34, 18, 0, true);
        $engine->building->setBuilding($vid, 35, 11, 0, true);
        $engine->building->setBuilding($vid, 39, 17, 0, true);
        $engine->building->setBuilding($vid, 40, 13, 0, true);

        $engine->unit->addUnit($vid, 1, 5,$_SESSION[$engine->server->prefix . 'uid']);
        $engine->unit->addUnit($vid, 2, 12,$_SESSION[$engine->server->prefix . 'uid']);
        $engine->unit->addUnit($vid, 11, 1,$_SESSION[$engine->server->prefix . 'uid']);

        setcookie("village", $vid, 0, '/');
    }
    $action = array(2 => 0);
    echo json_encode(array(
        "response" => array(),
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
        "event" => array(
            array(
                "name" => "clearCache",
                "data" => array()
            )
        ),
        'cache' => array(
            0 => $engine->unit->getTraining($vid),
            1 => $engine->building->getQueue($vid),
            2 => $engine->building->getBuilding($vid),
            3 => $engine->unit->getStay($vid),
            4 => $engine->move->get($vid),
            5 => array(
                'name' => 'Collection:Troops:trapped:' . $vid,
                'data' => array(
                    'cache' => array(),
                    'operation' => 1,
                ),
            ),
            6 => array(
                'name' => 'Collection:Troops:elsewhere:' . $vid,
                'data' => array(
                    'cache' => array(),
                    'operation' => 1,
                ),
            ),
            7 => array(
                'name' => 'Collection:Village:own',
                'data' => array(
                    'cache' => $engine->village->getAll('own'),
                    'operation' => 1,
                ),
            ),
            8 => $engine->hero->get($_SESSION[$engine->server->prefix . 'uid']),
            9 => $engine->hero->getFace($_SESSION[$engine->server->prefix . 'uid'], $_SESSION[$engine->server->prefix . 'avatar']),
            10 => array(
                'name' => 'Collection:PlayerProgressTrigger:',
                'data' => array(
                    'cache' => array(),
                    'operation' => 1,
                ),
            ),
            11 => $engine->account->getAjax($_SESSION[$engine->server->prefix . 'uid']),
            12 => array(
                'name' => 'Setting:' . $_SESSION[$engine->server->prefix . 'uid'],
                'data' => $engine->setting->getAll()
            ),
            13 => $engine->quest->get(),
            14 => $engine->quest->giver(),
        ),
    ));
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
            "populationRank" => $engine->ranking->getUserRank() - 1,
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
        "response" => [],
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