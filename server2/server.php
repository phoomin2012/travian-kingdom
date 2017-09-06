<?php

$ignoreLoad = true;
$_SERVER['HTTP_HOST'] = 'game_service';
include __DIR__ . '/../game/s1/engine/engine.php';

$interval = 0.5;
$time = microtime(true);
$next = $time + $interval;

function msleep($time) {
    usleep($time * 1000000);
}

while (true) {
    $engine->auto->work();
    msleep($interval);
}
