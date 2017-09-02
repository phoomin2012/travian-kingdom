<?php

class Ranking {

    public function getWorldStats() {
        global $engine;
        $r = array(
            "players" => array(
                "registered" => query("SELECT * FROM `" . $engine->server->prefix . "user`")->rowCount(),
                "active" => 0,
                "online" => 0,
            ),
            "kingdoms" => array(
                "kings" => 0,
                "dukes" => query("SELECT * FROM `" . $engine->server->prefix . "user`")->rowCount(),
                "governors" => 0,
            ),
            "tribes" => array(
                "1" => query("SELECT * FROM `" . $engine->server->prefix . "user` WHERE `tribe`=?", array(1))->rowCount(),
                "2" => query("SELECT * FROM `" . $engine->server->prefix . "user` WHERE `tribe`=?", array(2))->rowCount(),
                "3" => query("SELECT * FROM `" . $engine->server->prefix . "user` WHERE `tribe`=?", array(3))->rowCount(),
            ),
            "world" => array(
                "startTime" => time(),
                "speed" => $engine->server->speed_world,
                "speedTroops" => $engine->server->speed_unit,
            ),
            "troops" => array(
                "1" => array(
                    "1" => 55112,
                    "2" => 24939,
                    "3" => 17640,
                    "4" => 10051,
                    "5" => 9498,
                    "6" => 957,
                    "7" => 107,
                    "8" => 75,
                    "9" => 0,
                    "10" => 98
                ),
                "2" => array(
                    "1" => 76161,
                    "2" => 16327,
                    "3" => 6907,
                    "4" => 5962,
                    "5" => 3865,
                    "6" => 535,
                    "7" => 150,
                    "8" => 25,
                    "9" => 0,
                    "10" => 69
                ),
                "3" => array(
                    "1" => 79103,
                    "2" => 32470,
                    "3" => 8430,
                    "4" => 13363,
                    "5" => 2629,
                    "6" => 808,
                    "7" => 89,
                    "8" => 1,
                    "9" => 0,
                    "10" => 121
                )
            )
        );
        return $r;
    }

    public function getKingdomStats($kid) {
        global $engine;

        $k = $engine->kingdom->get($kid);
        $kr = query("SELECT * FROM `{$engine->server->prefix}kingdom` WHERE `id`=?;", [$kid])->fetch(PDO::FETCH_ASSOC);

        $us = query("SELECT * FROM `{$engine->server->prefix}user` WHERE `kingdom`=?;", [$kid])->fetchAll(PDO::FETCH_ASSOC);
        $vc = 0;
        foreach ($us as $u) {
            $v = $engine->village->getAll($u['uid']);
            $vc += count($v);
        }

        $r = [
            "kingId" => $kid,
            "kingName" => $k['tag'],
            "members" => count($k['members']),
            "rank" => false,
            "treasures" => false,
            "victoryPoints" => $kr['vca'] == 0 ? false : $kr['vca'],
            "villages" => $vc,
            "worldWonderLvl" => false,
        ];
        return $r;
    }

    public function allUser() {
        global $engine;

        $r = query("SELECT * FROM `{$engine->server->prefix}user`")->rowCount();
        return $r;
    }

    public function getUserRank($uid = null) {
        global $engine;
        $uid === null ? $uid = $_SESSION[$engine->server->prefix . 'uid'] : false;
        
        return $this->getRank([
            "rankingType"=>"ranking_Player",
            "rankingSubtype" => "population",
            "id" => $uid,
        ])['rank'];
    }

    public function getRank($params) {
        global $engine;
        $rank = 0;
        $all = 0;
        if ($params['rankingType'] == "ranking_Player") {
            $us = query("SELECT `{$engine->server->prefix}user`.`uid` `uid`,`{$engine->server->prefix}user`.`username` `username`, (SELECT SUM( `{$engine->server->prefix}village`.`pop` ) FROM `{$engine->server->prefix}village` WHERE `{$engine->server->prefix}village`.`owner` = `uid`)`totalpop` FROM `{$engine->server->prefix}user` WHERE `{$engine->server->prefix}user`.`uid` > 100 AND `{$engine->server->prefix}user`.`tutorial` >= 256 ORDER BY `totalpop` DESC, `uid` ASC")->fetchAll(PDO::FETCH_ASSOC);
            $all = count($us);
            foreach ($us as $u) {
                $rank += 1;
                if ($u['uid'] == $params['id']) {
                    break;
                }
            }
        } elseif ($params['rankingType'] == "ranking_Kingdom") {
            $ks = query("SELECT *,(SELECT COUNT(*) FROM `{$engine->server->prefix}user` WHERE `{$engine->server->prefix}user`.`kingdom`=`{$engine->server->prefix}kingdom`.`id`) AS `memcount` ,(SELECT SUM((SELECT SUM(`{$engine->server->prefix}village`.`pop`) FROM `{$engine->server->prefix}village` WHERE `{$engine->server->prefix}village`.owner=`{$engine->server->prefix}user`.`uid`)) FROM `{$engine->server->prefix}user` WHERE `{$engine->server->prefix}kingdom`.`id`=`{$engine->server->prefix}user`.`kingdom`) AS `totalpop` FROM `{$engine->server->prefix}kingdom` ORDER BY `totalpop` DESC, `id` ASC")->fetchAll(PDO::FETCH_ASSOC);
            $all = count($ks);
            foreach ($ks as $k) {
                $rank += 1;
                if ($k['uid'] == $params['id']) {
                    break;
                }
            }
        } elseif ($params['rankingType'] == "ranking_Villages") {
            $vs = query("SELECT * FROM `{$engine->server->prefix}village`")->fetchAll(PDO::FETCH_ASSOC);
            $all = count($vs);
            foreach ($vs as $v) {
                $rank += 1;
                if ($v['uid'] == $params['id']) {
                    break;
                }
            }
        }
        return ['rank' => $rank, 'all' => $all];
    }

    public function getRanking($params) {
        global $engine;
        $r = [];
        $perpage = 10;

        if ($params['rankingType'] == "ranking_Player") {
            $us = query("SELECT `{$engine->server->prefix}user`.`uid` `uid`,`{$engine->server->prefix}user`.`username` `username`, (SELECT SUM( `{$engine->server->prefix}village`.`pop`) FROM `{$engine->server->prefix}village` WHERE `{$engine->server->prefix}village`.`owner` = `uid`) `totalpop` FROM `{$engine->server->prefix}user` WHERE `{$engine->server->prefix}user`.`uid` > 100  AND `{$engine->server->prefix}user`.`tutorial` >= 256 ORDER BY `totalpop` DESC, `uid` ASC LIMIT {$params['start']},{$params['end']}")->fetchAll(PDO::FETCH_ASSOC);
            $rank = 0;
            if ($params['rankingSubtype'] == "population") {
                foreach ($us as $u) {
                    $ud = $engine->account->getById($u['uid']);
                    $k = query("SELECT * FROM `{$engine->server->prefix}kingdom` WHERE `id`=?;", [$u['kingdom']])->fetch(PDO::FETCH_ASSOC);
                    $v = count($engine->village->getAll($u['uid']));
                    $r[] = [
                        'rank' => $rank,
                        'playerId' => $ud['uid'],
                        'playerName' => $ud['username'],
                        'kingdomId' => $ud['kingdom'],
                        'kingdomTag' => $k['tag'],
                        'tribeId' => $ud['tribe'],
                        'village' => $v,
                        'points' => $u['totalpop'],
                        'population' => $u['totalpop'],
                        'stars' => $engine->account->getPrestige($u['uid'], true),
                    ];
                    $rank++;
                }
            } elseif ($params['rankingSubtype'] == "offPoints") {
                foreach ($us as $u) {
                    $ud = $engine->account->getById($u['uid']);
                    $k = query("SELECT * FROM `{$engine->server->prefix}kingdom` WHERE `id`=?;", [$u['kingdom']])->fetch(PDO::FETCH_ASSOC);
                    $v = count($engine->village->getAll($u['uid']));
                    $r[] = [
                        'rank' => $rank,
                        'playerId' => $ud['uid'],
                        'playerName' => $ud['username'],
                        'kingdomId' => $ud['kingdom'],
                        'kingdomTag' => $k['tag'],
                        'tribeId' => $ud['tribe'],
                        'village' => $v,
                        'points' => $ud['attp'],
                        'population' => $u['totalpop'],
                        'stars' => $engine->account->getPrestige($u['uid'], true),
                    ];
                    $rank++;
                }
            } elseif ($params['rankingSubtype'] == "deffPoints") {
                foreach ($us as $u) {
                    $ud = $engine->account->getById($u['uid']);
                    $k = query("SELECT * FROM `{$engine->server->prefix}kingdom` WHERE `id`=?;", [$u['kingdom']])->fetch(PDO::FETCH_ASSOC);
                    $v = count($engine->village->getAll($u['uid']));
                    $r[] = [
                        'rank' => $rank,
                        'playerId' => $ud['uid'],
                        'playerName' => $ud['username'],
                        'kingdomId' => $ud['kingdom'],
                        'kingdomTag' => $k['tag'],
                        'tribeId' => $ud['tribe'],
                        'village' => $v,
                        'points' => $ud['defp'],
                        'population' => $u['totalpop'],
                        'stars' => $engine->account->getPrestige($u['uid'], true),
                    ];
                    $rank++;
                }
            } elseif ($params['rankingSubtype'] == "heroes") {
                foreach ($us as $u) {
                    $ud = $engine->account->getById($u['uid']);
                    $k = query("SELECT * FROM `{$engine->server->prefix}kingdom` WHERE `id`=?;", [$u['kingdom']])->fetch(PDO::FETCH_ASSOC);
                    $h = query("SELECT * FROM `{$engine->server->prefix}hero` WHERE `owner`=?;", [$u['uid']])->fetch(PDO::FETCH_ASSOC);
                    $r[] = [
                        'rank' => $rank,
                        'playerId' => $ud['uid'],
                        'playerName' => $ud['username'],
                        'kingdomId' => $ud['kingdom'],
                        'kingdomTag' => $k['tag'],
                        'tribeId' => $ud['tribe'],
                        'level' => $h['level'],
                        'points' => $h['xp'],
                        'population' => $u['totalpop'],
                        'stars' => $engine->account->getPrestige($u['uid'], true),
                    ];
                    $rank++;
                }
            }
        } elseif ($params['rankingType'] == "ranking_Kingdom") {
            $ks = query("SELECT *,(SELECT COUNT(*) FROM `{$engine->server->prefix}user` WHERE `{$engine->server->prefix}user`.`kingdom`=`{$engine->server->prefix}kingdom`.`id`) AS `memcount` ,(SELECT SUM((SELECT SUM(`{$engine->server->prefix}village`.`pop`) FROM `{$engine->server->prefix}village` WHERE `{$engine->server->prefix}village`.owner=`{$engine->server->prefix}user`.`uid`)) FROM `{$engine->server->prefix}user` WHERE `{$engine->server->prefix}kingdom`.`id`=`{$engine->server->prefix}user`.`kingdom`) AS `totalpop` FROM `{$engine->server->prefix}kingdom` ORDER BY `totalpop` DESC, `id` ASC LIMIT {$params['start']},{$params['end']}")->fetchAll(PDO::FETCH_ASSOC);
            $rank = 0;
            foreach ($ks as $k) {
                $r[] = [
                    'rank' => $rank,
                    'kingdomId' => $k['id'],
                    'name' => $k['tag'],
                    'playerId' => $ud['kingdom'],
                    'membersCount' => $k['memcount'],
                    'village' => 0,
                    'points' => $k['totalpop'],
                    'victoryPointsLastWeek' => 0,
                    'treasuresCurrent' => 0,
                    'treasuresLatestWeek' => 0,
                ];
                $rank++;
            }
        } elseif ($params['rankingType'] == "ranking_Village") {
            $vs = query("SELECT * FROM `{$engine->server->prefix}village` LIMIT {$params['start']},{$params['end']}")->fetchAll(PDO::FETCH_ASSOC);
            $rank = 0;
            foreach ($vs as $v) {
                $ud = $engine->account->getById($v['owner']);
                $r[] = [
                    'rank' => $rank,
                    'kingdomId' => $ud['kingdom'],
                    'name' => $v['name'],
                    'playerId' => $ud['uid'],
                    'playerName' => $ud['username'],
                    'points' => $v['pop'],
                    'coordinates' => [
                        'x' => $engine->world->id2xy($v['wid'])[0],
                        'y' => $engine->world->id2xy($v['wid'])[1],
                    ],
                    'tribeId' => $ud['tribe'],
                    'villageId' => $v['wid'],
                    'villageType' => 3,
                    'isActive' => true,
                ];
                $rank++;
            }
        }
        return $r;
    }

}
