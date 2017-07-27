<?php

class Account {

    public function Signup($email, $pass) {
        global $engine;
        if ($pass['password'] == $pass['passwordRepeat']) {
            $pass = base64_encode($pass['password']);
            $sql = "INSERT INTO `global_user` (`email`,`password`,`timed`) VALUE (?,?,?);";
            $array = array($email, $pass, time());
            $q = $engine->sql->prepare($sql);
            if ($q->execute($array)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function Login($email, $pass) {
        global $engine;
        //$post['name'] = mysqli_real_escape_string($post['name']);
        //$pass = base64_encode($pass);
        $q = query("SELECT * FROM `global_user` WHERE `email`=?;", array($email));
        $n = $q->rowCount();
        if ($n == 1) {
            $u = $q->fetch();
            if (base64_decode($u['password']) == $pass) {
                $engine->session->data = (object) $u;
                $_SESSION['mellon_uid'] = $u['uid'];
                $_SESSION['mellon_username'] = $u['username'];
                $_SESSION['mellon_email'] = $u['email'];
                $token = $engine->database->msid($u['email']);
                $_SESSION['mellon_msid'] = $token;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function Logout() {
        global $engine;
        unset($_SESSION['mellon_uid']);
        unset($_SESSION['mellon_username']);
        unset($_SESSION['mellon_email']);
        unset($_SESSION['mellon_msid']);
    }

    public function WSignup($world) {
        global $engine;
        if (query("SELECT * FROM `" . $engine->server->prefix . "first_play` WHERE `email`=?", array($_SESSION['mellon_email']))->rowCount() == 0) {
            $sql = "INSERT INTO `" . $engine->server->prefix . "first_play` (`email`,`step`) VALUE (?,?);";
            $array = array($_SESSION['mellon_email'], 0);
            if (query($sql, $array)) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

}

?>
