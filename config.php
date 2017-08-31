<?php

ini_set('display_errors', 'On');
define('SQL_HOST', '127.0.0.1');
define('SQL_USER', 'root');
define('SQL_PASS', '');
define('SQL_DATB', 'travian5_new');
define('LANGUAGE', 'en');

if (isset($_SERVER['SERVER_ADDR'])) {
    if ($_SERVER['SERVER_ADDR'] == "::1" || $_SERVER['SERVER_ADDR'] == "localhost" || $_SERVER['SERVER_ADDR'] == "127.0.0.1") {
        $index_url = "http://kingdoms.t5.ph/";
        $mellon_url = "http://mellon.t5.ph/";
        $cdn_url = "http://cdn.t5.ph/";
        $lobby_url = "http://lobby.t5.ph/";
        $domain = "t5.ph";
        $game_dir = "";
		
    } else {
        $index_url = "http://kingdoms.t5.phumin.in.th/";
        $mellon_url = "http://mellon.t5.phumin.in.th/";
        $cdn_url = "http://cdn.t5.phumin.in.th/";
        $lobby_url = "http://lobby.t5.phumin.in.th/";
        $domain = "t5.phumin.in.th";
        $game_dir = "";
    }
}

function protocalRemove($url) {
    preg_match("/(https|http)\:\/\/([\w]+)[.]+([.\w]+)/", $url, $matches);
    return $matches[2] . "." . $matches[3];
}

set_error_handler('myErrorHandler');
register_shutdown_function('fatalErrorShutdownHandler');

function myErrorHandler($code, $message, $file, $line) {
    $row = query("SELECT * FROM `error_php` WHERE `host`=? AND `code`=? AND `message`=? AND `file`=? AND `line`=?;",[$_SERVER['HTTP_HOST'], $code, $message, $file, $line])->fetchAll(PDO::FETCH_ASSOC);
    if(count($row) == 0){
        query("INSERT INTO `error_php` (`host`,`code`,`message`,`file`,`line`,`count`,`last`) VALUES (?,?,?,?,?,?,?);", [$_SERVER['HTTP_HOST'], $code, $message, $file, $line,1,date('Y-m-d H:i:s')]);
    }else{
        query("UPDATE `error_php` SET `count`=`count`+1, `last`=? WHERE `id`=?;",[date('Y-m-d H:i:s'),$row[0]['id']]);
    }
}

function fatalErrorShutdownHandler() {
    $last_error = error_get_last();
    if ($last_error['type'] === E_ERROR) {
        myErrorHandler(E_ERROR, $last_error['message'], $last_error['file'], $last_error['line']);
    }
}
