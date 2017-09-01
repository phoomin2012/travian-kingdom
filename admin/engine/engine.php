<?php

/*
 * Develop by Phumin Chanthalert from Thailand
 * Facebook : http://fb.com/phoomin2012
 * Tel. : 091-8585234 (Thai mobile)
 * Copy Rigth © Phumin Chanthalert.
 */
@session_start();
date_default_timezone_set('Asia/Bangkok');
include_once(dirname(__FILE__) . "/../../config.php");
include_once(dirname(__FILE__) . "/database.php");
include_once(dirname(__FILE__) . "/essentials.php");
include_once(dirname(__FILE__) . "/oasis.php");
include_once(dirname(__FILE__) . "/session.php");
include_once(dirname(__FILE__) . "/unit.php");
include_once(dirname(__FILE__) . "/village.php");
include_once(dirname(__FILE__) . "/world.php");

$engine = (object) array(
            "sql" => new PDO("mysql:host=" . SQL_HOST . "; dbname=" . SQL_DATB . ";", SQL_USER, SQL_PASS),
            "error" => (object) array(
                "sql" => null
            ),
            "session" => new Session(),
            "database" => new Database(),
            "world" => new World(),
            "unit" => new Unit(),
            "oasis" => new Oasis(),
            "math" => new Field_calculate(),
);
$engine->sql->exec("SET CHARACTER SET utf8");
$engine->sql->exec("SET character_set_results=utf8");
$engine->sql->exec("SET character_set_client=utf8");
$engine->sql->exec("SET character_set_connection=utf8");
$engine->sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
define('TB_PREFIX', $engine->server->tag);
