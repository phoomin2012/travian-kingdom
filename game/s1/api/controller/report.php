<?php

if ($data['action'] == "getFullReport") {
    echo json_encode(array(
        "response" => $engine->report->get($data['params']['id'], $data['params']['collection']),
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "getLastReports") {
    
    $report = $engine->report->getLast($data['params']['collection'],$data['params']['start'],$data['params']['count']);
    
    echo json_encode(array(
        "response" => [
            'totalNumberOfReports' => count($report),
            'reports' => $report,
        ],
        "serialNo" => $engine->session->serialNo(),
    ));
}