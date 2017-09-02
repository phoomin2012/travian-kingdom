/**************************/
/*        Library         */
/**************************/
var async = require("async");
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

// operation
//  1 = REPLACE
//  2 = ADD
//  3 = REMOVE
//  4 = INNER UPDATE
//  5 = ADD OR REPLACE

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
Travian.user = {
    get: function (uid, cb) {
        var rr = [];
        async.parallel([
            (callback) => {
                query("SELECT * FROM `" + config.prefix + "user` WHERE `uid`=?;", [uid], (err_u, res_u) => {
                    rr = res_u[0];
                    callback();
                });
            }
        ], () => {
            typeof cb == "function" ? cb(rr) : false;
        });
        return rr;
    },
    serial: function (uid, cb) {
        async.parallel([
            (callback) => {
                query("SELECT * FROM `" + config.prefix + "user` WHERE `uid`=?;", [uid], (err_u, res_u) => {
                    callback(null, res_u[0]);
                    query("UPDATE `" + config.prefix + "user` SET `serial`=`serial`+1 WHERE `uid`=?;", [uid]);
                });
            }
        ], (err, res) => {
            typeof cb == "function" ? cb(res[0].serial) : false;
        });
    }
};
//
//["chatCache",{"cache":[{"name":"Collection:ChatInbox:","data":{"cache":[{"name":"ChatInbox:1.9327.2386","data":{"_id":"9327:1.9327.2386","roomId":"1.9327.2386","myPlayerId":"9327","group":"","linePlayerId":"2386","linePlayerName":"phoomin009","line":"tesst","timestamp":1503994474624,"lastTimestamp":1503994474624,"unread":1,"lastOwnRead":1503994417728,"lastOtherRead":1503994120634,"playersRead":{},"closed":false,"closedBy":0,"ignoreUntil":0}}],"operation":5}}]}]
//["chatCache",{"cache":[{"name":"Collection:ChatInbox:","data":{"cache":[{"name":"ChatInbox:1.9327.2386","data":{"_id":"9327:1.9327.2386","roomId":"1.9327.2386","myPlayerId":"9327","group":"","linePlayerId":"2386","linePlayerName":"phoomin009","line":"test","timestamp":1503994487090,"lastTimestamp":1503994487090,"unread":1,"lastOwnRead":1503994475506,"lastOtherRead":1503994475507,"playersRead":{},"closed":false,"closedBy":0,"ignoreUntil":0}}],"operation":5}}]}]
//
//["chatCache",{"cache":[{"name":"ChatInbox:1.9327.2386","data":{"_id":"9327:1.9327.2386","roomId":"1.9327.2386","myPlayerId":"9327","group":"","linePlayerId":"2386","linePlayerName":"phoomin009","line":"tesst","timestamp":1503994474624,"lastTimestamp":1503994474624,"unread":0,"lastOwnRead":1503994475506,"lastOtherRead":1503994475507,"playersRead":{},"closed":false,"closedBy":0,"ignoreUntil":0}}]}]
//["chatCache",{"cache":[{"name":"ChatInbox:1.9327.2386","data":{"_id":"9327:1.9327.2386","roomId":"1.9327.2386","myPlayerId":"9327","group":"","linePlayerId":"2386","linePlayerName":"phoomin009","line":"test","timestamp":1503994487090,"lastTimestamp":1503994487090,"unread":1,"lastOwnRead":1503994475506,"lastOtherRead":1503994487654,"playersRead":{},"closed":false,"closedBy":0,"ignoreUntil":0}}]}]
Travian.chat = {
    unread: 0,
    formRoom: function (data, uid, cb) {
        var form = {};
        Travian.user.get(data.from, (user) => {
            form = {
                name: "ChatInbox:" + data.roomId,
                data: {
                    _id: uid + ":" + data.roomId,
                    roomId: data.roomId,
                    group: "",
                    line: data.line,
                    linePlayerId: data.from,
                    linePlayerName: user.username,
                    myPlayerId: uid,
                    unread: Travian.chat.unread++,
                    closed: false,
                    closeBy: 0,
                    ignoreUntil: 0,
                    lastOtherRead: (new Date).getTime(),
                    lastOwnRead: 0,
                    lastTimestamp: (new Date).getTime(),
                    timestamp: (new Date).getTime(),
                    playersRead: {},
                }
            };
            typeof cb == "function" ? cb(form) : false;
        });
        return form;
    },
    formLine: function (data, cb) {
        var form = {};
        Travian.user.get(data.from, (user) => {
            form = {
                name: "ChatLine:" + data.time,
                data: {
                    _id: data.id + data.room + data.time,
                    id: data.id,
                    roomId: data.room,
                    isFirst: true,
                    playerId: data.from,
                    playerName: user.username,
                    text: data.text,
                    timestamp: data.time
                }
            };
            typeof cb == "function" ? cb(form) : false;
        });
        return form;
    },
    openRoom: function (type, from, to, line) {
        var timestamp = (new Date()).getTime();
        var roomId = `${type}.${from}.${to}`;
        query("INSERT INTO `" + config.prefix + "chat_room` (`roomId`,`type`,`from`,`to`,`time`,`line`) VALUES (?,?,?,?,?,?);", [roomId, type, from, to, timestamp,line], (err) => {
            console.log(err);
        });
    },
    getRoom: function (roomId, cb) {
        var room = [];
        async.parallel([
            (callback) => {
                query("SELECT * FROM `" + config.prefix + "chat_room` WHERE `roomId`=?;", [roomId], (err, r) => {
                    room = r[0];
                    callback();
                });
            }
        ], () => {
            cb(room);
        });
    },
    getLine: function (id, cb) {
        var rl = [];
        async.parallel([
            (callback) => {
                query("SELECT * FROM `" + config.prefix + "chat_line` WHERE `id`=?;", [id], (err, r) => {
                    rl = r[0];
                    callback();
                });
            }
        ], () => {
            cb(rl);
        });
    },
    addLine: function (room, from, text, cb) {
        var lineId = false;
        async.parallel([
            function (callback) {
                var timestamp = (new Date()).getTime();
                query("INSERT INTO `" + config.prefix + "chat_line` SET ?", {room: room, from: from, text: text, time: timestamp}, (err, res) => {
                    console.log(`Last add ${res.insertId}`);
                    lineId = res.insertId;
                    callback();
                });
            }
        ], () => {
            typeof cb == "function" ? cb(lineId) : false;
        });
        return lineId;
    },
    getAllLine: async function (room, from, socket, line) {
        query("SELECT * FROM `" + config.prefix + "chat_line` WHERE `room`=?;", [room], (err_r, res_l) => {
            var r = [];
            async.each(res_l, (item, callback) => {
                query("SELECT * FROM `" + config.prefix + "user` WHERE `uid`=?;", [item.from], (err_u, res_u) => {
                    Travian.chat.formLine(item, (form) => {
                        r.push(form);
                        callback();
                    });
                });
            }, (err) => {
                r = {
                    cache: [
                        {
                            name: 'Collection:ChatLine:' + room,
                            data: {
                                operation: 1,
                                cache: r,
                            }
                        }
                    ]
                };
                socket.emit('chatCache', r);
            });
        });
    },
    getInbox: function (from, socket) {
        query("SELECT * FROM `" + config.prefix + "chat_room` WHERE `from`=? OR `to`=?;", [from, from], (err_r, res_r) => {
            var r = [];
            async.each(res_r, (item, callback) => {
                query("SELECT * FROM `" + config.prefix + "user` WHERE `uid`=?;", [item.from], (err_u, res_u) => {
                    Travian.chat.formRoom(item, Travian.player.index[socket.id], (form) => {
                        r.push(form);
                        callback();
                    });

                });
            }, (err) => {
                r = {
                    cache: [
                        {
                            name: 'Collection:ChatInbox:',
                            data: {
                                operation: 1,
                                cache: r,
                            },
                        }
                    ]
                };
                socket.emit('chatCache', r);
            });
        });
    },
    sendNotifLine: function (uid, data) {
        if (typeof Travian.socket.clients[uid] != "undefined") {
            if (typeof Travian.socket.clients[uid].socket == "object") {
                if (typeof data != "object") {
                    Travian.chat.getLine(data, (Ldata) => {
                        Travian.chat.getRoom(Ldata.room, (Rdata) => {
                            Travian.chat.formRoom(Rdata, uid, (form) => {
                                Travian.socket.clients[uid].socket.emit('chatCache', {
                                    cache: [
                                        {
                                            name: 'Collection:ChatInbox:' + Ldata.room,
                                            data: {
                                                operation: 5,
                                                cache: [
                                                    form
                                                ],
                                            },
                                        }
                                    ]
                                });
                            })
                            Travian.chat.formLine(Ldata, (form) => {
                                Travian.socket.clients[uid].socket.emit('chatCache', {
                                    cache: [
                                        {
                                            name: 'Collection:ChatLine:' + Ldata.room,
                                            data: {
                                                operation: 5,
                                                cache: [
                                                    form
                                                ],
                                            }
                                        }
                                    ]
                                });
                            });
                        });
                    });
                } else {
                    var Ldata = data;
                    Travian.chat.formLine(Ldata, (form) => {
                        Travian.socket.clients[uid].socket.emit('chatCache', {
                            cache: [
                                {
                                    name: 'Collection:ChatLine:' + Ldata.room,
                                    data: {
                                        operation: 5,
                                        cache: [
                                            form
                                        ],
                                    }
                                }
                            ]
                        });
                    });
                }
            }
        }
    },
}

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
        logs(data);
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
    socket.on('chat', function (action, data) {
        if (action == 'sendPrivMessage') {
            query("SELECT * FROM `" + config.prefix + "chat_room` WHERE `from`=? OR `to`=?;", [data.uid, data.uid], (err_r, res_r) => {
                console.log(err_r, res_r)
                if (res_r.length == 0) {
                    Travian.chat.openRoom(1, Travian.player.index[socket.id], data.uid, data.text);
                    Travian.chat.addLine(`1.${Travian.player.index[socket.id]}.${data.uid}`, Travian.player.index[socket.id], data.text, (id) => {
                        Travian.chat.getInbox(Travian.player.index[socket.id], socket);
                        Travian.chat.getAllLine(data.roomId, Travian.player.index[socket.id], socket);
                    });
                } else {
                    Travian.chat.addLine(`1.${res_r[0]['from']}.${res_r[0]['to']}`, Travian.player.index[socket.id], data.text, (id) => {
                        Travian.chat.sendNotifLine(res_r[0]['from'], id);
                        Travian.chat.sendNotifLine(res_r[0]['to'], id);
                    });
                }
            });
        } else if (action == 'sendMessage') {
            if (typeof data.roomId == "object") {
                data.roomId.forEach((room) => {
                    console.log('Add line to ', room, '(m) ,message : ', data.text)
                    Travian.chat.addLine(room, Travian.player.index[socket.id], data.text, (id) => {
                        Travian.chat.getRoom(room, (roomData) => {
                            Travian.chat.sendNotifLine(roomData.from, id);
                            Travian.chat.sendNotifLine(roomData.to, id);
                        });
                    });
                });
            } else {
                console.log('Add line to ', data.roomId, '(1) ,message : ', data.text)
                Travian.chat.addLine(data.roomId, Travian.player.index[socket.id], data.text, (id) => {
                    Travian.chat.getRoom(data.roomId, (roomData) => {
                        console.log(roomData)
                        Travian.chat.sendNotifLine(roomData.from, id);
                        Travian.chat.sendNotifLine(roomData.to, id);
                    });
                });
            }
        }
    });
    socket.on('chatCache', function (data, callback_ac) {
        data.forEach(function (v, i) {
            var c_args = v.split(':');
            var controller = c_args[1];
            if (c_args[0] == "ChatUser") {
                query("SELECT * FROM `" + config.prefix + "user` WHERE `uid`=?;", [c_args[1]], function (err_ap, res_ap) {
                    socket.emit('chatCache', {
                        cache: [
                            {
                                name: 'ChatUser:' + c_args[1],
                                data: {
                                    playerId: res_ap[0].uid,
                                    name: res_ap[0].username,
                                    online: false,
                                    status: -1,
                                    kingStatus: "0",
                                    kingdomId: "0",
                                    kingdomRole: "0",
                                    lastClick: "2",
                                }
                            }
                        ]
                    });
                    callback_ac({
                        name: 'ChatUser:' + c_args[1],
                        data: {
                            playerId: res_ap[0].uid,
                            name: res_ap[0].username,
                            online: false,
                            status: -1,
                            kingStatus: "0",
                            kingdomId: "0",
                            kingdomRole: "0",
                            lastClick: "2",
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
                                    {
                                        name: "ChatLine:1488810372670",
                                        data: {
                                            _id: "58bd71841a4576411962ecfc",
                                            id: "210603",
                                            roomId: "1.101.102",
                                            isFirst: true,
                                            playerId: 101,
                                            playerName: "phoomin009",
                                            text: "Hello",
                                            timestamp: 1488810372670
                                        }
                                    }
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
                    Travian.chat.getInbox(Travian.player.index[socket.id], socket);
                } else if (controller == "ChatLine") {
                    Travian.chat.getAllLine(c_args[2], Travian.player.index[socket.id], socket);
                } else if (controller == "chatNotification") {

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
                var $return = {
                    id: [],
                    nameType: 'player',
                    name: {},
                    resultType: {},
                };
                async.each(data.query, (id, callback) => {
                    query("SELECT * FROM `" + config.prefix + "user` WHERE `uid`=?", [id], function (err_ap, res_ap) {
                        if (id == "-1") {
                            $return.name[id] = "Robber";
                        } else if (id == "0") {
                            $return.name[id] = "Nature";
                        } else if (id == "1") {
                            $return.name[id] = "Natars";
                        } else {
                            if (typeof res_ap[0] == "undefined") {
                                $return.name[id] = "Unknow";
                            } else {
                                $return.name[res_ap[0].uid] = res_ap[0].username;
                            }
                        }
                        callback();
                    });
                }, () => {
                    callback_ns($return);
                });
            } else if (data.nameType == "village") {
                var $return = {
                    id: [],
                    nameType: 'village',
                    name: {},
                    resultType: {},
                };
                async.each(data.query, (id, callback) => {
                    if (id == "536920065") {
                        $return.name[id] = "Robber hideout";
                        callback();
                    } else {
                        query("SELECT * FROM `" + config.prefix + "village` WHERE `wid`=?", [id], function (err_av, res_av) {
                            query("SELECT * FROM `" + config.prefix + "world` WHERE `id`=?", [id], function (err_w_av, res_w_av) {
                                if (res_w_av[0] == undefined) {
                                    $return.name[id] = "";
                                } else {
                                    if (res_av[0] == undefined) {
                                        $return.name[id] = "Field (" + res_w_av[0].x + "|" + res_w_av[0].y + ")";
                                    } else {
                                        if (res_w_av[0].fieldtype != "0") {
                                            $return.name[id] = res_av[0].vname;
                                        } else {
                                            if (res_w_av[0].oasistype != "0") {
                                                $return.name[id] = "Oasis (" + res_w_av[0].x + "|" + res_w_av[0].y + ")";
                                            } else {
                                                $return.name[id] = "Field (" + res_w_av[0].x + "|" + res_w_av[0].y + ")";
                                            }
                                        }

                                    }
                                }
                                callback();
                            });
                        });
                    }
                }, (err, res) => {
                    callback_ns($return);
                });
            } else if (data.nameType == "kingdom") {
                var $return = {
                    id: [],
                    nameType: 'kingdom',
                    name: {},
                    resultType: {},
                    kingObject: {},
                };
                async.each(data.query, (id, callback) => {
                    query("SELECT * FROM `" + config.prefix + "kingdom` WHERE `id`=?", [id], function (err_ap, res_ak) {
                        if (id == "0") {
                            $return.name[id] = "";
                            $return.kingObject[id] = {};
                        } else {
                            if (typeof res_ak[0] == "undefined") {
                                $return.name[id] = "Unknow";
                                $return.kingObject[id] = {};
                            } else {
                                $return.name[res_ak[0].id] = res_ak[0].tag;
                                $return.kingObject[res_ak[0].id] = {};
                            }
                        }
                        callback();
                    });
                }, () => {
                    callback_ns($return);
                });
            }
        }
    });
    socket.on('prestigeService', function (data, callback_ns) {
        if (data.type == "askForPrestige") {
            query("SELECT * FROM `" + config.prefix + "user` WHERE `uid`=?", [data.query[0]], function (err_ap, res_au) {
                query("SELECT * FROM `global_user` WHERE `email`=?", [res_au[0]['email']], function (err_ap, res_gu) {
                    $return = {
                        id: data.query[0],
                        outdated: false,
                        prestige: res_gu[0]['prestige'],
                    };
                    callback_ns([$return]);
                    socket.emit($return);
                });
            });
        }
    });
});