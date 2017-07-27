<!DOCTYPE html>
<html lang="en">
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
                        window.location.href = 'http://kingdoms.travian.com/com?msid=<?php echo $_SESSION['mellon_msid']; ?>&msname=msid';
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
            window.fbAsyncInit = function () {
                FB.init({"appId": "780743665316084", "version": "v2.2"});
                $(function () {
                    $(document).trigger('fbInit');
                });
            };
            //-->
        </script>
        <script type="text/javascript">
            //<!--
            (function (d) {
                var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
                if (d.getElementById(id)) {
                    return
                }

                js = d.createElement('script');
                js.id = id;
                js.async = true;
                js.src = '//connect.facebook.net/en_US/sdk.js';

                ref.parentNode.insertBefore(js, ref);
            }(document));
            //-->
        </script>
        <script type="text/javascript">
            //<!--

            window.___gcfg = {
                lang: 'en'
            };

            $(document).ready(function () {
                var po = document.createElement('script');
                po.type = 'text/javascript';
                po.async = false;
                po.src = 'https://apis.google.com/js/client:plusone.js?onload=renderGoogleBtn';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
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
    <body class="mellon-dialog c-registration-index ltr">
        <div class="container">
            <div class="page-header">
                <h1>Register a Travian account</h1>
            </div>
            <form action="<?php echo str_replace('/easyXDM/api','',$page->baseURI());?>/easyXDM/api/registration/index/applicationDomain/kingdoms.travian.com/applicationInGame/0/applicationId/travian-ks/applicationCountryId/en/applicationInstanceId/portal-en/applicationLanguageId/en_US/applicationStyles/applicationCookieRead/0/applicationCookieEnabled?msid=621v5m1f8dqciu21fm8t515gg0&msname=msid" method="POST" name="account" class="form-horizontal" id="account"><div class="form-group form-group-type-text">
                    <label>Enter your email address</label>
                    <input type="text" name="email" class="form-control" placeholder="Enter&#x20;your&#x20;email&#x20;address&#x20;here" value="">        
                </div>
                <div class="form-group form-group-type-submit">
                    <input name="submit" type="submit" class="btn&#x20;btn-primary" value="Continue">        
                </div>
                <fieldset class="social-login">
                    <legend>Or play with</legend>
                    <div class="form-group form-group-type-image">
                        <div class="facebook-login-wrapper">
                            <div class="facebook-login-button">
                                <input type="image" name="social&#x5B;facebook-login&#x5D;" id="fb-login-button" src="/images/login-facebook.png" value="">		<span>Login</span>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(document).on('fbInit', function () {
                                $('#fb-login-button').closest('.facebook-login-wrapper').on('click', function (e) {
                                    if ($(this).data('locked') == true) {
                                        return false;
                                    }

                                    $(this).data('locked', true);
                                    FB.login(
                                            function (response) {
                                                $('#fb-login-button').data('locked', false);
                                                $(document).trigger('fbLogin', response);
                                            },
                                            {"scope": "email", "auth_type": "https"});

                                    return false;
                                });
                            });

                            $(document).on('fbLogin', function (event, response) {
                                if (response.status !== 'connected') {
                                    $('#fb-login-button').closest('.facebook-login-wrapper').data('locked', false);
                                    return false;
                                }

                                var url = '<?php echo str_replace('/easyXDM/api','',$page->baseURI());?>/easyXDM/api/authentication/login-facebook/applicationDomain/kingdoms.travian.com/applicationInGame/0/applicationId/travian-ks/applicationCountryId/en/applicationInstanceId/portal-en/applicationLanguageId/en_US/applicationStyles/applicationCookieRead/0/applicationCookieEnabled/signed-request/-sr-/access-token/-at-?msid=621v5m1f8dqciu21fm8t515gg0&msname=msid';

                                url = url.replace('-sr-', response.authResponse.signedRequest);
                                url = url.replace('-at-', response.authResponse.accessToken);

                                window.location.href = url;

                                return false;
                            });
                        </script>
                    </div>
                    <div class="form-group form-group-type-image">
                        <div class="vkontakte-login-wrapper">
                            <div class="vkontakte-login-button">
                                <input type="image" name="social&#x5B;vkontakte-login&#x5D;" id="vk-login-button" src="/images/login-vkontakte.png" value="">		<span>Login</span>
                            </div>
                        </div>
                        <script type="text/javascript">
                            var newWindow, timer = null;

                            $('#vk-login-button').closest('.vkontakte-login-wrapper').on('click', function (e) {
                                if (newWindow && newWindow.closed == false) {
                                    return false;
                                }

                                if ($(this).data('locked')) {
                                    return false;
                                }

                                $(this).data('locked', true);

                                // hack for FF, it is very slow and user still can catch a moment for click.
                                timer = setTimeout(function () {
                                    $('#vk-login-button').closest('.vkontakte-login-wrapper').data('locked', false);
                                }, 3000);

                                newWindow = window.open('https://oauth.vk.com/authorize?display=popup&scope=4194304&redirect_uri=https://mellon-t5.traviangames.com/authentication/login-vkontakte-helper/applicationDomain/kingdoms.travian.com/applicationInGame/0/applicationId/travian-ks/applicationCountryId/en/applicationInstanceId/portal-en/applicationLanguageId/en_US/applicationStyles/applicationCookieRead/0/applicationCookieEnabled?msid=621v5m1f8dqciu21fm8t515gg0&msname=msid&response_type=code&v=5.25&client_id=4621153', 'vk', 'menubar=0,titlebar=0,height=200,width=200');

                                return false;
                            });

                            function vkontakteWindowExecute() {
                                $('#vk-login-button').closest('.vkontakte-login-wrapper').data('locked', true);
                                newWindow.close();
                                newWindow = timer = null;

                                window.location.href = '<?php echo str_replace('/easyXDM/api','',$page->baseURI());?>/easyXDM/api/authentication/login-vkontakte/applicationDomain/kingdoms.travian.com/applicationInGame/0/applicationId/travian-ks/applicationCountryId/en/applicationInstanceId/portal-en/applicationLanguageId/en_US/applicationStyles/applicationCookieRead/0/applicationCookieEnabled?msid=621v5m1f8dqciu21fm8t515gg0&msname=msid';
                            }
                        </script>

                    </div>
                    <div class="form-group form-group-type-hidden">
                        <div class="google-login-wrapper">
                            <div id="block-google-login" class="google-login-button">
                                <input type="hidden" name="social&#x5B;google-login&#x5D;" id="google-login" value="">        <span>Login</span>
                            </div>
                        </div>
                        <script type="text/javascript">
                            function renderGoogleBtn() {
                                $('.google-login-button').bind('click', function (e) {
                                    if ($(this).data('locked')) {
                                        return false;
                                    }

                                    $(this).data('locked', true);
                                    gapi.auth.authorize({
                                        client_id: '692823100644-ioveuchqrt57fj6fkg8eq3gsghuvi9p1.apps.googleusercontent.com',
                                        immediate: false,
                                        scope: ['https://www.googleapis.com/auth/userinfo.email']
                                    }, googleLoginCallback);

                                    setTimeout(function () {
                                        $('.google-login-button').data('locked', false);
                                    }, 1000);

                                    return false;
                                });
                            }

                            function googleLoginCallback(authResult) {
                                if (authResult['access_token']) {
                                    var url = '<?php echo str_replace('/easyXDM/api','',$page->baseURI());?>/easyXDM/api/authentication/login-google/applicationDomain/kingdoms.travian.com/applicationInGame/0/applicationId/travian-ks/applicationCountryId/en/applicationInstanceId/portal-en/applicationLanguageId/en_US/applicationStyles/applicationCookieRead/0/applicationCookieEnabled/access-token/-at-?msid=621v5m1f8dqciu21fm8t515gg0&msname=msid';
                                    url = url.replace('-at-', authResult['access_token']);

                                    window.location.href = url;
                                }
                            }
                        </script>
                    </div>
                </fieldset>
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
