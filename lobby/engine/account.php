<?php

class Account {

    public function get() {
        global $engine;

        return [
            "name" => "Player:" . $_SESSION['lobby_uid'],
            "data" => [
                "playerId" => $_SESSION['lobby_uid'],
                "avatarName" => $_SESSION['lobby_username'],
                "userAccountIdentifier" => $_SESSION['lobby_uid'],
                "isInstantAccount" => 0,
                "isActivated" => 1
            ]
        ];
    }

    public function Signup($post) {
        global $engine;
        //$post['name'] = mysqli_real_escape_string($post['name']);
        //$post['email'] = mysqli_real_escape_string($post['email']);
        $post['pw'] = base64_encode($post['pw']);
        $sql = "INSERT INTO `global_user` (`username`,`password`,`email`,`timed`) VALUE (?,?,?,?);";
        $array = array($post['name'], $post['pw'], $post['email'], time());
        $q = $engine->sql->prepare($sql);
        if ($q->execute($array)) {
            return true;
        } else {
            return false;
        }
    }

    public function Login($token) {
        global $engine, $index_url, $domain, $lobby_url;

        $q = query("SELECT * FROM `global_msid` WHERE `token`=? AND `ip`=?;", array($token, $_SERVER['REMOTE_ADDR']));
        $n = $q->rowCount();
        if ($n == 1) {
            $t = $q->fetch();
            $u = query("SELECT * FROM `global_user` WHERE `email`=?;", array($t['email']))->fetch();

            $engine->session->data = (object) $u;
            $_SESSION['lobby_uid'] = $u['uid'];
            $_SESSION['lobby_username'] = $u['username'];
            $_SESSION['lobby_email'] = $u['email'];

            $_SESSION['mellon_uid'] = $u['uid'];
            $_SESSION['mellon_username'] = $u['username'];
            $_SESSION['mellon_email'] = $u['email'];
            $token = $engine->database->msid($u['email']);
            $_SESSION['mellon_msid'] = $token;

            setcookie("gl5SessionKey", json_encode(array(
                "key" => $t['token'],
                "id" => $_SESSION['lobby_uid'],
                    )), time() + 1209600, "/", '.' . $domain);
            setcookie("gl5SessionKey", json_encode(array(
                "key" => $t['token'],
                "id" => $_SESSION['lobby_uid'],
                    )), time() + 1209600, "/", protocalRemove($lobby_url));
            setcookie("gl5PlayerId", 4, time() + 1209600, "/", '.' . $domain);
            setcookie("gl5PlayerId", 4, time() + 1209600, "/", protocalRemove($lobby_url));
            header("Location: ../?g_msid=" . md5($t['token']) . "&gl5SessionKey=" . $t['token']);
            return true;
        } else {
            header("Location: " . $index_url);
            return false;
        }
    }

    public function Logout() {
        global $engine;
        unset($_SESSION['lobby_uid']);
        unset($_SESSION['lobby_username']);
        unset($_SESSION['lobby_email']);
        unset($_SESSION['mellon_uid']);
        unset($_SESSION['mellon_username']);
        unset($_SESSION['mellon_email']);
        unset($_SESSION['mellon_msid']);
    }

}
