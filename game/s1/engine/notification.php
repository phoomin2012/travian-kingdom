<?php

class Notification {

    public function getAll($id = null, $data = true) {
        global $engine;
        if ($id === null) {
            $id = $_SESSION[$engine->server->prefix . 'uid'];
        }
        $n = query("SELECT * FROM `" . $engine->server->prefix . "notification` WHERE `player`=?;", array($id))->fetchAll(PDO::FETCH_ASSOC);
        $r = array();
        //for ($i = 0; $i < count($n); $i++) {
        for ($i = 0; $i < count($n); $i++) {
            $d = [
                "itemId" => $n[$i]['itemId'],
                "type" => $n[$i]['type'],
                "pId" => $n[$i]['player'],
                "count" => $n[$i]['count'],
                "expireTime" => 0,
                "time" => time() + 3600,
            ];
            array_push($r, array(
                "name" => "Notifications:" . ($i + 1),
                "data" => $data ? $d : "",
            ));
        }
        return $r;
    }

    public function add($uid, $type, $itemId, $icon, $expire = 2592000) {
        global $engine;

        $numtype = query("SELECT * FROM `" . $engine->server->prefix . "notification` WHERE `player`=? AND `type`=?;", [$uid, $type])->rowCount();
        if ($numtype == 0)
            query("INSERT INTO `" . $engine->server->prefix . "notification` (`player`,`type`,`itemId`,`icon`,`expire`) VALUES (?,?,?,?,?);", [$uid, $type, $itemId, $icon, $expire]);
        else
            query("UPDATE `" . $engine->server->prefix . "notification` SET `count`=`count`+1 WHERE `player`=? AND `type`=?", [$uid, $type]);

        // Send Notification Cache
        $engine->auto->emitCache($uid, [
            "name" => "Collection:Notifications:",
            "data" => array(
                "operation" => 1,
                "cache" => $this->getAll($uid),
            ),
        ]);
    }

    public function delete($id, $all = false) {
        global $engine;
        if ($all === false) {
            $owner = query("SELECT * FROM `" . $engine->server->prefix . "notification` WHERE `id`=?;", [$id])->fetch(PDO::FETCH_ASSOC);
            query("DELETE FROM `" . $engine->server->prefix . "notification` WHERE `id`=?;", [$id]);
            $engine->auto->emitCache($owner['player'], [
                "name" => "Collection:Notifications:",
                "data" => array(
                    "operation" => 1,
                    "cache" => $this->getAll($owner['player'],false),
                ),
            ]);
        } else {
            query("DELETE FROM `" . $engine->server->prefix . "notification` WHERE `player`=?;", [$id]);
            $engine->auto->emitCache($id, [
                "name" => "Collection:Notifications:",
                "data" => array(
                    "operation" => 1,
                    "cache" => $this->getAll($id,false),
                ),
            ]);
        }
    }

    public function deleteByType($uid, $type) {
        global $engine;
        query("DELETE FROM `" . $engine->server->prefix . "notification` WHERE `type`=? AND `player`=?;", [$type, $uid]);
        $engine->auto->emitCache($uid, [
            "name" => "Collection:Notifications:",
            "data" => array(
                "operation" => 1,
                "cache" => $this->getAll($uid,false),
            ),
        ]);
    }

}
