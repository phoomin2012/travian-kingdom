<?php

/*
 * Develop by Phumin Chanthalert from Thailand
 * Facebook : http://fb.com/phoomin2012
 * Tel. : 091-8585234 (Thai mobile)
 * Copy Rigth © Phumin Chanthalert.
 */
@session_start();
ini_set('display_errors', 'On');
define('SERVER_TAG', 'server1');
include_once(dirname(__FILE__) . "/../../../index/engine/config.php");
include_once(dirname(__FILE__) . "/building.php");
include_once(dirname(__FILE__) . "/village.php");
include_once(dirname(__FILE__) . "/account.php");
include_once(dirname(__FILE__) . "/session.php");
include_once(dirname(__FILE__) . "/database.php");
include_once(dirname(__FILE__) . "/unit.php");
include_once(dirname(__FILE__) . "/world.php");
include_once(dirname(__FILE__) . "/generater.php");
include_once(dirname(__FILE__) . "/setting.php");
include_once(dirname(__FILE__) . "/page.php");
include_once(dirname(__FILE__) . "/ranking.php");
include_once(dirname(__FILE__) . "/hero.php");
include_once(dirname(__FILE__) . "/item.php");
include_once(dirname(__FILE__) . "/notification.php");
include_once(dirname(__FILE__) . "/essentials.php");
include_once(dirname(__FILE__) . "/technology.php");
include_once(dirname(__FILE__) . "/movement.php");
include_once(dirname(__FILE__) . "/cache.php");
include_once(dirname(__FILE__) . "/report.php");
include_once(dirname(__FILE__) . "/market.php");
include_once(dirname(__FILE__) . "/battle.php");
include_once(dirname(__FILE__) . "/oasis.php");
include_once(dirname(__FILE__) . "/auto.php");
include_once(dirname(__FILE__) . "/quest.php");
include_once(dirname(__FILE__) . "/kingdom.php");
include_once(dirname(__FILE__) . "/celebrate.php");
include_once(dirname(__FILE__) . "/auction.php");

include_once(dirname(__FILE__) . "/data/buidata.php");
include_once(dirname(__FILE__) . "/data/hero_full.php");
include_once(dirname(__FILE__) . "/data/unitdata.php");
include_once(dirname(__FILE__) . "/data/resdata.php");
include_once(dirname(__FILE__) . "/data/cpdata.php");

$engine = (object) array(
            "sql" => new PDO("mysql:host=" . SQL_HOST . "; dbname=" . SQL_DATB . ";", SQL_USER, SQL_PASS),
            "error" => (object) array(
                "sql" => null
            ),
            "server" => null,
            "kingdom" => new Kingdom(),
            "cache" => new Cache(),
            "session" => new Session(),
            "database" => new Database(),
            "account" => new Account(),
            "world" => new World(),
            "unit" => new Unit(),
            "oasis" => new Oasis(),
            "battle" => new Battle(),
            "building" => new Building(),
            "ranking" => new Ranking(),
            "setting" => new Setting(),
            "item" => new Item(),
            "market" => new Market(),
            "report" => new Report(),
            "quest" => new Quest(),
            "celebrate" => new Celebrate(),
            "page" => (isset($_SERVER['REQUEST_URI'])) ? new Page() : null,
            "notification" => new Notification(),
            "tech" => new Technology(),
            "move" => new Movement(),
            "auction" => new Auction(),
            "data" => (object) array(
                "building" => new BuildingData(),
            ),
            "village" => new Village(),
            "hero" => new Hero(),
            "gen" => new Generater(),
            "auto" => new Auto(),
);
$engine->sql->exec("SET CHARACTER SET utf8");
$engine->sql->exec("SET character_set_results=utf8");
$engine->sql->exec("SET character_set_client=utf8");
$engine->sql->exec("SET character_set_connection=utf8");
$engine->sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$engine->server = (object) $engine->database->getServerInfo();
define('TB_PREFIX', $engine->server->tag);

if (!isset($ignoreLoad)) {
    $engine->session->checkLogin();
    $engine->village->LoadData();
} else {
    if ($ignoreLoad !== true) {
        $engine->session->checkLogin();
        $engine->village->LoadData();
    }
}