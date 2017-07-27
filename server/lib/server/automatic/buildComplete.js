var b = require('../controller/building');
var vc = require('../controller/village');
var buildData = require("../data/builddata");

var bc = function (parent) {
    function check() {
        var now = (new Date()).getTime() / 1000;
        parent.sql.query("SELECT * FROM `" + parent.setting.prefix + "building` WHERE `timestamp`<? AND `queue`<>?", [now, 4], function (err, result) {
            for (var i in result) {
                var building = result[i];
                if (building.queue == 1 || building.queue == 2) { //สิ่งก่อสร้างทั่วไป (1 = ในหมู่บ้าน,2 = ทุ่งทรัพยากร)
                    var bD = buildData[building.type][building.level];
                    parent.sql.query("UPDATE `" + parent.setting.prefix + "field` SET ? WHERE `wid`=? AND `location`=?;", [{level: building.level, type: building.type, rubble: 0}, building.wid, building.location]);
                    parent.sql.query("DELETE FROM `" + parent.setting.prefix + "building` WHERE `id`=?;", [building.id]);
                    parent.sql.query("UPDATE `" + parent.setting.prefix + "village` SET `pop`=`pop`+?,`cp`=`cp`+? WHERE `wid`=?;", [bD.pop, bD.cp, building.wid]);
                    parent.sql.query("SELECT * FROM `" + parent.setting.prefix + "village` WHERE `wid`=?;", [building.wid], function (err, v) {
                        parent.eventSend(v[0]['owner'], {
                            name: 'flashNotification',
                            data: 39,
                        });
                        if (building.type == 10) {
                            var $storage = parseInt(v[0].warehouse);
                            if (building.level == 1 && $storage == parent.setting.base_storage) {
                                $storage -= parseInt(parent.setting.base_storage);
                            }
                            if (building.level >= 1 && $storage != 0) {
                                $storage -= parseInt(buildData[building.type][building.level - 1].effect) * parent.setting.storage;
                            }
                            $storage += parseInt(bD.effect) * parent.setting.storage;
                            parent.sql.query("UPDATE `" + parent.setting.prefix + "village` SET ? WHERE `wid`=?;", [{warehouse: $storage}, building.wid]);
                        } else if (building.type == 11) {
                            var $storage = parseInt(v[0].granrey);
                            if (building.level == 1 && $storage == parent.setting.base_storage) {
                                $storage -= parseInt(parent.setting.base_storage);
                            }
                            if (building.level >= 1 && $storage != 0) {
                                $storage -= parseInt(buildData[building.type][building.level - 1].effect) * parent.setting.storage;
                            }
                            $storage += parseInt(bD.effect) * parent.setting.storage;
                            parent.sql.query("UPDATE `" + parent.setting.prefix + "village` SET ? WHERE `wid`=?;", [{granrey: $storage}, building.wid]);
                        }


                        b.getQueue(parent, v[0]['owner'], building.wid);
                        b.getBuilding(parent, v[0]['owner'], building.wid, building.location);
                        b.getBuildings(parent, v[0]['owner'], building.wid);
                        vc.get(parent, building.wid, v[0]['owner']);

                    });
                } else if (building.queue == 5) { //Rubble (ขยะ)
                    var bD = buildData[building.type][0];
                    parent.sql.query("UPDATE `" + parent.setting.prefix + "field` SET `level`=?,`type`=?,`rubble`=? WHERE `wid`=? AND `location`=?;", [0, 0, 0, building.wid, building.location]);
                    parent.sql.query("DELETE FROM `" + parent.setting.prefix + "building` WHERE `id`=?;", [building.id]);
                    parent.sql.query("SELECT * FROM `" + parent.setting.prefix + "village` WHERE `wid`=?;", [building.wid], function (err, v) {
                        parent.eventSend(v[0]['owner'], {
                            name: 'flashNotification',
                            data: 41,
                        });
                        b.getQueue(parent, v[0]['owner'], building.wid);
                        b.getBuilding(parent, v[0]['owner'], building.wid, building.location);
                        b.getBuildings(parent, v[0]['owner'], building.wid);
                        parent.sql.query("UPDATE `" + parent.setting.prefix + "village` SET `wood`=`wood`+?,`clay`=`clay`+?,`iron`=`iron`+?,`crop`=`crop`+? WHERE `wid`=?", [bD.wood, bD.clay, bD.iron, bD.crop, building.wid], function () {
                            vc.get(parent, building.wid, v.owner);
                        });
                    });
                }
                console.log('Process complete building construction...');
            }
        });

        /* Master Build */
        parent.sql.query("SELECT * FROM `" + parent.setting.prefix + "building` WHERE `queue`=? ORDER BY `id` DESC;", [4], function (err, result) {
            var vProcessed = [];
            for (var i in result) {
                var Q = result[i];
                if (vProcessed.indexOf(Q.wid)) {
                    Q.cost = JSON.parse(Q.cost);
                    parent.sql.query("SELECT * FROM `" + parent.setting.prefix + "village` WHERE `wid`=?", [Q.wid], function (err, v) {
                        v = v[0];
                        parent.sql.query("SELECT * FROM `" + parent.setting.prefix + "user` WHERE `uid`=?", [v.owner], function (err, u) {
                            u = u[0];
                            parent.sql.query("SELECT * FROM `" + parent.setting.prefix + "building` WHERE `wid`=? AND `queue`<>?", [Q.wid, 4], function (err, bList) {
                                parent.sql.query("SELECT * FROM `" + parent.setting.prefix + "building` WHERE `wid`=? AND `queue`=? ORDER BY `id` ASC", [Q.wid, 1], function (err, b1) {
                                    parent.sql.query("SELECT * FROM `" + parent.setting.prefix + "building` WHERE `wid`=? AND `queue`=? ORDER BY `id` ASC", [Q.wid, 2], function (err, b2) {
                                        numTask = {
                                            village: 0,
                                            resource: 0,
                                            all: 0,
                                        };
                                        for (ii in bList) {
                                            if (bList[ii].location < 19) {
                                                numTask.resource += 1;
                                                numTask.all += 1;
                                            } else {
                                                numTask.village += 1;
                                                numTask.all += 1;
                                            }
                                        }
                                        if (Q.paid == 0) {
                                            if ((u.tribe == 1 && ((numTask.resource == 0 && Q.location < 19) || (numTask.village == 0 && Q.location >= 19))) || numTask == 0) {
                                                if (v.wood >= Q.cost.wood && v.clay >= Q.cost.clay && v.iron >= Q.cost.iron && v.crop >= Q.cost.crop) {
                                                    console.log('Process master building and paid...');
                                                    parent.sql.query("UPDATE `" + parent.setting.prefix + "village` SET `wood`=`wood`-?,`clay`=`clay`-?,`iron`=`iron`-?,`crop`=`crop`-? WHERE `wid`=?", [Q.cost.wood, Q.cost.clay, Q.cost.iron, Q.cost.crop, Q.wid], function () {
                                                        vc.get(parent, Q.wid, v.owner);
                                                    });
                                                    parent.sql.query("UPDATE `" + parent.setting.prefix + "building` SET `queue`=?,`cost`=?,`paid`=?,`start`=?,`timestamp`=? WHERE `id`=?;", [(Q.location < 19) ? 2 : 1, "", 1, Math.round((new Date()).getTime() / 1000), Math.round((new Date()).getTime() / 1000) + Q.cost.time, Q.id]);
                                                    b.getQueue(parent, v.owner, Q.wid);
                                                    b.getBuilding(parent, v.owner, Q.wid, Q.location);
                                                    b.getBuildings(parent, v.owner, Q.wid);
                                                    parent.eventSend(v.owner, {
                                                        name: 'flashNotification',
                                                        data: 33,
                                                    });
                                                    vProcessed.push(Q.wid);
                                                }
                                            }
                                        } else {
                                            console.log('Process master building without paid...');
                                            if (Q.location < 19) {
                                                if (b2.length == 0) {
                                                    parent.sql.query("UPDATE `" + parent.setting.prefix + "building` SET `queue`=?,`cost`=?,`paid`=?,`start`=?,`timestamp`=? WHERE `id`=?;", [2, "", 1, Math.round((new Date()).getTime() / 1000), Math.round((new Date()).getTime() / 1000) + (buildData[Q.type][Q.level].time / parent.setting.speed), Q.id]);
                                                    b.getQueue(parent, v.owner, Q.wid);
                                                    b.getBuilding(parent, v.owner, Q.wid, Q.location);
                                                    b.getBuildings(parent, v.owner, Q.wid);
                                                    parent.eventSend(v.owner, {
                                                        name: 'flashNotification',
                                                        data: 33,
                                                    });
                                                    vProcessed.push(Q.wid);
                                                }
                                            } else {
                                                if (b1.length == 0) {
                                                    parent.sql.query("UPDATE `" + parent.setting.prefix + "building` SET `queue`=?,`cost`=?,`paid`=?,`start`=?,`timestamp`=? WHERE `id`=?;", [1, "", 1, Math.round((new Date()).getTime() / 1000), Math.round((new Date()).getTime() / 1000) + (buildData[Q.type][Q.level].time / parent.setting.speed), Q.id]);
                                                    b.getQueue(parent, v.owner, Q.wid);
                                                    b.getBuilding(parent, v.owner, Q.wid, Q.location);
                                                    b.getBuildings(parent, v.owner, Q.wid);
                                                    parent.eventSend(v.owner, {
                                                        name: 'flashNotification',
                                                        data: 33,
                                                    });
                                                    vProcessed.push(Q.wid);
                                                }
                                            }
                                        }
                                    });
                                });
                            });
                        });
                    });
                }
            }
        });
    }
    check();
};

module.exports = bc;