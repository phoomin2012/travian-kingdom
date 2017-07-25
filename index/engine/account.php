<?php
class Account{

    public function Signup($post){
        global $engine;
        //$post['name'] = mysqli_real_escape_string($post['name']);
        //$post['email'] = mysqli_real_escape_string($post['email']);
        $post['pw'] = base64_encode($post['pw']);
        $sql = "INSERT INTO `global_user` (`username`,`password`,`email`,`timed`) VALUE ('".$post['name']."','".$post['pw']."','".$post['email']."','".time()."');";
        $q = $engine->sql->prepare($sql);
        if($q->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function Login($post){
        global $engine;
        //$post['name'] = mysqli_real_escape_string($post['name']);
        $post['pw'] = base64_encode($post['pw']);
        $q = $engine->sql->prepare("SELECT * FROM `global_user` WHERE `username`='".$post['name']."';");
        $q->execute();
        $n = $q->rowCount();
        if($n==1){
            $u = $q->fetch();
            if($u['password']==$post['pw']){
                $engine->session->data = (object) $u;
                $_SESSION['uid'] = $u['uid'];
                $_SESSION['username'] = $u['username'];
                $_SESSION['email'] = $u['email'];
                return true;
            }else{
                return false;
            }

        }else{
            return false;
        }
    }
}
?>
