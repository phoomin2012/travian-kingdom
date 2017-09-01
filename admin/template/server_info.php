<?php
$s = $engine->database->getServer($_GET['id']);
?>
<div class="container">
    <div class="row">
        <div class="col-4">
            <table class="table table-bordered">
                <tr>
                    <td>Name</td>
                    <td><?php echo $s['name']; ?></td>
                </tr>
                <tr>
                    <td>Tag</td>
                    <td><?php echo $s['tag']; ?></td>
                </tr>
                <tr>
                    <td>Link</td>
                    <td><?php echo $s['folder']; ?></td>
                </tr>
                <tr>
                    <td>Database prefix</td>
                    <td><?php echo $s['prefix']; ?></td>
                </tr>
                <tr>
                    <td>Speed</td>
                    <td>x<?php echo $s['speed_world']; ?></td>
                </tr>
                <tr>
                    <td>Unit speed</td>
                    <td>x<?php echo $s['speed_unit']; ?></td>
                </tr>
                <tr>
                    <td>Hero item</td>
                    <td>x<?php echo $s['multiple_hero_item']; ?></td>
                </tr>
                <tr>
                    <td>Hero resource</td>
                    <td>x<?php echo $s['multiple_hero_resource']; ?></td>
                </tr>
                <tr>
                    <td>Hero speed</td>
                    <td>x<?php echo $s['multiple_hero_speed']; ?></td>
                </tr>
                <tr>
                    <td>Hero power</td>
                    <td>x<?php echo $s['multiple_hero_power']; ?></td>
                </tr>
                <tr>
                    <td>Multiple storage</td>
                    <td>x<?php echo $s['multiple_storage']; ?></td>
                </tr>
                <tr>
                    <td>Base storage</td>
                    <td><?php echo $s['base_storage']; ?></td>
                </tr>
                <tr>
                    <td>Plus time</td>
                    <td><?php echo $engine->math->calculate($s['plus_time']); ?></td>
                </tr>
                <tr>
                    <td>Protect time</td>
                    <td><?php echo $engine->math->calculate($s['protection']); ?></td>
                </tr>
                <tr>
                    <td>Start</td>
                    <td><?php echo date('Y-m-d H:i:s', $s['start']); ?></td>
                </tr>
                <tr>
                    <td>Age</td>
                    <td><?php echo round((time() - $s['start']) / 86400); ?> days</td>
                </tr>
                <tr>
                    <td>WW Village</td>
                    <td><?php echo date('Y-m-d H:i:s', $s['wwvillage']); ?></td>
                </tr>
                <tr>
                    <td>Installed</td>
                    <td><?php echo ($s['installed'] == 1 ? '<i class="fa fa-check"></i>':'<i class="fa fa-remove"></i>'); ?></td>
                </tr>
                <tr>
                    <td>Recommended</td>
                    <td><?php echo ($s['recommended'] == 1 ? '<i class="fa fa-check"></i>':'<i class="fa fa-remove"></i>'); ?></td>
                </tr>
            </table>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <h3>Actions</h3><hr>
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
                    <?php
                    if ($s['maintenance'] == 0) {
                        ?>
                        <a href="?p=maintenance&id=<?php echo $s['sid']; ?>" class="btn btn-warning">
                            <i class="fa fa-cog"></i>
                            Maintenance mode
                        </a>
                        <?php
                    } else {
                        ?>
                        <a href="?p=maintenance&id=<?php echo $s['sid']; ?>" class="btn btn-warning">
                            <i class="fa fa-check"></i>
                            Normal mode
                        </a>
                        <?php
                    }
                    ?>
                    <?php
                    if ($s['peace'] == 0) {
                        ?>
                        <a href="?p=peace&id=<?php echo $s['sid']; ?>" class="btn btn-warning">
                            <i class="fa fa-cog"></i>
                            Disable attack
                        </a>
                        <?php
                    } else {
                        ?>
                        <a href="?p=peace&id=<?php echo $s['sid']; ?>" class="btn btn-warning">
                            <i class="fa fa-check"></i>
                            Enable attack
                        </a>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>