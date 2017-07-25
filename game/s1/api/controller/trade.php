<?php

if ($data['action'] == "getOfferList") {
    echo json_encode([
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
        "response" => $engine->market->getOffer($data['params']['villageId'], $data['params']),
    ]);
} elseif ($data['action'] == "createOffer") {
    $engine->market->createOffer($data['params']['villageId'], $data['params']['offeredAmount'], $data['params']['offeredResource'], $data['params']['searchedAmount'], $data['params']['searchedResource'], $data['params']['kingdomOnly']);

    echo json_encode([
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
        "response" => [],
        "cache" => [
            $engine->village->get($data['params']['villageId']),
            [
                "name" => "Merchant:{$data['params']['villageId']}",
                "data" => $engine->market->get($data['params']['villageId']),
            ],
            [
                "name" => "Collection:TradeOffer:own:{$data['params']['villageId']}",
                "data" => [
                    "operation" => 1,
                    "cache" => $engine->market->getOffer($data['params']['villageId'], ['own' => true]),
                ]
            ]
        ],
    ]);
} elseif ($data['action'] == "cancelOffer") {
    $wid = $engine->market->cancelOffer($data['params']['offerId']);

    echo json_encode([
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
        "response" => [],
        "cache" => [
            $engine->village->get($wid),
            [
                "name" => "Merchant:{$wid}",
                "data" => $engine->market->get($wid),
            ],
            [
                "name" => "Collection:TradeOffer:own:{$wid}",
                "data" => [
                    "operation" => 1,
                    "cache" => $engine->market->getOffer($wid, ['own' => true]),
                ]
            ]
        ],
    ]);
} elseif ($data['action'] == "checkTarget") {
    echo json_encode([
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
        "response" => $engine->market->checkTarget($data['params']['sourceVillageId'], $data['params']['destVillageId']),
    ]);
} elseif ($data['action'] == "sendResources") {
    $unit = $engine->market->send($data['params']['sourceVillageId'],$data['params']['destVillageId'],$data['params']['recurrences'],$data['params']['resources']);

    echo json_encode([
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
        "response" => [
            'troopId' => $unit,
        ],
        "cache" => [
            $engine->unit->getUnit($unit),
            $engine->village->get($data['params']['sourceVillageId']),
            [
                "name" => "Merchant:{$data['params']['sourceVillageId']}",
                "data" => $engine->market->get($data['params']['sourceVillageId']),
            ],
        ],
    ]);
}