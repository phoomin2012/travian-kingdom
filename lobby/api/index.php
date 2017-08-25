<?php

include_once __DIR__ . '/../engine/session.php';

$request_body = file_get_contents('php://input');
$data = json_decode($request_body, true);
header('Content-Type: application/json');

$json = array();

if ($data['controller'] == "cache") {
    if ($data['action'] == "get") {
        $json['serialNo'] = 1092;
        $json['cache'] = [];
        $json['response'] = [];

        for ($i = 0; $i < count($data['params']['names']); $i++) {
            $action = explode(":", $data['params']['names'][$i]);
            switch ($action[0]) {
                case "Collection": {
                        if ($action[1] == "Gold") {
                            array_push($json['cache'], [
                                "name" => join(":", $action),
                                "data" => [
                                    "cache" => [],
                                    "operation" => 1
                                ],
                            ]);
                        }
                    }
                    break;
                case "Session": {
                        array_push($json['cache'], $engine->session->get());
                    }
                    break;
                case "GameWorld": {
                        array_push($json['cache'], $engine->session->get());
                    }
                    break;
                case "Player": {
                        array_push($json['cache'], $engine->account->get());
                    }
                    break;
                case "Feed": {
                        array_push($json['cache'], [
                            "name" => "Feed:" . $action[1] . ":" . $action[2],
                            "data" => [
                                "entries" => [
                                ],
                            ],
                        ]);
                    }
                    break;
            }
        }
    }
} elseif ($data['controller'] == "player") {
    if ($data['action'] == "getPrestigeStars") {
        $json['serialNo'] = 1032;
        $json['response'] = array(
            "level" => 0,
            "stars" => array(
                "bronze" => 0,
                "silver" => 0,
                "gold" => 0
            )
        );
    } elseif ($data['action'] == "getAllPrestigeData") {
        $json['serialNo'] = 1042;
        $json['response'] = array(
            "activeGameWorldsPrestige" => null,
            "currentLevelPrestigePoints" => 0,
            "finishedGameWorldsPrestige" => null,
            "globalPrestige" => 0,
            "level" => 0,
            "nextLevelPrestigePoints" => 25
        );
    } elseif ($data['action'] == "getLastPlayedGameWorld") {
        $json['serialNo'] = 1039;
        $json['response'] = array(
            "id" => 412,
            "name" => "COM3"
        );
    } elseif ($data['action'] == "getOtherRegions") {
        $json['serialNo'] = 1040;
        $json['response'] = array();
    } elseif ($data['action'] == "ping") {
        $json['serialNo'] = 1153;
        $json['response'] = array();
    } elseif ($data['action'] == "getCountries") {
        $json['serialNo'] = 1041;
        $json['response'] = array(
            "asia" => array("tr"),
            "europe" => array("dk", "no", "se", "fi", "fr", "nl", "de", "it", "hu", "en", "gb", "us", "ru", "cz", "pl"),
            "middle_east" => array("ae")
        );
    } elseif ($data['action'] == "getAccountDetails") {
        $json['serialNo'] = 1154;
        $json['response'] = array(
            "accountType" => "Account",
            "duals" => array(),
            "sitters" => array(),
            "email" => $_SESSION['mellon_email'],
            "facebookId" => null,
            "googleId" => null,
            "vkontakteId" => null,
            "id" => 52219,
            "isActivated" => true,
            "isInstant" => false,
            "newEmail" => null,
            "dwhData" => array(
                "customerGroup" => array(
                    "key" => 3,
                    "name" => "Workers"
                )
            ),
            "newsletter" => array(
                array(
                    "newsletterId" => 4,
                    "newsletterName" => "Travian Games",
                    "newsletterTerms" => "",
                    "subscribed" => false,
                )
            )
        );
    } elseif ($data['action'] == "getLastPlayedAvatars") {
        $json['serialNo'] = 1043;
        $json['response'] = array(
            array(
                "avatarIdentifier" => "2456530",
                "gameworldId" => "412",
                "id" => "2456530",
                "lastLogin" => "1455454831"
            ),
        );
        $json['cache'] = array(
            array(
                "name" => "AvatarInformation:2456530",
                "data" => array(
                    "avatarIdentifier" => "2456530",
                    "buildingQueue" => 0,
                    "buildingQueueMaster" => 0,
                    "incomingAttacks" => 0,
                    "lastClick" => "1455455250",
                    "lastLogin" => "1455455250",
                    "population" => "0",
                    "ranking" => 1,
                    "signupTime" => "1455419457",
                    "spawnedOnMap" => "0",
                    "userAccountIdentifier" => "52219",
                    "villages" => 0
                )
            ),
            array(
                "name" => "AvatarInformation:1533802",
                "data" => array(
                    "avatarIdentifier" => "1533802",
                    "buildingQueue" => "0",
                    "buildingQueueMaster" => "0",
                    "incomingAttacks" => "0",
                    "lastClick" => "-",
                    "lastLogin" => "-",
                    "population" => "-",
                    "ranking" => "331",
                    "signupTime" => "-",
                    "spawnedOnMap" => "-",
                    "userAccountIdentifier" => "52219",
                    "villages" => "-"
                )
            ),
        );
    } elseif ($data['action'] == "getAll") {
        $json['serialNo'] = 1033;
        $json['response'] = [];
        $json['event'] = [
            "name" => "clearCache",
            "data" => [],
        ];
        $json['cache'] = [
            $engine->session->get(),
            $engine->account->get(),
            $engine->avatar->getImage(),
            $engine->prestige->get(),
            $engine->achv->get(),
            $engine->noti->get(),
        ];
        $json['cache'] = array_merge($json['cache'], $engine->avatar->getAll());
    }
} elseif ($data['controller'] == "achievements") {
    if ($data['action'] == "update") {
        $json['response'] = [];
    }
} elseif ($data['controller'] == "gameworld") {
    if ($data['action'] == "getPossibleNewGameworlds") {
        $json['response'] = [
            "cluster" => ["en", "gb", "us"],
            "other" => [],
            "recommended" => $engine->database->listServer(true)
        ];
        $json['serialNo'] = 1172;
    }
} elseif ($data['controller'] == "login") {
    if ($data['action'] == "logout") {
        $engine->account->Logout();
        $json['response'] = [];
        echo json_encode($json);
        exit();
    }
}

$json['time'] = time();
echo json_encode($json);
exit();
