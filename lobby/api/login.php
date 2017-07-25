<?php
include_once dirname(__FILE__).'/../engine/session.php';

if($_GET['token']==md5($_GET['msid'])){
    $engine->account->Login($_GET['msid']);
}else{
    header("Location: ".$index_url);
}