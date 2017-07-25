<?php

class Battle {

    public function calculateBattle($type = 3, $attacker, $defender) {
        global $engine;

        //attackType == 3 >>>> สู้จนกว่าทหารจะตาย
        //attackType == 4 >>>> สู้จนผลรวมความเสียหายทั้งสู้ฝั่งอยู่ที่ 103.2%
        //attackType == 5 >>>> เพิ่มพลังโจมตี 30% & เหมือนโจมตีธรรมดา

        $atk = [
            "wid" => $attacker['wid'],
            "tribeId" => $attacker['tribe'],
            "playerId" => (isset($attacker['player'])) ? (isset($attacker['player']['id'])) ? $attacker['player']['id'] : 0 : 0,
            "playerName" => (isset($attacker['player'])) ? (isset($attacker['player']['name'])) ? $attacker['player']['name'] : 'attacker' : 'attacker',
            "villageId" => (isset($attacker['village'])) ? (isset($attacker['village']['id'])) ? $attacker['village']['id'] : 0 : 0,
            "villageName" => (isset($attacker['village'])) ? (isset($attacker['village']['name'])) ? $attacker['village']['name'] : '' : '',
            "originalTroops" => [
                "1" => isset($attacker['unit'][1]) ? $attacker['unit'][1] : 0,
                "2" => isset($attacker['unit'][2]) ? $attacker['unit'][2] : 0,
                "3" => isset($attacker['unit'][3]) ? $attacker['unit'][3] : 0,
                "4" => isset($attacker['unit'][4]) ? $attacker['unit'][4] : 0,
                "5" => isset($attacker['unit'][5]) ? $attacker['unit'][5] : 0,
                "6" => isset($attacker['unit'][6]) ? $attacker['unit'][6] : 0,
                "7" => isset($attacker['unit'][7]) ? $attacker['unit'][7] : 0,
                "8" => isset($attacker['unit'][8]) ? $attacker['unit'][8] : 0,
                "9" => isset($attacker['unit'][9]) ? $attacker['unit'][9] : 0,
                "10" => isset($attacker['unit'][10]) ? $attacker['unit'][10] : 0,
                "11" => isset($attacker['unit'][11]) ? $attacker['unit'][11] : 0
            ],
            "lostTroops" => [
                "1" => 0,
                "2" => 0,
                "3" => 0,
                "4" => 0,
                "5" => 0,
                "6" => 0,
                "7" => 0,
                "8" => 0,
                "9" => 0,
                "10" => 0,
                "11" => 0
            ]
        ];
        $defs = [];
        $sums = [
            [
                "tribeId" => 1,
                "playerId" => -1,
                "playerName" => "",
                "villageId" => -1,
                "villageName" => "",
                "originalTroops" => [
                    "1" => 0,
                    "2" => 0,
                    "3" => 0,
                    "4" => 0,
                    "5" => 0,
                    "6" => 0,
                    "7" => 0,
                    "8" => 0,
                    "9" => 0,
                    "10" => 0,
                    "11" => 0
                ],
                "lostTroops" => [
                    "1" => 0,
                    "2" => 0,
                    "3" => 0,
                    "4" => 0,
                    "5" => 0,
                    "6" => 0,
                    "7" => 0,
                    "8" => 0,
                    "9" => 0,
                    "10" => 0,
                    "11" => 0
                ]
            ], [
                "tribeId" => 2,
                "playerId" => -1,
                "playerName" => "",
                "villageId" => -1,
                "villageName" => "",
                "originalTroops" => [
                    "1" => 0,
                    "2" => 0,
                    "3" => 0,
                    "4" => 0,
                    "5" => 0,
                    "6" => 0,
                    "7" => 0,
                    "8" => 0,
                    "9" => 0,
                    "10" => 0,
                    "11" => 0
                ],
                "lostTroops" => [
                    "1" => 0,
                    "2" => 0,
                    "3" => 0,
                    "4" => 0,
                    "5" => 0,
                    "6" => 0,
                    "7" => 0,
                    "8" => 0,
                    "9" => 0,
                    "10" => 0,
                    "11" => 0
                ]
            ], [
                "tribeId" => 3,
                "playerId" => -1,
                "playerName" => "",
                "villageId" => -1,
                "villageName" => "",
                "originalTroops" => [
                    "1" => 0,
                    "2" => 0,
                    "3" => 0,
                    "4" => 0,
                    "5" => 0,
                    "6" => 0,
                    "7" => 0,
                    "8" => 0,
                    "9" => 0,
                    "10" => 0,
                    "11" => 0
                ],
                "lostTroops" => [
                    "1" => 0,
                    "2" => 0,
                    "3" => 0,
                    "4" => 0,
                    "5" => 0,
                    "6" => 0,
                    "7" => 0,
                    "8" => 0,
                    "9" => 0,
                    "10" => 0,
                    "11" => 0
                ]
            ], [
                "tribeId" => 4,
                "playerId" => -1,
                "playerName" => "",
                "villageId" => -1,
                "villageName" => "",
                "originalTroops" => [
                    "1" => 0,
                    "2" => 0,
                    "3" => 0,
                    "4" => 0,
                    "5" => 0,
                    "6" => 0,
                    "7" => 0,
                    "8" => 0,
                    "9" => 0,
                    "10" => 0,
                    "11" => 0
                ],
                "lostTroops" => [
                    "1" => 0,
                    "2" => 0,
                    "3" => 0,
                    "4" => 0,
                    "5" => 0,
                    "6" => 0,
                    "7" => 0,
                    "8" => 0,
                    "9" => 0,
                    "10" => 0,
                    "11" => 0
                ]
            ], [
                "tribeId" => 5,
                "playerId" => -1,
                "playerName" => "",
                "villageId" => -1,
                "villageName" => "",
                "originalTroops" => [
                    "1" => 0,
                    "2" => 0,
                    "3" => 0,
                    "4" => 0,
                    "5" => 0,
                    "6" => 0,
                    "7" => 0,
                    "8" => 0,
                    "9" => 0,
                    "10" => 0,
                    "11" => 0
                ],
                "lostTroops" => [
                    "1" => 0,
                    "2" => 0,
                    "3" => 0,
                    "4" => 0,
                    "5" => 0,
                    "6" => 0,
                    "7" => 0,
                    "8" => 0,
                    "9" => 0,
                    "10" => 0,
                    "11" => 0
                ]
            ]
        ];

        foreach ($defender as $unitDef) {
            array_push($defs, [
                "wid" => $unitDef['wid'],
                "tribeId" => $unitDef['tribe'],
                "playerId" => (isset($unitDef['player'])) ? (isset($unitDef['player']['id'])) ? $unitDef['player']['id'] : 0 : 0,
                "playerName" => (isset($unitDef['player'])) ? (isset($unitDef['player']['name'])) ? $unitDef['player']['name'] : 'defender' : 'defender',
                "villageId" => (isset($unitDef['village'])) ? (isset($unitDef['village']['id'])) ? $unitDef['village']['id'] : 0 : 0,
                "villageName" => (isset($unitDef['village'])) ? (isset($unitDef['village']['name'])) ? $unitDef['village']['name'] : '' : '',
                "originalTroops" => [
                    "1" => isset($unitDef['unit'][1]) ? $unitDef['unit'][1] : 0,
                    "2" => isset($unitDef['unit'][2]) ? $unitDef['unit'][2] : 0,
                    "3" => isset($unitDef['unit'][3]) ? $unitDef['unit'][3] : 0,
                    "4" => isset($unitDef['unit'][4]) ? $unitDef['unit'][4] : 0,
                    "5" => isset($unitDef['unit'][5]) ? $unitDef['unit'][5] : 0,
                    "6" => isset($unitDef['unit'][6]) ? $unitDef['unit'][6] : 0,
                    "7" => isset($unitDef['unit'][7]) ? $unitDef['unit'][7] : 0,
                    "8" => isset($unitDef['unit'][8]) ? $unitDef['unit'][8] : 0,
                    "9" => isset($unitDef['unit'][9]) ? $unitDef['unit'][9] : 0,
                    "10" => isset($unitDef['unit'][10]) ? $unitDef['unit'][10] : 0,
                    "11" => isset($unitDef['unit'][11]) ? $unitDef['unit'][11] : 0
                ],
                "lostTroops" => [
                    "1" => 0,
                    "2" => 0,
                    "3" => 0,
                    "4" => 0,
                    "5" => 0,
                    "6" => 0,
                    "7" => 0,
                    "8" => 0,
                    "9" => 0,
                    "10" => 0,
                    "11" => 0
                ]
                    ]
            );
        }

        $atki = $atkc = $totalAP = 0;
        $defi = $defc = $totalDP = 0;

        //var_dump($atk);
        //var_dump($defs);
        ####################################
        #  Prepair attack and defent point
        ####################################
        for ($i = 1; $i <= 11; $i++) {
            if ($i != 11) {
                $type = $i + (10 * ($atk['tribeId'] - 1));
                if (in_array($i + (10 * ($atk['tribeId'] - 1)), UnitData::get('nitsbytype', 'cavalry'))) {
                    if (!isset($attacker['research']))
                        $atkc += $engine->tech->getPower($attacker['wid'], $type, 'atk') * $attacker['unit'][$i];
                    else {
                        !isset($attacker['research'][$i]) ? $attacker['research'][$i] = 0 : '';
                        $atkc += $engine->tech->getPower([$attacker['research'][$i]], $type, 'atk') * $atk['originalTroops'][$i];
                    }
                } else {
                    if (!isset($attacker['research']))
                        $atki += $engine->tech->getPower($attacker['wid'], $type, 'atk') * $attacker['unit'][$i];
                    else {
                        !isset($attacker['research'][$i]) ? $attacker['research'][$i] = 0 : '';
                        $atki += $engine->tech->getPower([$attacker['research'][$i]], $type, 'atk') * $atk['originalTroops'][$i];
                    }
                }
                foreach ($defender as $k => $unitDef) {
                    var_dump($unitDef);
                    $type = $i + (10 * ($unitDef['tribeId'] - 1));
                    if (!isset($defender[$k]['research'])) {
                        $defi += $engine->tech->getPower($unitDef['wid'], $type, 'di') * $unitDef['unit'][$i];
                        $defc += $engine->tech->getPower($unitDef['wid'], $type, 'dc') * $unitDef['unit'][$i];
                    } else {
                        !isset($defender[$k]['research'][$i]) ? $defender[$k]['research'][$i] = 0 : '';
                        $defi += $engine->tech->getPower([$defender[$k]['research'][$i]], $type, 'di') * $unitDef['unit'][$i];
                        $defc += $engine->tech->getPower([$defender[$k]['research'][$i]], $type, 'dc') * $unitDef['unit'][$i];
                    }
                }
            }
        }

        $totalAP = $atki + $atkc;
        $totalDP = $defi + $defc;
        $Mfactor = 1.5;
        $moralbonus = 1;
        $result = [];
        $loss = [
            "attacker" => [
                "resources" => 0,
                "crop" => 0,
                "time" => 0,
            ],
            "defender" => [
                "resources" => 0,
                "crop" => 0,
                "time" => 0,
            ],
        ];
        $final = [
            "attacker" => [
                "sum" => 0,
                "loss" => 0,
            ],
            "defender" => [
                "sum" => 0,
                "loss" => 0,
            ],
        ];

        // Calc Factor
        $winner = ($totalAP > $totalDP);
        $result[1] = ($winner) ? pow((($totalDP * $moralbonus) / $totalAP), $Mfactor) : 1;
        // Attacker
        $result[1] = ($winner) ? pow((($totalDP * $moralbonus) / $totalAP), $Mfactor) : 1;
        $result[1] = round($result[1], 8);
        // Defender
        $result[2] = (!$winner) ? pow(($totalAP / ($totalDP * $moralbonus)), $Mfactor) : 1;
        $result[2] = round($result[2], 8);
        $result[1] = max(0, min(1, $result[1]));
        $result[2] = max(0, min(1, $result[2]));

        // Calc Unit figth
        // ####################
        for ($i = 1; $i <= 11; $i++) {
            // Attacker
            $type = $i + (10 * ($atk['tribeId'] - 1));
            $atk['lostTroops'][$i] = round($result[1] * $atk['originalTroops'][$i]);
            $loss['attacker']['resources'] += (UnitData::get($type, 'wood') + UnitData::get($type, 'clay') + UnitData::get($type, 'iron')) * $atk['lostTroops'][$i];
            $loss['attacker']['crop'] += UnitData::get($type, 'pop') * $atk['lostTroops'][$i];
            $loss['attacker']['time'] += UnitData::get($type, 'time') * $atk['lostTroops'][$i];

            $sums[$atk['tribeId'] - 1]['originalTroops'][$i] += $atk['originalTroops'][$i];
            $sums[$atk['tribeId'] - 1]['lostTroops'][$i] += $atk['lostTroops'][$i];

            $final['attacker']['sum'] += $atk['originalTroops'][$i];
            $final['attacker']['loss'] += $atk['lostTroops'][$i];

            // Defender
            foreach ($defs as $k => $unitDef) {
                $type = $i + (10 * ($unitDef['tribeId'] - 1));
                $defs[$k]['lostTroops'][$i] = round($result[2] * $unitDef['originalTroops'][$i]);
                $loss['defender']['resources'] += (UnitData::get($type, 'wood') + UnitData::get($type, 'clay') + UnitData::get($type, 'iron')) * $defs[$k]['lostTroops'][$i];
                $loss['defender']['crop'] += UnitData::get($type, 'pop') * $defs[$k]['lostTroops'][$i];
                $loss['defender']['time'] += UnitData::get($type, 'time') * $defs[$k]['lostTroops'][$i];

                $sums[$defs[$k]['tribeId'] - 1]['originalTroops'][$i] += $unitDef['originalTroops'][$i];
                $sums[$defs[$k]['tribeId'] - 1]['lostTroops'][$i] += $defs[$k]['lostTroops'][$i];

                $final['defender']['sum'] += $unitDef['originalTroops'][$i];
                $final['defender']['loss'] += $defs[$k]['lostTroops'][$i];
            }
        }

        return [
            "attacker" => $atk,
            "defender" => $defs,
            "sum" => $sums,
            "data" => [
                "lossPercent" => [
                    "attacker" => $result[1] * 100,
                    "defender" => $result[2] * 100,
                ],
                "losses" => [
                    "resources" => [
                        "attacker" => $loss['attacker']['resources'],
                        "defender" => $loss['defender']['resources']
                    ],
                    "crop" => [
                        "attacker" => $loss['attacker']['crop'],
                        "defender" => $loss['defender']['crop']
                    ],
                    "time" => [
                        "attacker" => $loss['attacker']['time'],
                        "defender" => $loss['defender']['time']
                    ]
                ],
                "totalEffective" => [
                    "attacker" => $totalAP,
                    "defender" => $totalDP
                ]
            ],
            "final" => $final,
        ];
    }

}
