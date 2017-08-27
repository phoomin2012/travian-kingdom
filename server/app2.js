/**************************/
/*        Library         */
/**************************/

var mysql = require('mysql');
var express = require('express');
var app = express();
process.env.PORT = 8081;
var server = app.listen(process.env.PORT, function () {
    console.log('Listen on ' + process.env.PORT + '!!');
});
var io = require('socket.io')(server, {path: '/chat'});
var middleware = require('socketio-wildcard')();

io.use(middleware);
config = {
    prefix: 's1_',
    debug: true,
}

var sql = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'travian5_new'
});
setTimeout(function () {
    sql.ping();
    config.debug ? console.log('Ping mysql server...') : '';
}, 600);
/**************************/
/*         Engine         */
/**************************/

var Travian = {}
Travian.socket = {
    clients: {},
    send: function (uid, data) {
        if (typeof Travian.socket.clients[uid] != "undefined") {
            Travian.socket.clients[uid].socket.emit('message', data);
        }
    },
    sendAll: function (data) {
        for (var i in this.clients) {
            Travian.socket.send(i, data);
        }
    },
}

Travian.player = {
    index: {},
    join: function (uid, socket) {
        Travian.player.index[socket.id] = uid;
        query("UPDATE `" + config.prefix + "user` SET `online`=? WHERE `uid`=?", [1, Travian.player.index[socket.id]]);
        Travian.socket.clients[uid] = {
            socket: socket
        };
    },
    left: function (socket) {
        query("UPDATE `" + config.prefix + "user` SET `online`=? WHERE `uid`=?", [0, Travian.player.index[socket.id]]);
    }
};
Travian.world = {
    id2xy: function (a) {
        return 0 > a || null === a ? {x: 0, y: 0} : {x: a % 32768 - 16384, y: Math.floor(a / 32768) - 16384}
    },
    xy2id: function (a, c) {
        return a + 16384 + 32768 * (c + 16384)
    }
};

function query($sql, $params, $callback) {
    if (typeof $callback == "undefined") {
        if (typeof $params == "function") {
            $callback = $params;
            $params = [];
        } else {
            $callback = function () {};
        }
    }
    sql.query($sql, $params, $callback);
}
/**************************/
/*          Start         */
/**************************/

setInterval(function () {
    query("SELECT * FROM `" + config.prefix + "nodejs` WHERE `sent`<>1", [], function (err_n, res_n) {
        for (var c in res_n) {
            if (res_n[c].uid != "") {
                Travian.socket.send(res_n[c].uid, JSON.parse(res_n[c].data));
            } else {
                Travian.socket.sendAll(JSON.parse(res_n[c].data));
            }
            //query("UPDATE FROM `" + config.prefix + "nodejs` SET `sent`=1 WHERE `id`=?", [res_n[c].id]);
            query("DELETE FROM `" + config.prefix + "nodejs` WHERE `id`=?", [res_n[c].id]);
            config.debug ? console.log('Send node with delete data...') : '';
        }
    });
}, 250);

function logs(msg) {
    var argumentsArray = [].slice.apply(arguments);
    console.log("=============================================");
    argumentsArray.forEach(function (value) {
        console.log(value);
    });
}

io.on('connect', function (socket) {
    socket.on('subscribe', function (data, fn) {
        fn();
        Travian.player.join(data.playerId, socket);
    });
    socket.on('*', function (data) {
        logs(data.data[0], data.data[1], typeof data.data[2], data.data[2]);
    });

    socket.on('disconnect', function () {
        Travian.player.left(socket);
    });

    socket.on('missedPackets', function (data) {
        /*query("UPDATE `" + config.prefix + "user` SET `serial`=? WHERE `uid`=?", [data.to + 1, Travian.player.index[socket.id]], function () {
         socket.emit('message', {
         event: [
         {
         name: 'pong',
         data: 1
         }
         ],
         missedPackets: {
         from: data.from,
         to: data.to
         },
         response: [],
         serial: data.to + 1,
         ts: (new Date()).getTime()
         });
         });*/
    });

    socket.on('chatCache', function (data, callback_ac) {
        data.forEach(function (v, i) {
            var c_args = v.split(':');
            var controller = c_args[1];
            if (c_args[0] == "ChatUser") {
                query("SELECT * FROM `" + config.prefix + "user` WHERE `uid`=?", [c_args[1]], function (err_ap, res_ap) {
                    socket.emit('chatCache', {
                        cache: [
                            {
                                name: 'ChatUser:' + c_args[1],
                                data: {
                                    operation: 1,
                                    cache: [
                                        {
                                            playerId: res_ap[0].uid,
                                            name: res_ap[0].username,
                                            online: 0,
                                            status: -1,
                                            kingStatus: "0",
                                            kingdomId: "0",
                                            kingdomRole: "0"
                                        }
                                    ],
                                }
                            }
                        ]
                    });
                    callback_ac({
                        name: 'ChatUser:' + c_args[1],
                        data: {
                            operation: 1,
                            cache: [
                                {
                                    playerId: res_ap[0].uid,
                                    name: res_ap[0].username,
                                    online: 0,
                                    status: -1,
                                    kingStatus: "0",
                                    kingdomId: "0",
                                    kingdomRole: "0"
                                }
                            ],
                        }
                    });
                });
            } else if (c_args[0] == "ChatLine") {
                socket.emit('chatCache', {
                    cache: [
                        {
                            name: 'ChatLine:' + c_args[1],
                            data: {
                                operation: 1,
                                cache: [
                                    /*{
                                     name: "ChatLine:1488810372670",
                                     data: {
                                     _id: "58bd71841a4576411962ecfc",
                                     id: "210603",
                                     roomId: "1.101.104",
                                     isFirst: true,
                                     playerId: 101,
                                     playerName: "phoomin009",
                                     text: "Hello",
                                     timestamp: 1488810372670
                                     }
                                     }*/
                                ],
                            }
                        }
                    ]
                });
            } else if (c_args[0] == "Collection") {
                if (controller == "FriendRequest") {
                    socket.emit('chatCache', {
                        cache: [
                            {
                                name: 'Collection:FriendRequest:',
                                data: {
                                    operation: 1,
                                    cache: [],
                                }
                            }
                        ]
                    });
                } else if (controller == "ChatUser") {
                    socket.emit('chatCache', {
                        cache: [
                            {
                                name: 'Collection:ChatUser:' + c_args[2],
                                data: {
                                    operation: 1,
                                    cache: [],
                                }
                            }
                        ]
                    });
                } else if (controller == "ChatRoom") {
                    socket.emit('chatCache', {
                        cache: [
                            {
                                name: 'Collection:ChatRoom:',
                                data: {
                                    operation: 1,
                                    cache: [],
                                }
                            }
                        ]
                    });
                } else if (controller == "ChatInbox") {
                    socket.emit('chatCache', {
                        cache: [
                            {
                                name: 'Collection:ChatInbox:',
                                data: {
                                    operation: 1,
                                    cache: [
                                        /*{
                                         name: "ChatInbox:1.101.104",
                                         data: {
                                         _id: controller + ":1.101.104",
                                         roomId: "1.101.104",
                                         group: "",
                                         line: "ถ้ายังไงก็ติดต่อผมได้นะครับ เล่นไอดีนี้จนจบเซิฟแน่นอน",
                                         linePlayerId: "101",
                                         linePlayerName: "phoomin009",
                                         myPlayerId: "101",
                                         unread: 0,
                                         closed: true,
                                         closeBy: 0,
                                         ignoreUntil: 0,
                                         lastOtherRead: 1488297885932,
                                         lastOwnRead: 1488298916122,
                                         lastTimestamp: 1488298915535,
                                         timestamp: 1488298915535,
                                         playersRead: {},
                                         }
                                         },*/
                                    ],
                                }
                            }
                        ]
                    });
                } else if (controller == "ChatLine") {
                    socket.emit('chatCache', {
                        cache: [
                            {
                                name: 'Collection:ChatLine:' + c_args[2],
                                data: {
                                    operation: 1,
                                    cache: [
                                        /*{
                                         name: "ChatLine:1488810372670",
                                         data: {
                                         _id: "58bd71841a4576411962ecfc",
                                         id: "210603",
                                         roomId: "1.101.104",
                                         isFirst: true,
                                         playerId: 101,
                                         playerName: "phoomin009",
                                         text: "Hello",
                                         timestamp: 1488810372670
                                         }
                                         }*/
                                    ],
                                }
                            }
                        ]
                    });
                }
            }
        });
    });

    socket.on('autocomplete', function (data, callback_ac) {
        if (data.type[0] == "player") {
            query("SELECT * FROM `" + config.prefix + "user`  WHERE LOCATE(?, `username`) > 0 ORDER BY LOCATE(?, `username`), `username` LIMIT 10", [data.string, data.string], function (err_ac, res_ac) {
                $rac = [];
                for (var $iac in res_ac) {
                    $rac.push({
                        playerId: res_ac[$iac].uid,
                        name: res_ac[$iac].username,
                        searchType: 'player',
                        online: 0,
                        allianceId: 0,
                        allianceRights: 0,
                        kingdomId: 0,
                        kingdomRole: 0,
                        kingStatus: 0,
                        status: -1
                    });
                }
                callback_ac($rac);
            });
        } else if (data.type[0] == "village") {
            query("SELECT * FROM `" + config.prefix + "kingdom`  WHERE LOCATE(?, `tag`) > 0 ORDER BY LOCATE(?, `tag`), `tag` LIMIT 10", [data.string, data.string], function (err_ac, kingdom_ac) {
                $rac = [];
                for (var $iac in kingdom_ac) {
                    $rac.push({
                        groupId: kingdom_ac[$iac].id,
                        tag: kingdom_ac[$iac].tag,
                        name: kingdom_ac[$iac].tag,
                        searchType: 'kingdom',
                    });
                }
                callback_ac($rac);
            });
        } else if (data.type[0] == "kingdom") {
            query("SELECT * FROM `" + config.prefix + "village`  WHERE LOCATE(?, `vname`) > 0 ORDER BY LOCATE(?, `vname`), `vname` LIMIT 10", [data.string, data.string], function (err_ac, res_ac) {
                $rac = [];
                for (var $iac in res_ac) {
                    $rac.push({
                        belongsToKing: 0,
                        villageId: res_ac[$iac].wid,
                        name: res_ac[$iac].vname,
                        searchType: 'village',
                        playerId: res_ac[$iac].owner,
                        x: Travian.world.id2xy(res_ac[$iac].wid).x,
                        y: Travian.world.id2xy(res_ac[$iac].wid).y,
                    });
                }
                callback_ac($rac);
            });
        }
    });
    socket.on('nameService', function (data, callback_ns) {
        if (data.type == "askForName") {
            if (data.nameType == "player") {
                query("SELECT * FROM `" + config.prefix + "user` WHERE `uid`=?", [data.query[0]], function (err_ap, res_ap) {
                    $return = {
                        id: [],
                        nameType: 'player',
                        name: {},
                        resultType: {},
                    };
                    if (data.query[0] == "-1") {
                        $return.name[data.query[0]] = "Robber";
                    } else if (data.query[0] == "0") {
                        $return.name[data.query[0]] = "Nature";
                    } else if (data.query[0] == "1") {
                        $return.name[data.query[0]] = "Natars";
                    } else {
                        if (typeof res_ap[0] == "undefined") {
                            $return.name[data.query[0]] = "Unknow";
                        } else {
                            $return.name[res_ap[0].uid] = res_ap[0].username;
                        }
                    }
                    callback_ns($return);
                });
            } else if (data.nameType == "village") {
                if (data.query[0] == "536920065") {
                    $return = {
                        id: [],
                        nameType: 'village',
                        name: {"536920065": "Robber hideout"},
                        resultType: {},
                    };
                    $return.name[data.query[0]] = "";
                    callback_ns($return);
                } else {
                    query("SELECT * FROM `" + config.prefix + "village` WHERE `wid`=?", [data.query[0]], function (err_av, res_av) {
                        query("SELECT * FROM `" + config.prefix + "world` WHERE `id`=?", [data.query[0]], function (err_w_av, res_w_av) {
                            if (res_w_av[0] == undefined) {
                                $return = {
                                    id: [],
                                    nameType: 'village',
                                    name: {},
                                    resultType: {},
                                };
                                $return.name[data.query[0]] = "";
                                callback_ns($return);
                            } else {
                                if (res_av[0] == undefined) {
                                    $return = {
                                        id: [],
                                        nameType: 'village',
                                        name: {},
                                        resultType: {},
                                    };
                                    $return.name[data.query[0]] = "Field (" + res_w_av[0].x + "|" + res_w_av[0].y + ")";
                                    callback_ns($return);
                                } else {
                                    $return = {
                                        id: [],
                                        nameType: 'village',
                                        name: {},
                                        resultType: {},
                                    };
                                    if (res_w_av[0].fieldtype != "0") {
                                        $return.name[data.query[0]] = res_av[0].vname;
                                    } else {
                                        if (res_w_av[0].oasistype != "0") {
                                            $return.name[data.query[0]] = "Oasis (" + res_w_av[0].x + "|" + res_w_av[0].y + ")";
                                        } else {
                                            $return.name[data.query[0]] = "Field (" + res_w_av[0].x + "|" + res_w_av[0].y + ")";
                                        }
                                    }
                                    callback_ns($return);
                                }
                            }
                        });
                    });
                }
            } else if (data.nameType == "kingdom") {
                query("SELECT * FROM `" + config.prefix + "kingdom` WHERE `id`=?", [data.query[0]], function (err_ap, res_ak) {
                    $return = {
                        id: [],
                        nameType: 'kingdom',
                        name: {},
                        resultType: {},
                        kingObject: {},
                    };
                    if (data.query[0] == "0") {
                        $return.name[data.query[0]] = "";
                        $return.kingObject[data.query[0]] = {};
                    } else {
                        if (typeof res_ak[0] == "undefined") {
                            $return.name[data.query[0]] = "Unknow";
                            $return.kingObject[data.query[0]] = {};
                        } else {
                            $return.name[res_ak[0].id] = res_ak[0].tag;
                            $return.kingObject[res_ak[0].id] = {};
                        }
                    }
                    callback_ns($return);
                });
            }
        }
    });
});