<?php
class Setting{
    public $data = null;
    public function getAll($uid=null){
        global $engine;
        if($uid===null){
            $uid = $_SESSION[$engine->server->prefix.'uid'];
        }
        $return = null;
        $return = query("SELECT * FROM `".$engine->server->prefix."setting` WHERE `uid`=?;",array($uid))->fetch();
        $return['playerId'] = $return['uid'];
        if($return['TabNotifications']=="1"){
            $return['enableTabNotifications'] = "1";
            $return['disableTabNotifications'] = 0;
        }else{
            $return['enableTabNotifications'] = "0";
            $return['disableTabNotifications'] = 1;
        }
        if($return['HelpNotifications']=="1"){
            $return['enableHelpNotifications'] = "1";
            $return['disableHelpNotifications'] = false;
        }else{
            $return['enableHelpNotifications'] = "0";
            $return['disableHelpNotifications'] = true;
        }
        
        unset($return['TabNotifications']);
        unset($return['HelpNotifications']);
        unset($return['email']);
        unset($return['uid']);
        unset($return['id']);
        for($i=0;$i<20;$i++){
            unset($return[$i]);
        }
        $this->data = $return;
        return $return;
    }
}

