<?php

include_once __DIR__ . '/engine/engine.php';

if (isset($_GET['id'])) {
    $s = $engine->database->getServer($_GET['id']);
    $engine->server = (object) $s;
}
switch ($_GET['p']) {
    case 'install':
        if ($s['installed'] == "1") {
            $q = query("SHOW TABLES LIKE ?;", ["%{$s['prefix']}%"])->fetchAll();
            foreach ($q as $n) {
                $n = $n[0];
                query("TRUNCATE TABLE `{$n}`");
            }
        }
        $engine->world->generateMap();
        query("UPDATE `global_server_data` SET `start`=?,`installed`=? WHERE `sid`=?;", [time(), 1, $_GET['id']]);
        header("Location: index.php?p=info&id={$_GET['id']}");
        break;
    case 'import':
        $sql = file_get_contents(__DIR__ . '/sql.sql');
        query($sql);
        $q = query("SHOW TABLES;", ["%{$s['prefix']}%"])->fetchAll();
        foreach ($q as $n) {
            $n = $n[0];
            if ($n != "global_server_data")
                query("TRUNCATE TABLE `{$n}`");
        }
        header("Location: index.php");
        break;
    default:
        header("Location: index.php");
        break;
}