<?php

if ($data['action'] == "getBuildingList") {
    echo json_encode(array(
        "response" => $engine->building->getBuildable($data['params']['villageId'], $data['params']['locationId']),
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "upgrade") {
    $engine->building->StartBuild($data['params']['locationId'], $data['params']['buildingType'], $data['params']['villageId']);
    echo json_encode(array(
        "cache" => [
            $engine->building->getBuilding(array(
                'wid' => $data['params']['villageId'],
                'location' => $data['params']['locationId'],
            )),
            $engine->building->getBuildings($data['params']['villageId']),
            $engine->village->get($data['params']['villageId']),
            $engine->building->getQueue($data['params']['villageId']),
        ],
        "response" => array(),
        "ignoreSerial" => 2,
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "useMasterBuilder") {
    isset($data['params']['count']) ? $count = $data['params']['count'] : $count = 1;
    for($i=0;$i<$count;$i++){
        $entryId = $engine->building->MasterBuild($data['params']['locationId'], $data['params']['buildingType'], $data['params']['villageId']);
    }
    if (isset($data['params']['reserveResources'])) {
        if ($data['params']['reserveResources'] == true) {
            $engine->building->reserveResources($entryId);
        }
    }
    echo json_encode(array(
        "cache" => array(
            $engine->building->getBuilding(array(
                'wid' => $data['params']['villageId'],
                'location' => $data['params']['locationId'],
            )),
            $engine->building->getBuildings($data['params']['villageId']),
            $engine->village->get($data['params']['villageId']),
            $engine->building->getQueue($data['params']['villageId'])
        ),
        "response" => array(),
        "ignoreSerial" => 2,
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "cancel") {
    $q = $engine->building->getSingleQueue($data['params']['eventId']);
    $engine->building->cancelBuild($data['params']['eventId']);
    echo json_encode(array(
        "cache" => array(
            $engine->building->getBuilding(array(
                'wid' => $q['wid'],
                'location' => $q['location'],
            )),
            $engine->building->getBuildings($data['params']['villageId']),
            $engine->village->get($data['params']['villageId']),
            $engine->building->getQueue($data['params']['villageId'])
        ),
        "response" => array(),
        "ignoreSerial" => 2,
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "destroy") {
    $engine->building->destroy($data['params']);
    echo json_encode(array(
        "cache" => array(
            $engine->building->getQueue($data['params']['villageId'])
        ),
        "response" => array(),
        "ignoreSerial" => 2,
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "reserveResources") {
    $engine->building->reserveResources($data['params']['entryId']);
    echo json_encode(array(
        "cache" => array(
            $engine->building->getQueue($data['params']['villageId']),
            $engine->village->get($data['params']['villageId'])
        ),
        "response" => array(),
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "getCelebrationList") {
    $effect = $engine->building->BuildingEffect(24, $engine->building->getTypeLevel($data['params']['villageId'], 24)) / 100;
    echo json_encode(array(
        "response" => array(
            1 => array(
                "type" => 1,
                "maxCount" => 1,
                "duration" => 86400 * $effect / $engine->server->speed_world,
                "culturePoints" => min(500,$engine->village->get($data['params']['villageId'],false)['culturePointProduction']),
                "costs" => array(
                    1 => 3800,
                    2 => 4000,
                    3 => 3030,
                    4 => 9500
                )
            ),
            2 => array(
                "type" => 2,
                "maxCount" => 1,
                "duration" => 216000 * $effect / $engine->server->speed_world,
                "culturePoints" => min(2000,$engine->village->get($data['params']['villageId'],false)['culturePointProduction']),
                "costs" => array(
                    1 => 16200,
                    2 => 20250,
                    3 => 17500,
                    4 => 47700
                )
            ),
        ),
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
    "locationId";
    "villageId";
} elseif ($data['action'] == "researchUnit") {
    $engine->tech->Research($data['params']['villageId'], $data['params']['unitType']);
    echo json_encode(array(
        "cache" => array(
            $engine->village->get($data['params']['villageId']),
            $engine->tech->getResearch($data['params']['villageId']),
            $engine->tech->getResearchQueue($data['params']['villageId']),
        ),
        "response" => array(),
        "ignoreSerial" => 2,
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "getRecruitList") {
    echo json_encode(array(
        "response" => $engine->unit->getTrainList($data['params']['villageId'], $data['params']['locationId']),
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "recruitUnits") {
    foreach ($data['params']['units'] as $key => $value) {
        $engine->unit->training($data['params']['villageId'], $key, $value);
    }
    echo json_encode(array(
        "cache" => array(
            $engine->village->get($data['params']['villageId']),
            $engine->unit->getTraining($data['params']['villageId']),
        ),
        "response" => array(),
        "ignoreSerial" => 2,
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "getCulturePointBalance") {
    echo json_encode(array(
        "response" => array(
            'currentCP' => round($engine->account->getByVillage($data['params']['villageId'], 'cp')),
            'neededCP' => 1000,
            'productionAllVillages' => $engine->account->getCPproduce($engine->account->getByVillage($data['params']['villageId'], 'uid')),
            'productionHero' => null,
            'productionThisVillage' => $engine->village->getProc($data['params']['villageId'], 5),
        ),
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "getCpData") {
    $cpp = $engine->account->getCPproduce($engine->account->getByVillage($data['params']['villageId'], 'uid'));
    $ncp = round($engine->account->getByVillage($data['params']['villageId'], 'cp'));

    $num_village = count($engine->village->getAll('own'));
    $slots = [];
    for ($s = 1; $s <= 9; $s++) {
        array_push($slots, [
            "slotNumber" => $s + $num_village,
            "culturePoints" => (new CP)->get($s + $num_village),
            "required" => (new CP)->get($s + $num_village) - $ncp,
        ]);
    }
    $nextpossible = 0;
    for ($s = 1; $s < (new CP)->max(); $s++) {
        if ((new CP)->get($s) > $ncp) {
            $nextpossible = (new CP)->get($s);
            break;
        }
    }

    $timeneed = time() + (($nextpossible - $engine->account->getByVillage($data['params']['villageId'], 'cp')) / $cpp) * 86400;

    echo json_encode(array(
        "response" => array(
            "cpProduction" => array(
                "activeVillage" => $cpp,
                "otherVillages" => $cpp - $engine->village->getProc($data['params']['villageId'], 5),
                "hero" => 0,
                "sum" => $cpp,
            ),
            "expansionSlots" => array(
                "numberOfVillages" => $num_village,
                "numberOfTowns" => 0,
                "producedCulturePoints" => $ncp,
                "nextVillagePossible" => $nextpossible,
                "timeNeeded" => $timeneed,
                "slots" => $slots,
            ),
        ),
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "getOasisList") {
    echo json_encode(array(
        "response" => $engine->oasis->getList($data['params']['villageId']),
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "getTreasuryTransformations") {
    echo json_encode(array(
        "response" => $engine->building->getTreasuryTransformations(),
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "transformHiddenTreasury") {
    $engine->village->startTreasuryTransformations($data['params']['villageId']);
    echo json_encode(array(
        "response" => [],
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "transformTreasury") {
    $engine->village->removeTreasuryTransformations($data['params']['villageId'],$data['params']['locationId']);
    echo json_encode(array(
        "response" => [],
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "cancelTransformHiddenTreasury") {
    $engine->village->cancelTreasuryTransformations($data['params']['villageId']);
    echo json_encode(array(
        "response" => [],
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "countForTransformingToTreasuryFreeSlots") {
    echo json_encode(array(
        "response" => [
            'available' => 1,
            'totalSlots' => 3,
            'maxSlotsReached' => false,
        ],
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "shiftMasterBuilder") {
    $engine->building->shiftMasterBuild($data['params']['villageId'], $data['params']['from'], $data['params']['to']);
    echo json_encode(array(
        "cache" => array(
            $engine->building->getQueue($data['params']['villageId'])
        ),
        "response" => array(),
        "ignoreSerial" => 2,
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
}