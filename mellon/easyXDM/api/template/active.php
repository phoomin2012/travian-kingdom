<!DOCTYPE html><html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Mellon</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?php echo str_replace('/easyXDM/api','',$page->baseURI());?>/core-styles.css" media="screen" rel="stylesheet" type="text/css">
        <link href="<?php echo str_replace('/easyXDM/api','',$page->baseURI());?>/styles.css" media="screen" rel="stylesheet" type="text/css">
        <script src="<?php echo str_replace('/easyXDM/api','',$page->baseURI());?>/core-scripts.js" type="text/javascript"></script>
        <script src="<?php echo str_replace('/easyXDM/api','',$page->baseURI());?>/scripts.js" type="text/javascript"></script>
        <script type="text/javascript">
            //<!--
            $(function () {
                if (!window.parent || !window.parent.bridge) {
                    return;
                }
                var bridge = window.parent.bridge;
                bridge.setCookie("msid", "621v5m1f8dqciu21fm8t515gg0", {"expires": 30});
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
                bridge.event("activation");
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

    <body class="mellon-dialog c-activation-activate ltr">
        <div class="container">
            <div class="page-header">
                <h1>Activate your Travian account</h1>
                <p class="small">In order to complete the registration, you need to activate your Travian account</p>
                <div class="separator"></div>
            </div>

            <form action="<?php echo str_replace('/easyXDM/api','',$page->baseURI());?>&#x2F;easyXDM&#x2F;api&#x2F;activation&#x2F;activate&#x2F;applicationDomain&#x2F;kingdoms.travian.com&#x2F;applicationInGame&#x2F;0&#x2F;applicationId&#x2F;travian-ks&#x2F;applicationCountryId&#x2F;en&#x2F;applicationInstanceId&#x2F;portal-en&#x2F;applicationLanguageId&#x2F;en_US&#x2F;applicationStyles&#x2F;applicationCookieRead&#x2F;0&#x2F;applicationCookieEnabled&#x3F;msid&#x3D;621v5m1f8dqciu21fm8t515gg0&amp;msname&#x3D;msid" method="POST"><div class="form-group form-group-type-text">
                    <label>Please enter the activation code we sent to your email address:</label>
                    <input type="text" name="email" class="form-control" data-marker-class-readonly="glyphicon&#x20;glyphicon-edit" data-marker-class-writable="glyphicon&#x20;glyphicon-check" id="email-change" placeholder="Enter&#x20;your&#x20;email&#x20;address&#x20;here" value="">        
                </div>
                <div class="form-group form-group-type-div">
                    <div ></div>        
                </div>
                <div class="form-group form-group-type-text">
                    <label>Activation code</label>
                    <input type="text" name="code" class="form-control" placeholder="Enter&#x20;your&#x20;activation&#x20;code&#x20;here" value="">        
                </div>
                <div class="form-group form-group-type-submit">
                    <input name="activate" type="submit" class="btn&#x20;btn-primary" value="Activate">        
                </div>
                <div class="form-group form-group-type-paragraph">
                    <p >If you did not receive an email from us after a few minutes, click the following link to request a new one:</p>        
                </div>
                <div class="form-group form-group-type-anchor">
                    <a href="&#x23;" class="submit-on-click" id="resend">Request a new email</a>        
                </div>
                <div class="form-group form-group-type-paragraph">
                    <p class="small">Note: Please check your spam folder too!</p>        
                </div>
            </form>
            <div class="login-extra">
                <div class="login-extra-support"><a target="_blank" href="http&#x3A;&#x2F;&#x2F;help.kingdoms.travian.com&#x2F;en">Support</a></div>
            </div>
            <script type="text/javascript">
                $('body').width('386px');
            </script>
        </div> <!-- /container -->
        <!-- facebook layer -->
        <div id="fb-root"></div>
    </body>
</html>
