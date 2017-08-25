<?php
include_once __DIR__ . '/engine/session.php';
if (isset($_GET['g_msid'])) {
    if ($_GET['g_msid'] == md5($_GET['gl5SessionKey'])) {
        header("Location: index.php#msid=" . $_GET['gl5SessionKey']);
    } else {
        header("Location: ../");
    }
}
if (!$engine->session->data->islogin) {
    header("Location: " . $index_url . "#logout");
}

include_once __DIR__.'/lang/en.php';
?>
<!DOCTYPE html>
<html dir="ltr">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="msapplication-tap-highlight" content="no" />
        <link rel="shortcut icon" href="/favicon.ico">
        <title>Travian Kingdoms</title>
        <script>
            window.__INITIAL_STATE__ = {
            country: 'us',
                    cache: {
                    'Session:450bd510c7240adeb0b8': {
                    name: 'Session:450bd510c7240adeb0b8',
                            data: {
                            "sessionId": "450bd510c7240adeb0b8",
                                    "type": 0,
                                    "country": "us"
                            }
                    },
                            'Player:13953': {
                            name: 'Player:13953',
                                    data: {
                                    "playerId": "13953",
                                            "avatarName": "phoomin009",
                                            "userAccountIdentifier": "52219",
                                            "isInstantAccount": 0,
                                            "isActivated": 0,
                                            "signupTime": "---"
                                    }
                            },
                            'UserAccountImage:52219': {
                            name: 'UserAccountImage:52219',
                                    data: {
                                    "avatarIdentifier": "3810393",
                                            "userAccountIdentifier": "52219",
                                            "gender": "0",
                                            "hairColor": "1",
                                            "face": {
                                            "beard": "4",
                                                    "ear": "0",
                                                    "eye": "8",
                                                    "eyebrow": "7",
                                                    "hair": "5",
                                                    "mouth": "3",
                                                    "nose": "2"
                                            }
                                    }
                            }
                    },
                    intl: {
                        messages: {
    <?php
    foreach ($language as $k => $l) {
        echo "                    \"$k\": \"".addslashes($l)."\","."\n";
    }
    ?>
                        },
                    },
                    forms: {
                        changeName: {
                        value: "phoomin009",
                                errors: []
                        }
                    },
                    config: {
                    "backendUrl": "\/api\/index.php",
                            "redirectAfterLogout": "\/\/www.kingdoms.com\/#logout",
                            "environment": "live",
                            "node": {
                            "host": "<?php echo $lobby_url; ?>",
                                    "port": 80,
                                    "resource": "chat"
                            },
                            "avatar": {
                            "maxSitters": 2,
                                    "maxDuals": 2
                            },
                            "links": {
                            "urlForum": "https:\/\/forum.kingdoms.com\/",
                                    "urlWiki": "\/\/wiki.kingdoms.com\/tiki-switch_lang.php?language=",
                                    "urlHelpCenter": "\/\/help.kingdoms.com\/",
                                    "urlPrivacy": "\/\/agb.traviangames.com\/privacy-XX.pdf",
                                    "urlTerms": "\/\/agb.traviangames.com\/terms-XX.pdf",
                                    "urlGameRules": "\/\/www.kingdoms.com\/rules.php?lang=X",
                                    "urlBaseLink": "\/\/www.kingdoms.com\/",
                                    "urlImprint": "\/\/www.kingdoms.com\/X\/imprint\/"
                            },
                            "languages": {
                            "ae": "ar_AE",
                                    "en": "en_US",
                                    "ru": "ru_RU",
                                    "cs": "cs_CZ",
                                    "cz": "cs_CZ",
                                    "da": "da_DK",
                                    "dk": "da_DK",
                                    "de": "de_DE",
                                    "cl": "es_CL",
                                    "es": "es_ES",
                                    "et": "et_EE",
                                    "ee": "et_EE",
                                    "fr": "fr_FR",
                                    "gb": "en_GB",
                                    "hu": "hu_HU",
                                    "id": "id_ID",
                                    "it": "it_IT",
                                    "lt": "lt_LT",
                                    "lv": "lv_LV",
                                    "nl": "nl_NL",
                                    "pl": "pl_PL",
                                    "br": "pt_BR",
                                    "pt": "pt_PT",
                                    "ro": "ro_RO",
                                    "sk": "sk_SK",
                                    "si": "sl_SI",
                                    "sl": "sl_SI",
                                    "tr": "tr_TR",
                                    "uk": "uk_UA",
                                    "us": "en_US",
                                    "ua": "uk_UA"
                            },
                            "mellon": {
                            "url": "<?php echo $mellon_url; ?>",
                                    "application": {
                                    "countryId": false,
                                            "instanceId": "gl-t5",
                                            "languageId": false
                                    },
                                    "checkSession": "true",
                                    "mellon": {
                                    "cookie": {
                                    "domain": ".<?php echo $domain; ?>"
                                    }
                                    }
                            }
                    }
            };
            window.__INITIAL_STATE__.config.countries = {
            "asia": ["tr"],
                    "europe": ["en", "gb", "us", "ru", "dk", "no", "se", "fi", "nl", "fr", "pt", "de", "it", "es", "pl", "cz", "hu"],
                    "middle_east": ["ae"]
            };
            window.__INITIAL_STATE__.config.clusters = {
            "1": ["dk", "no", "se", "fi"],
                    "2": ["en", "gb", "us"]
            };
            window.__INITIAL_STATE__.config.features = {
            "maxSitters": 2,
                    "maxDuals": 2,
                    "prestigeNeededForRename": 100,
                    "enableAccountNameChange": true,
                    "prestige": true,
                    "achievements": true,
                    "disableByTutorial": false,
                    "cdnPrefix": "https:\/\/cdn.traviantools.net\/lobby\/live\/",
                    "goldTransferNotAllowedCountries": ["pl", "hu", "ru"]
            };
        </script>
        <link href="/static/css/main.css" rel="stylesheet"> </head>

    <body>
        <div id="root"></div>
        <div id="mellonModal" class="jqFensterModal">
            <div class="jqFensterModalContent"></div>
        </div>
        <script type="text/javascript" src="/static/js/vendor.js"></script>
        <link rel="stylesheet" href="<?php echo $cdn_url; ?>startpage/live/css/ltr/mellonModal.css?h=21ba5197cdd21b864e49104ba38a3b9d">
        <link rel="stylesheet" href="<?php echo $mellon_url; ?>/tk/fenster-css.css">
        <script src="<?php echo $mellon_url; ?>/tk/fenster-js.js"></script>
        <script src="<?php echo $mellon_url; ?>/tk/sdk-js.js"></script>
        <!-- GA -->
        <script>
            (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
            (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
            ga('create', 'UA-83432822-1', 'auto');
            ga('set', 'userId', 52219);
            ga('require', 'linkid');
        </script>

        <!-- Facebook Pixel Code -->
        <script>
            ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
            n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
            }(window,
                    document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '906554786118185');
            fbq('track', "PageView");
        </script>
        <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=906554786118185&ev=PageView&noscript=1"/></noscript>
        <!-- End Facebook Pixel Code -->
        <script type="text/javascript" src="/static/js/main.js"></script>
    </body>

</html>