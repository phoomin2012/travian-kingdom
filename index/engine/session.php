<?php
@session_start();
include_once(dirname(__FILE__)."/config.php");
include_once(dirname(__FILE__)."/account.php");
include_once(dirname(__FILE__)."/database.php");
class Session{
    public $data = null;

    public function checkLogin(){
        global $engine;
        if(isset($_SESSION['username'])){
            if($_SESSION['username'] != ""){
                $q = $engine->sql->prepare("SELECT * FROM `global_user` WHERE `username`='".$_SESSION['username']."';");
                $q->execute();
                $u = $q->fetch();
                $this->data = (object) $u;
                return true;
            }else{
                $this->data = (object) array(
                    "uid" => 0,
                    "username" => "",
                    "email" => ""
                );
                $_SESSION['username'] = "";
                return false;
            }
        }
    }
}
$engine = (object) array(
    "sql" => new PDO("mysql:host=".SQL_HOST."; dbname=".SQL_DATB.";", SQL_USER, SQL_PASS),
    "session" => new Session,
    "database" => new Database,
    "account" => new Account,
);
$engine->sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$engine->sql->exec("SET CHARACTER SET utf8");
$engine->sql->exec("SET character_set_results=utf8");
$engine->sql->exec("SET character_set_client=utf8");
$engine->sql->exec("SET character_set_connection=utf8");

?>
