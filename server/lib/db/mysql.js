var sql = require('mysql');
var Mysql = function () {};

Mysql.prototype.init = function (option) {
    this.sql = sql.createConnection({
        host: option.host,
        user: option.user,
        password: option.password,
        database: option.database
    });
    return this.sql;
}

module.exports = new Mysql();