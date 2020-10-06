<?php
// The file addAppAdmin.php is adapted from personal written code for the Module "Database and Information Management Systems (19/20)" with the course code COMP0022-PG taught at UCL

// Start the session
session_start();

// Ensure that a session is not already started
if (isset($_SESSION['userID'])){
    header("location: index.php");
}

//Import the database connection
include "config.php";

$username = "";
$usernameError = "";
$password = "";
$passwordError = "";

// Check only the data once the form has been submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // User forgot to enter the username
    if (empty($_POST["username"])){
        $usernameError = "Please enter a username";
    }

    // User forgot to enter password
    if (empty($_POST["password"])){
        $passwordError = "Please enter a password";
    }

    if (empty($usernameError) && empty($passwordError)){
        
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Prepare a SQL query to check the email/username
        $query = "SELECT admin_id, email, password FROM smiledatabase.admin WHERE email = '$username'";
        
        $queryResult = mysqli_query($link, $query);

        // Check if the provided email is in the databse
        if (mysqli_num_rows($queryResult) == 1){
            $data = mysqli_fetch_array($queryResult);
            
            //Check that the entered password is correct
            if (password_verify($password,$data["password"])){
                
                // start a new session and assign user id and user name to super global
                session_start ();
                $_SESSION['username'] = $username;
                $_SESSION['userID'] = $data['admin_id'];
                header("location: index.php");
            }
            else {
                $passwordError = "The password you entered did not match with the email details you provided";
            }

        }
        else {
            $usernameError = "The email you entered was not found";
        }

    } 
}
// Close the connection
mysqli_close($link);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Smile Login </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="SmileCustom.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
    <div class = "container vh-100">
        <div class = "row h-25 justify-content-center align-items-end">
            <div class="col-6">
                <h1 style="text-align: center;"> <small>Welcome to<br><kbd>Smile</kbd>'s<br>administration platform.</small></h1>
            </div>
        </div>
        <div class = "row h-25 justify-content-center align-items-center">    
            <div class="col-4 text-center">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
                    <input type = "text" class="form-control" name = "username" 
                        <?php 
                        if(!isset($_POST["username"]) || empty($_POST["username"])){
                            echo "placeholder = 'Username'"; 
                            } else{
                                echo "value = " . $_POST["username"];
                            }?>>
                    
                    <input type = "password" class = "form-control" name = "password" <?php 
                        if(!isset($_POST["password"]) || empty($_POST["password"])){
                            echo "placeholder = 'Password'"; 
                        } else{
                            echo "value = " . $_POST["password"];
                        }?>><br>
                    <input type = "submit" class="btn btn-primary" value = "Login">
                    <br><br>
                </form>
            </div>
        </div>
        <div class = "row h-25 justify-content-center align-items-baseline">    
            <div class="col-4">
                <?php
                    if (!empty($usernameError)){
                         echo '<div class="alert alert-danger">
                            <small><strong>Error! </strong>'.$usernameError.'</small>
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>';
                    }
                ?>
                <?php
                    if (!empty($passwordError)){
                         echo '<div class="alert alert-danger">
                            <small><strong>Error! </strong>'.$passwordError.'</small>
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>';
                    }
                ?>
            </div>   
        </div>
    </div>
</body>
</html>

