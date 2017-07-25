<?php

ini_set('display_errors', 'On');
define('SQL_HOST', '127.0.0.1');
define('SQL_USER', 'root');
define('SQL_PASS', '');
define('SQL_DATB', 'travian5_new');

if (isset($_SERVER['SERVER_ADDR'])) {
    if ($_SERVER['SERVER_ADDR'] == "::1" || $_SERVER['SERVER_ADDR'] == "localhost" || $_SERVER['SERVER_ADDR'] == "127.0.0.1") {
        $index_url = "http://kingdoms.t5th.ph/";
        $mellon_url = "http://mellon.t5th.ph/";
        $cdn_url = "http://cdn.t5th.ph/";
        $lobby_url = "http://lobby.t5th.ph/";
        $domain = "t5th.ph";
        $game_dir = "";
        
        /*$index_url = "http://localhost/travian5/index/";
        $mellon_url = "http://localhost/travian5/mellon/";
        $cdn_url = "http://localhost/travian5/cdn/";
        $lobby_url = "http://localhost/travian5/lobby/";
        $domain = "localhost";
        $game_dir = "travian5/game/";*/
    } else {
        $index_url = "http://kingdoms.t5.phumin.in.th/";
        $mellon_url = "http://mellon.t5.phumin.in.th/";
        $cdn_url = "http://cdn.t5.phumin.in.th/";
        $lobby_url = "http://lobby.t5.phumin.in.th/";
        $domain = "t5.phumin.in.th";
        $game_dir = "";
    }
}

function protocalRemove($url){
    preg_match("/(https|http)\:\/\/([\w]+)[.]+([.\w]+)/", $url, $matches);
    return $matches[2].".".$matches[3];
}
