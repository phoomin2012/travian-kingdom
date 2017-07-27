<?php

$r = [
    "name" => "Collection:TradeOffer:{$action[2]}:{$action[3]}",
    "data" => [
        "operation" => 1,
        "cache" => $engine->market->getOffer($action[3], ['own' => true]),
    ]
];
