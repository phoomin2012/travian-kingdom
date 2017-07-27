<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Mellon</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?php echo str_replace('/easyXDM/api', '', $page->baseURI()); ?>/core-styles.css" media="screen" rel="stylesheet" type="text/css">
        <link href="<?php echo str_replace('/easyXDM/api', '', $page->baseURI()); ?>/styles.css" media="screen" rel="stylesheet" type="text/css">
        <script src="<?php echo str_replace('/easyXDM/api', '', $page->baseURI()); ?>/core-scripts.js" type="text/javascript"></script>
        <script src="<?php echo str_replace('/easyXDM/api', '', $page->baseURI()); ?>/scripts.js" type="text/javascript"></script>
        <script type="text/javascript">
            //<!--
            $(function () {
                if (!window.parent || !window.parent.bridge) {
                    return;
                }
                var bridge = window.parent.bridge;
                bridge.setCookie("msid", "621v5m1f8dqciu21fm8t515gg0", {
                    "expires": 30
                });
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
                setTimeout(function () {
                    if (!window.bridgePresenceCheckSkip && (!window.parent || !window.parent.bridge)) {
                        window.location.href = 'http://kingdoms.travian.com/com?msid=621v5m1f8dqciu21fm8t515gg0&msname=msid';
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
                bridge.event("password-reset-request");
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

    <body class="mellon-dialog c-authentication-password-reset-request ltr">
        <div class="container">
            <div class="page-header">
                <h1>Forgot password</h1>
            </div>
            <form action="" method="POST">
                <div class="form-group form-group-type-text">
                    <label>Email address:</label>
                    <input type="text" name="email" class="form-control" placeholder="Your&#x20;email&#x20;address&#x20;used&#x20;for&#x20;registration" value="">
                </div>
                <div class="form-group form-group-type-submit">
                    <input type="submit" name="submit" class="btn&#x20;btn-primary" value="Reset&#x20;password">
                </div>
            </form>
            <div class="login-extra">
                <div class="login-extra-create-account">
                    <a href="<?php echo str_replace('/easyXDM/api','',$page->baseURI());?>&#x2F;easyXDM&#x2F;api/registration/index/applicationDomain/kingdoms.travian.com/applicationInGame/0/applicationId/travian-ks/applicationCountryId/en/applicationInstanceId/portal-en/applicationLanguageId/en_US/applicationStyles/applicationCookieRead/0/applicationCookieEnabled?msid=621v5m1f8dqciu21fm8t515gg0&msname=msid">
                        Register
                    </a>
                </div>
                <div>&nbsp;|&nbsp;</div>
                <div class="login-extra-activate-account">
                    <a href="<?php echo str_replace('/easyXDM/api','',$page->baseURI());?>&#x2F;easyXDM&#x2F;api/activation/activate/applicationDomain/kingdoms.travian.com/applicationInGame/0/applicationId/travian-ks/applicationCountryId/en/applicationInstanceId/portal-en/applicationLanguageId/en_US/applicationStyles/applicationCookieRead/0/applicationCookieEnabled?msid=621v5m1f8dqciu21fm8t515gg0&msname=msid">
                        Activate account
                    </a>
                </div>
                <div>&nbsp;|&nbsp;</div>
                <div class="login-extra-activate-account">
                    <a href="<?php echo str_replace('/easyXDM/api','',$page->baseURI());?>&#x2F;easyXDM&#x2F;api/authentication/login/applicationDomain/kingdoms.travian.com/applicationInGame/0/applicationId/travian-ks/applicationCountryId/en/applicationInstanceId/portal-en/applicationLanguageId/en_US/applicationStyles/applicationCookieRead/0/applicationCookieEnabled?msid=621v5m1f8dqciu21fm8t515gg0&msname=msid">
                        Login
                    </a>
                </div>
            </div>
            <script type="text/javascript">
                $('body').width('386px');

            </script>
        </div>
        <!-- /container -->
        <!-- facebook layer -->
        <div id="fb-root"></div>
    </body>

</html>
