<div class="container">
    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <th>World speed</th>
            <th>Unit speed</th>
            <th>Age</th>
            <th></th>
        </tr>
        <?php
        $servers = $engine->database->listServer();
        foreach ($servers as $s) {
            ?>
            <tr>
                <td class="align-middle"><?php echo $s['name']; ?></td>
                <td class="align-middle">x<?php echo $s['speed_world']; ?></td>
                <td class="align-middle">x<?php echo $s['speed_unit']; ?></td>
                <td class="align-middle"><?php echo date('Y-m-d H:i:s', $s['start']); ?> (<?php echo round((time() - $s['start']) / 86400); ?> days)</td>
                <td class="align-middle">
                    <a href="?p=info&id=<?php echo $s['sid']; ?>" class="btn btn-info">
                        <i class="fa fa-info-circle"></i>
                        Info
                    </a>
                    <?php
                    if ($s['installed'] == 0) {
                        ?>
                        <a href="?p=install&id=<?php echo $s['sid']; ?>" class="btn btn-success">
                            <i class="fa fa-download"></i>
                            Install
                        </a>
                        <?php
                    } else {
                        ?>
                        <a href="?p=install&id=<?php echo $s['sid']; ?>" class="btn btn-success">
                            <i class="fa fa-refresh"></i>
                            Reinstall
                        </a>
                        <?php
                    }
                    ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>