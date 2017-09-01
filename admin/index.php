<?php
include_once __DIR__ . '/engine/engine.php';
!isset($_GET['p']) ? $_GET['p'] = '' : false;
?>
<!DOCTYPE=html>
<html>
    <head>
        <link href="assets/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="container" style="margin-top: 1rem;">
            <a href="?p=index" class="btn btn-secondary">
                Home
            </a>
            <a href="process.php?p=import" class="btn btn-secondary">
                Import Database
            </a>
        </div>
        <hr>
        <?php
        switch ($_GET['p']) {
            case '':
            case 'index':
                include_once __DIR__ . '/template/server_list.php';
                break;
            case 'info':
                include_once __DIR__ . '/template/server_info.php';
                break;
        }
        ?>
    </body>
</html>