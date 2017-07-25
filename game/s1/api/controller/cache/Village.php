<?php

if ($action[2] == "own") {
    $r = [
        "name" => "Collection:Village:own",
        "data" => [
            "operation" => 1,
            "cache" => $engine->village->getAll("own"),
        ]
    ];
}elseif($action[2] == "kingdom") {
    
    $r = [
        "name" => "Collection:Village:kingdom",
        "data" => [
            "operation" => 1,
            "cache" => $engine->kingdom->getVillage(),
        ]
    ];
}