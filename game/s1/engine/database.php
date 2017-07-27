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
        while ($s = $q->fetch()) {
            $r[$i] = $s;
            for ($f = 0; $f < 17; $f+=1) {
                unset($r[$i][$f]);
            }
            $i+=1;
        }
        return $r;
    }

    public function getServerInfo() {
        global $engine;
        return query("SELECT * FROM `global_server_data` WHERE `tag`=?;", array(SERVER_TAG))->fetch();
    }

    public function msid($email = "abcdefghijklmnopqrstuvwxyz") {
        $token = rand(0, 1000);
        $token = $token . $email . rand(1000, 10000);
        $token = hash('adler32', $token);
        $token = time() . $token;
        $token = hash('crc32b', $token);
        $token = $token . hash('crc32', $token);

        $q = query("SELECT * FROM `global_msid` WHERE `email`=? AND `ip`=?", array($email, $_SERVER['REMOTE_ADDR']));
        if ($q->rowCount() == 1) {
            $t = $q->fetch();
            $token = $t['token'];
        } else {
            query("DELETE FROM `global_msid` WHERE `email`=? AND `ip`=?", array($email, $_SERVER['REMOTE_ADDR']));
            query("INSERT INTO `global_msid` (`token`,`email`,`ip`) VALUES (?,?,?);", array($token, $email, $_SERVER['REMOTE_ADDR']));
        }
        return $token;
    }

    public function getmsid($token) {
        $q = query("SELECT * FROM `global_msid` WHERE `token`=?", array($token));
        if ($q->rowCount() == 1) {
            $t = $q->fetch();
            $u = query("SELECT * FROM `global_user` WHERE `email`=?;", array($t['email']))->fetch();
            return $u;
        } else {
            return false;
        }
    }

}

?>
