<?php

if ($data['action'] == "getRunningAuctionAmount") {
    echo json_encode([
        "response" => [
            "data" => $engine->auction->runningCount($data['params']),
        ],
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ]);
}elseif($data['action'] == "getRunningAuctionPage"){
    echo json_encode([
        "cache" => [
            [
                "name" => "Collection:Auction:running",
                "data" => $engine->auction->runningPage($data['params']),
            ]
        ],
        "response" => [],
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ]);
}elseif($data['action'] == "getSellerPayout"){
    echo json_encode([
        "response" => $engine->auction->getPrice($data['params']),
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ]);
}