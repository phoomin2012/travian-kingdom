

var v = {
    procVillage: function (parent) {
        parent.sql.query("SELECT * FROM `" + parent.setting.prefix + "village`;", [], function (err, vd) {
            for (var i in vd) {
                vd[i].wood = vd[i].wood + ((vd[i].pwood / 3600) * (Math.round((new Date()).getTime() / 1000) - vd[i].lastupdate));
                vd[i].clay = vd[i].clay + ((vd[i].pclay / 3600) * (Math.round((new Date()).getTime() / 1000) - vd[i].lastupdate));
                vd[i].iron = vd[i].iron + ((vd[i].piron / 3600) * (Math.round((new Date()).getTime() / 1000) - vd[i].lastupdate));
                vd[i].crop = vd[i].crop + ((vd[i].pcrop / 3600) * (Math.round((new Date()).getTime() / 1000) - vd[i].lastupdate));
                vd[i].lastupdate = Math.round((new Date()).getTime() / 1000);
                (vd[i].wood >= vd[i].warehouse) ? vd[i].wood = vd[i].warehouse : '';
                (vd[i].clay >= vd[i].warehouse) ? vd[i].clay = vd[i].warehouse : '';
                (vd[i].iron >= vd[i].warehouse) ? vd[i].iron = vd[i].warehouse : '';
                (vd[i].crop >= vd[i].granrey) ? vd[i].crop = vd[i].granrey : '';
                parent.sql.query("UPDATE `" + parent.setting.prefix + "village` SET ? WHERE `wid`=?;", [{wood: vd[i].wood, clay: vd[i].clay, iron: vd[i].iron, crop: vd[i].crop, lastupdate: vd[i].lastupdate}, vd[i].wid],function(err){
                });
            }
        });
    },
    getAll: function (parent, uid) {
        var r = [];
        parent.sql.query("SELECT * FROM `" + parent.setting.prefix + "village` WHERE `owner`=?;", [uid], function (err, vd) {
            for (var i in vd) {
                r.push(v.get(parent, vd[i]['wid']));
            }
        });
        return r;
    },
    get: function (parent, vid, socket) {
        var r = {};
        v.procVillage(parent);
        parent.sql.query("SELECT * FROM `" + parent.setting.prefix + "village` WHERE `wid`=?;", [vid], function (err1, vd) {
            parent.sql.query("SELECT * FROM `" + parent.setting.prefix + "user` WHERE `uid`=?;", [vd[0].owner], function (err2, p) {
                p = p[0];
                vd = vd[0];
                r = {
                    'name': 'Village:' + vid,
                    'data': {
                        'villageId': vid,
                        'playerId': vd.owner,
                        'name': vd.vname,
                        'tribeId': p.tribe,
                        'belongsToKing': '0',
                        'type': '1',
                        'population': vd.pop,
                        'coordinates': {
                            'x': '0',
                            'y': '0',
                        },
                        'isMainVillage': (vd.capitel == 1) ? true : false,
                        'isTown': false,
                        'treasuresUsable': '0',
                        'treasures': '0',
                        'supplyBuildings': vd.pop,
                        'supplyTroops': '0',
                        'production': {
                            1: vd.pwood,
                            2: vd.pclay,
                            3: vd.piron,
                            4: vd.pcrop,
                        },
                        'storage': {
                            1: vd.wood,
                            2: vd.clay,
                            3: vd.iron,
                            4: vd.crop,
                        },
                        'treasury': {
                            1: '0',
                            2: '0',
                            3: '0',
                            4: 0,
                        },
                        'storageCapacity': {
                            1: vd.warehouse,
                            2: vd.warehouse,
                            3: vd.warehouse,
                            4: vd.granrey,
                        },
                        'usedControlPoints': '0',
                        'availableControlPoints': '0',
                        'culturePoints': 31.225312500000001,
                        'celebrationType': '0',
                        'celebrationEnd': '0',
                        'culturePointProduction': '81',
                        'treasureResourceBonus': '0',
                        'acceptance': 100,
                        'acceptanceProduction': '0.01666',
                        'tributes': {
                            1: 0,
                            2: 0,
                            3: 0,
                            4: 0,
                        },
                        'tributesCapacity': '800',
                        'tributeTreasures': 0,
                        'tributeProduction': 0,
                        'tributeTime': '0',
                        'tributesRequiredToFetch': 0,
                    },
                };
                if (typeof socket != "undefined") {
                    parent.cacheSend(socket, r);
                }
            });
        });
    }
}

module.exports = v;