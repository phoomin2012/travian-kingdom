<?php

if ($data['action'] == "checkCode") {
    echo json_encode(array(
        "respone" => array(
            "data" => array(1)
        ),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "setDeviceDimension") {
    echo json_encode(array("time" => round(microtime(true) * 1000), "response" => array()));
} elseif ($data['action'] == "logout") {
    echo json_encode(array(
        "time" => round(microtime(true) * 1000),
        "response" => array(
            'data' => $lobby_url . 'api/login.php?token=' . $_SESSION['mellon_msid']
        )
    ));
}