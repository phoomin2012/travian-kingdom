<?php

/*
 * Develop by Phumin Chanthalert from Thailand
 * Facebook : http://fb.com/phoomin2012
 * Tel. : 091-8585234 (Thai mobile)
 * Copy Rigth © Phumin Chanthalert.
 */

class Building {

    private $html = "";
    public $data = null;
    public $buildArray = null;

    public function getQueue($id = null) {
        global $engine;
        if ($id == null) {
            $id = $engine->village->select;
        }
        $v = query("SELECT * FROM `{$engine->server->prefix}village` WHERE `wid`=?", array($id))->fetch(PDO::FETCH_ASSOC);
        $p = query("SELECT * FROM `{$engine->server->prefix}user` WHERE `uid`=?", array($v['owner']))->fetch(PDO::FETCH_ASSOC);
        $b1 = query("SELECT * FROM `{$engine->server->prefix}building` WHERE `wid`=? AND `queue`=? ORDER BY `sort` ASC;", array($id, 1))->fetchAll(PDO::FETCH_ASSOC);
        $b2 = query("SELECT * FROM `{$engine->server->prefix}building` WHERE `wid`=? AND `queue`=? ORDER BY `sort` ASC;", array($id, 2))->fetchAll(PDO::FETCH_ASSOC);
        $b4 = query("SELECT * FROM `{$engine->server->prefix}building` WHERE `wid`=? AND `queue`=? ORDER BY `paid` DESC,`sort` ASC;", array($id, 4))->fetchAll(PDO::FETCH_ASSOC);
        $b5 = query("SELECT * FROM `{$engine->server->prefix}building` WHERE `wid`=? AND `queue`=? ORDER BY `sort` ASC;", array($id, 5))->fetchAll(PDO::FETCH_ASSOC);
        $b1n = array();
        $b2n = array();
        $b4n = array();
        $b5n = array();
        foreach ($b1 as $key => $value) {
            $b1n[count($b1n)] = $this->makeQueue($value);
        }
        foreach ($b2 as $key => $value) {
            $b2n[count($b2n)] = $this->makeQueue($value);
        }
        foreach ($b4 as $key => $value) {
            $b4n[count($b4n)] = $this->makeQueue($value);
        }
        foreach ($b5 as $key => $value) {
            $b5n[count($b5n)] = $this->makeQueue($value);
        }

        $r = array(
            'name' => 'BuildingQueue:' . $id,
            'data' =>
            array(
                'villageId' => $id,
                'tribeId' => $p['tribe'],
                'freeSlots' => array(
                    1 => 1 - count($b1n),
                    2 => 1 - count($b2n),
                    4 => 1 + $p['master'] - count($b4n),
                ),
                'queues' => array(
                    1 => $b1n,
                    2 => $b2n,
                    4 => $b4n,
                    5 => $b5n,
                ),
                'canUseInstantConstruction' => false,
                'canUseInstantConstructionOnlyInVillage' => false,
            ),
        );
        return $r;
    }

    public function getSingleQueue($id) {
        global $engine;

        return query("SELECT * FROM `{$engine->server->prefix}building` WHERE `id`=?;", array($id))->fetch(PDO::FETCH_ASSOC);
    }

    private function makeQueue($data) {
        global $engine;

        $f = query("SELECT * FROM `{$engine->server->prefix}field` WHERE `wid`=?", [$data['wid']])->fetchAll(PDO::FETCH_ASSOC);
        $inq = query("SELECT * FROM `{$engine->server->prefix}building` WHERE `wid`=? AND `location`=? AND `type`=?;", [$data['wid'], $data['location'], $data['type']])->rowCount();

        return array(
            "id" => $data['id'],
            "villageId" => $data['wid'],
            "locationId" => $data['location'],
            "buildingType" => $data['type'],
            "isRubble" => 0,
            "paid" => $data['paid'],
            "queueType" => $data['queue'],
            "timeStart" => $data['start'],
            "finished" => $data['timestamp'],
            "waiting" => false
        );
    }

    public function inQueue($wid, $type, $location = null) {
        global $engine;
        if ($location === null) {
            return query("SELECT * FROM `{$engine->server->prefix}building` WHERE `wid`=? AND `type`=?;", array($wid, $type))->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return query("SELECT * FROM `{$engine->server->prefix}building` WHERE `wid`=? AND `location`=? AND `type`=?;", array($wid, $location, $type))->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function getBuildings($id) {
        global $engine;
        $v = query("SELECT * FROM `{$engine->server->prefix}village` WHERE `wid`=?", array($id))->fetch(PDO::FETCH_ASSOC);
        $p = query("SELECT * FROM `{$engine->server->prefix}user` WHERE `uid`=?", array($v['owner']))->fetch(PDO::FETCH_ASSOC);
        $b = query("SELECT * FROM `{$engine->server->prefix}field` WHERE `wid`=?", array($id))->fetchAll(PDO::FETCH_ASSOC);
        $ba = array();
        for ($i = 0; $i < count($b); $i++) {
            $ba[count($ba)] = $this->makeDetail($b[$i]['id'], $id, $b[$i]['location'], $b[$i]['type'], $b[$i]['level']);
        }
        $r = array(
            'name' => 'Collection:Building:' . $id,
            'data' => array(
                'operation' => 1,
                'cache' => $ba
            )
        );
        return $r;
    }

    public function getBuilding($option) {
        global $engine;
        if (isset($option['id'])) {
            $b = query("SELECT * FROM `{$engine->server->prefix}field` WHERE `id`=?", array($option['id']))->fetch(PDO::FETCH_ASSOC);
        } else {
            $b = query("SELECT * FROM `{$engine->server->prefix}field` WHERE `wid`=? AND `location`=?", array($option['wid'], $option['location']))->fetch(PDO::FETCH_ASSOC);
        }
        return $this->makeDetail($b['id'], $b['wid'], $b['location'], $b['type'], $b['level']);
    }

    public function makeDetail($id, $wid, $location, $type, $level, $option = array(), $status = 0) {
        global $engine;

        $queue = query("SELECT * FROM `{$engine->server->prefix}building` WHERE `wid`=? AND `location`=? AND `type`=?;", [$wid, $location, $type])->rowCount();
        $max = $this->getMax($wid, $type);
        $cat = 1;
        $cat1 = array(10, 11, 15, 17, 18, 23);
        $cat2 = array(16, 19, 22, 33);
        $cat3 = array(1, 2, 3, 4);
        $cat4 = array(15);
        if (in_array($type, $cat1)) {
            $cat = 1;
        } elseif (in_array($type, $cat2)) {
            $cat = 2;
        } elseif (in_array($type, $cat3)) {
            $cat = 3;
        } elseif (in_array($type, $cat4)) {
            $cat = 4;
        } else {
            $cat = 1;
        }

        $return = array(
            'name' => 'Building:' . $id,
            'data' => array(
                'buildingType' => $type,
                'villageId' => $wid,
                'locationId' => $location,
                'lvl' => $level,
                'lvlNext' => $level + 1 + $queue,
                'isMaxLvl' => $this->isMax($wid, $location, $type, $level),
                'lvlMax' => $max,
                'upgradeCosts' => array(),
                'upgradeTime' => 0,
                'nextUpgradeCosts' => array(),
                'nextUpgradeTimes' => array(),
                'upgradeSupplyUsage' => 0,
                'upgradeSupplyUsageSums' => array(),
                'category' => $cat,
                'sortOrder' => 15,
                'effect' => array(),
            ),
        );
        $f = query("SELECT * FROM `{$engine->server->prefix}field` WHERE `wid`=? AND `location`=?", array($wid, $location))->fetch(PDO::FETCH_ASSOC);
        if ($location > 18) {
            if ($f['rubble'] == "1" && ($type != 0 && $type != 31 && $type != 32 && $type != 33)) {
                $upgrade = BuildingData::get($type, $f['level']);
                $return['data']['lvl'] = 0;
                $return['data']['lvlNext'] = 1;
                $return['data']['rubbleDismantleTime'] = $upgrade['time'];
                $return['data']['rubble'] = array(1 => $upgrade['wood'], 2 => $upgrade['clay'], 3 => $upgrade['iron'], 4 => $upgrade['crop']);
            }
        }
        /*
         * ค่า $status
         * 0 = สิ่งก่อสร้างปกติ
         * 1 = พื้นที่ก่อสร้าง
         * 2 = ขยะ
         */
        if ($status == 1) {
            $level = 1;
        } elseif ($status == 2) {
            $max = 0;
        }
        if ($level == 0 && $location > 18 && $location != 41) {
            $level = $level - 1;
        }
        $upgrade = BuildingData::get($type, $level + 1);
        $return['data']['upgradeCosts'] = array(1 => $upgrade['wood'], 2 => $upgrade['clay'], 3 => $upgrade['iron'], 4 => $upgrade['crop']);
        $return['data']['upgradeTime'] = round(($upgrade['time'] * ($this->BuildingEffect(15, $this->getTypeLevel($wid, 15)) / 100)) / $engine->server->speed_world);

        // Calculate supply
        $supply = 0;
        for ($i3 = 1; $i3 <= $level; $i3++) {
            $upgrade = BuildingData::get($type, $i3);
            $supply += $upgrade['pop'];
        }
        $return['data']['upgradeSupplyUsage'] = $supply;
        //End

        $upgrade = BuildingData::get($type, $level);
        // Get effect
        $ignore_effect = [13, 16, 18, 22, 24, 25, 26, 40];
        if (!in_array($type, $ignore_effect)) {
            $return['data']['effect'][0] = $upgrade['effect'];
        }
        //End
        
        for ($i2 = $level; $i2 <= (($level + 7 > $max) ? $max : $level + 7); $i2++) {
            $upgrade = BuildingData::get($type, $i2 + 1);
            if ($upgrade) {
                $return['data']['nextUpgradeCosts'][($status == 1 || $status == 2) ? $i2 - $level : $i2] = array(1 => $upgrade['wood'], 2 => $upgrade['clay'], 3 => $upgrade['iron'], 4 => $upgrade['crop']);
                $return['data']['nextUpgradeTimes'][($status == 1 || $status == 2) ? $i2 - $level : $i2] = round(($upgrade['time'] * ($this->BuildingEffect(15, $this->getTypeLevel($wid, 15)) / 100)) / $engine->server->speed_world);

                // Calculate supply
                $supply = 0;
                for ($i3 = 1; $i3 <= $i2; $i3++) {
                    $upgrade = BuildingData::get($type, $i3);
                    $supply += $upgrade['pop'];
                }
                $return['data']['upgradeSupplyUsageSums'][($status == 1 || $status == 2) ? $i2 - $level : $i2] = $supply;
                //End

                $upgrade = BuildingData::get($type, $i2);
                // Get effect
                if (!in_array($type, $ignore_effect)) {
                    if ($type == 1 || $type == 2 || $type == 3 || $type == 4) {
                        $return['data']['effect'][$i2 - $level] = round($upgrade['effect']) * $engine->server->speed_world;
                    } else {
                        $return['data']['effect'][$i2 - $level] = round($upgrade['effect']);
                    }
                }
                //End
            }
        }

        foreach ($option as $key => $value) {
            $return['data'][$key] = $option[$key];
        }
        if ($status == 1) {
            return $return['data'];
        } else {
            return $return;
        }
    }

    public function createBuilding($wid, $location, $type, $level = 1) {
        global $engine;
        query("INSERT INTO `{$engine->server->prefix}field` (`type`,`wid`,`location`,`level`) VALUES (?,?,?,?)", [$type, $wid, $location, $level]);
    }

    public function setBuilding($wid, $location, $type, $level = 1, $rubble = false) {
        global $engine;
        query("UPDATE `{$engine->server->prefix}field` SET `type`=?,`level`=?,`rubble`=? WHERE `wid`=? AND `location`=?;", [$type, $level, $rubble ? 1 : 0, $wid, $location]);
    }

    public function getAllBuildlist($vid = null) {
        global $engine;
        $return = array();

        $q = query("SELECT * FROM `{$engine->server->prefix}village` WHERE `owner`=?;", array($engine->session->data->uid));
        $data = $q->fetchAll(PDO::FETCH_ASSOC);
        for ($i = 0; $i < $q->rowCount(); $i += 1) {
            $b = query("SELECT * FROM `{$engine->server->prefix}building` WHERE `wid`=? ORDER BY `timestamp` ASC;", array($data[$i]['wid']));
            if ($b->rowCount() == 0) {
                $return[$i] = array();
            } else {
                $this->buildArray = $b->fetchAll(PDO::FETCH_ASSOC);
                $return[$i] = $this->buildArray;
            }
        }
        if ($vid == null) {
            return $return;
        } else {
            return $return;
        }
    }

    public function cancelBuild($id) {
        global $engine;
        $b = query("SELECT * FROM `{$engine->server->prefix}building` WHERE `id`=?", [$id])->fetch(PDO::FETCH_ASSOC);
        $f = query("SELECT * FROM `{$engine->server->prefix}field` WHERE `wid`=? AND `location`=?", [$b['wid'], $b['location']])->fetch(PDO::FETCH_ASSOC);
        if ($b['paid'] == 1) {
            $request = BuildingData::get($b['type'], $f['level'] + 1);
            $request['wood'] *= 1;
            $request['clay'] *= 1;
            $request['iron'] *= 1;
            $request['crop'] *= 1;
            if (($f['level'] == 1 || $f['level'] == 0) && $b['location'] > 18 && $location != 41) {
                query("UPDATE `{$engine->server->prefix}field` SET `type`=? WHERE `wid`=? AND `location`=?", array(0, $b['wid'], $b['location']));
            }
            query("UPDATE `{$engine->server->prefix}village` SET `wood`=`wood`+?,`clay`=`clay`+?,`iron`=`iron`+?,`crop`=`crop`+? WHERE `wid`=?", array($request['wood'], $request['clay'], $request['iron'], $request['crop'], $b['wid']));
        }
        query("UPDATE `{$engine->server->prefix}building` SET `sort`=`sort`-1 WHERE `wid`=? AND `sort`>=?", [$b['wid'], $b['sort']]);
        if (query("DELETE FROM `{$engine->server->prefix}building` WHERE `id`=?", array($id))) {
            return true;
        } else {
            return false;
        }
    }

    public function shiftMasterBuild($wid, $from, $to) {
        global $engine;
        $bq_from = query("SELECT * FROM `{$engine->server->prefix}building` WHERE `wid`=? AND `sort`=?", [$wid, $from + 1])->fetch(PDO::FETCH_ASSOC);
        $bq_to = query("SELECT * FROM `{$engine->server->prefix}building` WHERE `wid`=? AND `sort`=?", [$wid, $to + 1])->fetch(PDO::FETCH_ASSOC);

        query("UPDATE `{$engine->server->prefix}building` SET `sort`=? WHERE `id`=?", [$to + 1, $bq_from['id']]);
        query("UPDATE `{$engine->server->prefix}building` SET `sort`=? WHERE `id`=?", [$from + 1, $bq_to['id']]);
    }

    public function MasterBuild($location, $type = 0, $wid = 0) {
        global $engine;
        if ($wid == 0) {
            $wid = $engine->village->select;
        }
        $field = query("SELECT * FROM `{$engine->server->prefix}field` WHERE `wid`=? AND `location`=?", array($wid, $location))->fetch(PDO::FETCH_ASSOC);
        if ($type == 0) {
            $type = $field['type'];
        }
        if ($location == 32) {
            $type = 16;
        } elseif ($location == 33) {
            $type = 30 + $engine->session->data->tribe;
        }
        if ($type == 16) {
            $location = 32;
        } elseif ($type == 30 + $engine->session->data->tribe) {
            $location = 33;
        }
        $level = $field['level'] + 1;
        $intask_same = query("SELECT * FROM `{$engine->server->prefix}building` WHERE `wid`=? AND `location`=?;", array($wid, $location))->rowCount();
        $level = $level + $intask_same;
        $queuetype = 4;

        $request = BuildingData::get($type, $level);
        if (($engine->village->current['wood'] - $request['wood'] >= 0) && ($engine->village->current['clay'] - $request['clay'] >= 0) && ($engine->village->current['iron'] - $request['iron'] >= 0) && ($engine->village->current['crop'] - $request['crop'] >= 0)) {
            //Paid cost construction
            $request['time'] = round(($request['time'] * ($this->BuildingEffect(15, $this->getTypeLevel($wid, 15)) / 100)) / $engine->server->speed_world);
            $duration = $request['time'];
            query("UPDATE `{$engine->server->prefix}village` SET `wood`=`wood`-?,`clay`=`clay`-?,`iron`=`iron`-?,`crop`=`crop`-? WHERE `wid`=?", array($request['wood'], $request['clay'], $request['iron'], $request['crop'], $wid));
            query("UPDATE `{$engine->server->prefix}field` SET `type`=? WHERE `wid`=? AND `location`=?", array($type, $wid, $location));
            // Get queue to sort new task
            $inqueue_paid = query("SELECT * FROM `{$engine->server->prefix}building` WHERE `wid`=? AND `paid`=?;", [$wid, 1])->rowCount();
            query("UPDATE `{$engine->server->prefix}building` SET `sort`=`sort`+1 WHERE `wid`=? AND `paid`=?", [$wid, 0]);
            // Resort task queue
            //query("UPDATE `{$engine->server->prefix}building` SET `sort`=`sort`+1 WHERE `wid`=? AND `sort`<? AND `paid`=?", [$bq['wid'], $bq['sort'], 0]);
            //$inqueue_paid = query("SELECT * FROM `{$engine->server->prefix}building` WHERE `wid`=? AND `paid`=?;", [$bq['wid'], 1])->rowCount();
            //query("UPDATE `{$engine->server->prefix}building` SET `sort`=?,`paid`=? WHERE `id`=?", [$inqueue_paid + 1, 1, $bid]);

            query("INSERT INTO `{$engine->server->prefix}building` (`wid`,`location`,`sort`,`type`,`queue`,`paid`,`duration`,`cost`,`timestamp`) VALUE (?,?,?,?,?,?,?,?,?);", array($wid, $location, $inqueue_paid + 1, $type, $queuetype, 1, $duration, "[]", 0));
        } else {
            //Only add to queue
            $request['time'] = round(($request['time'] * ($this->BuildingEffect(15, $this->getTypeLevel($wid, 15)) / 100)) / $engine->server->speed_world);
            $duration = $request['time'];
            $cost = json_encode($request);
            query("UPDATE `{$engine->server->prefix}field` SET `type`=? WHERE `wid`=? AND `location`=?", array($type, $wid, $location));
            // Get queue to sort new task
            $inqueue = query("SELECT * FROM `{$engine->server->prefix}building` WHERE `wid`=?;", [$wid])->rowCount();
            query("INSERT INTO `{$engine->server->prefix}building` (`wid`,`location`,`sort`,`type`,`queue`,`paid`,`duration`,`cost`,`timestamp`) VALUE (?,?,?,?,?,?,?,?,?);", array($wid, $location, $inqueue + 1, $type, $queuetype, 0, $duration, $cost, 0));
        }
        return $engine->sql->lastInsertId();
    }

    public function StartBuild($location, $type = 0, $wid = 0) {
        global $engine;
        if ($wid == 0) {
            $wid = $engine->village->select;
        }
        $owner = $engine->account->getByVillage($wid);
        $field = query("SELECT * FROM `{$engine->server->prefix}field` WHERE `wid`=? AND `location`=?", array($wid, $location))->fetch(PDO::FETCH_ASSOC);
        if ($type == 0) {
            $type = $field['type'];
        }
        if ($location == 32) {
            $type = 16;
        }
        if ($location == 33) {
            $type = 30 + $owner['tribe'];
        }
        if ($field['rubble'] == 1 && ($type != 31 && $type != 32 && $type != 33)) {
            $queuetype = 5;
            $request = BuildingData::get($type, 0);
            $start = time();
            $time = time() + $request['time'];
            query("INSERT INTO `{$engine->server->prefix}building` (`wid`,`location`,`type`,`timestamp`,`start`,`queue`,`paid`) VALUE (?,?,?,?,?,?,?);", array($wid, $location, $type, $time, $start, $queuetype, 1));
            return true;
        } else {
            $level = $field['level'] + 1;
            $start = time();
            $request = BuildingData::get($type, $level);
            $time = round(($request['time'] * ($this->BuildingEffect(15, $this->getTypeLevel($wid, 15)) / 100)) / $engine->server->speed_world);
            //}
            $time += time();
            $request = BuildingData::get($type, $level);
            $request['time'] = round(($request['time'] * ($this->BuildingEffect(15, $this->getTypeLevel($wid, 15)) / 100)) / $engine->server->speed_world);
            $duration = $request['time'];

            if ($location >= 1 && $location <= 18) {
                $queuetype = 2;
            } else {
                $queuetype = 1;
            }

            $engine->auto->procRes($wid);
            $v = query("SELECT * FROM `{$engine->server->prefix}village` WHERE `wid`=?", [$wid])->fetch(PDO::FETCH_ASSOC);
            if (($v['wood'] - $request['wood'] >= 0) && ($v['clay'] - $request['clay'] >= 0) && ($v['iron'] - $request['iron'] >= 0) && ($v['crop'] - $request['crop'] >= 0)) {
                query("UPDATE `{$engine->server->prefix}village` SET `wood`=`wood`-?,`clay`=`clay`-?,`iron`=`iron`-?,`crop`=`crop`-? WHERE `wid`=?", array($request['wood'], $request['clay'], $request['iron'], $request['crop'], $wid));
                query("UPDATE `{$engine->server->prefix}field` SET `type`=? WHERE `wid`=? AND `location`=?", array($type, $wid, $location));
                query("INSERT INTO `{$engine->server->prefix}building` (`wid`,`location`,`type`,`timestamp`,`start`,`queue`,`paid`,`duration`) VALUE (?,?,?,?,?,?,?,?);", array($wid, $location, $type, $time, $start, $queuetype, 1, $duration));

                return true;
            } else {
                return false;
            }
        }
    }

    public function getTreasuryTransformations() {
        global $engine;

        $vs = query("SELECT * FROM `{$engine->server->prefix}village` WHERE `area`>? AND `owner`=?;", [0, $engine->session->data->uid])->fetchAll();
        $r = [];
        foreach ($vs as $v) {
            array_push($r, [
                "villageId" => $v['wid'],
                "finished" => $v['area']
            ]);
        }
        return $r;
    }

    public function BuildingEffect($type, $level) {
        global $engine;
        $effect = BuildingData::get($type, $level);
        if ($level == 0) {
            if ($type == 15) {
                $effect = array('effect' => 100);
            }
        }
        return $effect['effect'];
    }

    public function isMax($wid, $location, $type, $level = null) {
        global $engine;
        $q = query("SELECT * FROM `{$engine->server->prefix}building` WHERE `wid`=? AND `location`=? AND `type`=?;", [$wid, $location, $type]);
        $loop = $q->rowCount();
        if ($level === null) {
            $field = $q->fetch(PDO::FETCH_ASSOC);
            $type = $field['type'];
            $level = $field['type'];
        }
        $dataarray = BuildingData::get($type);
        $village = $engine->village->get($wid, false);
        //var_dump([$type, $village['isMainVillage'], $level, $loop, (count($dataarray) - 1)]);exit();
        if ($type <= 4) {
            if ($village['isMainVillage']) {
                return ($level + $loop >= (count($dataarray) - 1 ));
            } else {
                return ($level + $loop >= (count($dataarray) - 11));
            }
        } else {
            return ($level + $loop >= count($dataarray) - 1);
        }
    }

    public function getMax($wid, $type) {
        global $engine;
        $dataarray = BuildingData::get($type);
        $village = $engine->village->get($wid, false);
        if ($type <= 4) {
            if ($village['isMainVillage'] == 1) {
                return (count($dataarray) - 1);
            } elseif ($village['isMainVillage'] == 0) {
                return (count($dataarray) - 11);
            }
        } else {
            return count($dataarray) - 1;
        }
    }

    public function getTypeLevel($wid, $type) {
        global $engine;
        $a = query("SELECT * FROM `{$engine->server->prefix}field` WHERE `wid`=? AND `type`=?;", array($wid, $type))->fetchAll(PDO::FETCH_ASSOC);
        $c = 0;
        foreach ($a as $b) {
            $b['level'] > $c ? $c = $b['level'] : '';
        }
        return $c;
    }

    public function getLocation($wid, $type) {
        global $engine;
        $a = query("SELECT * FROM `{$engine->server->prefix}field` WHERE `wid`=? AND `type`=?;", array($wid, $type))->fetchAll(PDO::FETCH_ASSOC);
        $r = [];
        foreach ($a as $b) {
            array_push($r, $b['location']);
        }
        return $r;
    }

    public function destroy($params) {
        global $engine;
        $wid = $params['villageId'];
        $location = $params['locationId'];
        $field = query("SELECT * FROM `{$engine->server->prefix}field` WHERE `wid`=? AND `location`=?;", array($wid, $location))->fetch(PDO::FETCH_ASSOC);
        $type = $field['type'];
        $level = $field['level'];
        $uppertime = BuildingData::get($type, $level);
        $start = time();
        $duration = ($uppertime['time'] / 2) / $engine->server->speed_world;
        $time = $start + $duration;

        query("INSERT INTO `{$engine->server->prefix}building` (`wid`,`location`,`type`,`timestamp`,`start`,`level`,`queue`,`paid`,`duration`) VALUE (?,?,?,?,?,?,?,?,?);", array($wid, $location, $type, $time, $start, $level, 5, 0, $duration));
    }

    public function reserveResources($bid) {
        global $engine;

        $bq = query("SELECT * FROM `{$engine->server->prefix}building` WHERE `id`=?", array($bid))->fetch(PDO::FETCH_ASSOC);
        $f = query("SELECT * FROM `{$engine->server->prefix}field` WHERE `wid`=? AND `location`=?", array($bq['wid'], $bq['location']))->fetch(PDO::FETCH_ASSOC);

        $request = BuildingData::get($bq['type'], $bq['level']);
        $engine->auto->procRes($bq['wid']);

        $v = $engine->village->getById($bq['wid']);
        if ($v['wood'] >= $request['wood'] && $v['clay'] >= $request['clay'] && $v['iron'] >= $request['iron'] && $v['crop'] >= $request['crop']) {
            query("UPDATE `{$engine->server->prefix}village` SET `wood`=`wood`-?,`clay`=`clay`-?,`iron`=`iron`-?,`crop`=`crop`-? WHERE `wid`=?", [$request['wood'], $request['clay'], $request['iron'], $request['crop'], $bq['wid']]);
            // Resort task queue
            query("UPDATE `{$engine->server->prefix}building` SET `sort`=`sort`+1 WHERE `wid`=? AND `sort`<? AND `paid`=?", [$bq['wid'], $bq['sort'], 0]);
            $inqueue_paid = query("SELECT * FROM `{$engine->server->prefix}building` WHERE `wid`=? AND `paid`=?;", [$bq['wid'], 1])->rowCount();
            query("UPDATE `{$engine->server->prefix}building` SET `sort`=?,`paid`=? WHERE `id`=?", [$inqueue_paid + 1, 1, $bid]);
        }
    }

    public function getBuildable($wid, $id) {
        global $engine;
        $buildable = array();
        $notBuildable = array();

        $artEffGrt = 0;
        $village = $engine->village->get($wid, false);

        $twall = 32;
        if ($engine->session->data->tribe <= 3) {
            $twall = $engine->session->data->tribe + 30;
        }

        $woodcutter = $this->getTypeLevel($wid, 1);
        $claypit = $this->getTypeLevel($wid, 2);
        $ironmine = $this->getTypeLevel($wid, 3);
        $cropland = $this->getTypeLevel($wid, 4);
        $sawmill = $this->getTypeLevel($wid, 5);
        $brickyard = $this->getTypeLevel($wid, 6);
        $ironfoundry = $this->getTypeLevel($wid, 7);
        $grainmill = $this->getTypeLevel($wid, 8);
        $bakery = $this->getTypeLevel($wid, 9);
        $warehouse = $this->getTypeLevel($wid, 10);
        $granary = $this->getTypeLevel($wid, 11);
        $blacksmith = $this->getTypeLevel($wid, 13);
        $tournamentsquare = $this->getTypeLevel($wid, 14);
        $mainbuilding = $this->getTypeLevel($wid, 15);
        $rallypoint = $this->getTypeLevel($wid, 16);
        $market = $this->getTypeLevel($wid, 17);
        $embassy = $this->getTypeLevel($wid, 18);
        $barrack = $this->getTypeLevel($wid, 19);
        $stable = $this->getTypeLevel($wid, 20);
        $workshop = $this->getTypeLevel($wid, 21);
        $academy = $this->getTypeLevel($wid, 22);
        $cranny = $this->getTypeLevel($wid, 23);
        $townhall = $this->getTypeLevel($wid, 24);
        $residence = $this->getTypeLevel($wid, 25);
        $palace = $this->getTypeLevel($wid, 26);
        $treasury = $this->getTypeLevel($wid, 27);
        $tradeoffice = $this->getTypeLevel($wid, 28);
        $greatbarracks = $this->getTypeLevel($wid, 29);
        $greatstable = $this->getTypeLevel($wid, 30);
        $wall = $this->getTypeLevel($wid, $twall); //31, 32, 33
        $stonemasonslodge = $this->getTypeLevel($wid, 34);
        $brewery = $this->getTypeLevel($wid, 35);
        $trapper = $this->getTypeLevel($wid, 36);
        $greatwarehouse = $this->getTypeLevel($wid, 38);
        $greatgranary = $this->getTypeLevel($wid, 39);
        $wonderworld = $this->getTypeLevel($wid, 40);
        $horsedrinkingtrough = $this->getTypeLevel($wid, 41);
        $waterdutch = $this->getTypeLevel($wid, 42);
        $naterwall = $this->getTypeLevel($wid, 43);
        $teahouse = $this->getTypeLevel($wid, 44);
        $hiddentreasury = $this->getTypeLevel($wid, 45);

        $hasPalaceAnywhere = 0; //$this->hasPalaceAnywhere();
        $hasWW = 0;

        if ($mainbuilding == 0 && !$this->inQueue($wid, 15) && $id != 32 && $id != 33) {

            $b = $this->makeDetail(0, $wid, $id, 15, 0, array(
                'requiredBuildings' => array(
                    array(
                        'buildingType' => 15,
                        'currentLevel' => $mainbuilding,
                        'requiredLevel' => 1,
                        'valid' => ($mainbuilding >= 1)
                    )
                )), true, 1);
            if ($mainbuilding >= 1) {
                $buildable[count($buildable)] = $b;
            } else {
                $notBuildable[count($notBuildable)] = $b;
            }
        }
        if ((($cranny == 0 && !$this->inQueue($wid, 23)) || $cranny == 10) && $mainbuilding >= 1 && $id != 32 && $id != 33) {
            if ($cranny == 10) {
                $option = array(
                    'requiredBuildings' => array(
                        array(
                            'buildingType' => 23,
                            'currentLevel' => $cranny,
                            'requiredLevel' => 10,
                            'valid' => ($cranny >= 10)
                        )
                ));
            } else {
                $option = array('requiredBuildings' => array());
            }
            $buildable[count($buildable)] = $this->makeDetail(0, $wid, $id, 23, 0, $option, true, 1);
        }
        if ((($granary == 0 && !$this->inQueue($wid, 11)) || $granary == 20) && $mainbuilding >= 1 && $id != 32 && $id != 33) {
            if ($granary == 20) {
                $option = array(
                    'requiredBuildings' => array(
                        array(
                            'buildingType' => 11,
                            'currentLevel' => $granary,
                            'requiredLevel' => 20,
                            'valid' => ($granary >= 20)
                        ),
                        array(
                            'buildingType' => 15,
                            'currentLevel' => $mainbuilding,
                            'requiredLevel' => 1,
                            'valid' => ($mainbuilding >= 1)
                        )
                ));
            } else {
                $option = array('requiredBuildings' => array());
            }
            $buildable[count($buildable)] = $this->makeDetail(0, $wid, $id, 11, 0, $option, true, 1);
        }
        if ($wall == 0 && !$this->inQueue($wid, 32)) {
            if ($engine->session->data->tribe == 1 && $id != 32) {
                $buildable[count($buildable)] = $this->makeDetail(0, $wid, $id, 31, 0, array('requiredBuildings' => array()), true, 1);
            }
            if ($engine->session->data->tribe == 2 && $id != 32) {
                $buildable[count($buildable)] = $this->makeDetail(0, $wid, $id, 32, 0, array('requiredBuildings' => array()), true, 1);
            }
            if ($engine->session->data->tribe == 3 && $id != 32) {
                $buildable[count($buildable)] = $this->makeDetail(0, $wid, $id, 33, 0, array('requiredBuildings' => array()), true, 1);
            }
            if ($engine->session->data->tribe == 4 && $id != 32) {
                $buildable[count($buildable)] = $this->makeDetail(0, $wid, $id, 33, 0, array('requiredBuildings' => array()), true, 1);
            }
            if ($engine->session->data->tribe == 5 && $id != 32) {
                $buildable[count($buildable)] = $this->makeDetail(0, $wid, $id, 33, 0, array('requiredBuildings' => array()), true, 1);
            }
        }
        if ((($warehouse == 0 && !$this->inQueue($wid, 10)) || $warehouse == 20) && $id != 32 && $id != 33) {
            if ($warehouse == 20) {
                $option = array(
                    'requiredBuildings' => array(
                        array(
                            'buildingType' => 10,
                            'currentLevel' => $warehouse,
                            'requiredLevel' => 20,
                            'valid' => ($warehouse >= 20)
                        )
                ));
            } else {
                $option = array('requiredBuildings' => array(
                        array(
                            'buildingType' => 15,
                            'currentLevel' => $mainbuilding,
                            'requiredLevel' => 1,
                            'valid' => ($mainbuilding >= 1)
                        )
                ));
            }
            $buildable[count($buildable)] = $this->makeDetail(0, $wid, $id, 10, 0, $option, true, 1);
        }
        if ($mainbuilding >= 10 && ($artEffGrt > 0 || $hasWW == 40) && (($warehouse == 20) || ($greatwarehouse == 20)) && $id != 32 && $id != 33) {

//include("avaliable/greatwarehouse.tpl");
        }
        if ($mainbuilding >= 10 && ($artEffGrt > 0 || $hasWW == 40) && (($granary == 20) || ($greatgranary == 20)) && $id != 32 && $id != 33) {
            //include("avaliable/greatgranary.tpl");
        }
        if (($trapper == 0 || $trapper == 20) && !$this->inQueue($wid, 36) && $rallypoint >= 1 && $engine->session->data->tribe == 3 && $id != 32 && $id != 33) {
            if ($trapper == 20) {
                $option = array(
                    'requiredBuildings' => array(
                        array(
                            'buildingType' => 36,
                            'currentLevel' => $trapper,
                            'requiredLevel' => 20,
                            'valid' => ($trapper >= 20)
                        ),
                        array(
                            'buildingType' => 16,
                            'currentLevel' => $rallypoint,
                            'requiredLevel' => 1,
                            'valid' => ($rallypoint >= 1)
                        )
                ));
            } else {
                $option = array('requiredBuildings' => array(
                        array(
                            'buildingType' => 16,
                            'currentLevel' => $rallypoint,
                            'requiredLevel' => 1,
                            'valid' => ($rallypoint >= 1)
                        )
                ));
            }
            $b = $this->makeDetail(0, $wid, $id, 36, 0, $option, true, 1);
            if (($trapper >= 20 && $rallypoint >= 1) || $trapper == 20) {
                $buildable[count($buildable)] = $b;
            } else {
                $notBuildable[count($notBuildable)] = $b;
            }
        }
        if ($rallypoint == 0 && !$this->inQueue($wid, 16) && $id != 33) {
            $buildable[count($buildable)] = $this->makeDetail(0, $wid, $id, 16, 0, ['requiredBuildings' => []], true);
        }
        if ($embassy == 0 && !$this->inQueue($wid, 18) && $id != 32 && $id != 33) {
            $buildable[count($buildable)] = $this->makeDetail(0, $wid, $id, 18, 0, ['requiredBuildings' => []], true);
        }
        if (!$this->inQueue($wid, 19) && $barrack == 0 && $id != 32 && $id != 33) {
            $b = $this->makeDetail(0, $wid, $id, 19, 0, array(
                'requiredBuildings' => array(
                    array(
                        'buildingType' => 15,
                        'currentLevel' => $mainbuilding,
                        'requiredLevel' => 3,
                        'valid' => ($mainbuilding >= 3)
                    ),
                )), true, 1);
            if ($mainbuilding >= 3) {
                $buildable[count($buildable)] = $b;
            } else {
                $notBuildable[count($notBuildable)] = $b;
            }
        }
        if (!$this->inQueue($wid, 8) && $grainmill == 0 && $id != 32 && $id != 33) {
            $b = $this->makeDetail(0, $wid, $id, 8, 0, array(
                'requiredBuildings' => array(
                    array(
                        'buildingType' => 4,
                        'currentLevel' => $cropland,
                        'requiredLevel' => 5,
                        'valid' => ($cropland >= 5)
                    ),
                )), true, 1);
            if ($cropland >= 5) {
                $buildable[count($buildable)] = $b;
            } else {
                $notBuildable[count($notBuildable)] = $b;
            }
        }
        if (!$this->inQueue($wid, 17) && $market == 0 && $id != 32 && $id != 33) {
            $b = $this->makeDetail(0, $wid, $id, 17, 0, array(
                'requiredBuildings' => array(
                    array(
                        'buildingType' => 15,
                        'currentLevel' => $mainbuilding,
                        'requiredLevel' => 3,
                        'valid' => ($mainbuilding >= 3)
                    ),
                    array(
                        'buildingType' => 10,
                        'currentLevel' => $warehouse,
                        'requiredLevel' => 1,
                        'valid' => ($warehouse >= 1)
                    ),
                    array(
                        'buildingType' => 11,
                        'currentLevel' => $granary,
                        'requiredLevel' => 1,
                        'valid' => ($granary >= 1)
                    )
                )), true, 1);
            if ($mainbuilding >= 3 && $warehouse >= 1 && $granary >= 1) {
                $buildable[count($buildable)] = $b;
            } else {
                $notBuildable[count($notBuildable)] = $b;
            }
        }
        if (!$this->inQueue($wid, 25) && !$this->inQueue($wid, 26) && $residence == 0 && $id != 32 && $id != 33 && $palace == 0) {
            $b = $this->makeDetail(0, $wid, $id, 25, 0, array(
                'requiredBuildings' => array(
                    array(
                        'buildingType' => 15,
                        'currentLevel' => $mainbuilding,
                        'requiredLevel' => 5,
                        'valid' => ($mainbuilding >= 5)
                    ),
                )), true, 1);
            if ($mainbuilding >= 5) {
                $buildable[count($buildable)] = $b;
            } else {
                $notBuildable[count($notBuildable)] = $b;
            }
        }
        if ($academy == 0 && !$this->inQueue($wid, 22) && $id != 32 && $id != 33) {
            $b = $this->makeDetail(0, $wid, $id, 22, 0, array(
                'requiredBuildings' => array(
                    array(
                        'buildingType' => 15,
                        'currentLevel' => $mainbuilding,
                        'requiredLevel' => 3,
                        'valid' => ($mainbuilding >= 3)
                    ),
                    array(
                        'buildingType' => 19,
                        'currentLevel' => $barrack,
                        'requiredLevel' => 3,
                        'valid' => ($barrack >= 3)
                    ),
                )), true, 1);
            if ($mainbuilding >= 3 && $barrack >= 3) {
                $buildable[count($buildable)] = $b;
            } else {
                $notBuildable[count($notBuildable)] = $b;
            }
        }
        if ($hasWW != 40 && $palace == 0 && !$this->inQueue($wid, 26) && !$this->inQueue($wid, 25) && !$hasPalaceAnywhere && $id != 32 && $id != 33 && $residence == 0) {
            $b = $this->makeDetail(0, $wid, $id, 26, 0, array(
                'requiredBuildings' => array(
                    array(
                        'buildingType' => 15,
                        'currentLevel' => $mainbuilding,
                        'requiredLevel' => 5,
                        'valid' => ($mainbuilding >= 5)
                    ),
                    array(
                        'buildingType' => 18,
                        'currentLevel' => $embassy,
                        'requiredLevel' => 5,
                        'valid' => ($embassy >= 1)
                    ),
                )), true, 1);
            if ($mainbuilding >= 5 && $embassy >= 1) {
                $buildable[count($buildable)] = $b;
            } else {
                $notBuildable[count($notBuildable)] = $b;
            }
        }
        if ($blacksmith == 0 && !$this->inQueue($wid, 13) && $academy >= 1 && $mainbuilding >= 3 && $id != 32 && $id != 33) {
            $b = $this->makeDetail(0, $wid, $id, 13, 0, array(
                'requiredBuildings' => array(
                    array(
                        'buildingType' => 15,
                        'currentLevel' => $mainbuilding,
                        'requiredLevel' => 3,
                        'valid' => ($mainbuilding >= 3)
                    ),
                    array(
                        'buildingType' => 22,
                        'currentLevel' => $academy,
                        'requiredLevel' => 1,
                        'valid' => ($academy >= 1)
                    ),
                )), true, 1);
            if ($mainbuilding >= 3 && $academy >= 1) {
                $buildable[count($buildable)] = $b;
            } else {
                $notBuildable[count($notBuildable)] = $b;
            }
        }
        if ($stonemasonslodge == 0 && !$this->inQueue($wid, 34) && $palace >= 3 && $mainbuilding >= 5 && $id != 32 && $id != 33) {
            $b = $this->makeDetail(0, $wid, $id, 34, 0, array(
                'requiredBuildings' => array(
                    array(
                        'buildingType' => 15,
                        'currentLevel' => $mainbuilding,
                        'requiredLevel' => 5,
                        'valid' => ($mainbuilding >= 5)
                    ),
                    array(
                        'buildingType' => 26,
                        'currentLevel' => $palace,
                        'requiredLevel' => 3,
                        'valid' => ($palace >= 3)
                    ),
                )), true, 1);
            if ($mainbuilding >= 5 && $palace >= 3) {
                $buildable[count($buildable)] = $b;
            } else {
                $notBuildable[count($notBuildable)] = $b;
            }
        }
        if ($stable == 0 && !$this->inQueue($wid, 20) && $blacksmith >= 3 && $academy >= 5 && $id != 32 && $id != 33) {
            $b = $this->makeDetail(0, $wid, $id, 20, 0, array(
                'requiredBuildings' => array(
                    array(
                        'buildingType' => 15,
                        'currentLevel' => $blacksmith,
                        'requiredLevel' => 3,
                        'valid' => ($blacksmith >= 3)
                    ),
                    array(
                        'buildingType' => 22,
                        'currentLevel' => $academy,
                        'requiredLevel' => 5,
                        'valid' => ($academy >= 5)
                    ),
                )), true, 1);
            if ($academy >= 5 && $blacksmith >= 3) {
                $buildable[count($buildable)] = $b;
            } else {
                $notBuildable[count($notBuildable)] = $b;
            }
        }
        if ($hasWW != 40 && $treasury == 0 && !$this->inQueue($wid, 27) && $mainbuilding >= 10 && $id != 32 && $id != 33) {
            $buildable[count($buildable)] = $this->makeDetail(0, $wid, $id, 25, 0, array(
                'requiredBuildings' => array(
                    array(
                        'buildingType' => 15,
                        'currentLevel' => $mainbuilding,
                        'requiredLevel' => 10,
                        'valid' => ($mainbuilding >= 10)
                    ),
                )), true, 1);
        }
        if ($brickyard == 0 && !$this->inQueue($wid, 6) && $id != 32 && $id != 33) {
            $b = $this->makeDetail(0, $wid, $id, 6, 0, array(
                'requiredBuildings' => array(
                    array(
                        'buildingType' => 15,
                        'currentLevel' => $mainbuilding,
                        'requiredLevel' => 5,
                        'valid' => ($mainbuilding >= 5)
                    ),
                    array(
                        'buildingType' => 2,
                        'currentLevel' => $claypit,
                        'requiredLevel' => 10,
                        'valid' => ($claypit >= 10)
                    ),
                )), true, 1);
            if ($mainbuilding >= 5 && $claypit >= 10) {
                $buildable[count($buildable)] = $b;
            } else {
                $notBuildable[count($notBuildable)] = $b;
            }
        }
        if ($sawmill == 0 && !$this->inQueue($wid, 5) && $id != 32 && $id != 33) {
            $b = $this->makeDetail(0, $wid, $id, 5, 0, array(
                'requiredBuildings' => array(
                    array(
                        'buildingType' => 15,
                        'currentLevel' => $mainbuilding,
                        'requiredLevel' => 5,
                        'valid' => ($mainbuilding >= 5)
                    ),
                    array(
                        'buildingType' => 1,
                        'currentLevel' => $woodcutter,
                        'requiredLevel' => 10,
                        'valid' => ($woodcutter >= 10)
                    ),
                )), true, 1);
            if ($mainbuilding >= 5 && $woodcutter >= 10) {
                $buildable[count($buildable)] = $b;
            } else {
                $notBuildable[count($notBuildable)] = $b;
            }
        }
        if ($ironfoundry == 0 && !$this->inQueue($wid, 7) && $id != 32 && $id != 33) {
            $b = $this->makeDetail(0, $wid, $id, 7, 0, array(
                'requiredBuildings' => array(
                    array(
                        'buildingType' => 15,
                        'currentLevel' => $mainbuilding,
                        'requiredLevel' => 5,
                        'valid' => ($mainbuilding >= 5)
                    ),
                    array(
                        'buildingType' => 3,
                        'currentLevel' => $ironmine,
                        'requiredLevel' => 10,
                        'valid' => ($ironmine >= 10)
                    ),
                )), true, 1);
            if ($mainbuilding >= 5 && $ironmine >= 10) {
                $buildable[count($buildable)] = $b;
            } else {
                $notBuildable[count($notBuildable)] = $b;
            }
        }
        if ($workshop == 0 && !$this->inQueue($wid, 21) && $id != 32 && $id != 33) {
            $b = $this->makeDetail(0, $wid, $id, 21, 0, array(
                'requiredBuildings' => array(
                    array(
                        'buildingType' => 15,
                        'currentLevel' => $mainbuilding,
                        'requiredLevel' => 5,
                        'valid' => ($mainbuilding >= 5)
                    ),
                    array(
                        'buildingType' => 22,
                        'currentLevel' => $academy,
                        'requiredLevel' => 10,
                        'valid' => ($academy >= 10)
                    ),
                )), true, 1);
            if ($mainbuilding >= 5 && $academy >= 10) {
                $buildable[count($buildable)] = $b;
            } else {
                $notBuildable[count($notBuildable)] = $b;
            }
        }
        if ($tournamentsquare == 0 && !$this->inQueue($wid, 14) && $id != 32 && $id != 33) {
            $b = $this->makeDetail(0, $wid, $id, 6, 0, array(
                'requiredBuildings' => array(
                    array(
                        'buildingType' => 16,
                        'currentLevel' => $rallypoint,
                        'requiredLevel' => 15,
                        'valid' => ($rallypoint >= 15)
                    ),
                )), true, 1);
            if ($rallypoint >= 15) {
                $buildable[count($buildable)] = $b;
            } else {
                $notBuildable[count($notBuildable)] = $b;
            }
        }
        if ($bakery == 0 && !$this->inQueue($wid, 9) && $id != 32 && $id != 33) {
            $b = $this->makeDetail(0, $wid, $id, 9, 0, array(
                'requiredBuildings' => array(
                    array(
                        'buildingType' => 8,
                        'currentLevel' => $grainmill,
                        'requiredLevel' => 5,
                        'valid' => ($grainmill >= 5)
                    ),
                    array(
                        'buildingType' => 15,
                        'currentLevel' => $mainbuilding,
                        'requiredLevel' => 5,
                        'valid' => ($mainbuilding >= 5)
                    ),
                    array(
                        'buildingType' => 4,
                        'currentLevel' => $cropland,
                        'requiredLevel' => 10,
                        'valid' => ($cropland >= 10)
                    ),
                )), true, 1);
            if ($mainbuilding >= 5 && $grainmill >= 5 && $cropland >= 10) {
                $buildable[count($buildable)] = $b;
            } else {
                $notBuildable[count($notBuildable)] = $b;
            }
        }
        if ($townhall == 0 && !$this->inQueue($wid, 24) && $id != 32 && $id != 33) {
            $b = $this->makeDetail(0, $wid, $id, 24, 0, array(
                'requiredBuildings' => array(
                    array(
                        'buildingType' => 15,
                        'currentLevel' => $mainbuilding,
                        'requiredLevel' => 10,
                        'valid' => ($mainbuilding >= 10)
                    ),
                    array(
                        'buildingType' => 22,
                        'currentLevel' => $academy,
                        'requiredLevel' => 10,
                        'valid' => ($academy >= 10)
                    ),
                )), true, 1);
            if ($mainbuilding >= 10 && $academy >= 10) {
                $buildable[count($buildable)] = $b;
            } else {
                $notBuildable[count($notBuildable)] = $b;
            }
        }
        if ($tradeoffice == 0 && !$this->inQueue($wid, 28) && $id != 32 && $id != 33) {
            $b = $this->makeDetail(0, $wid, $id, 28, 0, array(
                'requiredBuildings' => array(
                    array(
                        'buildingType' => 15,
                        'currentLevel' => $market,
                        'requiredLevel' => 20,
                        'valid' => ($market >= 20)
                    ),
                    array(
                        'buildingType' => 20,
                        'currentLevel' => $stable,
                        'requiredLevel' => 10,
                        'valid' => ($stable >= 10)
                    ),
                )), true, 1);
            if ($market >= 20 && $stable >= 10) {
                $buildable[count($buildable)] = $b;
            } else {
                $notBuildable[count($notBuildable)] = $b;
            }
        }
        if ($engine->session->data->tribe == 1 && !$this->inQueue($wid, 41) && $horsedrinkingtrough == 0 && $id != 32 && $id != 33) {
            $b = $this->makeDetail(0, $wid, $id, 41, 0, array(
                'requiredBuildings' => array(
                    array(
                        'buildingType' => 16,
                        'currentLevel' => $rallypoint,
                        'requiredLevel' => 10,
                        'valid' => ($rallypoint >= 10)
                    ),
                    array(
                        'buildingType' => 20,
                        'currentLevel' => $stable,
                        'requiredLevel' => 20,
                        'valid' => ($stable >= 20)
                    ),
                )), true, 1);
            if ($rallypoint >= 10 && $stable >= 20) {
                $buildable[count($buildable)] = $b;
            } else {
                $notBuildable[count($notBuildable)] = $b;
            }
        }
        if ($engine->session->data->tribe == 2 && !$this->inQueue($wid, 35) && $brewery == 0 && $id != 32 && $id != 33) {
            $b = $this->makeDetail(0, $wid, $id, 28, 0, array(
                'requiredBuildings' => array(
                    array(
                        'buildingType' => 11,
                        'currentLevel' => $rallypoint,
                        'requiredLevel' => 20,
                        'valid' => ($rallypoint >= 20)
                    ),
                    array(
                        'buildingType' => 16,
                        'currentLevel' => $granary,
                        'requiredLevel' => 20,
                        'valid' => ($granary >= 20)
                    ),
                )), true, 1);
            if ($rallypoint >= 10 && $granary >= 20) {
                $buildable[count($buildable)] = $b;
            } else {
                $notBuildable[count($notBuildable)] = $b;
            }
        }
        if (!$this->inQueue($wid, 45) && $hiddentreasury == 0 && $id != 32 && $id != 33) {
            $b = $this->makeDetail(0, $wid, $id, 45, 0, array(
                'requiredBuildings' => array(
                    array(
                        'buildingType' => 15,
                        'currentLevel' => $mainbuilding,
                        'requiredLevel' => 3,
                        'valid' => ($mainbuilding >= 3)
                    ),
                )), true, 1);
            if ($mainbuilding >= 3) {
                $buildable[count($buildable)] = $b;
            } else {
                $notBuildable[count($notBuildable)] = $b;
            }
        }
        $barrack = $this->getTypeLevel($wid, 19);
        $stable = $this->getTypeLevel($wid, 20);
        $greatbarracks = $this->getTypeLevel($wid, 29);
        $greatstable = $this->getTypeLevel($wid, 30);
        if ($greatbarracks == 0 && !$this->inQueue($wid, 29) && $barrack == 20 && $village['isMainVillage'] == 0 && $id != 32 && $id != 33) {
            $b = $this->makeDetail(0, $wid, $id, 29, 0, array(
                'requiredBuildings' => array(
                    array(
                        'buildingType' => 19,
                        'currentLevel' => $barrack,
                        'requiredLevel' => 20,
                        'valid' => ($barrack >= 20)
                    ),
                )), true, 1);
            if ($barrack >= 3) {
                $buildable[count($buildable)] = $b;
            } else {
                $notBuildable[count($notBuildable)] = $b;
            }
        }
        if ($greatstable == 0 && !$this->inQueue($wid, 30) && $stable == 20 && $village['isMainVillage'] == 0 && $id != 32 && $id != 33) {
            $b = $this->makeDetail(0, $wid, $id, 30, 0, array(
                'requiredBuildings' => array(
                    array(
                        'buildingType' => 20,
                        'currentLevel' => $stable,
                        'requiredLevel' => 20,
                        'valid' => ($stable >= 20)
                    ),
                )), true, 1);
            if ($stable >= 3) {
                $buildable[count($buildable)] = $b;
            } else {
                $notBuildable[count($notBuildable)] = $b;
            }
        }

        return array(
            'buildings' => array(
                'buildable' => $buildable,
                'notBuildable' => $notBuildable,
            )
        );
    }

}

?>
