<?php

class Setting {

    public $data = null;

    public function getAll($uid = null, $head = false) {
        global $engine;
        if (is_bool($uid)) {
            $head = $uid;
            $uid = null;
        }
        if ($uid === null) {
            $uid = $_SESSION[$engine->server->prefix . 'uid'];
        }
        $return = null;
        $return = query("SELECT * FROM `{$engine->server->prefix}setting` WHERE `uid`=?;", array($uid))->fetch(PDO::FETCH_ASSOC);
        $return['playerId'] = $return['uid'];
        if ($return['TabNotifications'] == "1") {
            $return['enableTabNotifications'] = 1;
            $return['disableTabNotifications'] = 0;
        } else {
            $return['enableTabNotifications'] = 0;
            $return['disableTabNotifications'] = 1;
        }
        if ($return['HelpNotifications'] == "1") {
            $return['enableHelpNotifications'] = 1;
            $return['disableHelpNotifications'] = false;
        } else {
            $return['enableHelpNotifications'] = 0;
            $return['disableHelpNotifications'] = true;
        }
        if ($return['WelcomeScreen'] == "1") {
            $return['enableWelcomeScreen'] = 1;
            $return['disableWelcomeScreen'] = false;
        } else {
            $return['enableWelcomeScreen'] = 0;
            $return['disableWelcomeScreen'] = true;
        }

        unset($return['WelcomeScreen']);
        unset($return['TabNotifications']);
        unset($return['HelpNotifications']);
        unset($return['email']);
        unset($return['uid']);
        unset($return['id']);
        $this->data = $return;
        if ($head) {
            return [
                "name" => "Settings:" . $uid,
                "data" => $return,
            ];
        } else {
            return $return;
        }
    }

    public function change($params) {
        global $engine;
        $array = [];
        $sql = "";
        foreach ($params as $key => $value) {
            if ($key == 'enableTabNotifications' || $key == "disableTabNotifications") {
                $key = 'TabNotifications';
                if ($key == 'enableTabNotifications') {
                    $value = ($value) ? 0: 1;
                } else {
                    $value = (!$value) ? 0: 1;
                }
            }elseif ($key == 'enableHelpNotifications' || $key == "disableHelpNotifications") {
                $key = 'HelpNotifications';
                if ($key == 'enableHelpNotifications') {
                    $value = ($value) ? 0: 1;
                } else {
                    $value = (!$value) ? 0: 1;
                }
            }elseif ($key == 'enableWelcomeScreen' || $key == "disableWelcomeScreen") {
                $key = 'WelcomeScreen';
                if ($key == 'enableWelcomeScreen') {
                    $value = ($value) ? 0: 1;
                } else {
                    $value = (!$value) ? 0: 1;
                }
            }
            $sql .= "`{$key}`=?,";
            $array[] = $value;
        }
        $sql = trim($sql, ',');
        $sql = "UPDATE `{$engine->server->prefix}setting` SET {$sql} WHERE `uid`=?;";
        $array[] = $_SESSION[$engine->server->prefix . 'uid'];
        query($sql, $array);
    }

}
