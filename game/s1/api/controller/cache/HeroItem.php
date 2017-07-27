<?php

$r = [
    "name" => "Collection:HeroItem:" . $action[2],
    "data" => [
        "operation" => 1,
        "cache" => $engine->item->getAll($action[2]),
    ]
];
