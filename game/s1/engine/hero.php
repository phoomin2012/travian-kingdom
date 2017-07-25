<?php

class Hero {

    //Hero.STATUS_IDLE = 0;
    //Hero.STATUS_RETURNING = 1;
    //Hero.STATUS_TO_VILLAGE = 2;
    //Hero.STATUS_TO_OASIS = 3;
    //Hero.STATUS_TO_ADVENTURE = 4;
    //Hero.STATUS_SUPPORTING = 5;
    //Hero.STATUS_TRAPPED = 6;
    //Hero.STATUS_DEAD = 7;
    //Hero.STATUS_REVIVING = 8;

    public function get($id, $head = true) {
        global $engine;

        $hero = query("SELECT * FROM `{$engine->server->prefix}hero` WHERE `owner`=?;", [$id])->fetch(PDO::FETCH_ASSOC);
        $r = [
            'name' => 'Hero:' . $id,
            'data' => [
                'playerId' => $id,
                'villageId' => $hero['village'],
                'destVillageId' => '0',
                'status' => '0',
                'health' => $hero['health'],
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
                'untilTime' => '0',
                'bonuses' => [],
                'maxScrollsPerDay' => $hero['max_scroll'],
                'scrollsUsedToday' => $hero['use_scroll'],
                'waterbucketUsedToday' => $hero['use_waterbucket'],
                'ointmentsUsedToday' => $hero['use_ointments'],
                'adventurePointCardUsedToday' => $hero['use_advcard'],
                'resourceChestsUsedToday' => $hero['use_reschest'],
                'cropChestsUsedToday' => $hero['use_cropchest'],
                'artworkUsedToday' => $hero['use_artwork'],
                'isMoving' => false,
                'adventurePoints' => $hero['advPoint'] - $hero['useAdvPoint'],
                'adventurePointTime' => $hero['advNext'],
                'xp' => $hero['xp'],
                'xpThisLevel' => $hero['xp'],
                'xpNextLevel' => 50,
                'level' => $hero['level'],
                'levelUp' => $hero['levelUp'],
            ],
        ];
        return ($head) ? $r : $r['data'];
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

}
