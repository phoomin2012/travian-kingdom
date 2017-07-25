var fs = require('fs');
var db = require("../db/main");
var server = require("../server/server");

var Travian = function () {};

Travian.prototype.set = function(io,option){
    this.setting = option;
    this.io = io;
    this.db = new db(option.type,option);
    return this;
}

Travian.prototype.create = function(option){
    return new server(option,this.db,this.io);
}

module.exports = new Travian();