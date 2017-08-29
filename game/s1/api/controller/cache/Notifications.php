<?php

if ($action[2] == "") {
    $r = array(
        "name" => "Collection:Notifications:",
        "data" => array(
            "operation" => 1,
            "cache" => $engine->notification->getAll(),
        ),
    );
} else {
    if ($action[2] == "timed") {
        $r = array(
            'name' => 'Collection:Notifications:timed',
            'data' => array(
                'cache' => array(
                    /*array(
                        'name' => 'Notifications:73',
                        'data' => array(
                            'pId' => $_SESSION[$engine->server->prefix.'uid'],
                            'type' => 73,
                            'count' => 1,
                            'time' => '1455804000',
                            'itemId' => 0,
                            'expireTime' => time() + 3600,
                        ),
                    ),
                    array(
                        'name' => 'Notifications:74',
                        'data' => array(
                            'pId' => $_SESSION[$engine->server->prefix.'uid'],
                            'type' => 74,
                            'count' => 1,
                            'time' => '1455804000',
                            'itemId' => 0,
                            'expireTime' => time() + 3600,
                        ),
                    ),
                    array(
                        'name' => 'Notifications:75',
                        'data' => array(
                            'pId' => $_SESSION[$engine->server->prefix.'uid'],
                            'type' => 75,
                            'count' => 1,
                            'time' => '1455804000',
                            'itemId' => 0,
                            'expireTime' => time() + 3600,
                        ),
                    ),
                    array(
                        'name' => 'Notifications:76',
                        'data' => array(
                            'pId' => $_SESSION[$engine->server->prefix.'uid'],
                            'type' => 76,
                            'count' => 1,
                            'time' => '1455804000',
                            'itemId' => 0,
                            'expireTime' => time() + 3600,
                        ),
                    ),
                    array(
                        'name' => 'Notifications:78',
                        'data' => array(
                            'pId' => $_SESSION[$engine->server->prefix.'uid'],
                            'type' => 78,
                            'count' => 1,
                            'time' => '1455804000',
                            'itemId' => 0,
                            'expireTime' => time() + 3600,
                        ),
                    ),
                    array(
                        'name' => 'Notifications:79',
                        'data' => array(
                            'pId' => $_SESSION[$engine->server->prefix.'uid'],
                            'type' => 79,
                            'count' => 1,
                            'time' => '1455804000',
                            'itemId' => 0,
                            'expireTime' => time() + 3600,
                        ),
                    ),
                    array(
                        'name' => 'Notifications:80',
                        'data' => array(
                            'pId' => $_SESSION[$engine->server->prefix.'uid'],
                            'type' => 80,
                            'count' => 1,
                            'time' => '1455804000',
                            'itemId' => 0,
                            'expireTime' => time() + 3600,
                        ),
                    ),
                    array(
                        'name' => 'Notifications:81',
                        'data' => array(
                            'pId' => $_SESSION[$engine->server->prefix.'uid'],
                            'type' => 81,
                            'count' => 1,
                            'time' => '1455804000',
                            'itemId' => 0,
                            'expireTime' => time() + 3600,
                        ),
                    ),*/
                    array(
                        'name' => 'Notifications:82',
                        'data' => array(
                            'pId' => $_SESSION[$engine->server->prefix.'uid'],
                            'type' => 82,
                            'count' => 1,
                            'time' => '1455374466',
                            'itemId' => 0,
                            'expireTime' => 0,
                        ),
                    ),
                ),
                'operation' => 1,
            ),
        );
    } else {
        $r = array(
            "name" => "Collection:Notifications:" . $action[2],
            "data" => array(
                "operation" => 1,
                "cache" => array()
            )
        );
    }
}

//["message",{"response":[],"cache":[{"name":"Collection:Notifications:inGameHelp","data":{"cache":[{"name":"Notifications:Kingdom_MapAndDetailView","data":""}],"operation":3}}]
