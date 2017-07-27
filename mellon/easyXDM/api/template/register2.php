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
                bridge.setCookie("msid", "<?php echo $_SESSION['mellon_msid']; ?>", {"expires": 30});
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
                        window.location.href = 'http://kingdoms.travian.com/?msid=<?php echo $_SESSION['mellon_msid']; ?>&msname=msid';
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
                bridge.event("registration");
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

    <body class="mellon-dialog c-registration-index ltr">
        <div class="container">
            <div class="page-header">
                <h1>Register a Travian account</h1>
                <p class="small">Register a Travian account to manage your game worlds</p>
                <div class="separator"></div>
            </div>

            <form action="<?php echo str_replace('/easyXDM/api', '', $page->baseURI()); ?>/easyXDM/api/registration/index/applicationDomain/kingdoms.travian.com/applicationInGame/0/applicationId/travian-ks/applicationCountryId/us/applicationInstanceId/portal-us/applicationLanguageId/en_US/applicationStyles/applicationCookieRead/0/applicationCookieEnabled/email/<?php echo $_POST['email']; ?>/emailConfirmed/1?msid=<?php echo ""; ?>&msname=msid" method="POST" name="account" class="form-horizontal" id="account">
                <div class="form-group form-group-type-text">
                    <label>Email address:</label>
                    <span class="form-control">
                        <input type="text" name="email" placeholder="Enter your email address here" readonly="readonly" value="<?php echo $_POST['email']; ?>">
                        <span data-marker-class-readonly="glyphicon glyphicon-edit" class="set-writable glyphicon glyphicon-edit"></span>
                    </span>        
                </div>
                <div class="form-group form-group-type-paragraph">
                    <p >Choose a password for your Travian account. You can log in to each game world you play with this password.</p>        
                </div>
                <fieldset><div class="form-group form-group-type-password">
                        <label>Choose password</label>
                        <input type="password" name="password&#x5B;password&#x5D;" class="form-control" placeholder="Enter your password here" value="">        
                    </div>
                    <div class="form-group form-group-type-password">
                        <label>Repeat password</label>
                        <input type="password" name="password&#x5B;passwordRepeat&#x5D;" class="form-control" placeholder="Enter your password again" value="">        
                    </div>
                </fieldset>
                <div class="form-group form-group-type-checkbox">
                    <label>
                        <input type="checkbox" name="termsAccepted" value="1"><i></i>
                        I have read and accept the <a target="_blank" href="http://agb.traviangames.com/terms-en.pdf">general terms and conditions</a> and the <a target="_blank" href="http://agb.traviangames.com/privacy-en.pdf">privacy policy</a>
                    </label>
                </div>
                <div class="form-group form-group-type-multi_checkbox">
                    <input type="hidden" name="newsletters" value="">
                    <label>
                        <input type="checkbox" name="newsletters&#x5B;&#x5D;" value="4">
                        <b>Travian Games</b> newsletter<br/>
                    </label>        
                </div>
                <div class="form-group form-group-type-submit">
                    <input name="submit" type="submit" class="btn btn-primary" value="Finish registration">        
                </div>
            </form>
            <div class="login-extra">
                <div class="login-extra-support">
                    <a target="_blank" href="http&#x3A;//help.kingdoms.travian.com/en">Support</a>
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
