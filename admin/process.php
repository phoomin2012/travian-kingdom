<?php

include_once __DIR__ . '/engine/engine.php';

$s = $engine->database->getServer($_GET['id']);
$engine->server = (object) $s;
if ($s) {
    switch ($_GET['p']) {
        case 'install':
            if ($s['installed'] == "1") {
                $q = query("SHOW TABLES LIKE ?;", ["%{$s['prefix']}%"])->fetchAll();
                foreach ($q as $n) {
                    $n = $n[0];
                    query("TRUNCATE TABLE `{$n}`");
                }
                $engine->world->generateMap();
                query("UPDATE `global_server_data` SET `start`=? WHERE `sid`=?;", [time(), $_GET['id']]);
            } else {
                
            }
            header("Location: index.php?p=info&id={$_GET['id']}");
            break;
        case 'import':
            $sql = file_get_contents(__DIR__ . '/sql.sql');
            query($sql);
            header("Location: index.php");
            break;
        default:
            header("Location: index.php");
            break;
    }
} else {
    header("Location: index.php");
}