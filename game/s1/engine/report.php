<?php

class Report {
    # Share Token : (report id) + (0 + {id of collection (เลข 1 หลัก)}[เลข 2 หลัก]) + (0 + {report token (เลข 6 หลัก)}[เลข 7 หลัก])
    //Report.DISPLAY_TYPE_SUPPORT = 1;
    //Report.DISPLAY_TYPE_TRADE = 2;
    //Report.DISPLAY_TYPE_ADVENTURE = 3;
    //Report.DISPLAY_TYPE_FIGHT = 4;
    //Report.DISPLAY_TYPE_SPY = 5;
    //Report.DISPLAY_TYPE_VISIT = 6;
    //Report.DISPLAY_TYPE_SUPPORT_ATTACKED = 7;
    //Report.DISPLAY_TYPE_TROOP_RELEASE = 8;
    //Report.DISPLAY_TYPE_ANIMALS_CAPTURE = 9;
    //Report.DISPLAY_TYPE_PRESTIGE = 10;
    //Report.DISPLAY_TYPE_FARMLIST_RAID = 11;
    //Report.DISPLAY_TYPE_FARMLIST_RAID_COMPLETE = 12;
    //Report.DISPLAY_TYPES_FIGHT = [
    //	Report.DISPLAY_TYPE_FIGHT,
    //	Report.DISPLAY_TYPE_SPY,
    //	Report.DISPLAY_TYPE_VISIT,
    //	Report.DISPLAY_TYPE_SUPPORT_ATTACKED,
    //	Report.DISPLAY_TYPE_ANIMALS_CAPTURE
    //];
    //Report.ADVENTURE_LOOT_TYPE_NOTHING = 0;
    //Report.ADVENTURE_LOOT_TYPE_RESOURCES = 3;
    //Report.ADVENTURE_LOOT_TYPE_SILVER = 4;
    //Report.ADVENTURE_LOOT_TYPE_TROOPS = 5;

    public function get($id, $collection = "own") {
        global $engine;

        $report_head = query("SELECT * FROM `{$engine->server->prefix}report_head` WHERE `ref`=?", [$id])->fetch(PDO::FETCH_ASSOC);

        return [
            'header' => $this->getHead($id),
            'body' => $this->getBody($report_head['body'])
        ];
    }

    public function genRef($str) {
        return hash('crc32', $str . time()) . hash('crc32b', $this->genToken() . time() . $str) . hash('adler32', $str . time() . $this->genToken());
    }

    public function genToken() {
        return rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
    }

    public function getLast($collection = 'own', $start = 0, $count = 12) {
        global $engine;

        $r = [];

        $rhs = query("SELECT * FROM `{$engine->server->prefix}report_head` WHERE `owner`=? ORDER BY `time` DESC LIMIT {$start},{$count};", [$_SESSION[$engine->server->prefix . 'uid']])->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rhs as $rh) {
            array_push($r, $this->getHead($rh['ref']));
        }
        return $r;
    }

    public function add($type, $owner, $source, $target, $detail, $modules) {
        global $engine;
        // ##############################
        //  Body of report
        // ##############################
        $tokenb = $this->genRef('body:' . $type);

        $params = [$tokenb, $owner, json_encode($source), json_encode($target), json_encode($detail), json_encode($modules['attacker']), json_encode($modules['defender']), json_encode($modules['support']), time()];
        query("INSERT INTO `{$engine->server->prefix}report_body` (`ref`,`owner`,`source_data`,`target_data`,`detail_data`,`module_source`,`module_target`,`module_support`,`time`) VALUES (?,?,?,?,?,?,?,?,?)", $params);

        // ##############################
        //  Head of report
        // ##############################
        $tokenh = $this->genRef('head:' . $type);
        $params = [$tokenh, $owner, $tokenb, 'own', $type, $this->genToken(), json_encode($source), json_encode($target), json_encode($detail), time()];
        query("INSERT INTO `{$engine->server->prefix}report_head` (`ref`,`owner`,`body`,`collection`,`type`,`token`,`source_data`,`target_data`,`detail_data`,`time`) VALUES (?,?,?,?,?,?,?,?,?,?)", $params);

        return $tokenh;
    }

    public function getHead($id) {
        global $engine;

        $report = query("SELECT * FROM `{$engine->server->prefix}report_head` WHERE `ref`=?", [$id])->fetch(PDO::FETCH_ASSOC);
        $report['source_data'] = json_decode($report['source_data'], true);
        $report['target_data'] = json_decode($report['target_data'], true);
        $report['detail_data'] = json_decode($report['detail_data'], true);

        if ($report['type'] == "3") {
            $p = $engine->account->getById($report['source_data']['playerId']);
            $p['kingdom'] != 0 ? $k = query("SELECT * FROM `{$engine->server->prefix}kingdom` WHERE `id`=?;", [$p['kingdom']])->fetch(PDO::FETCH_ASSOC) : $k = ['id' => 0, 'tag' => ''];

            $r = [
                "_id" => [
                    "\$id" => $id,
                ],
                "bodyId" => [
                    "\$id" => $report['body'],
                ],
                "time" => $report['time'],
                "notificationType" => 21,
                "displayType" => (int) $report['type'],
                "securityCode" => $report['token'],
                "sourceId" => $report['source_data']['villageId'],
                "sourceName" => $report['source_data']['villageName'],
                "sourcePlayerId" => $report['source_data']['playerId'],
                "sourcePlayerName" => $report['source_data']['playerName'],
                "sourceKingdomId" => $k['id'],
                "sourceKingdomTag" => $k['tag'],
                'neededRights' => $report['detail_data']['neededRights'],
                'won' => $report['detail_data']['won'],
                'loot' => $report['detail_data']['loot'],
            ];
        } elseif ($report['type'] == "4") {

            $p = $engine->account->getById($report['source_data']['playerId']);
            $p['kingdom'] != 0 ? $k = query("SELECT * FROM `{$engine->server->prefix}kingdom` WHERE `id`=?;", [$p['kingdom']])->fetch(PDO::FETCH_ASSOC) : $k = ['id' => 0, 'tag' => ''];

            $pt = $engine->account->getById($report['target_data']['playerId']);
            $pt['kingdom'] != 0 ? $kt = query("SELECT * FROM `{$engine->server->prefix}kingdom` WHERE `id`=?;", [$pt['kingdom']])->fetch(PDO::FETCH_ASSOC) : $kt = ['id' => 0, 'tag' => ''];

            $r = [
                "_id" => [
                    "\$id" => $id,
                ],
                "bodyId" => [
                    "\$id" => $report['body'],
                ],
                "time" => $report['time'],
                "notificationType" => 1,
                "displayType" => (int) $report['type'],
                "neededRights" => 0,
                "otherKingdomId" => 0,
                "collection" => "own",
                "ownRole" => "attacker",
                "securityCode" => $report['token'],
                "attackType" => 3,
                "attackerTroopSum" => $report['detail_data']['final']['attacker']['sum'],
                "attackerTroopLossSum" => $report['detail_data']['final']['attacker']['loss'],
                "defenderTroopSum" => $report['detail_data']['final']['defender']['sum'],
                "defenderTroopLossSum" => $report['detail_data']['final']['defender']['loss'],
                "playerId" => $report['owner'],
                "sourceId" => $report['source_data']['villageId'],
                "sourceName" => $report['source_data']['villageName'],
                "sourcePlayerId" => $report['source_data']['playerId'],
                "sourcePlayerName" => $report['source_data']['playerName'],
                "sourceTribeId" => $report['source_data']['tribeId'],
                "sourceKingdomId" => $k['id'],
                "sourceKingdomTag" => $k['tag'],
                "destId" => $report['target_data']['villageId'],
                "destName" => $report['target_data']['villageName'],
                "destPlayerId" => $report['target_data']['playerId'],
                "destPlayerName" => $report['target_data']['playerName'],
                "destTribeId" => $report['target_data']['tribeId'],
                "destKingdomId" => $kt['id'],
                "destKingdomTag" => $kt['tag'],
                "destType" => 1,
                "destX" => $report['target_data']['coordinates']['x'],
                "destY" => $report['target_data']['coordinates']['y'],
                "troopId" => $report['source_data']['troopId'],
                "bounty" => $report['detail_data']['bounty']['wood'] + $report['detail_data']['bounty']['clay'] + $report['detail_data']['bounty']['iron'] + $report['detail_data']['bounty']['crop'],
                "capacity" => $report['detail_data']['capacity'],
            ];
        }

        return $r;
    }

    public function getBody($id) {
        global $engine;
        $report = query("SELECT * FROM `{$engine->server->prefix}report_body` WHERE `ref`=?", [$id])->fetch(PDO::FETCH_ASSOC);
        $head = query("SELECT * FROM `{$engine->server->prefix}report_head` WHERE `body`=?", [$id])->fetch(PDO::FETCH_ASSOC);

        if ($head['type'] == "3") {
            $report['source_data'] = json_decode($report['source_data'], true);
            $report['detail_data'] = json_decode($report['detail_data'], true);

            $p = $engine->account->getById($report['source_data']['playerId']);
            $p['kingdom'] != 0 ? $k = query("SELECT * FROM `{$engine->server->prefix}kingdom` WHERE `id`=?;", [$p['kingdom']])->fetch(PDO::FETCH_ASSOC) : $k = ['id' => 0, 'tag' => ''];

            $r = [
                "_id" => [
                    "\$id" => $id,
                ],
                'time' => $report['time'],
                'sourceId' => $report['source_data']['villageId'],
                'sourceName' => $report['source_data']['villageName'],
                'sourcePlayerId' => $report['source_data']['playerId'],
                'sourcePlayerName' => $report['source_data']['playerName'],
                'sourceKingdomId' => $k['id'],
                'sourceKingdomTag' => $k['tag'],
                'tribeId' => $report['source_data']['tribeId'],
                'xp' => $report['detail_data']['xp'],
                'hp' => $report['detail_data']['hp'],
                'won' => $report['detail_data']['won'],
                'loot' => $report['detail_data']['loot'],
                "modules" => [],
                "originalTroops" => [
                    1 => 0,
                    2 => 0,
                    3 => 0,
                    4 => 0,
                    5 => 0,
                    6 => 0,
                    7 => 0,
                    8 => 0,
                    9 => 0,
                    10 => 0,
                    11 => 1,
                ]
            ];
        } elseif ($head['type'] == "4") {
            $report['source_data'] = json_decode($report['source_data'], true);
            $report['target_data'] = json_decode($report['target_data'], true);
            $report['detail_data'] = json_decode($report['detail_data'], true);
            $report['module_source'] = json_decode($report['module_source'], true);
            $report['module_target'] = json_decode($report['module_target'], true);
            $report['module_support'] = json_decode($report['module_support'], true);

            $p = $engine->account->getById($report['source_data']['playerId']);
            $p['kingdom'] != 0 ? $k = query("SELECT * FROM `{$engine->server->prefix}kingdom` WHERE `id`=?;", [$p['kingdom']])->fetch(PDO::FETCH_ASSOC) : $k = ['id' => 0, 'tag' => ''];

            $pt = $engine->account->getById($report['target_data']['playerId']);
            $pt['kingdom'] != 0 ? $kt = query("SELECT * FROM `{$engine->server->prefix}kingdom` WHERE `id`=?;", [$pt['kingdom']])->fetch(PDO::FETCH_ASSOC) : $kt = ['id' => 0, 'tag' => ''];

            $modules = [];
            array_push($modules, $report['module_source']);
            array_push($modules, $report['module_target']);
            foreach ($report['module_support'] as $support) {
                array_push($modules, $support);
            }
            $r = [
                "_id" => [
                    "\$id" => $id,
                ],
                "time" => $report['time'],
                "duration" => 60,
                "otherKingdomId" => 0,
                "ownRole" => "attacker",
                "attackType" => 3,
                "playerId" => $report['owner'],
                "sourceId" => $report['source_data']['villageId'],
                "sourceName" => $report['source_data']['villageName'],
                "sourcePlayerId" => $report['source_data']['playerId'],
                "sourcePlayerName" => $report['source_data']['playerName'],
                "sourceTribeId" => $report['source_data']['tribeId'],
                "sourceKingdomId" => $k['id'],
                "sourceKingdomTag" => $k['tag'],
                "destId" => $report['target_data']['villageId'],
                "destName" => $report['target_data']['villageName'],
                "destPlayerId" => $report['target_data']['playerId'],
                "destPlayerName" => $report['target_data']['playerName'],
                "destTribeId" => $report['target_data']['tribeId'],
                "destKingdomId" => $kt['id'],
                "destKingdomTag" => $kt['tag'],
                "destType" => 1,
                "destX" => $report['target_data']['coordinates']['x'],
                "destY" => $report['target_data']['coordinates']['y'],
                "troopId" => 1,
                "supply" => 119,
                "bounty" => [
                    1 => $report['detail_data']['bounty']['wood'],
                    2 => $report['detail_data']['bounty']['clay'],
                    3 => $report['detail_data']['bounty']['iron'],
                    4 => $report['detail_data']['bounty']['crop']
                ],
                "capacity" => $report['detail_data']['capacity'],
                "stolenGoods" => null,
                "treasures" => null,
                "tributeBounty" => null,
                "victoryPoints" => null,
                "modules" => $modules,
            ];
        }
        return $r;
    }

}
