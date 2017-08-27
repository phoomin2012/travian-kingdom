/**************************/
/*        Library         */
/**************************/

var mysql = require('mysql');
var express = require('express');
var app = express();
process.env.PORT = 8082;
var server = app.listen(process.env.PORT, function () {
    console.log('Listen on ' + process.env.PORT + '!!');
});
var io = require('socket.io')(server, {path: '/chat'});
var middleware = require('socketio-wildcard')();

io.use(middleware);
config = {
    prefix: 'global_',
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
        //query("UPDATE `" + config.prefix + "user` SET `online`=? WHERE `uid`=?", [1, Travian.player.index[socket.id]]);
        Travian.socket.clients[uid] = {
            socket: socket
        };
    },
    left: function (socket) {
        //query("UPDATE `" + config.prefix + "user` SET `online`=? WHERE `uid`=?", [0, Travian.player.index[socket.id]]);
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

/*setInterval(function () {
    query("SELECT * FROM `" + config.prefix + "nodejs`", [], function (err_n, res_n) {
        for (var c in res_n) {
            if (res_n[c].uid != "") {
                Travian.socket.send(res_n[c].uid, JSON.parse(res_n[c].data));
            } else {
                Travian.socket.sendAll(JSON.parse(res_n[c].data));
            }
            query("DELETE FROM `" + config.prefix + "nodejs` WHERE `id`=?", [res_n[c].id]);
            config.debug ? console.log('Send node...') : '';
        }
    });
}, 250);*/

function logs(msg) {
    var argumentsArray = [].slice.apply(arguments);
    console.log("=============================================");
    argumentsArray.forEach(function (value) {
        console.log(value);
    });
}

io.on('connect', function (socket) {
    socket.on('subscribe', function (data, fn) {
        fn("ok");
        Travian.player.join(data.playerId, socket);
    });
    socket.on('*', function (data) {
        logs(data.data[0], data.data[1], typeof data.data[2], data.data[2]);
    });

    socket.on('disconnect', function () {
        Travian.player.left(socket);
    });
});