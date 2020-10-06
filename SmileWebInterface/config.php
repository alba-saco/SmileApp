<?php

/* Define the database credentials for local deployment
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'smileUser');
define('DB_PASSWORD', '123smile');
define('DB_NAME', 'smiledatabase');
*/



/*Define the database credentials for azure cloud deployment*/
define('DB_SERVER', '0067team14db.mysql.database.azure.com');
define('DB_USERNAME', 'smileAdmin@0067team14db');
define('DB_PASSWORD', 'BrushYourTeeth!');
define('DB_NAME', 'SmileDatabase');



/* Attempt to connect to the database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($link === false){
    die("ERROR: Could not connect to database. " . mysqli_connect_error());
}

?>