<?php

class Kingdom {

    public function get($id = 0, $head = false) {
        global $engine;

        $k = query("SELECT * FROM `{$engine->server->prefix}kingdom` WHERE `id`=?;", [$id])->fetch(PDO::FETCH_ASSOC);
        if ($k || $id != 0) {
            $ms = query("SELECT * FROM `{$engine->server->prefix}user` WHERE `kingdom`=?;", [$id])->fetchAll(PDO::FETCH_ASSOC);
            $r = [
                "name" => "Kingdom:" . $id,
                "data" => [
                    "groupId" => $id,
                    "tag" => $k['tag'],
                    "members" => $this->formMember1($ms, $k),
                    "description" => [
                        "groupId" => $id,
                        "internalDescription" => $k['indesc'],
                        "publicDescription" => $k['pubdesc'],
                    ],
                    "diplomacy" => [
                        "foreignOffers" => [],
                        "ownOffers" => [],
                        "treaties" => [],
                    ],
                ]
            ];
        } else {
            $r = [
                "name" => "Kingdom:0",
                "data" => [
                    "groupId" => "0",
                    "tag" => null,
                    "members" => [],
                    "description" => [
                        "groupId" => "0",
                        "internalDescription" => null,
                        "publicDescription" => null,
                    ],
                    "diplomacy" => [
                        "foreignOffers" => [],
                        "ownOffers" => [],
                        "treaties" => [],
                    ],
                ]
            ];
        }

        if ($head)
            return $r;
        else
            return $r['data'];
    }

    public function getStats($id = 0, $head = false) {
        global $engine;

        $k = query("SELECT * FROM `{$engine->server->prefix}kingdom` WHERE `id`=?;", [$id])->fetch(PDO::FETCH_ASSOC);
        if ($k || $id != 0) {
            $r = [
                "name" => "KingdomStats:$id",
                "data" => [
                    "kingdomId" => $id,
                    "treasuresCurrent" => 0,
                    "treasuresLatestWeek" => 0,
                    "victoryPointsCurrent" => $k['vca'],
                    "victoryPointsLastWeek" => $k['vcw'],
                ]
            ];
        } else {
            $r = [
                "name" => "KingdomStats:0",
                "data" => [
                    "kingdomId" => "0",
                    "treasuresCurrent" => 0,
                    "treasuresLatestWeek" => 0,
                    "victoryPointsCurrent" => 0,
                    "victoryPointsLastWeek" => 0,
                ]
            ];
        }

        if ($head)
            return $r;
        else
            return $r['data'];
    }

    public function getTreasures($id = 0) {
        global $engine;

        $k = query("SELECT * FROM `{$engine->server->prefix}kingdom` WHERE `id`=?;", [$id])->fetch(PDO::FETCH_ASSOC);

        return [
            "name" => "KingdomTreasures",
            "data" => [
                'kingdomId' => $id,
                'treasuresLatestWeek' => 0,
                'treasuresCurrent' => 0
            ],
        ];
    }

    public function getData($id = 0, $field = null) {
        global $engine;

        $k = query("SELECT * FROM `{$engine->server->prefix}kingdom` WHERE `id`=?;", [$id])->fetch(PDO::FETCH_ASSOC);

        return $field === null ? $k : $k[$field];
    }

    public function getRole($kid, $uid) {
        global $engine;
        $k = query("SELECT * FROM `{$engine->server->prefix}kingdom` WHERE `id`=?;", [$kid])->fetch(PDO::FETCH_ASSOC);
        $u = query("SELECT * FROM `{$engine->server->prefix}user` WHERE `uid`=?;", [$uid])->fetch(PDO::FETCH_ASSOC);

        if ($k['king'] == $uid) {
            return 1;
        } elseif ($k['duke1'] == $uid || $k['duke2'] == $uid || $k['duke3'] == $uid || $k['duke4'] == $uid) {
            return 2;
        } else {
            return 0;
        }
    }

    public function getVillage($id = null) {
        global $engine;
        if ($id === null) {
            $p = query("SELECT * FROM `" . $engine->server->prefix . "user` WHERE `uid`=?", array($_SESSION[$engine->server->prefix . 'uid']))->fetch(PDO::FETCH_ASSOC);
            $id = $p['kingdom'];
        }
        $us = query("SELECT * FROM `{$engine->server->prefix}user` WHERE `kingdom`=?;", [$id])->fetchAll(PDO::FETCH_ASSOC);
        $vs = [];
        foreach ($us as $u) {
            $v = $engine->village->getAll($u['uid']);
            $vs = array_merge($vs, $v);
        }
        return $vs;
    }

    public function getVillageAttack($id = 0) {
        global $engine;

        return [
            'villages' => [
                "-10101" => "101",
            ]
        ];
    }

    public function formMember1($ms, $kingdom) {
        global $engine;

        $r = [];
        foreach ($ms as $m) {
            array_push($r, [
                'kingdomId' => $kingdom['id'],
                'isDuke' => $kingdom['duke1'] == $m['uid'] || $kingdom['duke2'] == $m['uid'] || $kingdom['duke3'] == $m['uid'] || $kingdom['duke4'] == $m['uid'],
                'isKing' => $kingdom['king'] == $m['uid'],
                'playerId' => $m['uid'],
                'name' => $m['username'],
                'population' => $engine->village->getAllPop($m['uid']),
                'victoryPoints' => 0,
                'villages' => count($engine->village->getAll($m['uid'], false)),
            ]);
        }

        return $r;
    }

    public function create($tag) {
        global $engine;


        query("INSERT INTO `{$engine->server->prefix}kingdom` (`king`,`tag`) VALUES (?,?);", [$_SESSION[$engine->server->prefix . 'uid'], $tag]);
        $kid = $engine->sql->lastInsertId();
        $this->join($_SESSION[$engine->server->prefix . 'uid'], $kid);
        return $kid;
    }

    public function join($id, $kingdom) {
        global $engine;

        query("UPDATE `{$engine->server->prefix}user` SET `kingdom`=? WHERE `uid`=?;", [$kingdom, $id]);
    }

    public function changeDesc($id, $desc, $pub = true) {
        global $engine;
        if ($pub) {
            query("UPDATE `{$engine->server->prefix}kingdom` SET `pubdesc`=? WHERE `id`=?;", [$desc, $id]);
        } else {
            query("UPDATE `{$engine->server->prefix}kingdom` SET `indesc`=? WHERE `id`=?;", [$desc, $id]);
        }
    }

    public function getByPlayer($uid, $field = null) {
        global $engine;

        $p = query("SELECT * FROM `{$engine->server->prefix}user` WHERE `uid`=?;", [$uid])->fetch(PDO::FETCH_ASSOC);
        if ($p['kingdom'] != 0) {
            $k = query("SELECT * FROM `{$engine->server->prefix}kingdom` WHERE `id`=?;", [$p['kingdom']])->fetch(PDO::FETCH_ASSOC);
            return $field === null ? $k : $k[$field];
        } else {
            return false;
        }
    }

    public function getInf() {
        global $engine;

        $k = $this->getByPlayer($_SESSION[$engine->server->prefix . 'uid']);

        //Get duke & king data
        $dk = query("SELECT * FROM `{$engine->server->prefix}user` WHERE `uid`=? OR `uid`=? OR `uid`=? OR `uid`=? OR `uid`=? ;", [$k['king'], $k['duke1'], $k['duke2'], $k['duke3'], $k['duke4']])->fetchAll(PDO::FETCH_ASSOC);
        $r = [];
        foreach ($dk as $p) {
            $vs = query("SELECT * FROM `{$engine->server->prefix}village` WHERE `owner`=? AND `area`=?;", [$p['uid'], -1])->fetchAll(PDO::FETCH_ASSOC);
            foreach ($vs as $v) {

                $infLevel = 4;
                $infSize = 4.2;
                $infFull = 10000;
                if ($v['pop'] < 1000) {
                    $infLevel = 3;
                    $infSize = 4.2;
                    $infFull = 1000;
                }
                if ($v['pop'] < 500) {
                    $infLevel = 2;
                    $infSize = 3.2;
                    $infFull = 500;
                }
                if ($v['pop'] < 250) {
                    $infLevel = 1;
                    $infSize = 2.3;
                    $infFull = 250;
                }
                if ($v['pop'] < 100) {
                    $infLevel = 0;
                    $infSize = 1.3;
                    $infFull = 100;
                }

                $prepare = [
                    $v['wid'] => [
                        "villageId" => $v['wid'],
                        "villageName" => $v['vname'],
                        "population" => $v['pop'],
                        "influence" => $v['pop'],
                        "treasureBonus" => 1,
                        "size" => $infSize,
                        "level" => $infLevel,
                        "currentCells" => 21,
                        "nextCells" => 21,
                        "playerId" => $p['uid'],
                        "players" => [
                            $p['uid'] => [
                                "name" => $p['username'],
                                "cells" => 21
                            ]
                        ],
                        "currentFrom" => $v['pop'],
                        "currentTo" => $infFull
                    ]
                ];
                $r = $r + $prepare;
            }
        }
        return $r;
    }

}
