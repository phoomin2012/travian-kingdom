<?php

include_once dirname(__FILE__) . '/page.php';
include_once dirname(__FILE__) . '/../../engine/session.php';

$page = new Page();
$a = 0;
if ($page->getURI($a + 1) == "authentication") {
    if ($page->getURI($a + 2) == "login") {
        if (isset($_POST) && count($_POST) > 0) {
            $engine->account->Login($_POST['email'], $_POST['password']);
            include_once dirname(__FILE__) . '/template/redirect.php';
        } else {
            include_once dirname(__FILE__) . '/template/login.php';
        }
    } elseif ($page->getURI($a + 2) == "password-reset-request") {
        if (isset($_POST) && count($_POST) > 0) {
            echo "Password reset have post<br>";
            echo "<pre>";
            var_dump($_POST);
            echo "</pre>";
        } else {
            include_once dirname(__FILE__) . '/template/forgot.php';
        }
    }
} elseif ($page->getURI($a + 1) == "registration") {
    if ($page->getURI($a + 2) == "index") {
        var_dump($_POST);
        if (isset($_POST['email'])) {
            if (!isset($_POST['password'])) {
                include_once dirname(__FILE__) . '/template/register2.php';
            } else {
                if ($engine->account->Signup($_POST['email'], $_POST['password'])) {
                    include_once dirname(__FILE__) . '/template/register2.php';
                }else{
                    $engine->account->Login($_POST['email'], $_POST['password']['password']);
                    include_once dirname(__FILE__) . '/template/redirect.php';
                }
            }
        } else {
            include_once dirname(__FILE__) . '/template/register.php';
        }
    }
} elseif ($page->getURI($a + 1) == "activation") {
    if ($page->getURI($a + 2) == "activate") {
        if (isset($_POST) && count($_POST) > 0) {
            echo "Active have post<br>";
            echo "<pre>";
            var_dump($_POST);
            echo "</pre>";
        } else {
            include_once dirname(__FILE__) . '/template/active.php';
        }
    }
} else {
    echo "<pre>";
    var_dump($page->getURI());
    echo "</pre>";
}