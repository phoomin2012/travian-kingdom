var sql = {};
sql.mysql = require('./mysql');


var Database = function (type, option) {
    if (typeof sql[type] == 'undefined') {
        console.log("You can't use " + type + ". Please setting again.");
        process.exit();
    } else {
        return sql[type].init(option);
    }
};

module.exports = Database;