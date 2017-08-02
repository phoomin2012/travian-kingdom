<?php

ini_set('display_errors', 'On');
define('SQL_HOST', '127.0.0.1');
define('SQL_USER', 'root');
define('SQL_PASS', '');
define('SQL_DATB', 'travian5_new');

if (isset($_SERVER['SERVER_ADDR'])) {
    if ($_SERVER['SERVER_ADDR'] == "::1" || $_SERVER['SERVER_ADDR'] == "localhost" || $_SERVER['SERVER_ADDR'] == "127.0.0.1") {
        $index_url = "http://kingdoms.t5.ph/";
        $mellon_url = "http://mellon.t5.ph/";
        $cdn_url = "http://cdn.t5.ph/";
        $lobby_url = "http://lobby.t5.ph/";
        $domain = "t5.ph";
        $game_dir = "";

        /* $index_url = "http://localhost/travian5/index/";
          $mellon_url = "http://localhost/travian5/mellon/";
          $cdn_url = "http://localhost/travian5/cdn/";
          $lobby_url = "http://localhost/travian5/lobby/";
          $domain = "localhost";
          $game_dir = "travian5/game/"; */
    } else {
        $index_url = "http://kingdoms.t5.ph/";
        $mellon_url = "http://mellon.t5.ph/";
        $cdn_url = "http://cdn.t5.ph/";
        $lobby_url = "http://lobby.t5.ph/";
        $domain = "t5.ph";
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
    query("INSERT INTO `error_php` (`host`,`code`,`message`,`file`,`line`) VALUES (?,?,?,?,?);", [$_SERVER['HTTP_HOST'], $code, $message, $file, $line]);
}

function fatalErrorShutdownHandler() {
    $last_error = error_get_last();
    if ($last_error['type'] === E_ERROR) {
        myErrorHandler(E_ERROR, $last_error['message'], $last_error['file'], $last_error['line']);
    }
}
