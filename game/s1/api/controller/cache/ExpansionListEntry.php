<?php

$r = [
    "name" => "Collection:ExpansionListEntry:" . $action[2],
    "data" => [
        "operation" => 1,
        "cache" => $engine->village->getExpansion($action[2]),
    ]
];