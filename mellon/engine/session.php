<?php

@session_start();
include_once(dirname(__FILE__) . "/../../config.php");
include_once(dirname(__FILE__) . "/account.php");
include_once(dirname(__FILE__) . "/database.php");
include_once(dirname(__FILE__) . "/page.php");
include_once(dirname(__FILE__) . "/essentials.php");

//include_once(dirname(__FILE__) . "/language/en.php");

class Session {

    public $data = null;

    public function checkLogin() {
        global $engine;
        if (isset($_SESSION['mellon_msid']) && $_SESSION['mellon_msid'] != "") {
            $msid = query("SELECT * FROM `global_msid` WHERE `token`=?;", [$_SESSION['mellon_msid']])->fetch(PDO::FETCH_ASSOC);
            if ($msid) {
                $u = query("SELECT * FROM `global_user` WHERE `email`=?;", [$msid['email']])->fetch(PDO::FETCH_ASSOC);
                $u['islogin'] = true;
                $this->data = (object) $u;
                $_SESSION['mellon_uid'] = $u['uid'];
                $_SESSION['mellon_username'] = $u['username'];
                $_SESSION['mellon_email'] = $u['email'];
                return true;
            } else {
                return false;
            }
        }elseif (isset($_SESSION['mellon_username'])) {
            if ($_SESSION['mellon_username'] != "" && $_SESSION['mellon_username'] != null) {
                $u = query("SELECT * FROM `global_user` WHERE `username`='" . $_SESSION['mellon_username'] . "';")->fetch(PDO::FETCH_ASSOC);
                $u['islogin'] = true;
                $this->data = (object) $u;
                $_SESSION['mellon_uid'] = $u['uid'];
                $_SESSION['mellon_username'] = $u['username'];
                $_SESSION['mellon_email'] = $u['email'];
                return true;
            } else {
                $this->data = (object) array(
                            "uid" => 0,
                            "username" => "",
                            "email" => "",
                            "islogin" => false,
                );
                $_SESSION['mellon_uid'] = "";
                $_SESSION['mellon_username'] = "";
                $_SESSION['mellon_email'] = "";
                return false;
            }
        } else {
            $this->data = (object) array(
                        "uid" => 0,
                        "username" => "",
                        "email" => "",
                        "islogin" => false,
            );
            return false;
        }
        
    }

}

$engine = (object) array(
            "sql" => new PDO("mysql:host=" . SQL_HOST . "; dbname=" . SQL_DATB . ";", SQL_USER, SQL_PASS),
            "session" => new Session,
            "database" => new Database,
            "account" => new Account,
            "server" => null,
);
$engine->sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$engine->sql->exec("SET CHARACTER SET utf8");
$engine->sql->exec("SET character_set_results=utf8");
$engine->sql->exec("SET character_set_client=utf8");
$engine->sql->exec("SET character_set_connection=utf8");

$engine->session->checkLogin();
?>
