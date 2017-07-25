<?php
include_once __DIR__ . '/engine/session.php';
if (isset($_GET['g_msid'])) {
    if ($_GET['g_msid'] == md5($_GET['gl5SessionKey'])) {
        header("Location: index.php#msid=" . $_GET['gl5SessionKey']);
    } else {
        header("Location: ../");
    }
}
if(!$engine->session->data->islogin){
    header("Location: ".$index_url."#logout");
}
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <title>Travian Kingdoms</title>

        <script type="text/javascript">
            /**
             * A JS file loader
             * @param {function} [scriptAddedCallback] - is called everytime a file is added to the file loader
             * @param {function} [scriptLoadedCallback] - is called everytime a file has been loaded
             * @param {function} [errorCallback] - is called on error
             * @param {boolean} [debug=false] - true to activate debug output
             * @constructor
             */
            var FileLoader = function (scriptAddedCallback, scriptLoadedCallback, errorCallback, debug) {
                this.debug = debug || false;
                this.scriptType = {
                    'css': 'text/css',
                    'js': 'text/javascript'
                };
                this.scripts = [];

                this.listenerLoaded = scriptLoadedCallback;
                this.listenerAdded = scriptAddedCallback;
                this.listenerError = errorCallback;
                this.listenerDone = null;

            };
            var Script = function (src, callback, fileType) {
                this.asyncFiles = ['css'];
                this.fileType = fileType;
                this.asyncLoading = false;
                this.src = src;
                this.callback = callback;

                if ((typeof this.fileType === 'undefined' || this.fileType == '')) {
                    this.fileType = getFileType(src);
                }

                if (this.asyncFiles.indexOf(this.fileType) >= 0) {
                    this.asyncLoading = true;
                }
                function getFileType(src) {
                    var ending = src.slice((Math.max(0, src.lastIndexOf(".")) || 0) + 1);
                    if (ending.indexOf('?') >= 0) {
                        ending = ending.slice(0, ending.indexOf('?'));
                    }
                    return ending;
                }
            };
            FileLoader.prototype = {
                'logger': function (message) {
                    if (this.debug) {
                        console.log('[FileLoader]', message);
                    }
                },
                'addScript': function (src, callback, forceFileType) {
                    var script = new Script(src, callback, forceFileType);
                    if (script.asyncLoading) {
                        this.scripts.unshift(script);
                    } else {
                        this.scripts.push(script);
                    }
                    this.logger('ADDED: ' + script.src);

                    if (typeof this.listenerAdded == 'function') {
                        this.listenerAdded.call(this, script.src);
                    }
                },
                'load': function (cb) {
                    if (typeof cb === 'function') {
                        this.listenerDone = cb;
                    }
                    this.createScriptElement(this.scripts.shift());
                },
                'ieLoadBugFix': function (scriptElement, callback) {
                    if (scriptElement.readyState == 'loaded' || scriptElement.readyState == 'complete') {
                        callback();
                    } else {
                        setTimeout(function () {
                            this.ieLoadBugFix(scriptElement, callback);
                        }, 100);
                    }
                },
                'scriptEventHandler': function (event, scriptObj) {
                    if (event.type == 'error') {
                        if (typeof this.listenerError == 'function') {
                            this.listenerError.call(this, scriptObj.src);
                        }
                        this.logger('ERROR: ' + scriptObj.src + ' could not be loaded. Stopping ...');
                    } else {
                        this.logger('LOADED: ' + scriptObj.src);

                        if (typeof this.listenerLoaded == 'function') {
                            this.listenerLoaded.call(this, scriptObj.src);
                        }
                        if (typeof scriptObj.callback == 'function') {
                            scriptObj.callback.call(this);
                        }
                        // if there are any scripts left start loading the next script if not trigger callback
                        if (this.scripts.length == 0) {
                            if (typeof this.listenerDone == 'function') {
                                this.listenerDone.call(this)
                            }
                        } else {
                            //only add the next file if we do not want load stuff in parallel
                            if (!scriptObj.asyncLoading) {
                                this.createScriptElement(this.scripts.shift());
                                this.logger('SCRIPTS LEFT: ' + this.scripts.length);
                            }
                        }
                    }

                },
                'createScriptElement': function (scriptObj) {
                    this.logger('CREATE ELEMENT: ' + scriptObj.src);
                    var self = this;
                    var scriptElement = null;
                    if (scriptObj.fileType == 'css') {
                        scriptElement = document.createElement('link');
                        scriptElement.rel = 'stylesheet';
                        scriptElement.href = scriptObj.src;

                    } else {
                        scriptElement = document.createElement('script');
                        scriptElement.src = scriptObj.src;

                    }
                    scriptElement.type = this.scriptType[scriptObj.fileType];
                    scriptElement.async = false;

                    if (typeof scriptElement.addEventListener !== "undefined") {
                        scriptElement.addEventListener("load", function (type) {
                            self.scriptEventHandler(type, scriptObj);
                        }, false);
                        scriptElement.addEventListener('error', function (type) {
                            self.scriptEventHandler(type, scriptObj);
                        }, false)
                    } else {
                        scriptElement.onreadystatechange = function (type) {
                            scriptElement.onreadystatechange = null;
                            this.ieLoadBugFix(scriptElement, function () {
                                self.scriptLoaded(type, scriptObj);
                            });
                        }
                    }

                    var head = document.getElementsByTagName('head')[0];
                    head.appendChild(scriptElement);
                    this.logger('LOAD SCRIPT ASYNC', scriptObj.asyncLoading);

                    // only load the next file if the current file can be loaded async
                    if (scriptObj.asyncLoading && this.scripts.length > 0) {
                        this.createScriptElement(this.scripts.shift());
                        this.logger('SCRIPTS LEFT: ' + this.scripts.length);
                    }

                }
            };
        </script>
        <script type="text/javascript">
            function LoadingScreenManager() {

                var steps = [];
                var totalSteps = 0;
                var achievedStepsCounter = 0;
                var sword = {
                    transparent: null,
                    fullVisible: null,
                    swordFullOffset: 0
                };
                var percentTextElement = null;
                var loadingScreen = null;
                var currentPercent = 0;
                var draw = null;
                var drawTimer = 17;

                this.showUnload = function () {
                    if (loadingScreen == null) {
                        loadingScreen = document.querySelector('.loadingScreen');
                    }
                    if (loadingScreen != null) {
                        loadingScreen.style.display = 'block';
                        loadingScreen.className += ' unload';
                    }
                };
                this.registerStep = function (reference) {
                    steps.push(reference);
                    totalSteps++;
                };
                this.achieveStep = function (reference) {
                    var pos = steps.indexOf(reference);
                    if (pos >= 0) {
                        steps.splice(pos, 1);
                        achievedStepsCounter++;
                        updateProgressBar();
                    }
                };
                function displayPercentage() {
                    if (sword.fullVisible == null) {
                        sword.fullVisible = document.querySelector('.loadingScreen .loadingBar .progressBar .sword.fullVisible');
                        if (sword.fullVisible != null) {
                            sword.swordFullOffset = sword.fullVisible.offsetWidth;
                        }
                    }
                    if (sword.transparent == null) {
                        sword.transparent = document.querySelector('.loadingScreen .loadingBar .progressBar .sword.transparent');
                    }
                    if (percentTextElement == null) {
                        percentTextElement = document.querySelector('.loadingScreen .loadingBar .loadingPercent .loadingTextNumber');
                    }
                    if (sword.transparent != null && sword.fullVisible != null && percentTextElement != null) {
                        var currentWidth = ((currentPercent * (sword.transparent.offsetWidth - sword.swordFullOffset)) / 100) + sword.swordFullOffset;
                        sword.fullVisible.style.width = currentWidth + 'px';
                        document.querySelector('.loadingScreen .loadingBar .loadingPercent .loadingTextNumber').textContent = currentPercent + '';
                    }
                }

                function hideLoadingScreen() {
                    var loadingScreen = document.querySelector(".loadingScreen");
                    loadingScreen.style.display = 'none';
                }
                function finishLoading() {
                    var allStepsLoadingTimeNeeded = Date.now() - loadingStartTime;
                    var timeSinceAllStepsLoaded = Date.now();

                    draw = setInterval(function () {
                        if (currentPercent <= 100) {
                            displayPercentage();
                            var elapsedTimeSinceAllStepsLoaded = Date.now() - timeSinceAllStepsLoaded;
                            var speedUp = 0.2; //1 = we wait the same amount as the loading time, to "finish" (for images from .css files) - lower is faster
                            //calculate the percent for the time since loading has finished
                            currentPercent = Math.round(50 + ((elapsedTimeSinceAllStepsLoaded / (allStepsLoadingTimeNeeded * speedUp)) * 50));
                        } else {
                            currentPercent = 100;
                            displayPercentage();
                            hideLoadingScreen();
                            clearInterval(draw);
                        }
                    }, drawTimer);
                }
                function updateProgressBar() {

                    var achievedPercent = Math.round((((achievedStepsCounter) * 50) / totalSteps));
                    //if we are behind the new calculated achieved progress we need to jump ahead to the achievedProgress
                    if (currentPercent < achievedPercent) {
                        currentPercent = achievedPercent;
                        displayPercentage();
                    }

                    //clear the interval if it already exists
                    if (draw != null) {
                        clearInterval(draw);
                        draw = null;
                    }
                    if (achievedStepsCounter < totalSteps) {
                        draw = setInterval(function () {
                            if (currentPercent < 50) {
                                currentPercent++;
                                displayPercentage();
                            } else {
                                updateProgressBar();
                                clearInterval(draw);
                            }
                        }, 500); //needs to be fixed to 500 so the files have time to load whilst the loading screen keeps moving
                    } else {
                        finishLoading();
                    }

                }
                this.onFileLoadingError = function (file) {
                    var loadingText = null;
                    function logError() {
                        var url = '';
                        var data = {
                            'controller': 'error',
                            'action': 'logLoadingError',
                            'params': {
                                'playerId': Travian.Globals['playerId'],
                                'error': file
                            }
                        };
                        if (typeof (config['SERVER_ENV']) == 'undefined') {
                            config['SERVER_ENV'] = 'devPHP';
                        }
                        if (config['SERVER_ENV'] === 'devPHP') {
                            url = config['devPHPUrl'];
                        } else {
                            if (config['SERVER_ENV'] === 'live') {
                                url = config['liveUrl'];
                            }
                        }
                        var start = new Date().getTime();

                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', encodeURI(url + "?c=error&a=logLoadingError&t=" + start));
                        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
                        xhr.send(JSON.stringify(data));
                    }
                    function displayError() {
                        if (loadingText == null) {
                            loadingText = document.querySelector('.loadingScreen .centerArea .loadingText .action.loadingGame');
                            displayError()
                        } else {
                            var filename = file.substring(file.lastIndexOf('/') + 1, file.indexOf('?'));
                            loadingText.className += ' errorMessage';
                            loadingText.textContent = 'An error has occurred whilst loading "' + filename + '". Please reload the page. If the problem persists, please contact our game support.'
                        }
                    }

                    if (typeof config != 'undefined') {
                        logError();
                    }
                    displayError();
                }
            }
        </script>
        <style type="text/css">
            body {
                overflow: hidden;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-weight: normal;
                font-size: 13px;
                line-height: 16px;
            }

            #loadingOverlay {
                position: fixed;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                padding: 20px;
                z-index: 1060;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-size: 14px;
                background-color: #9CA55B;
                background-image: url("../../../images-ltr/loading_screen_logo.png");
                background-repeat: no-repeat;
                background-position: center;
            }

            .loadingScreen {
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                z-index: 1060;
                position: fixed;
                background-color: #9ca55b;
                color: #463f39;
                /*rtl:ignore*/
                direction: ltr;
            }

            .loadingScreen .centerArea {
                width: 100%;
                height: 1000px;
                position: absolute;
                top: 50%;
                margin-top: -500px;
            }

            .loadingScreen .centerArea .highlight {
                max-width: 647px;
                width: 100%;
                background: -moz-radial-gradient(50% 50%, circle closest-side, #D9DBC6 0%, #9CA55B 100%);
                background-image: -webkit-radial-gradient(50% 50%, circle closest-side, #D9DBC6 0%, #9CA55B 100%);
                background: -webkit-radial-gradient(50% 50%, circle closest-side, #D9DBC6 0%, #9CA55B 100%);
                background: radial-gradient(50% 50%, circle closest-side, #D9DBC6 0%, #9CA55B 100%);
                height: 629px;
                margin: 0 auto;
                top: 21px;
                position: relative;
            }

            .loadingScreen .centerArea .loadingBar {
                background-color: #ccbb8f;
                height: 58px;
                position: absolute;
                top: 50%;
                width: 100%;
                background-color: rgba(0, 0, 0, 0.33);
                margin-top: -29px;
                text-align: center;
            }

            .loadingScreen .centerArea .loadingBar .loadingPercent {
                display: inline-block;
                font-size: 22px;
                /*rtl:ignore*/
                left: 2px;
                bottom: 19px;
                position: relative;
                width: 50px;
                color: #f1f0ee;
            }

            .loadingScreen .centerArea .loadingBar .progressBar {
                width: 211px;
                height: 58px;
                position: relative;
                display: inline-block;
            }

            .loadingScreen .centerArea .loadingBar .progressBar .sword.transparent {
                opacity: 0.4;
                width: 211px;
            }

            .loadingScreen .centerArea .loadingBar .progressBar .sword {
                height: 100%;
                width: 48px;
                position: absolute;
                /*rtl:ignore*/
                background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAM8AAAAvBAMAAAC264PuAAAAMFBMVEUAAADm5ubZ19dlUET08/PNy8uqpae1sbPCv8Gclpp5Y1WCeXW+u7mddlujmpa2h2W5fRWkAAAAAXRSTlMAQObYZgAAAkhJREFUWMPV2MFr01AcB/AfvJu3dxg48NIMpaJIZpRJqgel/4CWN1BPOnwdbAi2aER7sVAJehSEXEYht4DaLq7t3BBkIAPjyZsQBIsDC/YPGEjMS7KRJ2SO8fJkn0Ogh/KlL7/3+71X+H+QBlKg0gikQKsLIAV6T1WQAfXmZQUtdkAG1KvWQQbUN6ZAAhZ0CmRA696sjGpgQU05QQPzSRtyof0d1BxCHtCSzRdDi1T234AzOQz3DkoPn6tcr1vEk1oG3WHWmFUrtDQeU0oNo+F5LRJSFAVjXN51M71ar8m1Dhdkvby3RWnVMDxv0zSTrx/QSS1VZYRMcZ3h59ZtLMwZGxJohZBJNSqKWH84c18R58RO0pEfpxVFSxnMXWgdJ+LMuhDRa/XlgpsKWqmfJ0VToKeuGgU13Rk85zi6k1iun1WKhkgPoiT9ql3Cz3z/lf81fnQ3pvFRKtY7NQwqaCV8I/j9JtgOAvZ4WzlXnrAEs9X4F30Otr8FPkuLg66UxXqksqVzL+Jf/hffv8QWz/G7lWmMhcZcHqlR1W10cVh1jq07NqsJ9o4KWKCJF2q0j74X+X3Eqk5k0DF3pzMoSrozsA3bFNoZsnpd/261pghz3U537zbXVCn9YIXG47iHR0PANFvkID5pe8yjeW4e8ZzEWsJKplI8lxg2W3YtaNxh2wbuo9GowH79e8Jmnxl69M4Q8seCbrUhfyyopkL+WFD2SfVwnr3l3SYaku5H65sdkIAFSbrDDj7Kuiw/BimQPoK9Hbb/gvLyB0UOPQQTizs9AAAAAElFTkSuQmCC") no-repeat left center;
            }

            .loadingScreen .centerArea .logo {
                background-image: url("../../../images-ltr/loading_screen_logo.png");
                width: 236px;
                height: 202px;
                margin: 0 auto;
                position: relative;
                top: 188px;
            }

            @media (max-height: 600px) {
                .loadingScreen .centerArea .logo {
                    top: 240px;
                }
            }

            .loadingScreen .centerArea .loadingText {
                text-align: center;
                position: relative;
                bottom: 56px;
            }

            .loadingScreen .centerArea .loadingText .action {
                font-weight: bold;
                font-size: 22px;
                line-height: 25px;
            }

            .loadingScreen .centerArea .loadingText .avatarOnGameworld {
                font-size: 22px;
                line-height: 25px;
            }

            .loadingScreen .centerArea .loadingText .errorMessage {
                padding-bottom: 31px;
                line-height: 22px;
            }

            .loadingScreen .centerArea .loadingText .randomText {
                font-size: 18px;
                font-style: italic;
                line-height: 35px;
            }

            .loadingScreen .centerArea .loadingText hr {
                width: 560px;
                border-top: 1px solid #7b736d;
                border-bottom: 1px solid #ABA7A4;
                margin-top: 0px;
                margin-bottom: 0px;
                display: block;
            }
        </style>

        <script type="text/javascript">
            var loadingStartTime = Date.now();
            GlobalLoadingScreenManager = new LoadingScreenManager();
            GlobalLoadingScreenManager.registerStep('get_all');
            var fileLoader = new FileLoader(GlobalLoadingScreenManager.registerStep, GlobalLoadingScreenManager.achieveStep, GlobalLoadingScreenManager.onFileLoadingError, false);

            var GameLobby = {
                htmlFilters: {},
                txt: {},
                tick: {},
                locale: {},
                globals: {}
            };

            GameLobby.config = {
                "backendUrl": "/api/index.php",
                "redirectAfterLogout": "<?php echo $index_url; ?>#logout",
                "environment": "live",
                "node": {
                    "host": "<?php echo $lobby_url; ?>",
                    "port": 8082,
                    "resource": "chat"
                },
                "avatar": {
                    "maxSitters": 2,
                    "maxDuals": 2
                },
                "links": {
                    "urlForum": "http:\/\/forum.kingdoms.com\/",
                    "urlWiki": "http:\/\/wiki.kingdoms.com\/tiki-switch_lang.php?language=",
                    "urlHelpCenter": "http:\/\/help.kingdoms.com\/",
                    "urlPrivacy": "http:\/\/agb.traviangames.com\/privacy-XX.pdf",
                    "urlTerms": "http:\/\/agb.traviangames.com\/terms-XX.pdf",
                    "urlGameRules": "http:\/\/www.kingdoms.com\/rules.php?lang=X"
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
            };
            GameLobby.config['direction'] = 'ltr';
            GameLobby.config['mellon']['application']['styles'] = '<?php echo $mellon_url; ?>startpage/live/css/ltr/mellonDialogue.css';
            fileLoader.addScript("<?php echo $mellon_url; ?>startpage/live/css/ltr/mellonModal.css?h=d86bda6e947c64441b23cccd4fee8e29", function () {}, 'css');
            GameLobby.globals['sessionId'] = '<?php echo isset($_SESSION['mellon_msid']) ? $_SESSION['mellon_msid'] : ""; ?>';
            GameLobby.globals['playerId'] = '<?php echo isset($_SESSION['lobby_uid']) ? $_SESSION['lobby_uid'] : ""; ?>';
            GameLobby.globals['selectedCountry'] = 'en';
            GameLobby.Countries = {
                "asia": ["tr"],
                "europe": ["en", "gb", "us", "ru", "dk", "no", "se", "fi", "nl", "fr", "pt", "de", "it", "es", "pl", "cz", "hu"],
                "middle_east": ["ae"]
            };
            GameLobby.Clusters = {
                "1": ["dk", "no", "se", "fi"],
                "2": ["en", "gb", "us"]
            };
            GameLobby.Features = {
                "maxSitters": 2,
                "maxDuals": 2,
                "prestigeNeededForRename": 100,
                "enableAccountNameChange": true,
                "prestige": true,
                "achievements": false,
                "disableByTutorial": false,
                "cdnPrefix": "<?php echo $cdn_url; ?>lobby/live/",
                "goldTransferNotAllowedCountries": ["pl", "hu", "ru"]
            };

            fileLoader.addScript('<?php echo $cdn_url; ?>lobby/live/js/all.js?h=4f7981cf0d4ebe58d353882f3d541b36');
            fileLoader.addScript('<?php echo $cdn_url; ?>lobby/live/js/templates.js?h=7007214aff30a6ab0e3b687fad027478');


            fileLoader.addScript("//static-mellon.traviangames.com/tk/fenster-css.css", function () {}, 'css');
            fileLoader.addScript("//static-mellon.traviangames.com/tk/fenster-js.js", function () {}, 'js');
            fileLoader.addScript("//static-mellon.traviangames.com/tk/sdk-js.js", function () {}, 'js');

            fileLoader.addScript('<?php echo $cdn_url; ?>lobby/live/css/ltr/lobby.css?h=8a754bcd88f857d3f15459cf166164e3');

            fileLoader.addScript('<?php echo $cdn_url; ?>lobby/live/lang/us/lang.js', function () {}, 'js');

            fileLoader.load(
                    function () {
                        // we have to wait until all files have been loaded until we manually bootstrap angular
                        angular.bootstrap(document, ['GameLobby'], {
                            'strictDi': true
                        });
                    }
            )
        </script>
        <!-- apple related favicons and settings -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <link rel="apple-touch-icon" sizes="57x57" href="http://cdn.traviantools.net/lobby/live/images-ltr/favicons/apple-touch-icon-57x57.png?v=2">
        <link rel="apple-touch-icon" sizes="60x60" href="http://cdn.traviantools.net/lobby/live/images-ltr/favicons/apple-touch-icon-60x60.png?v=2">
        <link rel="apple-touch-icon" sizes="72x72" href="http://cdn.traviantools.net/lobby/live/images-ltr/favicons/apple-touch-icon-72x72.png?v=2">
        <link rel="apple-touch-icon" sizes="76x76" href="http://cdn.traviantools.net/lobby/live/images-ltr/favicons/apple-touch-icon-76x76.png?v=2">
        <link rel="apple-touch-icon" sizes="114x114" href="http://cdn.traviantools.net/lobby/live/images-ltr/favicons/apple-touch-icon-114x114.png?v=2">
        <link rel="apple-touch-icon" sizes="120x120" href="http://cdn.traviantools.net/lobby/live/images-ltr/favicons/apple-touch-icon-120x120.png?v=2">
        <link rel="apple-touch-icon" sizes="144x144" href="http://cdn.traviantools.net/lobby/live/images-ltr/favicons/apple-touch-icon-144x144.png?v=2">
        <link rel="apple-touch-icon" sizes="152x152" href="http://cdn.traviantools.net/lobby/live/images-ltr/favicons/apple-touch-icon-152x152.png?v=2">
        <link rel="apple-touch-icon" sizes="180x180" href="http://cdn.traviantools.net/lobby/live/images-ltr/favicons/apple-touch-icon-180x180.png?v=2">
        <link rel="mask-icon" href="http://cdn.traviantools.net/lobby/live/images-ltr/favicons/safari-pinned-tab.svg?v=2" color="#5bbad5">

        <!-- android related favicons and settings -->
        <link rel="manifest" href="http://cdn.traviantools.net/lobby/live/images-ltr/favicons/manifest.json?v=2">
        <meta name="theme-color" content="#7DA100">

        <!-- windows phone related favicons and settings -->
        <meta name="msapplication-tap-highlight" content="no" />
        <meta name="msapplication-config" content="http://cdn.traviantools.net/lobby/live/images-ltr/favicons/browserconfig.xml?v=2" />
        <meta name="application-name" content="Travian Kingdoms" />
        <meta name="msapplication-TileColor" content="#da532c" />
        <meta name="msapplication-TileImage" content="http://cdn.traviantools.net/lobby/live/images-ltr/favicons/mstile-144x144.png?v=2" />

        <!-- normal favicons -->
        <link rel="icon" type="image/x-icon" href="http://cdn.traviantools.net/lobby/live/images-ltr/favicons/favicon.ico?v=2">
        <link rel="icon" type="image/png" href="http://cdn.traviantools.net/lobby/live/images-ltr/favicons/favicon-32x32.png?v=2" sizes="32x32">
        <link rel="icon" type="image/png" href="http://cdn.traviantools.net/lobby/live/images-ltr/favicons/favicon-194x194.png?v=2" sizes="194x194">
        <link rel="icon" type="image/png" href="http://cdn.traviantools.net/lobby/live/images-ltr/favicons/favicon-96x96.png?v=2" sizes="96x96">
        <link rel="icon" type="image/png" href="http://cdn.traviantools.net/lobby/live/images-ltr/favicons/favicon-16x16.png?v=2" sizes="16x16"> </head>

    <body class="isLeft">
        <div class="loadingScreen">
            <div class="centerArea">
                <div class="highlight">
                    <div class="logo"></div>
                </div>
                <div class="loadingBar">
                    <div class="progressBar">
                        <div class="sword transparent"></div>
                        <div class="sword fullVisible"></div>
                    </div>
                    <div class="loadingPercent">
                        <span class="loading        TextNumber">0</span><span>%</span>
                    </div>
                </div>
                <div class="loadingText">
                    <div class="action loadingGame">
                        LOADING
                    </div>
                    <div class="avatarOnGameworld">
                        phoomin009_COM
                    </div>
                    <hr/>
                    <div class="randomText">
                        Building Wonders of the World
                    </div>
                    <div class="errorMessage"></div>
                </div>
            </div>
        </div>
        <div class="top-spacer"></div>
        <div class="overlay"></div>
        <div id="bgbg"></div>

        <div ng-if="loggedIn">
            <div ng-include="'templates/layout/notifications.html'" id="noti    fications"></div>
            <div ng-include="'templates/layout/header.html'" id="header"></div>
            <div scrollable resize-sensor-elem=".container-fluid" class="container-fluid ui-page-{{$state.current.name}}">
                <div class="wrapper">
                    <div ui-view class="glWindow"></div>
                </div>
            </div>
            <div ng-include="'templates/layout/sidebar.html'" id="sidebar"></div>
            <div ng-include="'templates/layout/footer.html'" id="footer"></div>
            <div ng-include="'templates/layout/mellon.html'"></div>
        </div>
        <div class="modals" modals></div>
    </body>

</html>
