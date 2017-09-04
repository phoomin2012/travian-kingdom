<?php

class Movement {
    /*
      Troops.MOVEMENT_TYPE_ATTACK = 3;
      Troops.MOVEMENT_TYPE_RAID = 4;
      Troops.MOVEMENT_TYPE_SUPPORT = 5;
      Troops.MOVEMENT_TYPE_SPY = 6;
      Troops.MOVEMENT_TYPE_TRANSPORT = 7;
      Troops.MOVEMENT_TYPE_RETURN = 9;
      Troops.MOVEMENT_TYPE_SETTLE = 10;
      Troops.MOVEMENT_TYPE_TRIBUTE_COLLECT = 12;
      Troops.MOVEMENT_TYPE_ADVENTURE = 20;
      Troops.MOVEMENT_TYPE_RETURN_ADVENTURE = 27;
      Troops.MOVEMENT_TYPE_TRANSPORT_RETURN = 33;
      Troops.MOVEMENT_TYPE_REGENERATION = 36;
      Troops.MOVEMENT_TYPE_SIEGE = 47;
      Troops.MOVEMENT_TYPE_TREASURE_RESOURCES = 50;

      Troops.TYPE_RAM = 7;
      Troops.TYPE_CATAPULT = 8;
      Troops.TYPE_LEADER = 9;
      Troops.TYPE_SETTLER = 10;
      Troops.TYPE_HERO = 11;

      Troops.TYPE_TRAPS = 79;

      Troops.SECOND_TARGET_CATAPULTS = 20;
     */

    public function get($wid = null) {
        global $engine;

        $r = array();
        $v = query("SELECT * FROM `" . $engine->server->prefix . "village` WHERE `wid`=?;", array($wid))->fetch(PDO::FETCH_ASSOC);
        $moves = query("SELECT * FROM `" . $engine->server->prefix . "troop_move` WHERE (`from`=? AND `owner`=?) OR `to`=?;", array($wid, $v['owner'], $wid))->fetchAll(PDO::FETCH_ASSOC);
        $owner = $engine->account->getByVillage($wid);

        foreach ($moves as $move) {
            $u = query("SELECT * FROM `" . $engine->server->prefix . "units` WHERE `id`=?;", array($move['unit']))->fetch(PDO::FETCH_ASSOC);
            $v = query("SELECT * FROM `" . $engine->server->prefix . "village` WHERE `wid`=?;", array($u['wid']))->fetch(PDO::FETCH_ASSOC);
            $vt = query("SELECT * FROM `" . $engine->server->prefix . "village` WHERE `wid`=?;", array($move['to']))->fetch(PDO::FETCH_ASSOC);
            $p = $engine->account->getById($move['owner']);
            $pt = $engine->account->getByVillage($move['to']);
            $w = $engine->world->getMapDetail($u['wid']);

            /* if ($w['isOasis'] == true) {
              $vid = $u['wid'];
              $vname = "Oasis (" . $engine->world->id2xy($vid)[0] . "|" . $engine->world->id2xy($vid)[1] . ")";
              } else {
              $vid = $v['wid'];
              $vname = $v['vname'];
              }
             */

            $supply = 0;
            for ($i = 1; $i <= 10; $i++) {
                $supply += $u['u' . $i] * UnitData::get($i + (($p['tribe'] - 1) * 10), 'pop');
            }
            $status = "transit";
            $rn = array(
                "name" => "Troops:" . $u['id'],
                "data" => array(
                    "troopId" => $u['id'],
                    "tribeId" => $p['tribe'],
                    "capacity" => 715,
                    "filter" => "",
                    "playerId" => $p['uid'],
                    "playerIdLocation" => $pt['uid'],
                    "playerName" => $p['username'],
                    "playerNameLocation" => $pt['username'],
                    "villageId" => $move['from'],
                    "villageIdLocation" => $move['to'],
                    "villageIdSupply" => $move['from'],
                    "villageName" => "",
                    "villageNameLocation" => "",
                    "status" => $status,
                    "supplyTroops" => $supply,
                    "units" => array(
                        1 => ($owner['uid'] != $move['owner']) ? '-1' : $u['u1'],
                        2 => ($owner['uid'] != $move['owner']) ? '-1' : $u['u2'],
                        3 => ($owner['uid'] != $move['owner']) ? '-1' : $u['u3'],
                        4 => ($owner['uid'] != $move['owner']) ? '-1' : $u['u4'],
                        5 => ($owner['uid'] != $move['owner']) ? '-1' : $u['u5'],
                        6 => ($owner['uid'] != $move['owner']) ? '-1' : $u['u6'],
                        7 => ($owner['uid'] != $move['owner']) ? '-1' : $u['u7'],
                        8 => ($owner['uid'] != $move['owner']) ? '-1' : $u['u8'],
                        9 => ($owner['uid'] != $move['owner']) ? '-1' : $u['u9'],
                        10 => ($owner['uid'] != $move['owner']) ? '-1' : $u['u10'],
                        11 => ($owner['uid'] != $move['owner']) ? '-1' : $u['u11'],
                    ),
                    "movement" => array(
                        "troopId" => $u['id'],
                        "villageIdStart" => $move['from'],
                        "villageIdTarget" => $move['to'],
                        "playerIdTarget" => $pt['uid'],
                        "kingdomIdTarget" => "-1",
                        "coordinateID" => 0,
                        "timeStart" => $move['start'],
                        "timeFinish" => $move['end'],
                        "movementType" => $move['type'],
                        "resources" => array(
                            1 => 0,
                            2 => 0,
                            3 => 0,
                            4 => 0,
                        ),
                        "treasures" => "0",
                        "spyTarget" => ($move['spy'] == 'resource') ? '2' : '1',
                        "catapultTarget1" => '',
                        "catapultTarget2" => '',
                        "merchants" => "0",
                    )
                )
            );
            if ($move['type'] != 6) {
                unset($rn['data']['movement']['spyTarget']);
            }
            if ($move['type'] == 7 || $move['type'] == 33) {
                $res = json_decode($move['data'], true);

                $rn['data']['movement'] = [
                    "troopId" => $u['id'],
                    "villageIdStart" => $move['from'],
                    "villageIdTarget" => $move['to'],
                    "playerIdTarget" => $pt['uid'],
                    "coordinateID" => 0,
                    "timeStart" => $move['start'],
                    "timeFinish" => $move['end'],
                    "movementType" => $move['type'],
                    "resources" => [
                        "1" => $res[0],
                        "2" => $res[1],
                        "3" => $res[2],
                        "4" => $res[3]
                    ],
                    "treasures" => $res[4],
                    "spyTarget" => "0",
                    "catapultTarget1" => "0",
                    "catapultTarget2" => "0",
                    "merchants" => "1",
                    "recurrences" => "1",
                    "recurrencesTotal" => "1"
                ];
            }
            array_push($r, $rn);
        }
        return array(
            "name" => "Collection:Troops:moving:" . $wid,
            "data" => array(
                'cache' => $r,
                'operation' => 1,
            )
        );
    }

    public function robber_start($from = '536887296', $to = null, $units = [], $tutorial = false, $time = false) {
        global $engine;

        ##################  Check Arguments  ######################
        if (is_numeric($tutorial)) {
            $time = $tutorial;
            $tutorial = false;
        }
        if (is_numeric($units)) {
            $time = $units;
            $units = [];
        }
        if (is_array($to)) {
            $units = $to;
            $to = null;
        }
        if (is_bool($to)) {
            $tutorial = $to;
            $to = null;
        }
        if (is_array($from)) {
            $units = $from;
            $from = '536887296';
        }
        if (is_bool($from)) {
            $tutorial = $from;
            $from = '536887296';
        }
        
        ($to === null) ? $to = $_COOKIE['village'] : '';
        ###########################################################

        $tid = $engine->unit->createUnit('536887296', $units);
        $dist = $engine->world->getDistance($from, $to);
        $start = time();
        $end = $start + ($time) ? $time : ($dist / (0.5 * $engine->server->speed_unit) * 3600);

        if ($tutorial) {
            $p = $engine->account->getByVillage($to);
            $end = $start + $time;
            $engine->account->edit('tutorial', 11, $p['uid']);
        }

        $params = [$from, '-1', $to, '3', '', '', $start, $end, $tid, json_encode(['robber' => true, 'tutorial' => $tutorial])];
        query("INSERT INTO `" . $engine->server->prefix . "troop_move` (`from`,`owner`,`to`,`type`,`spy`,`redeployHero`,`start`,`end`,`unit`,`data`) VALUES (?,?,?,?,?,?,?,?,?,?);", $params);
        $uid = $engine->account->getByVillage($to, 'uid');
        $engine->auto->emitCache($uid, $this->get($to));
    }

    public function send($from, $to, $type, $spy, $rdhero, $unit) {
        global $engine;

        $p = $engine->account->getByVillage($from);
        $dist = $engine->world->getDistance($from, $to);

        // Calculate speed
        $speeds = array();
        for ($i = 1; $i <= 10; $i++) {
            if (!isset($unit[$i])) {
                $unit[$i] = 0;
            }
            if ($unit[$i] > 0) {
                array_push($speeds, UnitData::get(($p['tribe'] - 1) * 10 + $i, 'speed') * $engine->server->speed_unit);
            }
        }

        // Decrease troops from village
        $engine->unit->removeUnit($from, '1', $unit[1]);
        $engine->unit->removeUnit($from, '2', $unit[2]);
        $engine->unit->removeUnit($from, '3', $unit[3]);
        $engine->unit->removeUnit($from, '4', $unit[4]);
        $engine->unit->removeUnit($from, '5', $unit[5]);
        $engine->unit->removeUnit($from, '6', $unit[6]);
        $engine->unit->removeUnit($from, '7', $unit[7]);
        $engine->unit->removeUnit($from, '8', $unit[8]);
        $engine->unit->removeUnit($from, '9', $unit[9]);
        $engine->unit->removeUnit($from, '10', $unit[10]);
        $engine->unit->removeUnit($from, '11', $unit[11]);
        $tid = $engine->unit->createUnit($from, $unit);

        // Set time
        if ($type == 20) {
            $start = time();
            $end = $start + $to;
            $to = 20;
        } else {
            $start = time();
            $end = $start + $dist / min($speeds) * 3600;
        }

        // Edit time for tutorial quest
        if ($p['tutorial'] == 2) {
            $to = 536887296;
            $engine->account->edit('tutorial', 3, $p['uid']);
            $engine->auto->emitCache($p['uid'], $engine->quest->get('', $p['uid']));
            $end = $start + 5;
        }

        // Create new movement
        $p = $engine->account->getByVillage($from, 'uid');
        $params = [$from, $p, $to, $type, $spy, $rdhero, $start, $end, $tid];
        query("INSERT INTO `" . $engine->server->prefix . "troop_move` (`from`,`owner`,`to`,`type`,`spy`,`redeployHero`,`start`,`end`,`unit`) VALUES (?,?,?,?,?,?,?,?,?);", $params);

        $engine->auto->emitEvent($p, array(
            "name" => "flashNotification",
            "data" => "32",
        ));
        if ($type != 10) {
            $pt = $engine->account->getByVillage($to, 'uid');
            $ptu = $engine->account->getByVillage($to, 'username');
            $engine->auto->emitCache($pt, $this->get($to));
            if ($type == 3 || $type == 4 || $type == 47) {
                $engine->auto->emitEvent($pt, array(
                    "name" => "flashNotification",
                    "data" => [
                        "notificationId" => "58",
                        "option" => $ptu
                    ],
                ));
            }
        }
    }

    public function abort($troopId) {
        global $engine;

        $move = query("SELECT * FROM `" . $engine->server->prefix . "troop_move` WHERE `unit`=?", array($troopId))->fetch(PDO::FETCH_ASSOC);

        $start = time();
        $end = (time() * 2 - $move['start']) + (60 / $engine->server->speed_unit);

        query("UPDATE `" . $engine->server->prefix . "troop_move` SET `from`=?, `to`=?,`type`='9',`start`=?,`end`=? WHERE `unit`=?", array($move['to'], $move['from'], $start, $end, $troopId));

        // Send Data to target
        $pt = $engine->account->getByVillage($move['to'], 'uid');
        $engine->auto->emitCache($pt, $this->get($move['to']));

        // Send Data Back
        return $move['from'];
    }

    public function reinforcement($data) {
        global $engine;

        // Prepare data
        $p = $engine->account->getByVillage($data['from'], 'uid');
        $pt = $engine->account->getByVillage($data['to'], 'uid');
        $unit = query("SELECT * FROM `{$engine->server->prefix}units` WHERE `id`=?", array($data['unit']))->fetch();

        // Add troops to village
        for ($i = 1; $i <= 11; $i++) {
            $engine->unit->addUnit($data['to'], $i, $unit['u' . $i], $unit['wid']);
            if ($i == 11) {
                if ($unit['u' . $i] > 0) {
                    query("UPDATE `{$engine->server->prefix}hero` SET `move`=? WHERE `owner`=?;", ['', $pt]);
                    $engine->auto->emitCache($pt, $engine->hero->get($pt));
                }
            }
        }
        // If have resource
        $res = json_decode($data['data'], true);
        if ($res) {
            $engine->auto->procRes($data['to']);
            query("UPDATE `{$engine->server->prefix}village` SET `wood`=`wood`+?,`clay`=`clay`+?,`iron`=`iron`+?,`crop`=`crop`+? WHERE `wid`=?", array($res[1], $res[2], $res[3], $res[4], $data['to']));
            $engine->auto->emitCache($pt, $engine->village->get($data['to']));
        }

        // Remove movement
        query("DELETE FROM `{$engine->server->prefix}units` WHERE `id`=?", array($data['unit']));
        query("DELETE FROM `{$engine->server->prefix}troop_move` WHERE `id`=?", array($data['id']));

        // Send Data Back
        if ($p != null) {
            $engine->auto->emitCache($p, $this->get($data['from']));
        }
        if ($pt != null) {
            $engine->auto->emitCache($pt, $this->get($data['to']));
            $engine->auto->emitCache($pt, $engine->unit->getStay($data['to']));
        }

        // Send notifications
        if ($data['type'] != 9) {
            if ($p != null) {
                $engine->auto->emitEvent($p, array(
                    "name" => "flashNotification",
                    "data" => "37",
                ));
            }
            if ($pt != null) {
                $engine->auto->emitEvent($pt, array(
                    "name" => "flashNotification",
                    "data" => "8",
                ));
            }
        } else {
            if ($pt != null) {
                $engine->auto->emitEvent($pt, array(
                    "name" => "flashNotification",
                    "data" => "36",
                ));
            }
        }
    }

    public function attack($data) {
        global $engine;

        $data['data'] = json_decode($data['data'], true);
        if ($data['owner'] == "-1" && $data['data']['tutorial'] == true) {
            $uid = $engine->account->getByVillage($data['to'], 'uid');
            $engine->account->edit('tutorial', 12, $uid);
            $engine->auto->emitCache($uid, $engine->quest->get('', $uid));
            query("DELETE FROM `" . $engine->server->prefix . "units` WHERE `id`=?", array($data['unit']));
            query("DELETE FROM `" . $engine->server->prefix . "troop_move` WHERE `id`=?", array($data['id']));
        } else {
            $duration = $data['end'] - $data['start'];
            query("UPDATE `" . $engine->server->prefix . "troop_move` SET `from`=?,`to`=?,`start`=?,`end`=?,`type`=?  WHERE `id`=?", array($data['to'], $data['from'], time(), time() + $duration, 9, $data['id']));
        }
        // Calcurate Battle Result
        $t = $engine->account->getByVillage($data['from'], 'tutorial'); //Get tutorial status
        $engine->unit->realBattle($data);

        if ($t == 3) {
            //Send troop back
            $p = $engine->account->getByVillage($data['from'], 'uid');
            $engine->auto->emitCache($p, $this->get($data['from']));
            $engine->auto->emitCache($p, $engine->village->get($data['from']));

            $engine->auto->emitEvent([
                "name" => "invalidateCache",
                "data" => "MapDetails:536887296",
            ]);
            $engine->auto->emitEvent([
                "name" => "mapChanged",
                "data" => "536887296",
            ]);
        } else {
            // Send Data Back
            if ($p && $p != null & $p != "" & $p != 0) {
                $p = $engine->account->getByVillage($data['from'], 'uid');
                $engine->auto->emitCache($p, $this->get($data['from']));
            }
            
            $pt = $engine->account->getByVillage($data['to'], 'uid');
            if ($pt && $pt != null & $pt != "" & $pt != 0) {
                $engine->auto->emitCache($pt, $this->get($data['to']));
                $engine->auto->emitCache($pt, $engine->unit->getStay($data['to']));

                //$engine->notification->add($p, 1, '1234567890', 'movement_attack_medium_flat_positive');
                $engine->notification->add($pt, 4, '1234567890', 'movement_defent_medium_flat_positive');
            }
        }
    }

    public function returnMerchant($data) {
        global $engine;
        query("DELETE FROM `" . $engine->server->prefix . "units` WHERE `id`=?", array($data['unit']));
        query("DELETE FROM `" . $engine->server->prefix . "troop_move` WHERE `id`=?", array($data['id']));

        // Send Data Back
        $p = $data['owner'];
        $engine->auto->emitCache($p, $this->get($data['to']));
        $engine->auto->emitCache($p, $engine->unit->getStay($data['to']));

        // Send flash notification to source
        $engine->auto->emitEvent($p, array(
            "name" => "flashNotification",
            "data" => "35",
        ));
    }

    public function sendResource($data) {
        global $engine;

        $duration = $data['end'] - $data['start'];
        query("UPDATE `" . $engine->server->prefix . "troop_move` SET `from`=?,`to`=?,`start`=?,`end`=?,`type`=?  WHERE `id`=?", array($data['to'], $data['from'], time(), time() + $duration, 33, $data['id']));

        // Send Data Back
        $p = $engine->account->getByVillage($data['from'], 'uid');
        $pt = $engine->account->getByVillage($data['to'], 'uid');
        $engine->auto->emitCache($p, $this->get($data['from']));
        $engine->auto->emitCache($pt, $this->get($data['to']));

        // Add resource to village
        $res = json_decode($data['data'], true);
        $engine->auto->procRes($data['to']);
        query("UPDATE `" . $engine->server->prefix . "village` SET `wood`=`wood`+?,`clay`=`clay`+?,`iron`=`iron`+?,`crop`=`crop`+? WHERE `wid`=?", array($res[1], $res[2], $res[3], $res[4], $data['to']));
        $engine->auto->emitCache($pt, $engine->village->get($data['to']));

        // Send flash notification to source
        $engine->auto->emitEvent($p, array(
            "name" => "flashNotification",
            "data" => "34",
        ));
        $engine->auto->emitEvent($p, array(
            "name" => "flashNotification",
            "data" => "10",
        ));

        // Send flash notification to target
        $engine->auto->emitEvent($pt, array(
            "name" => "flashNotification",
            "data" => "35",
        ));

        // Send notification
        $engine->notification->add($p, 10, '1234567890', 'movement_trade_medium_flat_black');
        $engine->notification->add($pt, 10, '1234567890', 'movement_trade_medium_flat_black');
    }

    public function raid($data) {
        global $engine;

        $duration = $data['end'] - $data['start'];
        query("UPDATE `" . $engine->server->prefix . "troop_move` SET `from`=?,`to`=?,`start`=?,`end`=?,`type`=?  WHERE `id`=?", array($data['to'], $data['from'], time(), time() + $duration, 9, $data['id']));

        // Send Data Back
        $p = $engine->account->getByVillage($data['from'], 'uid');
        $pt = $engine->account->getByVillage($data['to'], 'uid');
        $engine->auto->emitCache($p, $this->get($data['from']));
        $engine->auto->emitCache($pt, $this->get($data['to']));
        $engine->auto->emitCache($pt, $engine->unit->getStay($data['to']));
    }

    public function adventure($data) {
        global $engine;
        // Prepare data
        $pt = $engine->account->getByVillage($data['from']);
        $vt = $engine->village->get($data['from'], false);
        $duration = $data['end'] - $data['start'];
        $long = $duration >= $engine->hero->adv_long[0] ? true : false;
        $hero = query("SELECT * FROM `{$engine->server->prefix}hero` WHERE `owner`=?;", [$pt['uid']])->fetch(PDO::FETCH_ASSOC);

        // Calculate health point
        $hp = rand(8, 19) * ($long ? 2 : 1);
        $new_hp = $hero['health'] - $hp;
        $dead = $new_hp <= 0 ? true : false;

        // Calculate XP & cliam reward
        $res = null;
        if ($dead) {
            $rewards = [];
        } else {
            $rewards = $engine->hero->randomReward($hero, $long);
            foreach ($rewards as $reward) {
                if ($reward['type'] == 3) {
                    $res = $reward['amount'];
                } else {
                    
                }
            }
            $engine->auto->emitCache($pt['uid'], $engine->item->getAll($pt['uid'], true));
        }
        $xp = rand(10, 30) * ($long ? 2 : 1) * (count($rewards) == 0 ? 2.25 : 1);
        $xp = round($xp);

        // Save attributes
        if ($new_hp <= 0) {
            query("UPDATE `{$engine->server->prefix}hero` SET `useAdvPoint`=`useAdvPoint`+?,`health`=?,`xp`=`xp`+?,`dead`=?,`move`=?  WHERE `owner`=?", [$long ? 2 : 1, 0, $xp, 1, 0, $pt['uid']]);
        } else {
            query("UPDATE `{$engine->server->prefix}hero` SET `useAdvPoint`=`useAdvPoint`+?,`health`=?,`xp`=`xp`+?  WHERE `owner`=?", [$long ? 2 : 1, $new_hp, $xp, $pt['uid']]);
        }
        $engine->hero->checkLevelUp($pt['uid'],false,$dead);

        // New adventure duration
        $short = rand($engine->hero->adv_short[0], $engine->hero->adv_short[1]);
        $long = rand($engine->hero->adv_long[0], $engine->hero->adv_long[1]);
        query("UPDATE `{$engine->server->prefix}hero` SET `advShort`=?,`advLong`=?  WHERE `owner`=?", [$short, $long, $pt['uid']]);

        // Check for level up

        if (!$dead) {
            // Return hero to home village
            query("UPDATE `{$engine->server->prefix}troop_move` SET `from`=?,`to`=?,`start`=?,`end`=?,`type`=?,`data`=?  WHERE `id`=?", [$data['to'], $data['from'], time(), time() + $duration, 27, ($res !== null) ? json_encode($res) : '', $data['id']]);
        } else {
            // Remove movement
            query("DELETE FROM `{$engine->server->prefix}troop_move` WHERE `id`=?;", [$data['id']]);
        }

        // Prepare data & create new report
        $source = [
            'troopId' => $data['unit'],
            'tribeId' => $pt['tribe'],
            'playerId' => $pt['uid'],
            'playerName' => $pt['username'],
            'villageId' => $vt['villageId'],
            'villageName' => $vt['name'],
        ];
        $target = [];
        $detail = [
            'neededRights' => 0,
            'xp' => $xp,
            'hp' => $hp,
            'won' => $dead ? false : true,
            'loot' => $rewards,
        ];
        $modules = ['attacker' => [], 'defender' => [], 'support' => [], 'sum' => []];
        $reportId = $engine->report->add(3, $pt['uid'], $source, $target, $detail, $modules);
        $engine->notification->add($pt['uid'], 21, $reportId, 'movement_adventure_medium_flat_black');

        // Send Data Back
        $engine->auto->emitCache($pt['uid'], $this->get($vt['villageId']));
        $engine->auto->emitCache($pt['uid'], $engine->unit->getStay($vt['villageId']));
        $engine->auto->emitCache($pt['uid'], $engine->hero->get($pt['uid']));
        $engine->auto->emitCache($pt['uid'], $engine->quest->get('', $pt['uid']));
    }

    public function settle($data) {
        global $engine;

        // Get important data
        $wid = $data['to'];
        $uid = $engine->account->getByVillage($data['from'], 'uid');
        $username = $engine->account->getByVillage($data['from'], 'username');

        // Create New village
        $engine->village->createVillage($uid, $username, $wid);
        $engine->auto->procRes($wid);
        query("UPDATE `{$engine->server->prefix}village` SET `settled`=?, `expandedfrom`=?,`capitel`=? WHERE `wid`=?", [time(), $data['from'], 0, $wid]);
        // Send data of new village
        $engine->auto->emitCache($uid, $engine->building->getQueue($wid));
        $engine->auto->emitCache($uid, $engine->building->getBuildings($wid));
        $engine->auto->emitCache($uid, $engine->village->get($wid));
        $engine->auto->emitCache($uid, $engine->unit->getStay($wid));
        $engine->auto->emitCache($uid, $engine->account->getAjax($uid));
        $engine->auto->emitCache($uid, array(
            'name' => 'Collection:Village:own',
            'data' => array(
                'cache' => $engine->village->getAll($uid),
                'operation' => 1,
            ),
        ));
        $engine->auto->emitCache($uid, array(
            "name" => "MapDetails:" . $wid,
            "data" => $engine->world->getMapDetail($wid)
        ));
        $engine->auto->emitEvent([
            "name" => "mapChanged",
            "data" => $wid,
        ]);
        $engine->auto->emitEvent([
            "name" => "invalidateCache",
            "data" => "MapDetails:{$wid}",
        ]);

        // Delete movement data and send new data
        query("DELETE FROM `{$engine->server->prefix}troop_move` WHERE `id`=?", [$data['id']]);
        query("DELETE FROM `{$engine->server->prefix}units` WHERE `id`=?", [$data['unit']]);
        $engine->auto->emitCache($uid, $this->get($data['from']));
    }

}
