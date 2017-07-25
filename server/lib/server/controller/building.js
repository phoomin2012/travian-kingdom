var buildData = require("../data/builddata");

var b = {
    makeDetail: function (id, wid, location, type, level, option, status, setting) {
        if (typeof bD == "undefined" || bD === null) {
            bD = [];
            bD[level + 1] = {
                wood: 0,
                clay: 0,
                iron: 0,
                crop: 0,
                time: 0,
                effect: 0
            };
        }
        var cg_b_md = 1;
        switch (type) {
            case 0:
                cg_b_md = 0;
                break;
            case 10:
            case 11:
            case 15:
            case 17:
            case 18:
            case 23:
                cg_b_md = 1;
                break;
            case 16:
            case 19:
            case 22:
            case 33:
                cg_b_md = 2;
                break;
            case 1:
            case 2:
            case 3:
            case 4:
                cg_b_md = 3;
                break;
            case 15:
                cg_b_md = 4;
                break;
            default:
                cg_b_md = 1;
                break;
        }
        var r = {
            name: "Building:" + id,
            data: {
                buildingType: type,
                villageId: wid,
                locationId: location,
                lvl: level,
                lvlNext: level + 1,
                isMaxLvl: (bD.length - 1 <= level + 1) ? true : false,
                lvlMax: bD.length - 1,
                upgradeCosts: {},
                upgradeTime: 0,
                nextUpgradeCosts: {},
                nextUpgradeTimes: {},
                upgradeSupplyUsage: 0,
                upgradeSupplyUsageSums: [],
                category: cg_b_md,
                sortOrder: 15,
                effect: [],
            }
        }
        bD = buildData[type];
        if (typeof bD[level] != "undefined") {
            r.data.upgradeCosts = {
                1: bD[level].wood,
                2: bD[level].clay,
                3: bD[level].iron,
                4: bD[level].crop
            };
            r.data.upgradeTime = bD[level].time / setting.speed;
            r.data.upgradeSupplyUsage = bD[level].pop;
        }
        for (i = level; i <= (level + 7); i++) {
            if (typeof bD[i+1] != "undefined") {
                r.data.nextUpgradeCosts[i] = {
                    1: bD[i+1].wood,
                    2: bD[i+1].clay,
                    3: bD[i+1].iron,
                    4: bD[i+1].crop
                };
                console.log("Location : "+location,"Type : "+type,"Level : "+i,"Effect : "+bD[i+1].effect);
                r.data.nextUpgradeTimes[i-1] = bD[i+1].time / setting.speed;
                r.data.upgradeSupplyUsageSums[i - level] = bD[i+1].pop;
                r.data.effect[i - level] = bD[i].effect;
            }
        }

        return r;
    },
    getBuilding: function (parent, client, id, location) {
        var sql = "";
        var a = [];
        if (typeof location != "undefined") {
            a = [id, location];
            sql = "SELECT * FROM `" + parent.setting.prefix + "field` WHERE `wid`=? AND `location`=?;";
        } else {
            sql = "SELECT * FROM `" + parent.setting.prefix + "field` WHERE `id`=?;";
            a = [id];
        }
        parent.sql.query(sql, a, function (err, f) {
            f = f[0];
            var r = b.makeDetail(f.id, f.wid, f.location, f.type, f.level,undefined,undefined, parent.setting);
            parent.cacheSend(client, r);
        });


    },
    getBuildings: function (parent, client, vid) {
        parent.sql.query("SELECT * FROM `" + parent.setting.prefix + "field` WHERE `wid`=?;", [vid], function (err, bl) {
            var r = {
                name: 'Collection:Building:' + vid,
                data: {
                    operation: 1,
                    cache: [],
                },
            };
            for (var i in bl) {
                r.data.cache.push(b.makeDetail(bl[i].id, bl[i].wid, bl[i].location, bl[i].type, bl[i].level,undefined,undefined, parent.setting));
            }
            parent.cacheSend(client, r);
        });
    },
    makeQueue: function (data) {
        var r = {
            id: data.id,
            villageId: data.wid,
            locationId: data.location,
            buildingType: data.type,
            isRubble: 0,
            paid: data.paid,
            queueType: data.queue,
            timeStart: data.start,
            finished: data.timestamp,
            waiting: (data.queue == 4) ? true : false,
        }
        return r;
    },
    getQueue: function (parent, client, vid) {
        parent.sql.query("SELECT * FROM `" + parent.setting.prefix + "village` WHERE `wid`=?;", [vid], function (err, v) {
            parent.sql.query("SELECT * FROM `" + parent.setting.prefix + "user` WHERE `uid`=?", [v[0]['owner']], function (err, p) {
                parent.sql.query("SELECT * FROM `" + parent.setting.prefix + "building` WHERE `wid`=? AND `queue`=? ORDER BY `id` ASC", [vid, 1], function (err, b1) {
                    parent.sql.query("SELECT * FROM `" + parent.setting.prefix + "building` WHERE `wid`=? AND `queue`=? ORDER BY `id` ASC", [vid, 2], function (err, b2) {
                        parent.sql.query("SELECT * FROM `" + parent.setting.prefix + "building` WHERE `wid`=? AND `queue`=? ORDER BY `id` ASC", [vid, 4], function (err, b4) {
                            parent.sql.query("SELECT * FROM `" + parent.setting.prefix + "building` WHERE `wid`=? AND `queue`=? ORDER BY `id` ASC", [vid, 5], function (err, b5) {
                                p = p[0];
                                var r = {
                                    name: 'BuildingQueue:' + vid,
                                    data: {
                                        villageId: vid,
                                        tribeId: 0,
                                        freeSlots: {
                                            1: 1,
                                            2: 1,
                                            4: 1,
                                        },
                                        queues: {
                                            1: [],
                                            2: [],
                                            4: [],
                                            5: []
                                        },
                                        canUseInstantConstruction: false,
                                        canUseInstantConstructionOnlyInVillage: false
                                    }
                                }
                                r.data.tribeId = p['tribe'];
                                r.data.freeSlots[1] = 1 - b1.length;
                                r.data.freeSlots[2] = 1 - b2.length;
                                r.data.freeSlots[4] = 1 - b4.length + p.master;
                                var b1n = [], b2n = [], b4n = [], b5n = [];
                                for (var i in b1) {
                                    b1n[i] = b.makeQueue(b1[i]);
                                }
                                for (var i in b2) {
                                    b2n[i] = b.makeQueue(b2[i]);
                                }
                                for (var i in b4) {
                                    b4n[i] = b.makeQueue(b4[i]);
                                }
                                for (var i in b5) {
                                    b5n[i] = b.makeQueue(b5[i]);
                                }
                                r.data.queues[1] = b1n;
                                r.data.queues[2] = b2n;
                                r.data.queues[4] = b4n;
                                r.data.queues[5] = b5n;
                                parent.cacheSend(client, r);
                            });
                        });
                    });
                });
            });
        });
    }
}

module.exports = b;