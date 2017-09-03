<?php

class Hero {

    public $adv_short = [6, 11];
    public $adv_long = [15, 21];

    /*
      Hero.STATUS_IDLE = 0;
      Hero.STATUS_RETURNING = 1;
      Hero.STATUS_TO_VILLAGE = 2;
      Hero.STATUS_TO_OASIS = 3;
      Hero.STATUS_TO_ADVENTURE = 4;
      Hero.STATUS_SUPPORTING = 5;
      Hero.STATUS_TRAPPED = 6;
      Hero.STATUS_DEAD = 7;
      Hero.STATUS_REVIVING = 8;
     */

    public function get($id = null, $head = true) {
        global $engine, $_hero_levels, $_hero_t1, $_hero_t2, $_hero_t3;

        $id === null ? $id = $_SESSION[$engine->server->prefix . 'uid'] : '';

        $hero = query("SELECT * FROM `{$engine->server->prefix}hero` WHERE `owner`=?;", [$id])->fetch(PDO::FETCH_ASSOC);
        $status = 0;
        if ($hero['dead'] == 1) {
            if ($hero['revive'] != 0) {
                $status = '8';
            } else {
                $status = '7';
            }
        } elseif ($hero['move'] == "20") {
            $status = '4';
        } elseif ($hero['move'] == "27") {
            $status = '1';
        }

        $this->checkLevelUp($id, false);

        $r = [
            'name' => 'Hero:' . $id,
            'data' => [
                'playerId' => $id,
                'villageId' => $hero['village'],
                'destVillageId' => '0',
                'status' => $status,
                'health' => ($status == 7 || $status == 8) ? 0 : round($hero['health']),
                'lastHealthTime' => $hero['lastupdate'],
                'baseRegenerationRate' => $hero['regen'] * $engine->server->speed_world,
                'regenerationRate' => $hero['regen'] * $engine->server->speed_world,
                'fightStrengthPoints' => $hero['power'],
                'attBonusPoints' => $hero['atkBonus'],
                'defBonusPoints' => $hero['defBonus'],
                'resBonusPoints' => $hero['resBonus'],
                'resBonusType' => $hero['resType'],
                'freePoints' => $hero['point'],
                'speed' => $hero['speed'],
                'untilTime' => $hero['revive'],
                'bonuses' => [],
                'maxScrollsPerDay' => $hero['max_scroll'],
                'scrollsUsedToday' => $hero['use_scroll'],
                'waterbucketUsedToday' => $hero['use_waterbucket'],
                'ointmentsUsedToday' => $hero['use_ointments'],
                'adventurePointCardUsedToday' => $hero['use_advcard'],
                'resourceChestsUsedToday' => $hero['use_reschest'],
                'cropChestsUsedToday' => $hero['use_cropchest'],
                'artworkUsedToday' => $hero['use_artwork'],
                'isMoving' => ($status == 0 || $status == 5 || $status == 6 || $status == 7 || $status == 8) ? true : false,
                'adventurePoints' => $hero['advPoint'] - $hero['useAdvPoint'],
                'adventurePointTime' => $hero['advNext'],
                'xp' => $hero['xp'],
                'xpThisLevel' => !isset($_hero_levels[$hero['level'] - 1]) ? 0 : $_hero_levels[$hero['level'] - 1],
                'xpNextLevel' => !isset($_hero_levels[$hero['level']]) ? 247500000 : $_hero_levels[$hero['level']],
                'level' => $hero['level'],
                'levelUp' => $hero['levelUp'],
            ],
        ];

        if ($status == 7) {
            $player = $engine->account->getById($id);
            $cost = $_hero_t1;
            if ($player['tribe'] == 1) {
                $cost = $_hero_t1;
            } elseif ($player['tribe'] == 2) {
                $cost = $_hero_t2;
            } elseif ($player['tribe'] == 3) {
                $cost = $_hero_t3;
            }
            if ($hero['level'] > 74) {
                $cost = $cost[73];
            } else {
                $cost = $cost[$hero['level'] - 1];
            }

            $r['data']['reviveCosts'] = [
                1 => $cost['wood'],
                2 => $cost['clay'],
                3 => $cost['iron'],
                4 => $cost['crop'],
            ];
            $r['data']['reviveDuration'] = $cost['time'] / $engine->server->speed_world;
        } elseif ($status == 8) {
            //$r['data']['reviveDuration'] = $hero['revive'];
        }
        return ($head) ? $r : $r['data'];
    }

    public function revive($id, $wid) {
        global $engine, $_hero_t1, $_hero_t2, $_hero_t3;
        $error = [];

        $hero = query("SELECT * FROM `{$engine->server->prefix}hero` WHERE `owner`=?;", [$id])->fetch(PDO::FETCH_ASSOC);
        $player = $engine->account->getById($id);
        $cost = $_hero_t1;
        if ($player['tribe'] == 1) {
            $cost = $_hero_t1;
        } elseif ($player['tribe'] == 2) {
            $cost = $_hero_t2;
        } elseif ($player['tribe'] == 3) {
            $cost = $_hero_t3;
        }
        if ($hero['level'] > 74) {
            $cost = $cost[74 - 1];
        } else {
            $cost = $cost[$hero['level'] - 1];
        }
        $finish = time() + $cost['time'] / $engine->server->speed_world;

        $v = query("SELECT * FROM `{$engine->server->prefix}village` WHERE `wid`=?;", [$wid])->fetch(PDO::FETCH_ASSOC);
        if (($v['wood'] - $cost['wood'] >= 0) && ($v['clay'] - $cost['clay'] >= 0) && ($v['iron'] - $cost['iron'] >= 0) && ($v['crop'] - $cost['crop'] >= 0)) {
            query("UPDATE `{$engine->server->prefix}hero` SET `revive`=?,`village`=? WHERE `owner`=?;", [$finish, $wid, $id]);
            query("UPDATE `{$engine->server->prefix}village` SET `wood`=`wood`-?,`clay`=`clay`-?,`iron`=`iron`-?,`crop`=`crop`-? WHERE `wid`=?", array($cost['wood'], $cost['clay'], $cost['iron'], $cost['crop'], $wid));
            //$engine->auto->emitCache($hero['']);
        } else {
            $error = [];
        }
        return [
            "cache" => [
                $this->get($id),
                $engine->village->get($wid),
            ],
            "error" => $error,
        ];
    }

    public function create() {
        global $engine;
        $hero = query("SELECT * FROM `{$engine->server->prefix}hero` WHERE `owner`=?;", [$_SESSION[$engine->server->prefix . 'uid']])->rowCount();
        if ($hero < 1) {
            query("INSERT INTO `{$engine->server->prefix}hero` (`owner`,`village`) VALUES (?,?);", [$_SESSION[$engine->server->prefix . 'uid'], $_COOKIE['village']]);
        }
    }

    public function addAttr($param) {
        global $engine;
        $use = 0;
        $use += $param['attBonusPoints'] + $param['defBonusPoints'] + $param['fightStrengthPoints'] + $param['resBonusPoints'];

        query("UPDATE `{$engine->server->prefix}hero` SET `point`=`point`-?,`atkBonus`=`atkBonus`+?,`defBonus`=`defBonus`+?,`power`=`power`+?,`resBonus`=`resBonus`+?,`resType`=? WHERE `owner`=?", [$use, $param['attBonusPoints'], $param['defBonusPoints'], $param['fightStrengthPoints'], $param['resBonusPoints'], $param['resBonusType'], $_SESSION[$engine->server->prefix . 'uid']]);
    }

    public function getFace($id, $aid = null) {
        global $engine;

        if ($aid === null) {
            $aid = $engine->account->getById($id, 'avatar');
        }

        $avt = query("SELECT * FROM `global_avatar` WHERE `id`=?", array($aid))->fetch();

        $r = array(
            'name' => 'HeroFace:' . $id,
            'data' => array(
                'playerId' => $id,
                'gender' => $avt['gender'],
                'hairColor' => $avt['hairColor'],
                'face' => array(
                    'beard' => $avt['beard'],
                    'ear' => $avt['ear'],
                    'eye' => $avt['eye'],
                    'eyebrow' => $avt['eyebrow'],
                    'hair' => $avt['hair'],
                    'mouth' => $avt['mouth'],
                    'nose' => $avt['nose'],
                ),
            )
        );
        return $r;
    }

    public function saveFace($aid, $param) {
        global $engine;

        query("UPDATE `global_avatar` SET `gender`=?,`hairColor`=?,`beard`=?,`ear`=?,`eye`=?,`eyebrow`=?,`hair`=?,`mouth`=?,`nose`=? WHERE `id`=?", array($param['gender'], $param['hairColor'], (isset($param['face']['beard']) ? $param['face']['beard'] : 0), $param['face']['ear'], $param['face']['eye'], $param['face']['eyebrow'], $param['face']['hair'], $param['face']['mouth'], $param['face']['nose'], $aid));
    }

    public function sendAdventure($short = true) {
        global $engine;

        $uid = $_SESSION[$engine->server->prefix . 'uid'];
        $hero = query("SELECT * FROM `{$engine->server->prefix}hero` WHERE `owner`=?;", [$uid])->fetch(PDO::FETCH_ASSOC);
        $engine->move->send($hero['village'], ($short ? $hero['advShort'] : $hero['advLong']), 20, '', '', [11 => 1]);
        query("UPDATE `{$engine->server->prefix}hero` SET `move`=? WHERE `owner`=?;", [20, $uid]);
        $engine->unit->setUnit($hero['village'], '11', 0);

        $r = [
            $engine->unit->getStay($hero['village']),
            $engine->move->get($hero['village']),
        ];

        return $r;
    }

    public function isHome($uid = null) {
        global $engine;
        $uid === null ? $uid = $_SESSION[$engine->server->prefix . 'uid'] : '';
        $hero = $this->get($uid, false);
        if ($hero['move'] == '')
            return true;
        else
            return false;
    }

    public function checkLevelUp($uid, $send = true) {
        global $engine, $_hero_levels;

        $hero = query("SELECT * FROM `{$engine->server->prefix}hero` WHERE `owner`=?;", [$uid])->fetch(PDO::FETCH_ASSOC);
        ($hero) ? $hero = ['level' => 0, 'xp' => 0] : false;
        $nextXpLevel = $_hero_levels[$hero['level']];
        if ($hero['xp'] >= $nextXpLevel) {
            $levelup = 0;
            do {
                $levelup++;
                $nextXpLevel = $_hero_levels[$hero['level'] + $levelup];
            } while ($hero['xp'] >= $nextXpLevel);

            $new_level = $hero['level'] + $levelup;
            $point = $levelup * 4;
            query("UPDATE `{$engine->server->prefix}hero` SET `level`=?,`levelUp`=?,`point`=`point`+? WHERE `owner`=?;", [$new_level, $levelup, $point, $uid]);
            ($send) ? $engine->auto->emitCache($uid, $this->get($uid)) : '';
        }
    }

    public function randomReward($hero, $long = false) {
        global $engine;

        $t = rand(0, 5);
        $r = [];

        if ($t < 2) {
            $res = [
                'type' => 3,
                'subType' => null,
                'amount' => [
                    1 => rand(1000, 2000) * $hero['level'],
                    2 => rand(1000, 2000) * $hero['level'],
                    3 => rand(1000, 2000) * $hero['level'],
                    4 => rand(1000, 2000) * $hero['level'],
                ]
            ];
            array_push($r, $res);
        } elseif ($t < 5) {
            $type = rand(1, 142);
            //$type = rand(112, 142);
            $item = [
                'type' => 2,
                'subType' => $type,
                'amount' => 1
            ];
            array_push($r, $item);
            $engine->item->add($hero['owner'], $type, 1);
        }

        if ($long) {
            $r = array_merge($r, $this->randomReward($hero));
        }

        return $r;
    }

}
