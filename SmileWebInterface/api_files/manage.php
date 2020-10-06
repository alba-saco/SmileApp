<?php
   header('Access-Control-Allow-Origin: *');

//Import the database connection
require_once __DIR__ . "/db_connection.php";

   $json = file_get_contents('php://input');
   $obj = json_decode($json);
   $key  = $obj->key;

   // Determine which mode is being requested
   switch($key) {

      // Add a new record to the users table
      case "signup":

    	  $firstName  = $obj->first_name;
        $lastName  = $obj->last_name;
        $email = $obj->email;
        $password = password_hash($obj->password, PASSWORD_DEFAULT);
        $startDate = $obj->start_date;

        $signup_sql = "INSERT INTO users (first_name, last_name, email, `password`, `start_date`) VALUES ('$firstName', '$lastName', '$email', '$password', '$startDate')";
        $signup_email_query = "SELECT * FROM users WHERE email='$email'";
        $signup_result = mysqli_query($link, $signup_email_query);

         // Check if the provided email is in the databse
        if (mysqli_num_rows($signup_result) === 0) {

          mysqli_query($link, $signup_sql);
          $user_info_query = "SELECT * FROM users WHERE email='$email'";
          $user_info_result = mysqli_query($link, $user_info_query);
          $data = mysqli_fetch_array($user_info_result);
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
            echo mysqli_error($link);

        };

      break;

      // Update name for an existing user
      case "updateName":

         $userID  = $obj->userID;
         $firstName  = $obj->first_name;
         $lastName  = $obj->last_name;
         $email = $obj->email;

         $update_sql = "UPDATE users SET first_name='$firstName', last_name='$lastName', email='$email' WHERE user_id='$userID'";
         $check_id_query = "SELECT user_id FROM users WHERE email='$email'";
         $check_result = mysqli_query($link, $check_id_query);

         // Check if the provided UserID is in the databse and email is unique
         if ($check_result) {
            $check_id = mysqli_fetch_array($check_result);
            if ($check_id['user_id'] === $userID || mysqli_num_rows($check_result) === 0){
                $data = array("email"=> $email);

                mysqli_query($link, $update_sql);
                echo json_encode(array(
                  "success"=> true,
                  "userData" => $data
                ));
            } else {
                echo json_encode(array("success" => false));
            };
         } else {
             echo json_encode(array("success" => false));
         };

       break;

      // Update email and password for an existing user
      case "updatePassword":

         $userID  = $obj->userID;
         $password = $obj->password;
         $new_password = password_hash($obj->new_password, PASSWORD_DEFAULT);

         $update_sql = "UPDATE users SET `password`='$new_password' WHERE user_id='$userID'";
         $update_password_query = "SELECT * FROM users WHERE user_id='$userID'";
         $update_password_result = mysqli_query($link, $update_password_query);

         // Check if the provided UserID is in the databse
         if (mysqli_num_rows($update_password_result) === 1) {
            $data = mysqli_fetch_array($update_password_result);

            //Check that the entered password is correct
            if (password_verify($password, $data["password"])) {

               mysqli_query($link, $update_sql);
               echo json_encode(array("success"=> true,
               "userData" => $data["user_id"]
             ));

            } else {
               echo json_encode(array("success" => false));
            };
         } else {
               echo json_encode(array("success" => false));
         };

      break;
   };
// Close the connection
mysqli_close($link);

?>
