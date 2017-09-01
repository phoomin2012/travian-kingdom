<?php

/*
 * Develop by Phumin Chanthalert from Thailand
 * Facebook : http://fb.com/phoomin2012
 * Tel. : 091-8585234 (Thai mobile)
 * Copy Rigth © Phumin Chanthalert.
 */

class Database {

    public function listServer() {
        global $engine;
        $sql = "SELECT * FROM `global_server_data`";
        $q = $engine->sql->query($sql);
        $r = array();
        $i = 0;
        while ($s = $q->fetch(PDO::FETCH_ASSOC)) {
            $r[$i] = $s;
            for ($f = 0; $f < 17; $f+=1) {
                unset($r[$i][$f]);
            }
            $i+=1;
        }
        return $r;
    }

    public function getServer($sid) {
        global $engine;
        return query("SELECT * FROM `global_server_data` WHERE `sid`=?;", array($sid))->fetch(PDO::FETCH_ASSOC);
    }

}
