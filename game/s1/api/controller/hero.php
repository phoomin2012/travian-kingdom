<?php

if ($data['action'] == "getValuePoints") {
    echo json_encode([
        "response" => [
            "attBonus" => 0.2,
            "defBonus" => 0.2,
            "fightStrength" => 800,
            "fightStrengthBaseLevel" => 4,
            "maxPerSkill" => 100,
            "resBonusAll" => 5,
            "resBonusBaseAll" => 20,
            "resBonusBaseSingle" => 60,
            "resBonusSingle" => 20,
        ],
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ]);
} elseif ($data['action'] == "addAttributePoints") {
    $engine->hero->addAttr($data['params']);
    echo json_encode([
        "cache" => [
            $engine->hero->get($_SESSION[$engine->server->prefix . 'uid']),
        ],
        "response" => [
            "attBonus" => 0.2,
            "defBonus" => 0.2,
            "fightStrength" => 800,
            "fightStrengthBaseLevel" => 4,
            "maxPerSkill" => 100,
            "resBonusAll" => 5,
            "resBonusBaseAll" => 20,
            "resBonusBaseSingle" => 60,
            "resBonusSingle" => 20,
        ],
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ]);
} elseif ($data['action'] == "confirmHeroLevelUp") {
    query("UPDATE `{$engine->server->prefix}hero` SET `levelUp`=? WHERE `owner`=?", [0, $_SESSION[$engine->server->prefix . 'uid']]);
    echo json_encode([
        "cache" => [
            $engine->hero->get($_SESSION[$engine->server->prefix . 'uid']),
        ],
        "response" => [],
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ]);
} elseif ($data['action'] == "saveFace") {

    $engine->hero->saveFace($_SESSION[$engine->server->prefix . 'avatar'], $data['params']);
    echo json_encode(array(
        "cache" => array(
            $engine->hero->getFace($_SESSION[$engine->server->prefix . 'uid'], $_SESSION[$engine->server->prefix . 'avatar'])
        ),
        "response" => array(),
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "getLastInventoryView") {
    echo json_encode([
        "response" => ["data" => time()],
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ]);
} elseif ($data['action'] == "revive") {
    $cache = $engine->hero->revive($_SESSION[$engine->server->prefix.'uid'],$data['params']['villageId']);
    echo json_encode([
        "cache" => $cache['cache'],
        "response" => [],
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ]);
} elseif ($data['action'] == "switchItems") {
    $engine->item->swap($data['params']);
    echo json_encode([
        "cache" => [
            [
                "name" => "Collection:HeroItem:own",
                "data" => [
                    "operation" => 1,
                    "cache" => $engine->item->getAll('own'),
                ]
            ],
        ],
        "ignoreSerial" => 1,
        "response" => [],
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ]);
} elseif ($data['action'] == "useItem") {
    $r = $engine->item->useItem($data['params']);
    echo json_encode([
        "cache" => $r['cache'],
        "ignoreSerial" => 1,
        "response" => $r['response'],
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ]);
} elseif ($data['action'] == "getTreasureSellPrice") {
    echo json_encode([
        "response" => [
            1 => 100,
            2 => 100,
            3 => 100,
            4 => 0,
        ],
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ]);
} elseif ($data['action'] == "getDurationToClosestVillageWithInfluence") {
    echo json_encode([
        "response" => [
            "data" => 19,
            "playerId" => 0,
        ],
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ]);
}