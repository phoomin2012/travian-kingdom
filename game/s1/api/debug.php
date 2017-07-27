<?php

$ignoreLoad = true;
include_once dirname(__FILE__) . '/../engine/engine.php';
if (isset($_GET['a'])) {
    if ($_GET['a'] == "createWorld") {
        $engine->world->generateMap();
        echo "Done!";
    } elseif ($_GET['a'] == "createVillage") {
        $vid = $engine->world->bestPosition();
        $engine->village->createVillage($_SESSION[$engine->server->prefix . 'uid'], $_SESSION[$engine->server->prefix . 'username'], $vid[0]);
        setcookie("village", $vid[0], 0, $engine->page->baseURI() . '/');
        echo "Done!";
    } elseif ($_GET['a'] == "id2xy") {
        var_dump($engine->world->id2xy($_GET['id']));
    } elseif ($_GET['a'] == "xy2id") {
        var_dump($engine->world->xy2id($_GET['x'], $_GET['y']));
    } elseif ($_GET['a'] == "builddata") {
        echo json_encode(array(
            1 => BuildingData::get(1),
            2 => BuildingData::get(2),
            3 => BuildingData::get(3),
            4 => BuildingData::get(4),
            5 => BuildingData::get(5),
            6 => BuildingData::get(6),
            7 => BuildingData::get(7),
            8 => BuildingData::get(8),
            9 => BuildingData::get(9),
            10 => BuildingData::get(10),
            11 => BuildingData::get(11),
            13 => BuildingData::get(13),
            14 => BuildingData::get(14),
            15 => BuildingData::get(15),
            16 => BuildingData::get(16),
            17 => BuildingData::get(17),
            18 => BuildingData::get(18),
            19 => BuildingData::get(19),
            20 => BuildingData::get(20),
            21 => BuildingData::get(21),
            22 => BuildingData::get(22),
            23 => BuildingData::get(23),
            24 => BuildingData::get(24),
            25 => BuildingData::get(25),
            26 => BuildingData::get(26),
            27 => BuildingData::get(27),
            28 => BuildingData::get(28),
            29 => BuildingData::get(29),
            30 => BuildingData::get(30),
            31 => BuildingData::get(31),
            32 => BuildingData::get(32),
            33 => BuildingData::get(33),
            34 => BuildingData::get(34),
            35 => BuildingData::get(35),
            36 => BuildingData::get(36),
            37 => BuildingData::get(37),
            38 => BuildingData::get(38),
            39 => BuildingData::get(39),
            40 => BuildingData::get(40),
            41 => BuildingData::get(41),
            42 => BuildingData::get(42),
            44 => BuildingData::get(44),
            45 => BuildingData::get(45),
        ));
    }
}