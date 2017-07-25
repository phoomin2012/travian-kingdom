<!DOCTYPE html><html lang="en">
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
                bridge.setCookie("msid", "ji9hmqge85c2nv59plhdlrnhd0", {});
            });
            //-->
        </script>
        <script type="text/javascript">
            //<!--

            $(function () {
                setTimeout(function () {
                    if (!window.bridgePresenceCheckSkip && (!window.parent || !window.parent.bridge)) {
                        window.location.href = 'http://www.kingdoms.com/com?msid=ji9hmqge85c2nv59plhdlrnhd0&msname=msid';
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
        </script>        <script>
            $(document).ready(function () {
                $.fn.ajaxValidation.defaults.url = "/ajax/form-validate?msid=ji9hmqge85c2nv59plhdlrnhd0&msname=msid";
            });
        </script>
    </head>

    <body class="mellon-dialog c-authentication-password-reset-request ltr">
        <div class="container"><div class="pages">
                <span>1/2</span>
            </div>
            <div class="page-header">
                <h1>Reset password</h1>
            </div>

            <p class="description">Enter the email address registered to your account and we'll email you a link to reset your password.</p>

            <form action="" method="POST"><div class="form-group form-group-type-text">
                    <label>Email address:</label>

                    <input type="text" name="email" class="form-control&#x20;input-email" placeholder="Email&#x20;address" value="">        
                </div>
                <div class="form-group form-group-type-submit">

                    <input type="submit" name="submit" class="btn&#x20;btn-primary" value="Send&#x20;reset&#x20;link">        
                </div>
            </form>

            <script type="text/javascript">
                $('body').width('490px');

                $(document).ready(function () {
                    $('input[name=email]').ajaxValidation({formName: 'resetPasswordRequest'})
                });
            </script>
        </div> <!-- /container -->

        <!-- facebook layer -->
        <div id="fb-root"></div>

    </body>
</html>
