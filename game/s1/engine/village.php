<?php

/*
 * Develop by Phumin Chanthalert from Thailand
 * Facebook : http://fb.com/phoomin2012
 * Tel. : 091-8585234 (Thai mobile)
 * Copy Rigth © Phumin Chanthalert.
 */

class Village {

    public $data = null;
    public $select = '';
    public $current = null;

    public function getAll($id, $head = true) {
        global $engine;
        if ($id == "own") {
            $id = $_SESSION[$engine->server->prefix . 'uid'];
        }
        $v = query("SELECT * FROM `" . $engine->server->prefix . "village` WHERE `owner`=?", array($id))->fetchAll(PDO::FETCH_ASSOC);
        $r = array();
        for ($i = 0; $i < count($v); $i++) {
            array_push($r, $this->get($v[$i]['wid'], $head));
        }
        return $r;
    }

    public function getById($id) {
        global $engine;
        $v = query("SELECT * FROM `" . $engine->server->prefix . "village` WHERE `wid`=?", array($id))->fetch(PDO::FETCH_ASSOC);
        return $v;
    }

    public function get($id, $head = true) {
        global $engine;
        $v = query("SELECT * FROM `" . $engine->server->prefix . "village` WHERE `wid`=?", array($id))->fetch(PDO::FETCH_ASSOC);
        $p = query("SELECT * FROM `" . $engine->server->prefix . "user` WHERE `uid`=?", array($v['owner']))->fetch(PDO::FETCH_ASSOC);
        $k = query("SELECT * FROM `" . $engine->server->prefix . "kingdom` WHERE `id`=?", array($p['kingdom']))->fetch(PDO::FETCH_ASSOC);

        $r = array(
            'name' => 'Village:' . $id,
            'data' => array(
                'villageId' => $id,
                'playerId' => $p['uid'],
                'name' => $v['vname'],
                'tribeId' => $p['tribe'],
                'belongsToKing' => $k['king'],
                'belongsToKingdom' => $k['id'],
                'type' => ($v['town'] == 0 ? (($v['capitel'] == 1) ? 1 : 0) : (($v['capitel'] == 1) ? 3 : 2)),
                'population' => $v['pop'],
                'coordinates' => array(
                    'x' => $engine->world->id2xy($v['wid'])[0],
                    'y' => $engine->world->id2xy($v['wid'])[1],
                ),
                'isMainVillage' => ($v['capitel'] == 1) ? true : false,
                'isTown' => ($v['town'] == 0 ? false : true),
                'supplyBuildings' => $v['pop'],
                'supplyTroops' => '0',
                'production' => array(
                    1 => $v['pwood'],
                    2 => $v['pclay'],
                    3 => $v['piron'],
                    4 => $v['pcrop'],
                ),
                'storage' => array(
                    1 => $v['wood'],
                    2 => $v['clay'],
                    3 => $v['iron'],
                    4 => $v['crop'],
                ),
                'treasureResourceBonus' => '0',
                'treasuresUsable' => $engine->building->BuildingEffect(27, $engine->building->getTypeLevel($v['wid'], 27)),
                'treasures' => '0',
                'treasury' => array(
                    1 => '0',
                    2 => '0',
                    3 => '0',
                    4 => '0',
                ),
                'storageCapacity' => array(
                    1 => $v['maxstore'] * (($p['plus'] != 0) ? 1.25 : 1),
                    2 => $v['maxstore'] * (($p['plus'] != 0) ? 1.25 : 1),
                    3 => $v['maxstore'] * (($p['plus'] != 0) ? 1.25 : 1),
                    4 => $v['maxcrop'] * (($p['plus'] != 0) ? 1.25 : 1),
                ),
                'usedControlPoints' => $v['settler_used'],
                'availableControlPoints' => $v['settler'],
                'culturePoints' => $p['cp'],
                'culturePointProduction' => $v['cp'],
                'celebrationType' => '0',
                'celebrationEnd' => '0',
                'acceptance' => 100,
                'acceptanceProduction' => '0.01666',
                'tributes' => array(
                    1 => 0,
                    2 => 0,
                    3 => 0,
                    4 => 0,
                ),
                'tributeCollectorPlayerId' => 0,
                'tributesCapacity' => '800',
                'tributeTreasures' => 0,
                'tributeProduction' => 0,
                'tributeTime' => '0',
                'tributesRequiredToFetch' => 150,
                'realTributePercent' => 0.2,
                'protectionGranted' => '1',
                'allowTributeCollection' => 1,
            ),
        );
        if ($head) {
            return $r;
        } else {
            return $r['data'];
        }
    }

    public function getAllPop($uid) {
        global $engine;
        $data = query("SELECT * FROM `" . $engine->server->prefix . "village` WHERE `owner`=?;", array($uid))->fetchAll();
        $pop = 0;
        foreach ($data as $v) {
            $pop += $v['pop'];
        }
        return $pop;
    }

    public function LoadData($uid = null) {
        global $engine;
        if ($uid === null) {
            $uid = $_SESSION[$engine->server->prefix . 'uid'];
        }

        $data = query("SELECT * FROM `" . $engine->server->prefix . "village` WHERE `owner`=?;", array($uid))->fetchAll();

        if (!isset($_COOKIE['village'])) {
            if (count($data) > 0) {
                setcookie("village", $data[0]['wid'], 0, "/");
                $_COOKIE['village'] = $data[0]['wid'];
            } else {
                setcookie("village", 0, 0, "/");
                $_COOKIE['village'] = 0;
            }
        }

        $this->data = $data;
        for ($i = 0; $i < count($this->data); $i += 1) {
            $engine->auto->procRes($this->data[$i]['wid']);
            if ($this->data[$i]['wid'] == $_COOKIE['village']) {
                $this->current = $this->data[$i];
            }
        }
    }

    public function changeName($post) {
        global $engine;
        if (query("UPDATE `" . $engine->server->prefix . "village` SET `vname`=? WHERE `wid`=?;", array($post['name'], $post['wid']))) {
            return true;
        } else {
            return false;
        }
    }

    public function createVillage($uid, $username = null, $wid = null, $name = null, $pop = null, $option = []) {
        global $engine;
        if ($wid === null) {
            $wid = $engine->world->bestPosition();
        }
        $wdata = $engine->world->getMapDetail($wid);
        if ($wid < 0) {
            $wdata['resType'] = "4446";
        }

        if ($wdata['resType'] == "4446") {
            $engine->building->createBuilding($wid, 1, 1, 0, 3);
            $engine->building->createBuilding($wid, 2, 4, 0, 3);
            $engine->building->createBuilding($wid, 3, 1, 0, 3);
            $engine->building->createBuilding($wid, 4, 3, 0, 3);
            $engine->building->createBuilding($wid, 5, 2, 0, 3);
            $engine->building->createBuilding($wid, 6, 2, 0, 3);
            $engine->building->createBuilding($wid, 7, 3, 0, 3);
            $engine->building->createBuilding($wid, 8, 4, 0, 3);
            $engine->building->createBuilding($wid, 9, 4, 0, 3);
            $engine->building->createBuilding($wid, 10, 3, 0, 3);
            $engine->building->createBuilding($wid, 11, 3, 0, 3);
            $engine->building->createBuilding($wid, 12, 4, 0, 3);
            $engine->building->createBuilding($wid, 13, 4, 0, 3);
            $engine->building->createBuilding($wid, 14, 1, 0, 3);
            $engine->building->createBuilding($wid, 15, 4, 0, 3);
            $engine->building->createBuilding($wid, 16, 2, 0, 3);
            $engine->building->createBuilding($wid, 17, 1, 0, 3);
            $engine->building->createBuilding($wid, 18, 2, 0, 3);
        } elseif ($wdata['resType'] == "11115") {
            $engine->building->createBuilding($wid, 1, 4, 0, 3);
            $engine->building->createBuilding($wid, 2, 4, 0, 3);
            $engine->building->createBuilding($wid, 3, 1, 0, 3);
            $engine->building->createBuilding($wid, 4, 3, 0, 3);
            $engine->building->createBuilding($wid, 5, 4, 0, 3);
            $engine->building->createBuilding($wid, 6, 4, 0, 3);
            $engine->building->createBuilding($wid, 7, 4, 0, 3);
            $engine->building->createBuilding($wid, 8, 4, 0, 3);
            $engine->building->createBuilding($wid, 9, 4, 0, 3);
            $engine->building->createBuilding($wid, 10, 4, 0, 3);
            $engine->building->createBuilding($wid, 11, 4, 0, 3);
            $engine->building->createBuilding($wid, 12, 4, 0, 3);
            $engine->building->createBuilding($wid, 13, 4, 0, 3);
            $engine->building->createBuilding($wid, 14, 4, 0, 3);
            $engine->building->createBuilding($wid, 15, 4, 0, 3);
            $engine->building->createBuilding($wid, 16, 2, 0, 3);
            $engine->building->createBuilding($wid, 17, 4, 0, 3);
            $engine->building->createBuilding($wid, 18, 4, 0, 3);
        } elseif ($wdata['resType'] == "3339") {
            $engine->building->createBuilding($wid, 1, 4, 0, 3);
            $engine->building->createBuilding($wid, 2, 4, 0, 3);
            $engine->building->createBuilding($wid, 3, 1, 0, 3);
            $engine->building->createBuilding($wid, 4, 4, 0, 3);
            $engine->building->createBuilding($wid, 5, 4, 0, 3);
            $engine->building->createBuilding($wid, 6, 2, 0, 3);
            $engine->building->createBuilding($wid, 7, 3, 0, 3);
            $engine->building->createBuilding($wid, 8, 4, 0, 3);
            $engine->building->createBuilding($wid, 9, 4, 0, 3);
            $engine->building->createBuilding($wid, 10, 3, 0, 3);
            $engine->building->createBuilding($wid, 11, 3, 0, 3);
            $engine->building->createBuilding($wid, 12, 4, 0, 3);
            $engine->building->createBuilding($wid, 13, 4, 0, 3);
            $engine->building->createBuilding($wid, 14, 1, 0, 3);
            $engine->building->createBuilding($wid, 15, 4, 0, 3);
            $engine->building->createBuilding($wid, 16, 2, 0, 3);
            $engine->building->createBuilding($wid, 17, 1, 0, 3);
            $engine->building->createBuilding($wid, 18, 2, 0, 3);
        } elseif ($wdata['resType'] == "3456") {
            $engine->building->createBuilding($wid, 1, 3, 0, 3);
            $engine->building->createBuilding($wid, 2, 4, 0, 3);
            $engine->building->createBuilding($wid, 3, 1, 0, 3);
            $engine->building->createBuilding($wid, 4, 3, 0, 3);
            $engine->building->createBuilding($wid, 5, 2, 0, 3);
            $engine->building->createBuilding($wid, 6, 2, 0, 3);
            $engine->building->createBuilding($wid, 7, 3, 0, 3);
            $engine->building->createBuilding($wid, 8, 4, 0, 3);
            $engine->building->createBuilding($wid, 9, 4, 0, 3);
            $engine->building->createBuilding($wid, 10, 3, 0, 3);
            $engine->building->createBuilding($wid, 11, 3, 0, 3);
            $engine->building->createBuilding($wid, 12, 4, 0, 3);
            $engine->building->createBuilding($wid, 13, 4, 0, 3);
            $engine->building->createBuilding($wid, 14, 1, 0, 3);
            $engine->building->createBuilding($wid, 15, 4, 0, 3);
            $engine->building->createBuilding($wid, 16, 2, 0, 3);
            $engine->building->createBuilding($wid, 17, 1, 0, 3);
            $engine->building->createBuilding($wid, 18, 2, 0, 3);
        } elseif ($wdata['resType'] == "4536") {
            $engine->building->createBuilding($wid, 1, 1, 0, 3);
            $engine->building->createBuilding($wid, 2, 4, 0, 3);
            $engine->building->createBuilding($wid, 3, 1, 0, 3);
            $engine->building->createBuilding($wid, 4, 2, 0, 3);
            $engine->building->createBuilding($wid, 5, 2, 0, 3);
            $engine->building->createBuilding($wid, 6, 2, 0, 3);
            $engine->building->createBuilding($wid, 7, 3, 0, 3);
            $engine->building->createBuilding($wid, 8, 4, 0, 3);
            $engine->building->createBuilding($wid, 9, 4, 0, 3);
            $engine->building->createBuilding($wid, 10, 3, 0, 3);
            $engine->building->createBuilding($wid, 11, 3, 0, 3);
            $engine->building->createBuilding($wid, 12, 4, 0, 3);
            $engine->building->createBuilding($wid, 13, 4, 0, 3);
            $engine->building->createBuilding($wid, 14, 1, 0, 3);
            $engine->building->createBuilding($wid, 15, 4, 0, 3);
            $engine->building->createBuilding($wid, 16, 2, 0, 3);
            $engine->building->createBuilding($wid, 17, 1, 0, 3);
            $engine->building->createBuilding($wid, 18, 2, 0, 3);
        } elseif ($wdata['resType'] == "5346") {
            $engine->building->createBuilding($wid, 1, 1, 0, 3);
            $engine->building->createBuilding($wid, 2, 4, 0, 3);
            $engine->building->createBuilding($wid, 3, 1, 0, 3);
            $engine->building->createBuilding($wid, 4, 3, 0, 3);
            $engine->building->createBuilding($wid, 5, 1, 0, 3);
            $engine->building->createBuilding($wid, 6, 2, 0, 3);
            $engine->building->createBuilding($wid, 7, 3, 0, 3);
            $engine->building->createBuilding($wid, 8, 4, 0, 3);
            $engine->building->createBuilding($wid, 9, 4, 0, 3);
            $engine->building->createBuilding($wid, 10, 3, 0, 3);
            $engine->building->createBuilding($wid, 11, 3, 0, 3);
            $engine->building->createBuilding($wid, 12, 4, 0, 3);
            $engine->building->createBuilding($wid, 13, 4, 0, 3);
            $engine->building->createBuilding($wid, 14, 1, 0, 3);
            $engine->building->createBuilding($wid, 15, 4, 0, 3);
            $engine->building->createBuilding($wid, 16, 2, 0, 3);
            $engine->building->createBuilding($wid, 17, 1, 0, 3);
            $engine->building->createBuilding($wid, 18, 2, 0, 3);
        } elseif ($wdata['resType'] == "4437") {
            $engine->building->createBuilding($wid, 1, 1, 0, 3);
            $engine->building->createBuilding($wid, 2, 4, 0, 3);
            $engine->building->createBuilding($wid, 3, 4, 0, 3);
            $engine->building->createBuilding($wid, 4, 1, 0, 3);
            $engine->building->createBuilding($wid, 5, 2, 0, 3);
            $engine->building->createBuilding($wid, 6, 2, 0, 3);
            $engine->building->createBuilding($wid, 7, 3, 0, 3);
            $engine->building->createBuilding($wid, 8, 4, 0, 3);
            $engine->building->createBuilding($wid, 9, 4, 0, 3);
            $engine->building->createBuilding($wid, 10, 3, 0, 3);
            $engine->building->createBuilding($wid, 11, 3, 0, 3);
            $engine->building->createBuilding($wid, 12, 4, 0, 3);
            $engine->building->createBuilding($wid, 13, 4, 0, 3);
            $engine->building->createBuilding($wid, 14, 1, 0, 3);
            $engine->building->createBuilding($wid, 15, 4, 0, 3);
            $engine->building->createBuilding($wid, 16, 2, 0, 3);
            $engine->building->createBuilding($wid, 17, 1, 0, 3);
            $engine->building->createBuilding($wid, 18, 2, 0, 3);
        } elseif ($wdata['resType'] == "3447") {
            $engine->building->createBuilding($wid, 1, 3, 0, 3);
            $engine->building->createBuilding($wid, 2, 4, 0, 3);
            $engine->building->createBuilding($wid, 3, 4, 0, 3);
            $engine->building->createBuilding($wid, 4, 1, 0, 3);
            $engine->building->createBuilding($wid, 5, 2, 0, 3);
            $engine->building->createBuilding($wid, 6, 2, 0, 3);
            $engine->building->createBuilding($wid, 7, 3, 0, 3);
            $engine->building->createBuilding($wid, 8, 4, 0, 3);
            $engine->building->createBuilding($wid, 9, 4, 0, 3);
            $engine->building->createBuilding($wid, 10, 3, 0, 3);
            $engine->building->createBuilding($wid, 11, 3, 0, 3);
            $engine->building->createBuilding($wid, 12, 4, 0, 3);
            $engine->building->createBuilding($wid, 13, 4, 0, 3);
            $engine->building->createBuilding($wid, 14, 1, 0, 3);
            $engine->building->createBuilding($wid, 15, 4, 0, 3);
            $engine->building->createBuilding($wid, 16, 2, 0, 3);
            $engine->building->createBuilding($wid, 17, 1, 0, 3);
            $engine->building->createBuilding($wid, 18, 2, 0, 3);
        } elseif ($wdata['resType'] == "4347") {
            $engine->building->createBuilding($wid, 1, 3, 0, 3);
            $engine->building->createBuilding($wid, 2, 4, 0, 3);
            $engine->building->createBuilding($wid, 3, 4, 0, 3);
            $engine->building->createBuilding($wid, 4, 1, 0, 3);
            $engine->building->createBuilding($wid, 5, 1, 0, 3);
            $engine->building->createBuilding($wid, 6, 2, 0, 3);
            $engine->building->createBuilding($wid, 7, 3, 0, 3);
            $engine->building->createBuilding($wid, 8, 4, 0, 3);
            $engine->building->createBuilding($wid, 9, 4, 0, 3);
            $engine->building->createBuilding($wid, 10, 3, 0, 3);
            $engine->building->createBuilding($wid, 11, 3, 0, 3);
            $engine->building->createBuilding($wid, 12, 4, 0, 3);
            $engine->building->createBuilding($wid, 13, 4, 0, 3);
            $engine->building->createBuilding($wid, 14, 1, 0, 3);
            $engine->building->createBuilding($wid, 15, 4, 0, 3);
            $engine->building->createBuilding($wid, 16, 2, 0, 3);
            $engine->building->createBuilding($wid, 17, 1, 0, 3);
            $engine->building->createBuilding($wid, 18, 2, 0, 3);
        } elseif ($wdata['resType'] == "3546") {
            $engine->building->createBuilding($wid, 1, 3, 0, 3);
            $engine->building->createBuilding($wid, 2, 4, 0, 3);
            $engine->building->createBuilding($wid, 3, 1, 0, 3);
            $engine->building->createBuilding($wid, 4, 2, 0, 3);
            $engine->building->createBuilding($wid, 5, 2, 0, 3);
            $engine->building->createBuilding($wid, 6, 2, 0, 3);
            $engine->building->createBuilding($wid, 7, 3, 0, 3);
            $engine->building->createBuilding($wid, 8, 4, 0, 3);
            $engine->building->createBuilding($wid, 9, 4, 0, 3);
            $engine->building->createBuilding($wid, 10, 3, 0, 3);
            $engine->building->createBuilding($wid, 11, 3, 0, 3);
            $engine->building->createBuilding($wid, 12, 4, 0, 3);
            $engine->building->createBuilding($wid, 13, 4, 0, 3);
            $engine->building->createBuilding($wid, 14, 1, 0, 3);
            $engine->building->createBuilding($wid, 15, 4, 0, 3);
            $engine->building->createBuilding($wid, 16, 2, 0, 3);
            $engine->building->createBuilding($wid, 17, 1, 0, 3);
            $engine->building->createBuilding($wid, 18, 2, 0, 3);
        } elseif ($wdata['resType'] == "5436") {
            $engine->building->createBuilding($wid, 1, 1, 0, 3);
            $engine->building->createBuilding($wid, 2, 4, 0, 3);
            $engine->building->createBuilding($wid, 3, 1, 0, 3);
            $engine->building->createBuilding($wid, 4, 1, 0, 3);
            $engine->building->createBuilding($wid, 5, 2, 0, 3);
            $engine->building->createBuilding($wid, 6, 2, 0, 3);
            $engine->building->createBuilding($wid, 7, 3, 0, 3);
            $engine->building->createBuilding($wid, 8, 4, 0, 3);
            $engine->building->createBuilding($wid, 9, 4, 0, 3);
            $engine->building->createBuilding($wid, 10, 3, 0, 3);
            $engine->building->createBuilding($wid, 11, 3, 0, 3);
            $engine->building->createBuilding($wid, 12, 4, 0, 3);
            $engine->building->createBuilding($wid, 13, 4, 0, 3);
            $engine->building->createBuilding($wid, 14, 1, 0, 3);
            $engine->building->createBuilding($wid, 15, 4, 0, 3);
            $engine->building->createBuilding($wid, 16, 2, 0, 3);
            $engine->building->createBuilding($wid, 17, 1, 0, 3);
            $engine->building->createBuilding($wid, 18, 2, 0, 3);
        } elseif ($wdata['resType'] == "4356") {
            $engine->building->createBuilding($wid, 1, 3, 0, 3);
            $engine->building->createBuilding($wid, 2, 1, 0, 3);
            $engine->building->createBuilding($wid, 3, 4, 0, 3);
            $engine->building->createBuilding($wid, 4, 3, 0, 3);
            $engine->building->createBuilding($wid, 5, 1, 0, 3);
            $engine->building->createBuilding($wid, 6, 1, 0, 3);
            $engine->building->createBuilding($wid, 7, 4, 0, 3);
            $engine->building->createBuilding($wid, 8, 3, 0, 3);
            $engine->building->createBuilding($wid, 9, 1, 0, 3);
            $engine->building->createBuilding($wid, 10, 2, 0, 3);
            $engine->building->createBuilding($wid, 11, 2, 0, 3);
            $engine->building->createBuilding($wid, 12, 3, 0, 3);
            $engine->building->createBuilding($wid, 13, 1, 0, 3);
            $engine->building->createBuilding($wid, 14, 4, 0, 3);
            $engine->building->createBuilding($wid, 15, 4, 0, 3);
            $engine->building->createBuilding($wid, 16, 2, 0, 3);
            $engine->building->createBuilding($wid, 17, 4, 0, 3);
            $engine->building->createBuilding($wid, 18, 4, 0, 3);
        }


        $engine->building->createBuilding($wid, 19, 0, 0, 0);
        $engine->building->createBuilding($wid, 20, 0, 0, 0);
        $engine->building->createBuilding($wid, 21, 0, 0, 0);
        $engine->building->createBuilding($wid, 22, 0, 0, 0);
        $engine->building->createBuilding($wid, 23, 0, 0, 0);
        $engine->building->createBuilding($wid, 24, 0, 0, 0);
        $engine->building->createBuilding($wid, 25, 0, 0, 0);
        $engine->building->createBuilding($wid, 26, 0, 0, 0);
        $engine->building->createBuilding($wid, 27, 15, 1, 2); //Main building
        $engine->building->createBuilding($wid, 28, 0, 0, 0);
        $engine->building->createBuilding($wid, 29, 0, 0, 0);
        $engine->building->createBuilding($wid, 30, 0, 0, 0);
        $engine->building->createBuilding($wid, 31, 0, 0, 0);
        $engine->building->createBuilding($wid, 32, 0, 0, 0);
        $engine->building->createBuilding($wid, 33, 0, 0, 0);
        $engine->building->createBuilding($wid, 34, 0, 0, 0);
        $engine->building->createBuilding($wid, 35, 0, 0, 0);
        $engine->building->createBuilding($wid, 36, 0, 0, 0);
        $engine->building->createBuilding($wid, 37, 0, 0, 0);
        $engine->building->createBuilding($wid, 38, 0, 0, 0);
        $engine->building->createBuilding($wid, 39, 0, 0, 0);
        $engine->building->createBuilding($wid, 40, 0, 0, 0);

        !isset($option['settled']) ? $option['settled'] = time() : '';
        !isset($option['expandedfrom']) ? $option['expandedfrom'] = $wid : '';

        if (query("INSERT INTO `" . $engine->server->prefix . "village` (`wid`,`vname`,`owner`,`pop`,`maxstore`,`maxcrop`,`capitel`) VALUE (?,?,?,?,?,?,?);", array($wid, ($name != null ? $name : (($username == null || $username == "") ? "New Village" : $username . "'s village")), $uid, ($pop == null ? 1 : $pop), $engine->server->multiple_storage * $engine->server->base_storage, $engine->server->multiple_storage * $engine->server->base_storage, 1))) {
            $engine->unit->setUnit($wid, 1, 0);
            query("INSERT INTO `" . $engine->server->prefix . "tdata` (`wid`) VALUES (?);", array($wid));
            return true;
        } else {
            return false;
        }
    }

    public function getVillageField($wid, $field) {
        global $engine;
        $r = query("SELECT * FROM `" . $engine->server->prefix . "village` WHERE `wid`=?", array($wid))->fetch(PDO::FETCH_ASSOC);
        return $r[$field];
    }

    public function getExpansion($wid) {
        global $engine;
        $r = [];
        $villages = query("SELECT * FROM `" . $engine->server->prefix . "village` WHERE `expandedfrom`=?", [$wid])->fetchAll(PDO::FETCH_ASSOC);
        foreach ($villages as $village) {
            $owner = $engine->account->getById($village['owner']);
            array_push($r, [
                "name" => "ExpansionListEntry:",
                "data" => [
                    "villageId" => $village['wid'],
                    "villageName" => $village['vname'],
                    "ownerName" => $owner['username'],
                    "foundingTime" => $village['settled'],
                ]
            ]);
        }
        return $r;
    }

    public function setVillageField($wid, $field, $value) {
        global $engine;
        query("UPDATE `" . $engine->server->prefix . "village` SET `" . $field . "`=? WHERE `wid`=?", array($value, $wid));
        return true;
    }

    public function getProc($wid, $type) {
        global $engine;
        if ($type == 5 || $type == 'cp') {
            $product = $this->getVillageField($wid, 'cp') * $engine->server->speed_world;
        } else {
            $field = query("SELECT * FROM `" . $engine->server->prefix . "field` WHERE `wid`=? AND `type`=?;", array($wid, $type))->fetchAll(PDO::FETCH_ASSOC);
            $player = $engine->account->getByVillage($wid);
            $product = 0;
            foreach ($field as $key => $value) {
                $product2 = (new BuildingData)->get($type, $value['level']);
                $product += $product2['effect'] * $engine->server->speed_world;
            }
            if ($type == 4) {
                $product -= ($this->getVillageField($wid, 'pop') + $engine->unit->getVillageSupply($wid));
            }

            $bonusProduct = 0;
            $bonusFactor = $engine->building->getTypeLevel($wid, $type + 4);
            $bonusProduct = 1 + ((new BuildingData)->get($type + 4, $bonusFactor)['effect'] / 100);

            if ($type == 4) {
                $bonusFactor = $engine->building->getTypeLevel($wid, 9);
                $bonusProduct += (new BuildingData)->get(9, $bonusFactor)['effect'] / 100;
            }

            $product *= $bonusProduct;

            if ($type == 4) {
                if ($player['resBonus'] != 0) {
                    $product *= 0.25;
                }
            } else {
                if ($player['cropBonus'] != 0) {
                    $product *= 0.25;
                }
            }
        }
        return $product;
    }

    public function getProductDetail($wid) {
        global $engine;

        $product = [];
        for ($type = 1; $type <= 4; $type++) {
            $fields = query("SELECT * FROM `{$engine->server->prefix}field` WHERE `wid`=? AND `type`=?", [$wid, $type])->fetchAll(PDO::FETCH_ASSOC);

            $product[$type] = ["baseFactors" => [], "bonusFactors" => [], "globalBase" => [], "globalBonus" => []];

            foreach ($fields as $f) {
                array_push($product[$type]['baseFactors'], [
                    "resourceType" => $type,
                    "type" => $f['type'],
                    "level" => $f['level'],
                    "category" => 1,
                    "value" => (new BuildingData)->get($type, $f['level'])['effect'] * $engine->server->speed_world,
                ]);
            }

            $bonusFactor = $engine->building->getTypeLevel($wid, $type + 4);
            array_push($product[$type]['bonusFactors'], [
                "resourceType" => $type + 4,
                "type" => $type + 4,
                "level" => $bonusFactor,
                "category" => 1,
                "value" => (new BuildingData)->get($type + 4, $bonusFactor)['effect'] / 100,
            ]);
            if ($type == 4) {
                $bonusFactor = $engine->building->getTypeLevel($wid, 9);
                array_push($product[$type]['bonusFactors'], [
                    "resourceType" => 9,
                    "type" => 9,
                    "level" => $bonusFactor,
                    "category" => 1,
                    "value" => (new BuildingData)->get(9, $bonusFactor)['effect'] / 100,
                ]);
                if ($engine->session->data->cropBonus != 0) {
                    array_push($product[$type]['globalBonus'], [
                        "resourceType" => $type,
                        "type" => 0,
                        "level" => 0,
                        "category" => 6,
                        "value" => 0.25,
                    ]);
                }
            }else{
                if ($engine->session->data->resBonus != 0) {
                    array_push($product[$type]['globalBonus'], [
                        "resourceType" => $type,
                        "type" => 0,
                        "level" => 0,
                        "category" => 6,
                        "value" => 0.25,
                    ]);
                }
            }
        }
        return $product;
    }

    public function up2Town($wid) {
        global $engine;


        query("UPDATE `{$engine->server->prefix}village` SET `town`=?,`pop`=`pop`+? WHERE `wid`=?;", [1, 500, $wid]);
        $engine->building->setBuilding($wid, 41, 42, 0);

        $this->emitEvent([
            "name" => "invalidateCache",
            "data" => "MapDetails:$wid",
        ]);
        $this->emitEvent([
            "name" => "mapChanged",
            "data" => $wid,
        ]);
    }

    public function startTreasuryTransformations($wid) {
        global $engine;

        $duration = 86400;
        $duration = $duration / $engine->server->speed_world;

        query("UPDATE `{$engine->server->prefix}village` SET `area`=? WHERE `wid`=?;", [time() + $duration, $wid]);
    }

    public function removeTreasuryTransformations($wid, $location) {
        global $engine;

        $v = query("SELECT * FROM `{$engine->server->prefix}village` WHERE `wid`=?", [$wid])->fetch(PDO::FETCH_ASSOC);

        query("UPDATE `{$engine->server->prefix}field` SET `type`=? WHERE `location`=? AND `wid`=?;", [45, $location, $wid]);
        query("UPDATE `{$engine->server->prefix}village` SET `area`=? WHERE `wid`=?;", [0, $wid]);
        $engine->auto->emitCache($v['owner'], $engine->building->getBuilding(["wid" => $v['owner'], "location" => $location]));
        $engine->auto->emitCache($v['owner'], $engine->building->getBuildings($v['wid']));
        $engine->auto->emitCache($v['owner'], $engine->village->get($v['wid']));
    }

    public function cancelTreasuryTransformations($wid) {
        global $engine;

        query("UPDATE `{$engine->server->prefix}village` SET `area`=? WHERE `wid`=?;", [0, $wid]);
    }

}
