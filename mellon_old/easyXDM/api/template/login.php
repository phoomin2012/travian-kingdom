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
                bridge.setCookie("msid", "1mk78qll2dp82sv4pjv0jskg10", {"expires": 30});
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
                        window.location.href = '?msid=1mk78qll2dp82sv4pjv0jskg10&msname=msid';
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
                bridge.event("login");
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
        </script>    </head>

    <body class="mellon-dialog c-authentication-login ltr">
        <div class="container"><div class="page-header">
                <h1>Login</h1>
            </div>
            <form action="<?php echo str_replace('/easyXDM/api', '', $page->baseURI()); ?>&#x2F;easyXDM&#x2F;api&#x2F;authentication&#x2F;login&#x2F;applicationDomain&#x2F;kingdoms.travian.com&#x2F;applicationInGame&#x2F;0&#x2F;applicationId&#x2F;travian-ks&#x2F;applicationCountryId&#x2F;us&#x2F;applicationInstanceId&#x2F;portal-us&#x2F;applicationLanguageId&#x2F;en_US&#x2F;applicationStyles&#x2F;applicationCookieRead&#x2F;0&#x2F;applicationCookieEnabled&#x3F;msid&#x3D;1mk78qll2dp82sv4pjv0jskg10&amp;msname&#x3D;msid" method="POST" name="login" class="form-horizontal" id="login">
                <div class="form-group form-group-type-text">
                    <label>Email address:</label>

                    <input type="text" name="email" class="form-control" placeholder="Enter&#x20;your&#x20;email&#x20;address&#x20;here" value="">        
                </div>
                <div class="form-group form-group-type-password">
                    <label>Password:</label>

                    <input type="password" name="password" class="form-control" placeholder="Enter&#x20;your&#x20;password&#x20;here" value="">        
                </div>
                <div class="form-group form-group-type-submit">

                    <input name="submit" type="submit" class="btn&#x20;btn-primary" value="Login">        
                </div>
            </form>
            <div class="login-extra">
                <div class="login-extra-create-account">
                    <a href="<?php echo str_replace('/easyXDM/api', '', $page->baseURI()); ?>/easyXDM/api/registration/index/applicationDomain/kingdoms.travian.com/applicationInGame/0/applicationId/travian-ks/applicationCountryId/us/applicationInstanceId/portal-us/applicationLanguageId/en_US/applicationStyles/applicationCookieRead/0/applicationCookieEnabled?msid=1mk78qll2dp82sv4pjv0jskg10&msname=msid">Register</a>
                </div>
                <div>&nbsp;|&nbsp;</div>
                <div class="login-extra-activate-account">
                    <a href="<?php echo str_replace('/easyXDM/api', '', $page->baseURI()); ?>/easyXDM/api/activation/activate/applicationDomain/kingdoms.travian.com/applicationInGame/0/applicationId/travian-ks/applicationCountryId/us/applicationInstanceId/portal-us/applicationLanguageId/en_US/applicationStyles/applicationCookieRead/0/applicationCookieEnabled?msid=1mk78qll2dp82sv4pjv0jskg10&msname=msid">
                        Activate account        </a>
                </div>
                <div>&nbsp;|&nbsp;</div>
                <div class="login-extra-reset-password">
                    <a href="<?php echo str_replace('/easyXDM/api', '', $page->baseURI()); ?>/easyXDM/api/authentication/password-reset-request/applicationDomain/kingdoms.travian.com/applicationInGame/0/applicationId/travian-ks/applicationCountryId/us/applicationInstanceId/portal-us/applicationLanguageId/en_US/applicationStyles/applicationCookieRead/0/applicationCookieEnabled?msid=1mk78qll2dp82sv4pjv0jskg10&msname=msid">
                        Lost password		</a>
                </div>
            </div>

            <script type="text/javascript">
                $('body').width('386px');
            </script>
        </div> <!-- /container -->

        <!-- facebook layer -->
        <div id="fb-root"></div>
    </body>
</html>
