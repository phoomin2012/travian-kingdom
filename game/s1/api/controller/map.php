<?php

if ($data['action'] == "getHeatmapMaximums") {
    echo json_encode([
        "response" => [
            4 => 1154,
            5 => 210360,
            6 => 0,
        ],
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ]);
} elseif ($data['action'] == "getByRegionIds") {
    $regions = $data['params']['regionIdCollection'];

    $c = [1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => []];
    foreach ($regions as $k => $a) {
        $region = [];
        $player = [];
        $kingdom = [];
        if ($k == 1 && count($a) > 0) {
            foreach ($a as $b) {
                //echo "(".$engine->world->id2xy($b)[0].",".$engine->world->id2xy($b)[1].")\n";
                $r = $engine->world->getRegionDetail1($b);
                $player = $player + $r['player'];
                $kingdom = $kingdom + $r['kingdom'];
                $region[$b] = $r['region'];
            }
            $c[$k] = [
                'region' => $region,
                'player' => $player,
                'kingdom' => $kingdom,
                'reports' => [],
            ];
        } elseif ($k == 3 && count($a) > 0) {
            foreach ($a as $b) {
                $r = $engine->world->getRegionDetail3($b);
                $c[$k][$b] = $r['region'];
            }
        }
    }
    echo json_encode([
        'time' => round(microtime(true) * 1000),
        'serialNo' => $engine->session->serialNo(),
        'response' => [
            1 => $c[1],
            2 => $c[2],
            3 => $c[3],
            4 => $c[4],
            5 => $c[5],
            6 => $c[6]
        ],
    ]);
} elseif ($data['action'] == "getKingdomInfluenceStatistics") {
    echo json_encode([
        "response" => $engine->kingdom->getInf(),
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ]);
}