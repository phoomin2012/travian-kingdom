<?php

if ($data['action'] == "checkCode") {
    echo json_encode(array(
        "respone" => array(
            "data" => array(1)
        ),
        "time" => round(microtime(true) * 1000),
    ));
}
if ($data['action'] == "login") {
    $logined = false;
    if (isset($data['params']['password']) || isset($data['params']['name'])) {
        $logined = $engine->account->Login($data['params']['name'], $data['params']['password']);
    }
    $token = "";
    foreach ($_GET as $key => $value) {
        if ($_GET[$key] == "") {
            $token = $key;
        }
    }
    if ($logined || $token != "") {
        echo json_encode(array(
            "time" => round(microtime(true) * 1000),
            "serialNo" => $engine->session->serialNo(),
            "response" => array(),
            "event" => array(
                array(
                    "name" => "clearCache",
                    "data" => array()
                ),
            ),
            "cache" => array(
                array(
                    "name" => "Merchants:" . $_COOKIE['village'],
                    "data" => $engine->market->getData($_COOKIE['village'])
                ),
                array(
                    "name" => "UnitResearchQueue:" . $_COOKIE['village'],
                    "data" => array(
                        "buildingTypes" => array(),
                        "villageId" => $_COOKIE['village']
                    )
                ),
                array(
                    "name" => "Collection:Notifications:",
                    "data" => array(
                        "operation" => 1,
                        "cache" => array()
                    )
                ),
                array(
                    "name" => "Collection:TroopsMovementInfo:attackVillage:" . $_COOKIE['village'],
                    "data" => array(
                        "operation" => 1,
                        "cache" => array()
                    )
                ),
                array(
                    "name" => "Collection:Quest:",
                    "data" => array(
                        "operation" => 1,
                        "cache" => array(
                            array(
                                "name" => "Quest:623",
                                "data" => array(
                                    "data" => 0,
                                    "finalStep" => 4,
                                    "finishedSteps" => 2,
                                    "id" => 623,
                                    "progress" => 0,
                                    "questGiver" => 0,
                                    "rewards" => array(
                                        2 => array(625, 800, 600, 200)
                                    ),
                                    "status" => 3
                                /*
                                  Ферма 5
                                  Улучши одну из ферм до 5 уровня.
                                 */
                                )
                            )
                        )
                    )
                ),
                array(
                    "name" => "Collection:QuestGiver:",
                    "data" => array(
                        "operation" => 1,
                        "cache" => array(
                            array(
                                "name" => "QuestGiver:11429",
                                "data" => array(
                                    "dialog" => "-1",
                                    "npcId" => "0",
                                    "questId" => "-1",
                                    "questStatus" => "-1"
                                )
                            ),
                            array(
                                "name" => "QuestGiver:11441",
                                "data" => array(
                                    "dialog" => "-2",
                                    "npcId" => "9",
                                    "questId" => "623",
                                    "questStatus" => "2"
                                )
                            )
                        )
                    )
                ),
                array(
                    'name' => 'Collection:Notepad:',
                    'data' => array(
                        'cache' => array(),
                        'operation' => 1,
                    ),
                ),
                array(
                    'name' => 'Collection:MapMarker:',
                    'data' => array(
                        'cache' => array(),
                        'operation' => 1,
                    ),
                ),
                array(
                    "name" => "Alliance:0",
                    "data" => array(
                        'groupId' => '0',
                        'name' => NULL,
                        'members' => array(),
                        'id' => '0',
                        'tag' => NULL,
                        'victoryPointsRank' => false,
                        'forumLink' => '',
                        'points' => NULL,
                        'victoryPoints' => NULL,
                        'description' => array(
                            'allianceId' => '0',
                            'column1' => NULL,
                            'column2' => NULL,
                            'internalInfos1' => NULL,
                            'internalInfos2' => NULL,
                        ),
                        'diplomacy' => array(
                            'treaties' => array(),
                            'ownOffers' => array(),
                            'foreignOffers' => array(),
                        ),
                    ),
                ),
                array(
                    'name' => 'Collection:AllianceMemberlist:',
                    'data' => array(
                        'cache' => array(
                            array()
                        )
                    )
                ),
                array(
                    'name' => 'Collection:Quest:-1',
                    'data' => array(
                        'cache' => array(
                            array(
                                'name' => 'Quest:10001',
                                'data' => array(
                                    'id' => 10001,
                                    'questGiver' => -1,
                                    'status' => 2,
                                    'progress' => 0,
                                    'finishedSteps' => 0,
                                    'finalStep' => 1,
                                    'data' => 0,
                                    'rewards' => array(
                                        4 => 150,
                                    ),
                                ),
                            ),
                            array(
                                'name' => 'Quest:10002',
                                'data' => array(
                                    'id' => 10002,
                                    'questGiver' => -1,
                                    'status' => 2,
                                    'progress' => 0,
                                    'finishedSteps' => 0,
                                    'finalStep' => 1,
                                    'data' => 0,
                                    'rewards' => array(
                                        4 => 100,
                                    ),
                                ),
                            ),
                            array(
                                'name' => 'Quest:10003',
                                'data' => array(
                                    'id' => 10003,
                                    'questGiver' => -1,
                                    'status' => 2,
                                    'progress' => 0,
                                    'finishedSteps' => 0,
                                    'finalStep' => 1,
                                    'data' => 0,
                                    'rewards' => array(
                                        4 => 100,
                                    ),
                                ),
                            ),
                        ),
                        'operation' => 1,
                    ),
                ),
                array(
                    "name" => "Player:" . $_SESSION[$engine->server->prefix . 'uid'],
                    "data" => array(
                        "active" => "1",
                        "allianceId" => "1",
                        "allianceRights" => "0",
                        "allianceTag" => "Unknow",
                        "brewCelebration" => "0",
                        "coronationDuration" => 0,
                        "cropProductionBonusTime" => "0",
                        "deletionTime" => "0",
                        "gold" => $_SESSION[$engine->server->prefix . 'gold'],
                        "hasNoobProtection" => true,
                        "hintStatus" => "0",
                        "isActivated" => "1",
                        "isInstant" => "0",
                        "isKing" => false,
                        "isPunished" => false,
                        "kingdomId" => "1",
                        "kingstatus" => "0",
                        "lastPaymentTime" => "0",
                        "limitationFlags" => "0",
                        "limitedPremiumFeatureFlags" => "0",
                        "name" => "",
                        "playerId" => $_SESSION[$engine->server->prefix . 'uid'],
                        "plusAccountTime" => "0",
                        "population" => "12",
                        "premiumFeatureAutoExtendFlags" => "0",
                        "productionBonusTime" => "0",
                        "signupTime" => "1426219553",
                        "silver" => $_SESSION[$engine->server->prefix . 'silver'],
                        "spawnedOnMap" => "30",
                        "taxRate" => "0",
                        "tribeId" => "0",
                        "uiStatus" => "-1",
                        "villages" => $engine->village->getVillage('all')
                    )
                ),
                array(
                    "name" => "Collection:Notifications:timed",
                    "data" => array(
                        "operation" => 1,
                        "cache" => array(
                            array(
                                "name" => "Notifications:73",
                                "data" => array(
                                    "count" => 1,
                                    "expireTime" => 1426824881,
                                    "itemId" => 0,
                                    "pId" => $_SESSION[$engine->server->prefix . 'uid'],
                                    "time" => "1426292585",
                                    "type" => 73
                                )
                            )
                        )
                    )
                ),
                array(
                    'name' => 'Hero:' . $_SESSION[$engine->server->prefix . 'uid'],
                    'data' => array(
                        'playerId' => $_SESSION[$engine->server->prefix . 'uid'],
                        'villageId' => 0,
                        'destVillageId' => 0,
                        'status' => 0,
                        'health' => 0,
                        'lastHealthTime' => '1455717859',
                        'baseRegenerationRate' => 30,
                        'regenerationRate' => 30,
                        'fightStrengthPoints' => 0,
                        'attBonusPoints' => 0,
                        'defBonusPoints' => 0,
                        'resBonusPoints' => 0,
                        'resBonusType' => 0,
                        'freePoints' => 0,
                        'speed' => 14,
                        'untilTime' => 0,
                        'bonuses' => array(),
                        'maxScrollsPerDay' => 0,
                        'scrollsUsedToday' => 0,
                        'waterbucketUsedToday' => 0,
                        'ointmentsUsedToday' => 0,
                        'adventurePointCardUsedToday' => 0,
                        'resourceChestsUsedToday' => 0,
                        'cropChestsUsedToday' => 0,
                        'artworkUsedToday' => 0,
                        'isMoving' => false,
                        'adventurePoints' => 0,
                        'adventurePointTime' => 0,
                        'levelUp' => 0,
                        'xp' => 0,
                        'xpThisLevel' => 50,
                        'xpNextLevel' => 150,
                        'level' => 1,
                    ),
                ),
                array(
                    'name' => 'HeroFace:' . $_SESSION[$engine->server->prefix . 'uid'],
                    'data' => array(
                        'playerId' => $_SESSION[$engine->server->prefix . 'uid'],
                        'gender' => NULL,
                        'hairColor' => NULL,
                        'face' => NULL,
                    ),
                ),
                array(
                    'name' => 'Collection:Notifications:inGameHelp',
                    'data' => array(
                        'cache' => array(),
                        'operation' => 1,
                    ),
                ),
                array(
                    "name" => "Session:" . session_id(),
                    "data" => array(
                        "sessionId" => session_id(),
                        "type" => 0,
                        "rights" => null
                    )
                )
            )
        ));
    } else {
        echo json_encode(array(
            "time" => round(microtime(true) * 1000),
            "response" => array(),
            "error" => array()
        ));
    }
} elseif ($data['action'] == "setDeviceDimension") {
    echo json_encode(array("time" => round(microtime(true) * 1000), "response" => array()));
} elseif ($data['action'] == "logout") {
    echo json_encode(array(
        "time" => round(microtime(true) * 1000),
        "response" => array(
            'data' => $lobby_url.'api/login.php?token='.$_SESSION['mellon_msid']
        )
    ));
}