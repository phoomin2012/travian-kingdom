<?php

if ($data['action'] == "bookFeature") {
    if ($data['params']['featureName'] == "buildingMasterSlot") {
        if ($engine->session->data->master == 0) {
            $engine->account->edit("gold", $engine->session->data->gold - 50);
        } elseif ($engine->session->data->master == 1) {
            $engine->account->edit("gold", $engine->session->data->gold - 75);
        } elseif ($engine->session->data->master >= 2) {
            $engine->account->edit("gold", $engine->session->data->gold - 100);
        }
        $engine->account->edit("master", $engine->session->data->master + 1);

        echo json_encode([
            "cache" => [
                $engine->building->getQueue($_COOKIE['village']),
                $engine->account->getAjax($_SESSION[$engine->server->prefix . 'uid']),
            ],
            "response" => [],
            "serialNo" => $engine->session->serialNo(),
            "time" => round(microtime(true) * 1000),
        ]);
    } elseif ($data['params']['featureName'] == "finishNow") {
        if (isset($data['params']['params']['buildingType'])) {
            if ($data['params']['params']['buildingType'] == 13 || $data['params']['params']['buildingType'] == 22) {
                query("UPDATE `" . $engine->server->prefix . "tqueue` SET `end`=? WHERE `wid`=? AND `building`=?;", [time(), $data['params']['params']['villageId'], $data['params']['params']['buildingType']]);
                $engine->account->edit("gold", $engine->session->data->gold - $data['params']['params']['price']);
                echo json_encode([
                    "cache" => [
                        $engine->tech->getResearchQueue($data['params']['params']['villageId']),
                        $engine->account->getAjax($_SESSION[$engine->server->prefix . 'uid']),
                    ],
                    "response" => [],
                    "serialNo" => $engine->session->serialNo(),
                    "time" => round(microtime(true) * 1000),
                ]);
            }
        } else {
            if ($data['params']['params']['queueType'] == 1) {
                query("UPDATE `" . $engine->server->prefix . "building` SET `timestamp`=?,`duration`=? WHERE `wid`=? AND `queue`=?;", array(time(), 0, $data['params']['params']['villageId'], 1));
            } elseif ($data['params']['params']['queueType'] == 2) {
                query("UPDATE `" . $engine->server->prefix . "building` SET `timestamp`=?,`duration`=? WHERE `wid`=? AND `queue`=?;", array(time(), 0, $data['params']['params']['villageId'], 2));
            } elseif ($data['params']['params']['queueType'] == 5) {
                query("UPDATE `" . $engine->server->prefix . "building` SET `timestamp`=?,`duration`=? WHERE `wid`=? AND `queue`=?;", array(time(), 0, $data['params']['params']['villageId'], 5));
            }
            $engine->account->edit("gold", $engine->session->data->gold - $data['params']['params']['price']);
            echo json_encode([
                "cache" => [
                    $engine->building->getQueue($data['params']['params']['villageId']),
                    $engine->account->getAjax($_SESSION[$engine->server->prefix . 'uid']),
                ],
                "response" => [],
                "serialNo" => $engine->session->serialNo(),
                "time" => round(microtime(true) * 1000),
            ]);
        }
    } elseif ($data['params']['featureName'] == "exchangeOffice") {
        if ($data['params']['params']['type'] == "gold") {
            $take_gold = $data['params']['params']['amount'];
            $add_silver = $data['params']['params']['amount'] * 100;

            $engine->account->edit("gold", $engine->session->data->gold - $take_gold);
            $engine->account->edit("silver", $engine->session->data->silver + $add_silver);
        } elseif ($data['params']['params']['type'] == "silver") {
            $add_gold = $data['params']['params']['amount'] / 200;
            $take_silver = $data['params']['params']['amount'];

            $engine->account->edit("gold", $engine->session->data->gold + $add_gold);
            $engine->account->edit("silver", $engine->session->data->silver - $take_silver);
        }
        echo json_encode([
            "cache" => [
                $engine->account->getAjax($_SESSION[$engine->server->prefix . 'uid']),
            ],
            "response" => [],
            "serialNo" => $engine->session->serialNo(),
            "time" => round(microtime(true) * 1000),
        ]);
    } elseif ($data['params']['featureName'] == "plusAccount") {
        $engine->account->buyPremium(0, $data['params']['params']['price'], $data['params']['params']['bookGameRound']);
        echo json_encode([
            "cache" => [
                $engine->account->getAjax($_SESSION[$engine->server->prefix . 'uid']),
                [
                    'name' => 'Collection:Village:own',
                    'data' => [
                        'cache' => $engine->village->getAll('own'),
                        'operation' => 1,
                    ],
                ],
            ],
            "response" => [],
            "serialNo" => $engine->session->serialNo(),
            "time" => round(microtime(true) * 1000),
        ]);
    } elseif ($data['params']['featureName'] == "productionBonus") {
        $engine->account->buyPremium(1, $data['params']['params']['price'], $data['params']['params']['bookGameRound']);
        echo json_encode([
            "cache" => [
                $engine->account->getAjax($_SESSION[$engine->server->prefix . 'uid']),
                [
                    'name' => 'Collection:Village:own',
                    'data' => [
                        'cache' => $engine->village->getAll('own'),
                        'operation' => 1,
                    ],
                ],
            ],
            "response" => [],
            "serialNo" => $engine->session->serialNo(),
            "time" => round(microtime(true) * 1000),
        ]);
    } elseif ($data['params']['featureName'] == "cropProductionBonus") {
        $engine->account->buyPremium(2, $data['params']['params']['price'], $data['params']['params']['bookGameRound']);
        echo json_encode([
            "cache" => [
                $engine->account->getAjax($_SESSION[$engine->server->prefix . 'uid']),
                [
                    'name' => 'Collection:Village:own',
                    'data' => [
                        'cache' => $engine->village->getAll('own'),
                        'operation' => 1,
                    ],
                ],
            ],
            "response" => [],
            "serialNo" => $engine->session->serialNo(),
            "time" => round(microtime(true) * 1000),
        ]);
    } elseif ($data['params']['featureName'] == "cardgameSingle") {
        echo json_encode([
            "response" => [
                "type" => "CardgameSingle",
                "result" => $engine->account->gameCard($data['params']),
            ],
            "serialNo" => $engine->session->serialNo(),
            "time" => round(microtime(true) * 1000),
        ]);
    } elseif ($data['params']['featureName'] == "cardgame4of5") {
        echo json_encode([
            "response" => [
                "type" => "Cardgame4of5",
                "result" => $engine->account->gameCard($data['params']),
            ],
            "serialNo" => $engine->session->serialNo(),
            "time" => round(microtime(true) * 1000),
        ]);
    } else {
        echo json_encode([
            "cache" => [],
            "response" => [],
            "serialNo" => $engine->session->serialNo(),
            "time" => round(microtime(true) * 1000),
        ]);
    }
} elseif ($data['action'] == "saveAutoExtendFlags") {
    query("UPDATE `" . $engine->server->prefix . "user` SET `autoExtend`=? WHERE `uid`=?;", [$data['params']['autoExtendFlags'], $engine->session->data->uid]);
    echo json_encode([
        "response" => [
            "data" => true,
        ],
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ]);
}