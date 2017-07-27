<?php
include_once dirname(__FILE__) . '/../engine/engine.php';
$request_body = file_get_contents('php://input');
$data = json_decode($request_body, true);
header('Content-Type: application/json');

if ($data['controller'] == "login") {
    include_once dirname(__FILE__) . '/controller/login.php';
} elseif ($data['controller'] == "cache") {
    include_once dirname(__FILE__) . '/controller/cache.php';
} elseif ($data['controller'] == "troops") {
    include_once dirname(__FILE__) . '/controller/troops.php';
} elseif ($data['controller'] == "village") {
    include_once dirname(__FILE__) . '/controller/village.php';
} elseif ($data['controller'] == "map") {
    include_once dirname(__FILE__) . '/controller/map.php';
} elseif ($data['controller'] == "player") {
    include_once dirname(__FILE__) . '/controller/player.php';
} elseif ($data['controller'] == "quest") {
    include_once dirname(__FILE__) . '/controller/quest.php';
} elseif ($data['controller'] == "building") {
    include_once dirname(__FILE__) . '/controller/building.php';
} elseif ($data['controller'] == "premiumFeature") {
    include_once dirname(__FILE__) . '/controller/premiumFeature.php';
} elseif ($data['controller'] == "hero") {
    include_once dirname(__FILE__) . '/controller/hero.php';
} elseif ($data['controller'] == "ranking") {
    include_once dirname(__FILE__) . '/controller/ranking.php';
} elseif ($data['controller'] == "payment") {
    include_once dirname(__FILE__) . '/controller/payment.php';
} elseif ($data['controller'] == "reports") {
    include_once dirname(__FILE__) . '/controller/report.php';
} elseif ($data['controller'] == "trade") {
    include_once dirname(__FILE__) . '/controller/trade.php';
} elseif ($data['controller'] == "kingdom") {
    include_once dirname(__FILE__) . '/controller/kingdom.php';
} elseif ($data['controller'] == "auctions") {
    include_once dirname(__FILE__) . '/controller/auction.php';
}