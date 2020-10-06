<?php
//Enter host, username, password, database
$con = mysqli_connect("0067team14db.mysql.database.azure.com", "smileAdmin@0067team14db", "BrushYourTeeth!", "SmileDatabase");
    if (mysqli_connect_errno()){
echo "Failed to connect to MySQL: " . mysqli_connect_error();
die();
}
?>