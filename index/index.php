<?php
include_once __DIR__ . "/../config.php";
?>
<!DOCTYPE html>
<html class="desktop ">
    <head>
        <meta charset="UTF-8">
        <title>Travian Kingdoms</title>

        <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="mobile-web-app-capable" content="yes">

        <link rel="dns-prefetch" href="//connect.facebook.net">
        <link rel="dns-prefetch" href="//cdn.optimizely.com">
        <link rel="dns-prefetch" href="//cdn.zarget.com">


        <meta name="author" content="Travian Games GmbH" />
        <meta name="keywords" content="travian, kingdoms, strategy, free, browser, online, game, browsergame, ancient, mmo, massively multiplayer, f2p, play, team based" />
        <meta name="description" content="Play the free browser game Travian Kingdoms. Build up your village, train an army, choose your tribe and play against thousands of other players." />

        <link rel="alternate" hreflang="de" href="http://www.kingdoms.com/de/" />
        <link rel="alternate" hreflang="en" href="http://www.kingdoms.com/com/" />
        <link rel="alternate" hreflang="ru" href="http://www.kingdoms.com/ru/" />
        <link rel="alternate" hreflang="cs" href="http://www.kingdoms.com/cz/" />
        <link rel="alternate" hreflang="fr" href="http://www.kingdoms.com/fr/" />
        <link rel="alternate" hreflang="hu" href="http://www.kingdoms.com/hu/" />
        <link rel="alternate" hreflang="nl" href="http://www.kingdoms.com/nl/" />
        <link rel="alternate" hreflang="da" href="http://www.kingdoms.com/dk/" />
        <link rel="alternate" hreflang="en-US" href="http://www.kingdoms.com/us/" />
        <link rel="alternate" hreflang="it" href="http://www.kingdoms.com/it/" />
        <link rel="alternate" hreflang="tr" href="http://www.kingdoms.com/tr/" />
        <link rel="alternate" hreflang="pl" href="http://www.kingdoms.com/pl/" />
        <link rel="alternate" hreflang="en-GB" href="http://www.kingdoms.com/gb/" />
        <link rel="alternate" hreflang="ar" href="http://www.kingdoms.com/ae/" />
        <link rel="alternate" hreflang="sv" href="http://www.kingdoms.com/se/" />
        <link rel="alternate" hreflang="no" href="http://www.kingdoms.com/no/" />
        <link rel="alternate" hreflang="fi" href="http://www.kingdoms.com/fi/" />
        <link rel="alternate" hreflang="es" href="http://www.kingdoms.com/es/" />
        <link rel="alternate" hreflang="pt" href="http://www.kingdoms.com/pt/" />
        <link rel="alternate" hreflang="en" href="http://www.kingdoms.com/" />
        <link rel="alternate" hreflang="x-default" href="http://www.kingdoms.com/" />
        <link rel="canonical" href="http://www.kingdoms.com/com/" />

        <link rel="stylesheet" href="<?php echo $cdn_url; ?>startpage/live/css/ltr/default.css?h=5983f3e6e809544d105622c382f084bb"/>
        <script src="<?php echo $cdn_url; ?>startpage/live/js/startpage.min.js?h=8a985fc85d058694fb730f85f5a0b302" type="text/javascript"></script>

        <!-- apple related favicons and settings -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <link rel="apple-touch-icon" sizes="57x57" href="/img/favicons/apple-touch-icon-57x57.png?v=2">
        <link rel="apple-touch-icon" sizes="60x60" href="/img/favicons/apple-touch-icon-60x60.png?v=2">
        <link rel="apple-touch-icon" sizes="72x72" href="/img/favicons/apple-touch-icon-72x72.png?v=2">
        <link rel="apple-touch-icon" sizes="76x76" href="/img/favicons/apple-touch-icon-76x76.png?v=2">
        <link rel="apple-touch-icon" sizes="114x114" href="/img/favicons/apple-touch-icon-114x114.png?v=2">
        <link rel="apple-touch-icon" sizes="120x120" href="/img/favicons/apple-touch-icon-120x120.png?v=2">
        <link rel="apple-touch-icon" sizes="144x144" href="/img/favicons/apple-touch-icon-144x144.png?v=2">
        <link rel="apple-touch-icon" sizes="152x152" href="/img/favicons/apple-touch-icon-152x152.png?v=2">
        <link rel="apple-touch-icon" sizes="180x180" href="/img/favicons/apple-touch-icon-180x180.png?v=2">
        <link rel="mask-icon" href="/img/favicons/safari-pinned-tab.svg?v=2" color="#5bbad5">

        <!-- android related favicons and settings -->
        <link rel="manifest" href="/img/favicons/manifest.json?v=2">
        <meta name="theme-color" content="#7DA100">

        <!-- windows phone related favicons and settings -->
        <meta name="msapplication-tap-highlight" content="no"/>
        <meta name="msapplication-config" content="/img/favicons/browserconfig.xml?v=2"/>
        <meta name="application-name" content="Travian Kingdoms"/>
        <meta name="msapplication-TileColor" content="#da532c"/>
        <meta name="msapplication-TileImage" content="/img/favicons/mstile-144x144.png?v=2"/>

        <!-- normal favicons -->
        <link rel="icon" type="image/x-icon" href="/img/favicons/favicon.ico?v=2">
        <link rel="icon" type="image/png" href="/img/favicons/favicon-32x32.png?v=2" sizes="32x32">
        <link rel="icon" type="image/png" href="/img/favicons/favicon-194x194.png?v=2" sizes="194x194">
        <link rel="icon" type="image/png" href="/img/favicons/favicon-96x96.png?v=2" sizes="96x96">
        <link rel="icon" type="image/png" href="/img/favicons/favicon-16x16.png?v=2" sizes="16x16">

        <!-- mellon -->
        <link rel="dns-prefetch" href="https://mellon-t5.traviangames.com">
        <link rel="stylesheet" href="<?php echo $mellon_url; ?>tk/fenster-css.css" />
        <script src="<?php echo $mellon_url; ?>tk/fenster-js.js" type="text/javascript"></script>
        <script src="<?php echo $mellon_url; ?>tk/sdk-js.js" type="text/javascript"></script>
        <script type="text/javascript">
            var mellonStyles = {
                default: '<?php echo $cdn_url; ?>startpage/live/css/ltr/mellonDialogue.css?c1a17c184e69463ac3690af497880e83',
                signup: {
                    'A': '<?php echo $cdn_url; ?>startpage/live/css/ltr/mellonDialogueSignupA.css?5ab1d3a3e7eda3e1b17b829db285595c',
                    'B': '<?php echo $cdn_url; ?>startpage/live/css/ltr/mellonDialogueSignupB.css?87a62ddefc41b314f01cf521280685d5',
                    'C': '<?php echo $cdn_url; ?>startpage/live/css/ltr/mellonDialogueSignupC.css?975c395df6a5b0ce0a003b529ca1f80c'
                }
            };
            var mellonUrl = new MellonUrl('<?php echo $mellon_url; ?>');
            var mellonConfig = {
                url: mellonUrl.getBase(),
                application: {
                    id: 'travian-ks',
                    countryId: 'en',
                    instanceId: 'portal-en',
                    languageId: 'en_US',
                    styles: mellonStyles['A']
                },
                mellon: {
                    cookie: {
                        domain: '.travian.com'
                    }
                }
            };

        </script>
        <!-- /mellon -->

        <script type="text/javascript">
            Startpage['lang'] = 'com';
            Startpage['direction'] = 'ltr';
            Startpage['deviceType'] = 'desktop';
            Startpage['config'] = {lobbyUrl: '<?php echo $lobby_url; ?>'};
            setHeaderVersion('4');
            setSignUpVersion('0');
            window.loggedIn = false;
        </script>
    </head>
    <body>

        <!-- mellon -->
        <div id="mellonModal" class="jqFensterModal">
            <div class="jqFensterModalContent"></div>
        </div>
        <!-- /mellon -->

        <div class="page main">
            <div class="topBarBackground"></div>
            <div class="topBar">
                <div class="topBarContent jsHeaderFullWidth">
                    <div class="languageContainer" id="languageContainer">
                        <div class="dropdown" data-track-content data-content-name="Header" data-content-piece="Language">
                            <div class="dropdownButton" data-toggle="dropdown">
                                <div class="selectedLanguage">International</div>
                                <i class="languageFlag com"></i>
                                <div class="verticalDivider"></div>
                                <span class="tkIcon caret"></span>
                            </div>
                            <div class="dropdownContainer">
                                <ul class="dropdown-menu">
                                    <li class="dropdownLang" data-lang="de">
                                        <i class="languageFlag de"></i>
                                        <span class="dropdownLangText">Deutschland</span>
                                    </li>
                                    <li class="dropdownLang" data-lang="ru">
                                        <i class="languageFlag ru"></i>
                                        <span class="dropdownLangText">Россия</span>
                                    </li>
                                    <li class="dropdownLang" data-lang="cz">
                                        <i class="languageFlag cz"></i>
                                        <span class="dropdownLangText">Česká republika</span>
                                    </li>
                                    <li class="dropdownLang" data-lang="fr">
                                        <i class="languageFlag fr"></i>
                                        <span class="dropdownLangText">France</span>
                                    </li>
                                    <li class="dropdownLang" data-lang="hu">
                                        <i class="languageFlag hu"></i>
                                        <span class="dropdownLangText">Magyarország</span>
                                    </li>
                                    <li class="dropdownLang" data-lang="nl">
                                        <i class="languageFlag nl"></i>
                                        <span class="dropdownLangText">Nederland</span>
                                    </li>
                                    <li class="dropdownLang" data-lang="dk">
                                        <i class="languageFlag dk"></i>
                                        <span class="dropdownLangText">Danmark</span>
                                    </li>
                                    <li class="dropdownLang" data-lang="us">
                                        <i class="languageFlag us"></i>
                                        <span class="dropdownLangText">United States</span>
                                    </li>
                                    <li class="dropdownLang" data-lang="it">
                                        <i class="languageFlag it"></i>
                                        <span class="dropdownLangText">Italia</span>
                                    </li>
                                    <li class="dropdownLang" data-lang="tr">
                                        <i class="languageFlag tr"></i>
                                        <span class="dropdownLangText">Türkiye</span>
                                    </li>
                                    <li class="dropdownLang" data-lang="pl">
                                        <i class="languageFlag pl"></i>
                                        <span class="dropdownLangText">Polska</span>
                                    </li>
                                    <li class="dropdownLang" data-lang="gb">
                                        <i class="languageFlag gb"></i>
                                        <span class="dropdownLangText">United Kingdom</span>
                                    </li>
                                    <li class="dropdownLang" data-lang="ae">
                                        <i class="languageFlag ae"></i>
                                        <span class="dropdownLangText">عربية</span>
                                    </li>
                                    <li class="dropdownLang" data-lang="se">
                                        <i class="languageFlag se"></i>
                                        <span class="dropdownLangText">Sverige</span>
                                    </li>
                                    <li class="dropdownLang" data-lang="no">
                                        <i class="languageFlag no"></i>
                                        <span class="dropdownLangText">Norge</span>
                                    </li>
                                    <li class="dropdownLang" data-lang="fi">
                                        <i class="languageFlag fi"></i>
                                        <span class="dropdownLangText">Suomi</span>
                                    </li>
                                    <li class="dropdownLang" data-lang="es">
                                        <i class="languageFlag es"></i>
                                        <span class="dropdownLangText">España</span>
                                    </li>
                                    <li class="dropdownLang" data-lang="pt">
                                        <i class="languageFlag pt"></i>
                                        <span class="dropdownLangText">Portugal</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="loginButtonContainer" id="loginButtonContainer" data-track-content data-content-name="Header" data-content-piece="Login">
                        <div class="haveAnAccountContainer">Already have an account?</div>
                        <a data-mellon-iframe-url="/authentication/login" id="loginButton" data-selector="#mellonModal" class="jqFenster">
                            <button><span>Login</span></button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="topCaption">
                <div class="trapezoidalOrnament onBottom"></div>
                <div class="text">BROWSER GAME</div>
            </div>
            <div class="logoContainer jsHeaderFullWidth">
                <div class="logoCaption jsHeaderFullWidth">
                    <div class="trapezoidalOrnament onBottom"></div>
                    <div class="text">BROWSER GAME</div>
                </div>
                <div class="logoBox">
                    <i class="tkIcon tkIcon-travianKingdoms"></i>
                    <div class="trapezoidalOrnament onBottom"></div>
                </div>
            </div>			<div class="header">
                <div class="topWrapper">
                    <div class="topArea jsHeaderFullWidth"></div>
                    <div class="topImage layerBack jsHeaderFullWidth"></div>
                    <div class="topImage layerMiddle"></div>
                    <div class="topImage layerFront jsHeaderFullWidth"></div>
                </div>
                <div class="headerBgVideoContainer">
                    <video class="headerBgVideo" src="//cdn.traviantools.net/startpage/live/img/ltr/header_animation_1920x1080.mp4" poster="//cdn.traviantools.net/startpage/live/img/ltr/header_animation_1920x1080_poster.jpg" type="video/mp4" loop autoplay autobuffer></video>
                </div>
                <div class="playNowContainer jsHeaderFullWidth">
                    <div class="playButtonsContainer desktop ">
                        <div class="playNowButton">
                            <div class="originalButton">
                                <div class="background"></div>
                                <div class="foreground">
                                    <div class="patternWrapper fromPatternWrapper topPatternWrapper">
                                        <div class="bgPattern">
                                            <div class="pattern"></div>
                                        </div>
                                    </div>
                                    <div class="patternWrapper toPatternWrapper topPatternWrapper">
                                        <div class="bgPattern">
                                            <div class="pattern"></div>
                                        </div>
                                    </div>
                                    <div class="patternWrapper fromPatternWrapper bottomPatternWrapper">
                                        <div class="bgPattern">
                                            <div class="pattern"></div>
                                        </div>
                                    </div>
                                    <div class="patternWrapper toPatternWrapper bottomPatternWrapper">
                                        <div class="bgPattern">
                                            <div class="pattern"></div>
                                        </div>
                                    </div>
                                    <button id="playNowButton" data-track-content data-content-name="Button" data-content-piece="PlayNow">
                                        <span>START GAME					</span>
                                    </button>
                                </div>
                            </div>
                            <div class="abButton">
                                <div class="tkIcon tkIcon-kingdomsLogo kingdomsLogo"></div>
                                <div class="tkIcon buttonBackground"></div>
                                <button id="playNowButton" data-track-content data-content-name="Button" data-content-piece="PlayNow">
                                    <span>START GAME				</span>
                                </button>
                                <div class="tkIcon tkIcon-playNowArrow playNowArrow"></div>
                            </div>

                        </div>
                        <a href="https://70272.measurementapi.com/serve?action=click&publisher_id=243045&site_id=60756&sub1=11541" class="iosButton" data-track-content data-content-name="Button" data-content-piece="IOS">
                            <img src="/img/appStoreButtons/iOS/Download_on_the_App_Store_Badge_COM_135x40.svg">
                        </a>
                        <a class="androidButton" href="https://70272.measurementapi.com/serve?action=click&publisher_id=243045&site_id=60758&sub1=11541" data-track-content data-content-name="Button" data-content-piece="Android">
                            <img alt="Get it on Google Play" src="/img/appStoreButtons/android/en-play-badge.png" />
                        </a>
                    </div>		<div class="registerNowFrame">
                        <div class="registerLogoContainer">
                            <div class="tkIcon tkIcon-kingdomsLogo kingdomsLogo"></div>
                        </div>
                        <div class="trapezoidalOrnament onTop"></div>
                        <div class="dialogueContainer">
                            <div class="kingdomEdge fromEdge"></div>
                            <div class="kingdomEdge toEdge"></div>
                            <div class="tkIcon tkIcon-registerNowBottom registerNowBottom"></div>
                        </div>
                    </div>
                </div>
                <div class="bottomBarContainer jsHeaderFullWidth">
                    <div class="bottomBar"></div>
                </div>
            </div>			<div class="bgWrapper">
                <div class="contentWrapper">
                    <div class="content">
                        <div class="contentArea gameDescription">
                            <h1>BUILD YOUR<br> ULTIMATE EMPIRE</h1>
                            <hr>
                            <h2>Travian Kingdoms is one of the best multi-player strategy games for your browser!</h2>
                            <div data-track-content data-content-name="Content" data-content-piece="GameDescription"></div>
                            <ul>
                                <li><i class="tkIcon tkIcon-star"></i>Rule over your kingdom</li>
                                <li><i class="tkIcon tkIcon-star"></i>Expand your influence</li>
                                <li><i class="tkIcon tkIcon-star"></i>Use your diplomatic skills</li>
                                <li><i class="tkIcon tkIcon-star"></i>Conquer the Wonder of the World and win</li>
                            </ul>
                            <i class="chieftain"></i>
                            <div id="TimeLineMoreButton" class="moreButton closed" data-track-content data-content-name="Content" data-content-piece="TimeLineMore">
                                <i class="tkIcon tkIcon-more"></i>
                                <span>Learn more</span>
                            </div>
                            <div class="timelineContainer closed">
                                <div class="timelineHeader">
                                    <div class="headerText">SEE WHAT LIES AHEAD IN TRAVIAN KINGDOMS!</div>
                                </div>
                                <div class="timelineContent">
                                    <div class="timelineDescription">Join a game round lasting 6 months and try your best – only the strongest will make it to the top.</div>
                                    <div class="timelineBackground">
                                        <div class="stepCarousel">
                                            <div class="stepContainer step1 selected"><div class="stepFrame"><div class="textBox"><div class="headerContainer"><div class="headerContent"><span>Game start</span></div></div><div class="textContent">Discover the world of Travian Kingdoms. May your journey lead you to power and glory!</div></div></div></div><div class="stepContainer step2"><div class="stepFrame"><div class="textBox"><div class="headerContainer"><div class="headerContent"><span>Second village</span></div></div><div class="textContent">Found your second village and expand your influence in the early stages of your empire.</div></div></div></div><div class="stepContainer step3"><div class="stepFrame"><div class="textBox"><div class="headerContainer"><div class="headerContent"><span>First city</span></div></div><div class="textContent">Empower your villages. The choice is yours: Convert them into mighty cities or grow your strength in numbers with many villages.</div></div></div></div><div class="stepContainer step4"><div class="stepFrame"><div class="textBox"><div class="headerContainer"><div class="headerContent"><span>Catapults and conquering</span></div></div><div class="textContent">War is coming – train your troops and be prepared to defend your empire!</div></div></div></div><div class="stepContainer step5"><div class="stepFrame"><div class="textBox"><div class="headerContainer"><div class="headerContent"><span>War over treasures</span></div></div><div class="textContent">Valuable treasures will decide over the rise and fall of your kingdom – collect as many as possible and protect them!</div></div></div></div><div class="stepContainer step6"><div class="stepFrame"><div class="textBox"><div class="headerContainer"><div class="headerContent"><span>Natars and Wonders of the World</span></div></div><div class="textContent">The mysterious Natar tribe will appear and with them, the seven Wonders of the World – conquer and upgrade them to win!</div></div></div></div><div class="stepContainer step7"><div class="stepFrame"><div class="textBox"><div class="headerContainer"><div class="headerContent"><span>Game end</span></div></div><div class="textContent">Your task will be to complete the Wonder of the World! Only the most powerful kingdoms can achieve this and thereby dominate the world of Travian!</div></div></div></div>			</div>
                                        <table class="stepTimeline transparent">
                                            <tr>
                                                <td>
                                                    <div class="stepButtonContainer step1 selected">
                                                        <div class="stepButton"></div>
                                                    </div>
                                                    <div class="protection">
                                                        <i class="tkIcon tkIcon-protection"></i>
                                                    </div>
                                                    <div class="tooltip">Beginner's protection</div>
                                                </td>	<td>
                                                    <div class="stepButtonContainer step2">
                                                        <div class="stepButton"></div>
                                                    </div>
                                                </td>	<td>
                                                    <div class="stepButtonContainer step3">
                                                        <div class="stepButton"></div>
                                                    </div>
                                                </td>	<td>
                                                    <div class="stepButtonContainer step4">
                                                        <div class="stepButton"></div>
                                                    </div>
                                                </td>	<td>
                                                    <div class="stepButtonContainer step5">
                                                        <div class="stepButton"></div>
                                                    </div>
                                                </td>	<td>
                                                    <div class="stepButtonContainer step6">
                                                        <div class="stepButton"></div>
                                                    </div>
                                                </td>	<td>
                                                    <div class="stepButtonContainer step7">
                                                        <div class="stepButton"></div>
                                                    </div>
                                                </td>				</tr>
                                            <tr>
                                                <td class="step1 selected">Today</td><td class="step2">1 week</td><td class="step3">2 months</td><td class="step4">3 months</td><td class="step5">4 months</td><td class="step6">5 months</td><td class="step7">6 months</td>				</tr>
                                        </table>
                                    </div>
                                </div>
                            </div>	</div>
                        <div class="contentArea screenshots">
                            <div class="contentHeader">
                                <div class="headerIcon"><i class="tkIcon tkIcon-crown"></i></div>
                                <span class="headerText jsScreenshotsHeadline">RULE OVER YOUR KINGDOM</span>
                            </div>
                            <div class="carouselContainer">
                                <div id="screenshotCarousel" class="carousel slide" data-interval="false">
                                    <ol class="carousel-indicators">
                                        <li data-target="#screenshotCarousel" data-slide-to="0" class="active"><div class="carouselButton"></div></li><li data-target="#screenshotCarousel" data-slide-to="1" class=""><div class="carouselButton"></div></li><li data-target="#screenshotCarousel" data-slide-to="2" class=""><div class="carouselButton"></div></li>				</ol>
                                    <div class="carousel-inner" role="listbox">
                                        <div class="item active screenshot1"  data-track-content data-content-name="Screenshots" data-content-piece="Screenshot1"><span class="hiddenHeadline">RULE OVER YOUR KINGDOM</span><p>Gather resources, collect tributes and trade with other players.</p><img src="/img/screenshots/placeholder.png"/></div><div class="item  screenshot2"  data-track-content data-content-name="Screenshots" data-content-piece="Screenshot2"><span class="hiddenHeadline">BUILD UP YOUR EMPIRE</span><p>Upgrade your villages to cities, improve your army and hold celebrations to keep your citizens happy.</p><img src="/img/screenshots/placeholder.png"/></div><div class="item  screenshot3"  data-track-content data-content-name="Screenshots" data-content-piece="Screenshot3"><span class="hiddenHeadline">EXPAND YOUR INFLUENCE</span><p>Forge kingdoms, attack robbers and steal treasures.</p><img src="/img/screenshots/placeholder.png"/></div>				</div>
                                    <a class="left carousel-control" href="#screenshotCarousel" role="button" data-slide="prev">
                                        <span class="arrow" aria-hidden="true"></span>
                                    </a>
                                    <a class="right carousel-control" href="#screenshotCarousel" role="button" data-slide="next">
                                        <span class="arrow" aria-hidden="true"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="contentArea startNow">
                            <div class="contentHeader">
                                <div class="headerIcon"><i class="tkIcon tkIcon-crown"></i></div>
                                <span class="headerText">EXPERIENCE THE GLORY</span>
                            </div>
                            <div class="teaser">
                                <p>Travian Kingdoms takes place in an ancient world.</p>
                                <p>As the leader of a local tribe, your mission is to create a better future for your people.</p>
                                <p>Choose to be either king or governor and coordinate your strategy with other players to control resources, armies and territory.</p>
                                <p>
                                    Only few will survive long enough to rule the world.				<span class="question">Will you be one of them?</span>
                                </p>
                                <div data-track-content data-content-name="Content" data-content-piece="StartNow"></div>
                            </div>
                            <div class="playButtonsContainer desktop ">
                                <div class="playNowButton">
                                    <div class="originalButton">
                                        <div class="background"></div>
                                        <div class="foreground">
                                            <div class="patternWrapper fromPatternWrapper topPatternWrapper">
                                                <div class="bgPattern">
                                                    <div class="pattern"></div>
                                                </div>
                                            </div>
                                            <div class="patternWrapper toPatternWrapper topPatternWrapper">
                                                <div class="bgPattern">
                                                    <div class="pattern"></div>
                                                </div>
                                            </div>
                                            <div class="patternWrapper fromPatternWrapper bottomPatternWrapper">
                                                <div class="bgPattern">
                                                    <div class="pattern"></div>
                                                </div>
                                            </div>
                                            <div class="patternWrapper toPatternWrapper bottomPatternWrapper">
                                                <div class="bgPattern">
                                                    <div class="pattern"></div>
                                                </div>
                                            </div>
                                            <button id="playNowButton" data-track-content data-content-name="Button" data-content-piece="PlayNow">
                                                <span>START GAME					</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="abButton">
                                        <div class="tkIcon tkIcon-kingdomsLogo kingdomsLogo"></div>
                                        <div class="tkIcon buttonBackground"></div>
                                        <button id="playNowButton" data-track-content data-content-name="Button" data-content-piece="PlayNow">
                                            <span>START GAME				</span>
                                        </button>
                                        <div class="tkIcon tkIcon-playNowArrow playNowArrow"></div>
                                    </div>

                                </div>
                                <a href="https://70272.measurementapi.com/serve?action=click&publisher_id=243045&site_id=60756&sub1=11541" class="iosButton" data-track-content data-content-name="Button" data-content-piece="IOS">
                                    <img src="/img/appStoreButtons/iOS/Download_on_the_App_Store_Badge_COM_135x40.svg">
                                </a>
                                <a class="androidButton" href="https://70272.measurementapi.com/serve?action=click&publisher_id=243045&site_id=60758&sub1=11541" data-track-content data-content-name="Button" data-content-piece="Android">
                                    <img alt="Get it on Google Play" src="/img/appStoreButtons/android/en-play-badge.png" />
                                </a>
                            </div>	</div>
                    </div><div class="footer">
                        <div class="socialLinks">
                            <a href="http://blog.kingdoms.com/" data-track-content data-content-name="Footer" data-content-piece="Blog" id="FooterBlogLink"><i class="tkIcon tkIcon-blog"></i></a>
                            <a href="https://www.youtube.com/channel/UCxG9JXDenoqVlR442cuwg4Q" data-track-content data-content-name="Footer" data-content-piece="YoutTube" id="FooterYoutubeLink"><i class="tkIcon tkIcon-youTube"></i></a>
                            <a href="https://www.facebook.com/TravianKingdoms" data-track-content data-content-name="Footer" data-content-piece="Facebook" id="FooterFacebookLink"><i class="tkIcon tkIcon-facebook"></i></a>
                            <a href="https://twitter.com/TravianKingdoms" data-track-content data-content-name="Footer" data-content-piece="Twitter" id="FooterTwitterLink"><i class="tkIcon tkIcon-twitter"></i></a>
                        </div>
                        <div class="supportLinks">
                            <a href="http://help.kingdoms.com/en" data-track-content data-content-name="Footer" data-content-piece="HelpCenter" id="FooterHelpcenterLink">
                                Help Center</a>
                            <a href="http://forum.kingdoms.com/" data-track-content data-content-name="Footer" data-content-piece="Forum" id="FooterForumLink">
                                Forum</a>
                            <a href="http://wiki.kingdoms.com/" data-track-content data-content-name="Footer" data-content-piece="Wiki" id="FooterWikiLink">
                                Wiki</a>
                        </div>
                        <div class="gameLinks">
                            <div class="caption">Also from Travian</div>
                            <a href="http://games.traviangames.com/112861000091100/1" data-track-content data-content-name="Footer" data-content-piece="TravianLegends" id="FooterGameTravianLegendsLink">
                                <i class="tkIcon tkIcon-travianLegends"></i>
                                <div>Travian: Legends</div>
                            </a>
                            <a href="http://games.traviangames.com/112861000091100/22" data-track-content data-content-name="Footer" data-content-piece="RailNation" id="FooterGameRailNationLink">
                                <i class="tkIcon tkIcon-railNation"></i>
                                <div>Rail Nation</div>
                            </a>
                            <a href="http://games.traviangames.com/112861000091100/34" data-track-content data-content-name="Footer" data-content-piece="GoalUnitedPro" id="FooterGameGoalUnitedProLink">
                                <i class="tkIcon tkIcon-goalUnitedPro"></i>
                                <div>goalunited PRO</div>
                            </a>
                            <a href="http://games.traviangames.com/112861000091100/14" data-track-content data-content-name="Footer" data-content-piece="MiraMagia" id="FooterGameMiraMagiaLink">
                                <i class="tkIcon tkIcon-miramagia"></i>
                                <div>Miramagia</div>
                            </a>
                        </div>
                        <div class="company">
                            <i class="tkIcon tkIcon-travianGames" data-track-content data-content-name="Footer" data-content-piece="Company"></i>
                            <div>© 2016 Travian Games. All rights reserved.</div>
                            <div class="companyLinks">
                                <a class="jsLinkImprint" data-track-content data-content-name="Footer" data-content-piece="Imprint" id="FooterImprintLink">Imprint</a>
                                <a class="jsLinkGameRules" data-track-content data-content-name="Footer" data-content-piece="GameRules" id="FooterGameRulesLink">Game rules</a>
                                <a href="http://agb.traviangames.com/terms-en.pdf" data-track-content data-content-name="Footer" data-content-piece="Terms" id="FooterTermsLink">Terms and Conditions</a>
                                <a href="http://agb.traviangames.com/privacy-en.pdf" data-track-content data-content-name="Footer" data-content-piece="Privacy" id="FooterPrivacyLink">Privacy Policy</a>
                            </div>
                        </div>
                        <div class="preloadImage tribes"></div>
                    </div>				</div>
            </div>
        </div>
        <div class="overlay tribeSelection">
            <div class="selectionHeaderContainer">
                <div class="trapezoidalOrnament onTop"></div>
                <div class="selectionHeader">
                    <div class="fromEnding"></div>
                    <div class="content">Choose your path</div>
                    <div class="toEnding"></div>
                </div>
            </div>
            <div class="closeOverlay">
                <i class="tkIcon"></i>
            </div>
            <div class="tribeCarouselContainer">
                <div class="tribeSpotlight"></div>
                <div class="carouselArrow fromArrow"></div>
                <div class="carouselArrow toArrow"></div>
                <div class="tribeCarousel moveDirectionTo">
                    <div class="carouselItem gaul position0">
                        <i class="tribeImage gaul"></i>
                        <div class="hoverLighting"></div>
                    </div>
                    <div class="carouselItem teuton position1">
                        <i class="tribeImage teuton"></i>
                        <div class="hoverLighting"></div>
                    </div>
                    <div class="carouselItem roman position2">
                        <i class="tribeImage roman"></i>
                        <div class="hoverLighting"></div>
                    </div>
                </div>
            </div>
            <div class="tribeSelectionContainer tkDialogue">
                <div class="trapezoidalOrnament onTop"></div>
                <div class="selectionContainer dialogueContent tribeInfo">
                    <div class="infoHeader gaul" data-track-content data-content-name="TribeSelection" data-content-piece="Gaul">Gaul</div>
                    <div class="infoHeader teuton" data-track-content data-content-name="TribeSelection" data-content-piece="Teuton">Teuton</div>
                    <div class="infoHeader roman" data-track-content data-content-name="TribeSelection" data-content-piece="Roman">Roman</div>
                    <hr>
                    <ul class="gaul">
                        <li><i class="tkIcon tkIcon-star"></i><span>Very suitable for beginners</span></li>
                        <li><i class="tkIcon tkIcon-star"></i><span>Very strong in defense</span></li>
                        <li><i class="tkIcon tkIcon-star"></i><span>Efficient and fast cavalry</span></li>
                    </ul>
                    <ul class="teuton">
                        <li><i class="tkIcon tkIcon-star"></i><span>For active, warlike players</span></li>
                        <li><i class="tkIcon tkIcon-star"></i><span>Very strong attack</span></li>
                        <li><i class="tkIcon tkIcon-star"></i><span>Cheap infantry</span></li>
                    </ul>
                    <ul class="roman">
                        <li><i class="tkIcon tkIcon-star"></i><span>For experienced strategists</span></li>
                        <li><i class="tkIcon tkIcon-star"></i><span>Very strong troops</span></li>
                        <li><i class="tkIcon tkIcon-star"></i><span>Long and expensive training</span></li>
                    </ul>

                </div>
                <div class="selectionContainer dialogueContent tribeAction">
                    <button class="selectButton" data-track-content data-content-name="TribeSelection" data-content-piece="SelectTribe"><span>Select tribe</span></button>
                    <div class="options">
                        <div class="serverOption">
                            <span>Server:</span>
                            <a class="serverName"></a>
                        </div>
                        <div class="loginLink" data-track-content data-content-name="TribeSelection" data-content-piece="Login">
                            <span>Already have an account?</span>
                            <a data-mellon-iframe-url="/authentication/login" id="loginButton" data-selector="#mellonModal" class="gameLink jqFenster">
                                Log in</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="registerNowContainer tkDialogue">
                <div class="trapezoidalOrnament onTop"></div>
                <div class="selectionContainer dialogueContent iframeContainer">
                </div>
                <div class="selectionContainer dialogueContent bottomContainer"></div>
            </div>
            <div class="serverSelectionOverlay" data-track-content data-content-name="TribeSelection" data-content-piece="ServerSelection">
                <div class="serverSelectionContainer">
                    <div class="serverSelection">
                        <div class="serverSelectionDialogue tkDialogue">
                            <div class="trapezoidalOrnament onTop"></div>
                            <div class="dialogueContent">
                                <div class="tkIcon dialogueClose"></div>
                                <div class="dialogueHeader">Game world menu</div>
                                <div class="serverBoxContainer">
                                    <div class="serverCategory recommended">
                                        <div class="categoryName">Recommended</div>
                                        <div class="serverBox">
                                            <div class="hoverArea"></div>
                                            <i class="tkIcon tkIcon-tkLogo"></i>
                                            <span class="serverName"></span>
                                            <div class="serverPopulationContainer">
                                                <i class="tkIcon tkIcon-serverPopulation"></i>
                                                <span class="serverPopulation"> </span>
                                            </div>
                                            <div class="serverUptimeContainer">
                                                <i class="tkIcon tkIcon-serverUptime"></i>
                                                <span class="serverUptime">
                                                    <span class="serverUptimeDays"></span>
                                                    <span>Days</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="serverCategory other">
                                        <div class="categoryName">Other game servers</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="overlay imprint gameRules">
            <div class="tkDialogue iFrameDialogue">
                <div class="trapezoidalOrnament onTop"></div>
                <div class="dialogueContent">
                    <div class="tkIcon dialogueClose"></div>
                    <div class="dialogueHeader gameRulesHeader">Game rules</div>
                    <div class="dialogueHeader imprintHeader">Imprint</div>
                    <div class="iFrameContent">
                        <iframe class="gameRulesIFrame" src="http://www.kingdoms.com/rules.php?lang=com"></iframe>
                        <iframe class="imprintIFrame" src="http://www.kingdoms.com/imprint.php?lang=com"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
