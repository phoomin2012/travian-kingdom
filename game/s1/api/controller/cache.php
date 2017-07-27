<?php

if ($data['action'] == "get") {
    $return = array();
    for ($i = 0; $i < count($data['params']['names']); $i++) {
        $action = explode(":", $data['params']['names'][$i]);
        switch ($action[0]) {
            case "Collection": {
                    include dirname(__FILE__) . '/cache/' . $action[1] . ".php";
                    if (!isset($r)) {
                        echo "Collection:" . $action[1] . ":" . $action[2] . "\n";
                    } else {
                        array_push($return, $r);
                        unset($r);
                    }
                    break;
                }
            case "Player": {
                    $r = $engine->account->getAjax($action[1]);
                    array_push($return, $r);
                    unset($r);
                    break;
                }
            case "PlayerProfile": {
                    $r = $engine->account->getAjax($action[1]);
                    $r['name'] = "PlayerProfile";
                    array_push($return, $r);
                    unset($r);
                    break;
                }
            case "Session": {
                    $r = array(
                        'name' => 'Session:' . session_id(),
                        'data' => array(
                            'sessionId' => session_id(),
                            'avatarIdentifier' => $_SESSION[$engine->server->prefix . 'avatar'],
                            'userAccountIdentifier' => $_SESSION[$engine->server->prefix . 'uid'],
                            'type' => 0,
                            'rights' => NULL,
                        ),
                    );
                    array_push($return, $r);
                    unset($r);
                    break;
                }
            case "Merchants": {
                    $r = array(
                        'name' => 'Merchants:' . $action[1],
                        'data' => $engine->market->get($action[1]),
                    );
                    array_push($return, $r);
                    unset($r);
                    break;
                }
            case "BuildingQueue": {
                    $r = $engine->building->getQueue($action[1]);
                    array_push($return, $r);
                    unset($r);
                    break;
                }
            case "UnitQueue": {
                    $r = $engine->unit->getTraining($action[1]);
                    array_push($return, $r);
                    unset($r);
                    break;
                }
            case "UnitResearchQueue": {
                    $r = $engine->tech->getResearchQueue($action[1]);
                    array_push($return, $r);
                    unset($r);
                    break;
                }
            case "Kingdom": {
                    $r = $engine->kingdom->get($action[1], true);
                    array_push($return, $r);
                    unset($r);
                    break;
                }
            case "KingdomStats": {
                    $r = $engine->kingdom->getStats($action[1], true);
                    array_push($return, $r);
                    unset($r);
                    break;
                }
            case "KingdomTreasures": {
                    $r = $engine->kingdom->getTreasures($action[1]);
                    array_push($return, $r);
                    unset($r);
                    break;
                }
            case "Hero": {
                    $r = $engine->hero->get($action[1]);
                    array_push($return, $r);
                    unset($r);
                    break;
                }
            case "HeroItem": {
                    $r = $engine->item->get($action[1]);
                    array_push($return, $r);
                    unset($r);
                    break;
                }
            case "HeroFace": {
                    $r = $engine->hero->getFace($action[1]);
                    array_push($return, $r);
                    unset($r);
                    break;
                }
            case "Village": {
                    $r = $engine->village->get($action[1]);
                    array_push($return, $r);
                    unset($r);
                    break;
                }
            case "Research": {
                    $r = $engine->tech->getResearch($action[1]);
                    array_push($return, $r);
                    unset($r);
                    break;
                }
            case "Settings": {
                    $r = array(
                        "name" => "Settings:" . $action[1],
                        "data" => $engine->setting->getAll($action[1])
                    );
                    array_push($return, $r);
                    unset($r);
                    break;
                }
            case "CelebrationQueue": {
                    $r = array(
                        "name" => "CelebrationQueue:" . $action[1],
                        "data" => [
                            "queues" => [
                                24 => [],
                                33 => [],
                            ],
                            "lastFinished" => [
                                24 => time(),
                                33 => time(),
                            ]
                        ],
                    );
                    array_push($return, $r);
                    unset($r);
                    break;
                }
            case "MapDetails": {
                    $r = array(
                        "name" => "MapDetails:" . $action[1],
                        "data" => $engine->world->getMapDetail($action[1])
                    );
                    /* if ($action[1] == "536887296") {
                      $r['data'] = array(
                      "hasNPC" => 0,
                      "hasVillage" => "1",
                      "isHabitable" => 0,
                      "isOasis" => false,
                      "isWonder" => true,
                      "oasisType" => "0",
                      "landscape" => "9103",
                      "resType" => "11115",
                      "kingdomId" => "172",
                      "kingdomTag" => "☠",
                      "playerId" => "178",
                      "playerName" => "GOD",
                      "population" => "341",
                      "tribe" => "3",
                      "wwValues" => array(
                      "bonus" => 1,
                      "level" => 16,
                      "rank" => 1,
                      ),
                      );
                      } */
                    array_push($return, $r);
                    unset($r);
                    break;
                }
            case "PlayerProgressTrigger" : {
                    $r = array(
                        "name" => "PlayerProgressTrigger:" . $action[1],
                        "data" => array(
                            "id" => $action[1],
                            "type" => 1,
                            "playerId" => $_SESSION[$engine->server->prefix . 'uid'],
                            "data" => array(),
                            "subType" => "",
                            "triggered" => false,
                            "lastUse" => "0",
                        )
                    );
                    array_push($return, $r);
                    unset($r);
                    break;
                }
            case "Gameworld": {
                    $r = array(
                        'name' => 'Gameworld:',
                        'data' => array(
                            'status' => 0,
                            'data' => array(),
                            'messageTitle' => 'Maintenance work',
                            'messageText' => "Dear players,\n\nwe're currently updating this game world to a new version. This means the world will be unavailable for about 30-60 minutes. For more information regarding the update please see the game forum. http://forum.kingdoms.travian.com/com/\n\nThank you for your patience!\n\nYour Travian: Kingdoms Team",
                            'startTime' => '1455636868',
                            'worldWonderActivated' => 0,
                            'maintenance' => false,
                        )
                    );
                    array_push($return, $r);
                    unset($r);
                    break;
                }
            case "Voucher": {
                    $r = array(
                        'name' => 'Voucher:' . $action[1],
                        'data' => array(
                            "playerId" => $_SESSION[$engine->server->prefix . 'uid'],
                            "hasVouchers" => array(
                                "NPCTrader" => 0,
                                "cardgameSingle" => 1,
                                "finishNow" => 0,
                                "traderArriveInstantly" => 0,
                            )
                        ),
                    );
                    array_push($return, $r);
                    unset($r);
                    break;
                }
            case "CardgameRolls": {
                    $r = array(
                        'name' => 'CardgameRolls:' . $action[1],
                        'data' => array(
                            'playerId' => $action[1],
                            'hasDailyRoll' => 1,
                            'freeRolls' => 1,
                        )
                    );
                    array_push($return, $r);
                    unset($r);
                    break;
                }
            default: {
                    echo $data['params']['names'][$i];
                    break;
                }
        }
    }
    echo json_encode(
            array(
                "serialNo" => $engine->session->serialNo(),
                "ignoreSerial" => 6,
                "response" => array(),
                "cache" => $return,
                "time" => round(microtime(true) * 1000)
            )
    );
}