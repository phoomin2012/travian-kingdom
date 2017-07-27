var v = require("./village");

p = {
    get: function (parent, uid) {
        var returns = {};
        parent.sql.query("SELECT * FROM `" + parent.setting.prefix + "user` WHERE `uid`=?;", [uid], function (err, result) {
            returns = {
                'name': 'Player:' + uid,
                'data': {
                    'playerId': uid,
                    'name': result[0]['username'],
                    'tribeId': result[0]['tribe'],
                    'kingdomId': '0',
                    'allianceId': '0',
                    'allianceTag': '',
                    'allianceRights': '0',
                    'kingdomRole': '0',
                    'kingstatus': '0',
                    'isKing': (result[0]['tribe'] != 0) ? true : false,
                    'active': "1",
                    'isActivated': '1',
                    'isInstant': '0',
                    'isBannedFromMessaging': false,
                    'isPunished': false,
                    'villages': v.getAll(parent,uid),
                    'population': '0',
                    'prestige': 0,
                    'level': 0,
                    'stars': {
                        'bronze': 0,
                        'silver': 0,
                        'gold': 0,
                    },
                    'nextLevelPrestige': 25,
                    'hasNoobProtection': false,
                    'filterInformation': false,
                    'uiLimitations': '0',
                    'gold': '590',
                    'silver': '0',
                    'deletionTime': '0',
                    'taxRate': '0',
                    'coronationDuration': 0,
                    'brewCelebration': '0',
                    'uiStatus': '-1',
                    'hintStatus': '1',
                    'spawnedOnMap': '1',
                    'signupTime': '1455623665',
                    'productionBonusTime': '0',
                    'cropProductionBonusTime': '0',
                    'premiumFeatureAutoExtendFlags': '0',
                    'plusAccountTime': '0',
                    'limitation': '0',
                    'limitationFlags': '0',
                    'limitedPremiumFeatureFlags': (result[0]['master'] == 0) ? 1 : ((result[0]['master'] == 1) ? 2 : ((result[0]['master'] == 2) ? 6 : 6)),
                    'lastPaymentTime': '0',
                    'bannedFromMessaging': '0',
                    'questVersion': '2',
                    'nextDailyQuestTime': 1456055762,
                    'dailyQuestsExchanged': '0',
                    'avatarIdentifier': '2467000',
                },
            }
        });
        return returns;
    }
}

module.exports = p;