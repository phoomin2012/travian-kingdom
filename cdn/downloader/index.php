<?php
set_time_limit(86400);
if (isset($_POST)) {
    if (isset($_POST['auth'])) {
        $links = file_get_contents($_POST['link'] != "" ? $_POST['link'] : dirname(__FILE__) . '/ltr.css');
        $paths = $_POST['path'] != "" ? $_POST['path'] : "http://cdn.traviantools.net/game/0.66/layout";
        //http://cdn-fastly.traviantools.net/game/0.46/layout/css/ltr.css?h=29d66f3c04ab9934808ca5aa845e9415
        //background-image:url('../images/sprites/community/alliance-s54af43eb25.png')

        preg_match_all('/[A-Za-z0-9\-\/\.]+\.(png|jp(e)?g|gif)/', $links, $output);
        $json = array();
        foreach ($output[0] as $item) {
            $link = $paths . str_replace("..", "", $item);
            $path = dirname(__FILE__) . "/file/" . str_replace("../", "", $item);
            $json[count($json)] = array('path' => $path, 'link' => $link);
        }
        echo json_encode(array('all' => count($json), 'list' => $json));
        exit();
    } else {
        if (isset($_POST['download'])) {
            @mkdir(dirname($_POST['path']), 0777, true);
            file_put_contents($_POST['path'], file_get_contents($_POST['link']));
            echo "success";
            exit();
        }
    }
}
?>
<!DOCTYPE=html5>
<html>
    <head>
        <script src="jquery.1.8.3.min.js"></script>
        <script>
            var statusDownloaded = 0;
            var statusDownloadAll = 0;
            var taskWorking = 0;
            var fileList = [];
            function refreshStatus() {
                if (statusDownloaded == 0 && statusDownloadAll == 0) {
                    $(".status_text").text("Ready!");
                } else {
                    if (statusDownloaded == statusDownloadAll) {
                        $(".status_text").text('Downloaded ' + statusDownloaded + "/" + statusDownloadAll + " Finish");
                    } else {
                        $(".status_text").text('Downloading ' + statusDownloaded + "/" + statusDownloadAll + " ...");
                    }
                }
            }
            function checkTask() {
                while (taskWorking < 6) {
                    taskWorking++;
                    $.ajax({
                        url: 'index.php',
                        data: 'path=' + fileList[statusDownloaded+taskWorking].path + "&link=" + fileList[statusDownloaded+taskWorking].link + "&download",
                        type: 'post',
                        success: function (result) {
                            if (result == "success") {
                                statusDownloaded++;
                                refreshStatus();
                                taskWorking--;
                                checkTask();
                            }else{
                                statusDownloaded++;
                                refreshStatus();
                                taskWorking--;
                                checkTask();
                            }
                        }
                    });
                }
            }
            $(document).ready(function () {
                $(".submit_btn").on('click', function () {
                    $.ajax({
                        url: 'index.php',
                        data: 'link=' + $(".link_input").val() + "&path=" + $(".path_input").val() + "&auth",
                        dataType: 'json',
                        type: 'post',
                        beforeSend: function () {
                            $(".status_text").text('Loading...');
                        },
                        success: function (result) {
                            statusDownloadAll = result.all;
                            statusDownloaded = 0;
                            fileList = result.list;
                            refreshStatus();
                            checkTask();
                        }
                    });
                    return false;
                });
            });
        </script>
    </head>
    <body>
    <center>
        <label>Link : </label><input type="text" class="link_input"><br>
        <label>Path : </label><input type="text" class="path_input"><br>
        <button type="button" class="submit_btn">Download</button><br>
        <span class="status_text">Ready!</span>
    </center>
</body>
</html>