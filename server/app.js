var fs = require('fs');
var express = require('express');
var app = express();
process.env.PORT = 8081;
var server = app.listen(process.env.PORT, function () {
    console.log('Listen on ' + process.env.PORT + '!!')
});

var io = require('socket.io')(server,{path: '/chat'});

var middleware = require('socketio-wildcard')();
io.use(middleware);

var travian = require('./lib/travian/main').set(io, {
    type: 'mysql',
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'travian5_new'
});

var server = {};
var clients = {};

server['test'] = travian.create({
    id: 'test',
    prefix: 's1_',
    name: 'Server Test',
    language: 'th',
    speed: 100,
    troop_speed: 100,
    storage: 1,
    base_storage: 800,
    clients: clients,
});

io.on('connect', function (socket) {
    socket.on('subscribe', function (data, fn) {
        fn({});
        server['test'].playerJoin(data.playerId, socket);
    });
    socket.on('*', function (data) {
        console.log(data);
    });



});

/*var returns = {
 pingInterval: 25000,
 pingTimeout: 60000,
 sid: socket.id,
 upgrades: ['websocket']
 };
 returns = {
 event: [
 {
 name: "pong",
 data: 1
 }
 ],
 response: [],
 serial: clients[socket.id].serial++,
 ts: (new Date).getTime()
 };*/

/*socket.emit('chatCache', {
 cache: [
 {
 name: 'ChatUser:' + data.playerId,
 data: {
 playerId: data.playerId,
 name: 'phoomin2012',
 online: true,
 status: 1,
 lastClick: 2,
 allianceId: 0,
 allianceRights: 0,
 kingStatus: 0,
 kingdomId: 0,
 kingdomRole: 0,
 }
 }
 ]
 });
 socket.emit('chatCache', {
 cache: [
 {
 name: 'Collection:FriendRequest:',
 data: {
 cache: [],
 operation: 1,
 }
 }
 ]
 });
 socket.emit('chatCache', {
 cache: [
 {
 name: 'Collection:ChatUser:friends',
 data: {
 cache: [],
 operation: 1,
 }
 }
 ]
 
 });
 socket.emit('chatCache', {
 cache: [
 {
 name: 'Collection:Room:',
 data: {
 cache: [],
 operation: 1,
 }
 }
 ]
 
 });
 socket.emit('chatCache', {
 cache: [
 {
 name: 'Collection:ChatInbox:',
 data: {
 cache: [
 {
 name: "ChatInbox:5.6341.1464684840176",
 data: {
 _id: "-1:5.6341.1464684840176",
 roomId: "5.6341.1464684840176",
 group: "5.6341",
 timestamp: 1464684839860,
 lastTimestamp: 1465175044329,
 line: "Hello, I`m from Germany and you?",
 linePlayerId: 1,
 linePlayerName: "phoomin2012",
 myPlayerId: -1,
 unread: 1,
 lastOtherRead: -1,
 lastOwnRead: -1,
 playersRead: {
 280: 1467448820341
 }
 
 }
 }
 ],
 operation: 1,
 }
 }
 ]
 
 });*/