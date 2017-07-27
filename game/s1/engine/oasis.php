<?php

class Oasis {

    public function getList($wid) {
        global $engine;

        $xy = $engine->world->id2xy($wid);
        $in = [];

        for ($x = -3; $x <= 3; $x++) {
            for ($y = -3; $y <= 3; $y++) {
                $id = $engine->world->xy2id($xy[0] + $x, $xy[1] + $y);
                $o = $engine->world->getMapDetail($id);
                if ($o['isOasis']) {
                    array_push($in, [
                        "villageId" => $id,
                        "type" => $o['oasisType'],
                        "isWild" => true,
                        "coordsX" => $xy[0] + $x,
                        "coordsY" => $xy[1] + $y,
                        "usedByVillage" => 0,
                        "myRank" => 1,
                        "kingdomId" => "0",
                        "kingId" => "0",
                        "kingdomInfluence" => 0,
                        "bonus" => $o['oasisBonus'],
                    ]);
                }
            }
        }

        $r = [
            "radius" => 3,
            "inReach" => $in
        ];
        return $r;
    }

    public function getRank($wid) {
        global $engine;
        
        $ranks = query("SELECT * FROM `{$engine->server->prefix}oasis_rank` WHERE `oasis`=? ORDER BY `rank` ASC, `point` ASC", [$wid])->fetchAll(PDO::FETCH_ASSOC);;
        
        return $ranks;
    }

    public function get($wid) {
        global $engine;

        $oasis = query("SELECT * FROM `{$engine->server->prefix}oasis` WHERE `wid`=?", [$wid])->fetch(PDO::FETCH_ASSOC);
        return $oasis;
    }

}
