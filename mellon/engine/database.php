<?php

class Database {

    function listServer() {
        global $engine;
        $sql = "SELECT * FROM `global_server_data`";
        $s = query($sql)->fetchAll();
        $r = array();
        for ($i = 0; $i < count($s); $i++) {
            $r[$i] = array(
                "applicationId" => "travian-ks",
                "applicationCountryId" => "en",
                "applicationInstanceId" => $s[$i]['tag'],
                "title" => $s[$i]['name'],
                "status" => "active",
                "serverAge" => round((time()-$s[$i]['start'])/86400),
                "population" => (string) query("SELECT * FROM `".$s[$i]['prefix']."user`")->rowCount(),
                "isInMaintenance" => (int) $s[$i]['maintenance'],
                "recommended" => (int) $s[$i]['recommended'],
                "additionalInfo" => array($s[$i]),
                "beta" => 0,
            );
        }
        return $r;
    }
    
    public function msid($email="abcdefghijklmnopqrstuvwxyz") {
        $token = rand(0,1000);
        $token = $token.$email.rand(1000,10000);
        $token = hash('adler32', $token);
        $token = time() . $token;
        $token = hash('crc32b', $token);
        $token = $token . hash('crc32', $token);
        
        $q = query("SELECT * FROM `global_msid` WHERE `email`=? AND `ip`=?",array($email, $_SERVER['REMOTE_ADDR']));
        if($q->rowCount() == 1){
            $t = $q->fetch();
            $token = $t['token'];
        }else{
            query("DELETE FROM `global_msid` WHERE `email`=? AND `ip`=?",array($email, $_SERVER['REMOTE_ADDR']));
            query("INSERT INTO `global_msid` (`token`,`email`,`ip`) VALUES (?,?,?);", array($token, $email, $_SERVER['REMOTE_ADDR']));
        }
        return $token;
    }
    
    public function getServerInfo($world){
        global $engine;
        return query("SELECT * FROM `global_server_data` WHERE `sid`=?;",array($world))->fetch();
    }
}

