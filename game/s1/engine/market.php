<?php

class Market {

    public function get($wid = null) {
        global $engine;

        $owner = $engine->account->getByVillage($wid);

        $r = [
            "villageId" => $wid,
            "speed" => ($owner['tribe'] == 1) ? 16 : ($owner['tribe'] == 2) ? 24 : 12,
            "max" => $engine->building->getTypeLevel($wid, 17),
            "inTransport" => 0,
            "inOffers" => 0,
            "carry" => ($owner['tribe'] == 1) ? 500 : ($owner['tribe'] == 2) ? 750 : 1000,
        ];
        return $r;
    }

    public function getOffer($wid, $option = ["own" => false, "search" => 0, "offer" => 0, "rate" => 0, "start" => 0, "count" => 8]) {
        global $engine;
        !isset($option['own']) ? $option['own'] = false : '';

        $r = [];
        if ($option['own'])
            $offers = query("SELECT * FROM `{$engine->server->prefix}market` WHERE `wid`=?", [$wid]);
        else
            $offers = query("SELECT * FROM `{$engine->server->prefix}market` WHERE `wid`<>?", [$wid]);
        $offer_count = $offers->rowCount();
        $offers = $offers->fetchAll(PDO::FETCH_ASSOC);

        foreach ($offers as $offer) {
            $owner = $engine->account->getByVillage($offer['wid']);
            $duration = $engine->world->getDuration(16, $wid, $offer['wid']);

            if ($option['own']) {
                array_push($r, [
                    "name" => "TradeOffer:{$offer['id']}",
                    "data" => [
                        "offerId" => $offer['id'],
                        "villageId" => $offer['wid'],
                        "playerId" => $owner['uid'],
                        "playerName" => $owner['username'],
                        "offeredAmount" => $offer['gamt'],
                        "offeredResource" => $offer['gtype'],
                        "searchedAmount" => $offer['wamt'],
                        "searchedResource" => $offer['wtype'],
                        "duration" => $duration,
                        "maximumDuration" => round($offer['maxtime'] / 3600),
                        "limitDuration" => $offer['maxtime'] == 0 ? false : true,
                        "blockedMerchants" => "1",
                        "kingdomId" => $offer['kingdom'],
                        "limitKingdom" => $offer['kingdom'] == 0 ? false : true,
                    ]
                ]);
            } else {
                array_push($r, [
                    "offerId" => $offer['id'],
                    "villageId" => $offer['wid'],
                    "playerId" => $owner['uid'],
                    "playerName" => $owner['username'],
                    "offeredAmount" => $offer['gamt'],
                    "offeredResource" => $offer['gtype'],
                    "searchedAmount" => $offer['wamt'],
                    "searchedResource" => $offer['wtype'],
                    "duration" => $duration,
                    "maximumDuration" => round($offer['maxtime'] / 3600),
                    "limitDuration" => $offer['maxtime'] == 0 ? false : true,
                    "blockedMerchants" => "1",
                    "kingdomId" => $offer['kingdom'],
                    "limitKingdom" => $offer['kingdom'] == 0 ? false : true,
                ]);
            }
        }

        if ($option['own']) {
            return $r;
        } else {
            return [
                "countEntries" => $offer_count,
                "data" => $r,
            ];
        }
    }

    public function createOffer($wid, $offerAmount = 1, $offerType = 1, $searchAmount = 1, $searchType = 2, $onlyKingdom = false, $maxtime = 0) {
        global $engine;
        $engine->auto->procRes($wid);
        if ($offerType == 1)
            query("UPDATE `{$engine->server->prefix}village` SET `wood`=`wood`-? WHERE `wid`=?", [$offerAmount, $wid]);
        elseif ($offerType == 2)
            query("UPDATE `{$engine->server->prefix}village` SET `clay`=`clay`-? WHERE `wid`=?", [$offerAmount, $wid]);
        elseif ($offerType == 3)
            query("UPDATE `{$engine->server->prefix}village` SET `iron`=`iron`-? WHERE `wid`=?", [$offerAmount, $wid]);
        elseif ($offerType == 4)
            query("UPDATE `{$engine->server->prefix}village` SET `crop`=`crop`-? WHERE `wid`=?", [$offerAmount, $wid]);
        query("INSERT INTO `{$engine->server->prefix}market` (`wid`,`gtype`,`gamt`,`wtype`,`wamt`,`maxtime`,`kingdom`,`merchant`) VALUES (?,?,?,?,?,?,?,?);", [$wid, $offerType, $offerAmount, $searchType, $searchAmount, $maxtime, $onlyKingdom ? 1 : 0, 1]);
    }

    public function cancelOffer($id) {
        global $engine;
        $offer = query("SELECT * FROM `{$engine->server->prefix}market` WHERE `id`=?", [$id])->fetch(PDO::FETCH_ASSOC);
        $engine->auto->procRes($offer['wid']);
        if ($offer['gtype'] == 1)
            query("UPDATE `{$engine->server->prefix}village` SET `wood`=`wood`+? WHERE `wid`=?", [$offer['gamt'], $offer['wid']]);
        elseif ($offer['gtype'] == 2)
            query("UPDATE `{$engine->server->prefix}village` SET `clay`=`clay`+? WHERE `wid`=?", [$offer['gamt'], $offer['wid']]);
        elseif ($offer['gtype'] == 3)
            query("UPDATE `{$engine->server->prefix}village` SET `iron`=`iron`+? WHERE `wid`=?", [$offer['gamt'], $offer['wid']]);
        elseif ($offer['gtype'] == 4)
            query("UPDATE `{$engine->server->prefix}village` SET `crop`=`crop`+? WHERE `wid`=?", [$offer['gamt'], $offer['wid']]);
        query("DELETE FROM `{$engine->server->prefix}market` WHERE `id`=?", [$id]);
        return $offer['wid'];
    }

    public function checkTarget($from, $to) {
        global $engine;

        $target = $engine->account->getByVillage($to);
        $owner = $engine->account->getByVillage($from);
        $duration = $engine->world->getDuration(($owner['tribe'] == 1) ? 16 : ($owner['tribe'] == 2) ? 24 : 12, $from, $to);
        $village = $engine->village->get($to, false);
        return [
            "playerId" => $target['uid'],
            "villageId" => $village['villageId'],
            "villageName" => $village['name'],
            "mayCreateRoute" => true,
            "duration" => $duration
        ];
    }

    public function send($from, $to, $recurrences, $res) {
        global $engine;

        $tid = $engine->unit->createUnit($from, [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0]);

        $owner = $engine->account->getByVillage($from);
        $duration = $engine->world->getDuration(($owner['tribe'] == 1) ? 16 : ($owner['tribe'] == 2) ? 24 : 12, $from, $to);
        $start = time();
        $end = $start + $duration;
        $p = $engine->account->getByVillage($from, 'uid');

        $params = array($from, $p, $to, 7, 0, 0, $start, $end, $tid, 1, json_encode($res));
        query("INSERT INTO `" . $engine->server->prefix . "troop_move` (`from`,`owner`,`to`,`type`,`spy`,`redeployHero`,`start`,`end`,`unit`,`merchant`,`data`) VALUES (?,?,?,?,?,?,?,?,?,?,?);", $params);

        // Decrease resources from village
        $engine->auto->procRes($from);
        query("UPDATE `" . $engine->server->prefix . "village` SET `wood`=`wood`-?,`clay`=`clay`-?,`iron`=`iron`-?,`crop`=`crop`-? WHERE `wid`=?", array($res[1], $res[2], $res[3], $res[4], $from));
        $engine->auto->emitCache($p, $engine->village->get($from));

        // Send data to source
        $us = $engine->account->getByVillage($from, 'uid');
        $engine->auto->emitCache($us, $engine->move->get($from));

        //Send data to target
        $ut = $engine->account->getByVillage($to, 'uid');
        $engine->auto->emitCache($ut, $engine->move->get($to));

        //Send flash notification
        $engine->auto->emitEvent($us, array(
            "name" => "flashNotification",
            "data" => "50",
        ));

        return $tid;
    }

}
