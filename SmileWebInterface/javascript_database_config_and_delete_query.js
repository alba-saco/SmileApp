let deleteEntry = function (table, username){
    console.log("Reached delete entry function")
var mysql = require('mysql');

var con = mysql.createConnection({
  host: "localhost",
  user: "smileUser",
  password: "123smile",
  database: "smileDatabase"
});

con.connect(function(err, table, username) {
  if (err) throw err;
  var query_string = "DELETE FROM " + table + " WHERE email='" + username +"'";
  con.query(query_string, function (err, result) {
    if (err) throw err;
    console.log(result);
  });
});

con.end();
};

module.exports = {
    deleteEntry
};