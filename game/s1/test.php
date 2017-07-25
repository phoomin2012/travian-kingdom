<?php
include_once dirname(__FILE__) . '/engine/engine.php';

$k = query("SELECT * FROM `{$engine->server->prefix}kingdom` WHERE `id`=?;",[1])->fetch(PDO::FETCH_ASSOC);
var_dump($k);