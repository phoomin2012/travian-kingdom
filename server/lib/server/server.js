var b = require("./controller/building");
var p = require("./controller/player");
var v = require("./controller/village");

var Server = function (setting, sql, io) {
    this.setting = setting;
    this.io = io;
    this.sql = sql;
    this.clients = {};

    this.setting.lastPong = (new Date()).getTime();
    this.setting.lastFreeSilver = (new Date()).getTime();

    this.automatic(this);
};

Server.prototype.playerJoin = function (uid, socket) {
    var parent = this;
    this.sql.query("SELECT * FROM `" + this.setting.prefix + "user` WHERE `uid`=?", [uid], function (err, result) {
        console.log("Player online : "+result[0].username);
        if (typeof result[0] != "undefined") {
            parent.clients[uid] = {
                socket: socket,
                serial: result[0].serial
            }
        }
    });
}

Server.prototype.cacheSend = function (uid, data) {
    var parent = this;
    this.sql.query("SELECT * FROM `" + this.setting.prefix + "user` WHERE `uid`=?", [uid], function (err, result) {
        if (typeof result[0] != "undefined" && typeof parent.clients[uid] != "undefined") {
            if (result[0].serial <= parent.clients[uid].serial) {
                result[0].serial = parent.clients[uid].serial + 2;
            }
            var r = {
                cache: [data],
                response: [],
                serial: result[0].serial,
                serialNo: result[0].serial + 1,
                ts: (new Date()).getTime()
            }
            parent.clients[uid].serial = result[0].serial;
            parent.sql.query("UPDATE `" + parent.setting.prefix + "user` SET `serial`=? WHERE `uid`=?", [result[0].serial + 2, uid]);
            parent.clients[uid].socket.emit('message', r);
        }
    });
}
Server.prototype.cacheSendAll = function (data) {
    for (var i in this.clients) {
        this.cacheSend(i, data);
    }
}
Server.prototype.eventSend = function (uid, data) {
    var parent = this;
    this.sql.query("SELECT * FROM `" + this.setting.prefix + "user` WHERE `uid`=?", [uid], function (err, result) {
        if (typeof result[0] != "undefined" && typeof parent.clients[uid] != "undefined") {
            if (result[0].serial <= parent.clients[uid].serial) {
                result[0].serial = parent.clients[uid].serial + 2;
            }
            var r = {
                event: [data],
                response: [],
                serial: result[0].serial,
                ts: (new Date()).getTime()
            }
            parent.clients[uid].serial = result[0].serial;
            parent.sql.query("UPDATE `" + parent.setting.prefix + "user` SET `serial`=? WHERE `uid`=?", [result[0].serial + 2, uid]);
            parent.clients[uid].socket.emit('message', r);
        }
    });
}
Server.prototype.eventSendAll = function (data) {
    for (var i in this.clients) {
        this.eventSend(i, data);
    }
}

Server.prototype.automatic = function (a) {
    setTimeout(function () {
        v.procVillage(a);
        require("./automatic/buildComplete")(a);
        
        if ((new Date()).getTime() > a.setting.lastFreeSilver + (3600 * 1000)) {
            this.sql.query("UPDATE `" + parent.setting.prefix + "user` SET `silver`=`silver`+100", []);
        }
        
        if ((new Date()).getTime() > a.setting.lastPong + (30 * 1000)) {
            a.eventSendAll({
                name: 'pong',
                data: 1,
            });
            a.setting.lastPong = (new Date()).getTime();
            console.log('Send Pong...');
        }


        a.automatic(a);
    }, 400);
}


module.exports = Server;