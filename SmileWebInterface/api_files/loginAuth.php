<?php
   header('Access-Control-Allow-Origin: *');

//Import the database connection
require_once __DIR__ . "/db_connection.php";

// Check only the data once the form has been submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

        $json = file_get_contents('php://input');
        $obj = json_decode($json);
        $key  = $obj->key;
        $email = $obj->email;
        $password = $obj->password;

        // Prepare a SQL query to check the email/username
        $query = "SELECT * FROM users WHERE email='$email'";

        $queryResult = mysqli_query($link, $query);

        // Check if the provided email is in the databse
        if (mysqli_num_rows($queryResult) === 1){
            $data = mysqli_fetch_array($queryResult);

            //Check that the entered password is correct
            if (password_verify($password, $data["password"])) {
               echo json_encode(array(
               "success"=> true,
               "userData" => $data["user_id"],
               "firstName" => $data["first_name"],
               "lastName" => $data["last_name"],
               "email" => $data["email"],
               "start_date" => $data["start_date"],
             ));
            } else {
               echo json_encode(array("success" => false));
            }
        } else {
          echo json_encode(array("success" => false));
}}
// Close the connection
mysqli_close($link);

?>
