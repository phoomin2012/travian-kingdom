<!DOCTYPE html><html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Mellon</title><meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/min?g=core-styles" media="screen" rel="stylesheet" type="text/css">
        <link href="/min?g=styles" media="screen" rel="stylesheet" type="text/css"><script type="text/javascript" src="/min?g=core-scripts"></script>
        <script type="text/javascript" src="/min?g=scripts"></script>
        <script type="text/javascript">
            //<!--
            $(function () {
                if (!window.parent || !window.parent.bridge) {
                    return;
                }
                var bridge = window.parent.bridge;

                var body = $('body');
                setTimeout(function () {
                    bridge.resize(body.width(), body.height());
                    setTimeout(function () {
                        bridge.resize(body.width(), body.height());
                    }, 400);
                }, 30);

            });
            //-->
        </script>
        <script type="text/javascript">
            //<!--
            $(function () {
                if (!window.parent || !window.parent.bridge) {
                    return;
                }
                var bridge = window.parent.bridge;
                bridge.setCookie("msid", "<?php echo $_SESSION['mellon_msid'];?>", {"expires": 14});
            });
            //-->
        </script>
        <script type="text/javascript">
            //<!--

            $(function () {
                setTimeout(function () {
                    if (!window.bridgePresenceCheckSkip && (!window.parent || !window.parent.bridge)) {
                        window.location.href = 'http://www.kingdoms.com/?msid=<?php echo $_SESSION['mellon_msid'];?>&msname=msid';
                    }
                }, 4000);
            });

            //-->
        </script>
        <script type="text/javascript">
            //<!--
            $(function () {
                if (!window.parent || !window.parent.bridge) {
                    return;
                }
                var bridge = window.parent.bridge;
                bridge.event("loaded");
            });
            //-->
        </script>
    </head>

    <body class="mellon-dialog c-page-redirect ltr">
        <div class="container"><h1>Redirecting</h1>

            <p>If you are not redirected automatically within a few seconds please click the button.</p>

            <a href="#" id="jumpButton" class="btn btn-lg btn-block btn-primary">
                Click to continue...</a>

            <script type="text/javascript">
                $(function () {
                    var $btn = $('#jumpButton');

                    $btn.on('click', function () {
                        window.parent.bridge.redirect({url: '<?php echo $redirect;?>'});
                        window.parent.bridge.close();
                        return false;
                    });

                    setTimeout(function () {
                        $btn.trigger('click');
                    }, 500);
                });
            </script>
        </div> <!-- /container -->

        <!-- facebook layer -->
        <div id="fb-root"></div>

    </body>
</html>
