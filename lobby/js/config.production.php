<?php 
include_once dirname(__FILE__).'/../../index/engine/config.php';
header("Content-Type: text/javascript");
?>
GameLobby.config = {
    backendUrl: 'api/index.php',
    pathPrefix: '',
    redirectAfterLogout: '<?php echo $index_url;?>#action=logout',
    hardRedirect: true,
    node: {
        host: '<?php echo $domain;?>',
        port: 8888,
        resource: 'chat'
    },
    avatar: {
        maxSitters: 2,
        maxDuals: 2
    },
    links: {
        urlForum: 'http://forum.kingdoms.travian.com/',
        urlWiki: 'http://wiki.kingdoms.travian.com/tiki-switch_lang.php?language=',
        urlHelpCenter: 'http://help.kingdoms.travian.com/',
        urlPrivacy: 'http://agb.traviangames.com/privacy-XX.pdf',
        urlTerms: 'http://agb.traviangames.com/terms-XX.pdf',
        gameRules: 'http://kingdoms.travian.com/#to-rules'
    },
    mellon: {
        url: '<?php echo $mellon_url;?>',
        application: {
            id: 'travian-ks',
            countryId: 'en',
            instanceId: 'lobby',
            languageId: 'en_US'
        },
        mellon: {
            cookie: {
                domain: '.<?php echo $domain;?>'
            }
        }
    },
    languages: {
        'ae': 'ar_AE',
        'en': 'en_US',
        'ru': 'ru_RU',
        'cs': 'cs_CZ',
        'cz': 'cs_CZ',
        'da': 'da_DK',
        'dk': 'da_DK',
        'de': 'de_DE',
        'cl': 'es_CL',
        'es': 'es_ES',
        'et': 'et_EE',
        'ee': 'et_EE',
        'fr': 'fr_FR',
        'gb': 'en_GB',
        'hu': 'hu_HU',
        'id': 'id_ID',
        'it': 'it_IT',
        'lt': 'lt_LT',
        'lv': 'lv_LV',
        'nl': 'nl_NL',
        'pl': 'pl_PL',
        'br': 'pt_BR',
        'pt': 'pt_PT',
        'ro': 'ro_RO',
        'sk': 'sk_SK',
        'si': 'sl_SI',
        'sl': 'sl_SI',
        'tr': 'tr_TR',
        'uk': 'uk_UA',
        'us': 'en_US',
        'ua': 'uk_UA',
        'th': 'th_TH'
    }
};
