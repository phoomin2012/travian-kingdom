<?php

if ($data['action'] == "getAllianceInformation") {
    echo json_encode(array(
        "response" => array("villages" => array()),
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "getProductionDetails") {
    echo json_encode(array(
        "response" => array(
            "production" => $engine->village->getProductDetail($data['params']['villageId'])
        ),
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "updateName") {
    query("UPDATE `" . $engine->server->prefix . "village` SET `vname`=? WHERE `wid`=?;", array($data['params']['villageName'], $data['params']['villageId']));
    $engine->auto->emitEvent([
        "name" => "mapChanged",
        "data" => $data['params']['villageId'],
    ]);
    $engine->auto->emitEvent([
        "name" => "invalidateCache",
        "data" => "MapDetails:{$data['params']['villageId']}",
    ]);
    echo json_encode(array(
        "serialNo" => $engine->session->serialNo(),
        "ignoreSerial" => 1,
        "response" => array(),
        "cache" => array(
            $engine->village->get($data['params']['villageId'])
        ),
        "time" => round(microtime(true) * 1000)
    ));
} elseif ($data['action'] == "checkUnitProduction") {
    $engine->auto->trainComplete($data['params']['villageId']);
    echo json_encode(array(
        "response" => array(),
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "getKingdomVillageAttacks") {
    echo json_encode(array(
        "response" => $engine->kingdom->getVillageAttack(),
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "getVictoryPointsAndInfluenceBonus") {
    echo json_encode(array(
        "response" => [
            'currentTerritoryBonusBoundary' => 100,
            'currentTerritoryBonusFactor' => 1,
            'homeProductionPerDay' => -1,
            'maxTerritoryBonusFactor' => 1.25,
        ],
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "upgradeToTown") {
    $engine->village->up2Town($data['params']['villageId']);
    echo json_encode(array(
        "response" => [],
        "cache" => [
            array(
                'name' => 'Collection:Village:own',
                'data' => array(
                    'cache' => $engine->village->getAll('own'),
                    'operation' => 1,
                ),
            ),
            $engine->village->get($data['params']['villageId']),
            $engine->building->getBuildings($data['params']['villageId'])
        ],
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
}