<?php

class Session {

    public $data = null;

    public function MakeLogin() {
        global $engine;
        $q = query("SELECT * FROM `global_user` WHERE `username`=?;", array($_GET['username']));
        if ($q->rowCount() == 1) {
            $q2 = query("SELECT * FROM `" . $engine->server->prefix . "user` WHERE `username`=?;", array($_GET['username']));
            if ($q2->rowCount() == 0) {
                $u = $q->fetch();
                if ($engine->account->Signup($_GET['username'])) {
                    $engine->account->Login($_GET['username']);
                    header("Location: ?token=");
                } else {
                    header("Location: ../../?lobby");
                }
            } else {
                $engine->account->Login($_GET['username']);
                header("Location: ?token=");
            }
        } else {
            header("Location: ../../?lobby");
        }
    }

    public function checkLogin() {
        global $engine;
        if (isset($_SESSION[$engine->server->prefix . 'uid'])) {
            if ($_SESSION[$engine->server->prefix . 'uid'] != "") {
                $u = query("SELECT * FROM `" . $engine->server->prefix . "user` WHERE `uid`=?;", array($_SESSION[$engine->server->prefix . 'uid']))->fetch(PDO::FETCH_ASSOC);
                $this->data = (object) $u;
                $_SESSION[$engine->server->prefix . 'uid'] = $u['uid'];
                $_SESSION[$engine->server->prefix . 'username'] = $u['username'];
                $_SESSION[$engine->server->prefix . 'avatar'] = $u['avatar'];
                $_SESSION[$engine->server->prefix . 'gold'] = $u['gold'];
                $_SESSION[$engine->server->prefix . 'tribe'] = $u['tribe'];
                $_SESSION[$engine->server->prefix . 'tutorial'] = $u['tutorial'];
                return true;
            } else {
                return false;
            }
        }
    }

}