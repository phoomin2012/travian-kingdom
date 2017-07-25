<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Mellon</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/min?g=core-styles" media="screen" rel="stylesheet" type="text/css">
        <link href="/min?g=styles" media="screen" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="/min?g=core-scripts"></script>
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
                bridge.event("login-repeat");
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
        </script>        <script>
            $(document).ready(function () {
                $.fn.ajaxValidation.defaults.url = "/ajax/form-validate?msid=<?php echo $_SESSION['mellon_msid'];?>&msname=msid";
            });
        </script>
    </head>

    <body class="mellon-dialog c-authentication-login-repeat ltr">
        <div class="container"><div class="page-header-logout">
                <div class="row">
                    <h1>Logout successful</h1>
                </div>
                <div class="row">
                    <p class="alert alert-success">Thank you for playing. Come back soon!</p>
                </div>
            </div>

            <div class="logout-btn-wrapper">
                <div class="form-group form-group-type-submit">
                    <form class="form-horizontal" method="get"
                          action="/authentication/login/applicationInstanceId/portal-us/applicationLanguageId/en_US/applicationCountryId/us/applicationId/travian-ks?msid=<?php echo $_SESSION['mellon_msid'];?>&msname=msid">
                        <input type="submit" class="btn btn-primary" value="Log in">
                    </form>
                </div>
            </div>

            <script type="text/javascript">
                $('body').width('386px');
            </script>
        </div> <!-- /container -->
    </body>
</html>
