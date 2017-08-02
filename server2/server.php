<?php
$ignoreLoad = true;
$_SERVER['HTTP_HOST'] = 'game_service';
include __DIR__ . '/../game/s1/engine/engine.php';

$interval = 0.5;
$time = microtime(true);
$next = $time + $interval;

while (true) {
    $time = microtime(true);
    if ($time - $next >= 0) {
        $next = $time + $interval;
        $engine->auto->work();
    }
}
