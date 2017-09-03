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
        $q = query($sql, []);
        while ($s = $q->fetch(PDO::FETCH_ASSOC)) {
            $s['ww_position'] = json_decode($s['ww_position']);
            $r[] = $s;
        }
        return $r;
    }

    public function getServer($id = null) {
        global $engine;
        $s = query("SELECT * FROM `global_server_data` WHERE `sid`=?;", [$id])->fetch(PDO::FETCH_ASSOC);
        $s['ww_position'] = json_decode($s['ww_position']);
        return $s;
    }

}
