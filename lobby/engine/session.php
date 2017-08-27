<?php

session_start();
include_once(dirname(__FILE__) . "/../../config.php");
include_once(dirname(__FILE__) . "/avatar.php");
include_once(dirname(__FILE__) . "/account.php");
include_once(dirname(__FILE__) . "/achievement.php");
include_once(dirname(__FILE__) . "/cache.php");
include_once(dirname(__FILE__) . "/notification.php");
include_once(dirname(__FILE__) . "/prestige.php");
include_once(dirname(__FILE__) . "/database.php");
include_once(dirname(__FILE__) . "/server.php");
include_once(dirname(__FILE__) . "/essentials.php");

class Session {

    public $data = null;

    public function get() {
        global $engine;

        return [
            "name" => "Session:" . $_SESSION['mellon_msid'],
            "data" => [
                "sessionId" => $_SESSION['mellon_msid'],
                "type" => 0,
                "country" => "en"
            ]
        ];
    }

    public function checkLogin() {
        global $engine;
        if (isset($_SESSION['lobby_uid'])) {
            if ($_SESSION['lobby_uid'] != "" && $_SESSION['lobby_uid'] != null) {
                $u = query("SELECT * FROM `global_user` WHERE `uid`='" . $_SESSION['lobby_uid'] . "';")->fetch(PDO::FETCH_ASSOC);
                $u['islogin'] = true;
                $this->data = (object) $u;
                $_SESSION['lobby_uid'] = $u['uid'];
                $_SESSION['lobby_username'] = $u['username'];
                $_SESSION['lobby_email'] = $u['email'];
                //return true;
            } else {
                $this->data = (object) array(
                            "uid" => 0,
                            "username" => "",
                            "email" => "",
                            "islogin" => false,
                );
                $_SESSION['lobby_uid'] = "";
                $_SESSION['lobby_username'] = "";
                $_SESSION['lobby_email'] = "";
                //return false;
            }
        } else {
            $this->data = (object) array(
                        "uid" => 0,
                        "username" => "",
                        "email" => "",
                        "islogin" => false,
            );
            //return false;
        }
    }

}

$engine = (object) array(
            "sql" => new PDO("mysql:host=" . SQL_HOST . "; dbname=" . SQL_DATB . ";", SQL_USER, SQL_PASS),
            "session" => new Session(),
            "database" => new Database(),
            "account" => new Account(),
            "avatar" => new Avatar(),
            "noti" => new Notification(),
            "achv" => new Achievement(),
            "prestige" => new Prestige(),
    "server" => new Server(),
);
$engine->sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$engine->sql->exec("SET CHARACTER SET utf8");
$engine->sql->exec("SET character_set_results=utf8");
$engine->sql->exec("SET character_set_client=utf8");
$engine->sql->exec("SET character_set_connection=utf8");

$engine->session->checkLogin();
