<?php
class Database{
    function listServer(){
        global $engine;
        $sql = "SELECT * FROM `global_server_data`";
        $q = $engine->sql->prepare($sql);
        $q->execute();
        $r = array();
        $i = 0;
        while($s = $q->fetch()){
            $r[$i] = $s;
            for($f=0;$f<17;$f+=1){
                unset($r[$i][$f]);
            }
            $i+=1;
        }
        return $r;
    }
}
?>
