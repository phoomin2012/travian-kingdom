<?php

if ($action[2] == "stationary") {
    $r = $engine->unit->getStay($action[3]);
} elseif ($action[2] == "moving") {
    $r = $engine->move->get($action[3]);
} elseif ($action[2] == "trapped") {
    $r = array(
        "name" => "Collection:Troops:trapped:" . $action[3],
        "data" => array(
            "operation" => 1,
            "cache" => array(),
        )
    );
} elseif ($action[2] == "elsewhere") {
    $r = array(
        "name" => "Collection:Troops:elsewhere:" . $action[3],
        "data" => array(
            "operation" => 1,
            "cache" => array(),
        )
    );
}