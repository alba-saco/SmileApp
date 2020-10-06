<?php
// The file addAppAdmin.php is adapted from personal written code for the Module "Database and Information Management Systems (19/20)" with the course code COMP0022-PG taught at UCL

// Start the session
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['userID'])){
    header("location: login.php");
}

// Get the databse connection
include "config.php";

//Identify the user
$userID = $_SESSION['userID'];


//setup input and error variables
$password = $password2 = $passwordError = $password2Error = "";

//Define a changes saved variable to display after submiting
$changesSaved = "";

//Only change the password when the form is submited
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (empty($_POST['password'])){
        $passwordError = "*Password required";
    }
    else{
        $password = $_POST["password"];
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    }
    if (empty($_POST['password2'])){
        $password2Error = "*Password Required";
    }
    else{
        $password2 = $_POST["password2"];
        //Check if passwords match
        if (empty($passwordError) && $password != $password2){
            $password2Error = "*Password did not match!";
        }
    }

    // If the passwords were entered correctly then change values
    if (empty($passwordError) && empty($password2Error)){
        $query = "UPDATE smiledatabase.admin SET password = '$passwordHash' WHERE admin_id = '$userID'";
        
        // Run the query
        if(mysqli_query($link, $query)){
            // Let the client know that the changes have been successfully saved
            $changesSaved = "Your changes have been saved!";
        }
        else{
            echo "An error ocurred, please try again later.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title> Smile Change Password </title>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>uBid Registration</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="SmileCustom.css" type="text/css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    
    <style>
    @import "topPageStyles.css";
    .flex-container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    </style>
</head>
<body>
    <?php include_once "pageTop.php"; ?>
    <div class = "container" style = "margin-top:30px">
        <div class="row justify-content-center">
            <div class="col-sm-4" style="margin-top:160px; text-align: center;">
              <h1 style="color:#d6efff">Manage Account</h1>
              <svg class="bi bi-caret-down" width="3.5em" height="3.5em" viewBox="0 0 16 16" fill="currentColor" style="color:#6ac5fe;"  xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M3.204 5L8 10.481 12.796 5H3.204zm-.753.659l4.796 5.48a1 1 0 001.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 00-.753 1.659z" clip-rule="evenodd"/>
              </svg>
              <h1 style="color:#6ac5fe">Change Your <kbd style="background-color: #6ac5fe">Smile</kbd>&nbsp;Password</h1>
            </div>
            <div class="col-sm-7" style="margin-top:80px; margin-bottom:80px;">
                <div class = "jumbotron rounded-lg" style = " min-width:90%; padding-top:0rem; padding-right: 0rem; padding-left:0rem; padding-bottom:1rem; margin-bottom: 2rem; margin-top:30px; background-color:#FFFFFF; padding-bottom:10px;border: solid; border-color:#6ac5fe; border-width: 4px;">
                <div class = "jumbotron jumbotron-fluid" style="background-color:#6ac5fe; padding-top:10px; padding-bottom:5px; text-align: center" >
                <h3 style = "color:white">Change Password</h3>
                </div>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
                        <div style="margin-left:32px; margin-right:32px">
                            <div class="form-group">
                                <label for="newPassword">New Password</label>
                                <br>
                                <input class= "form-control" type = "password" name = "password" id="newPassword"
                                    <?php 
                                    if(!isset($_POST["password"]) || empty($_POST["password"])){
                                        echo "placeholder = 'Password'"; 
                                    } else{
                                        echo "value = " . $_POST["password"];
                                    }?> style="margin-bottom:8px">
                                <div class="invalid-feedback d-block"><?php echo $passwordError;?></div>
                            </div>
                            <div class="form-group">
                                <label for="retypeNewPassword">Re-type new Password</label>
                                <br>
                                <input  class="form-control" type = "password" name = "password2" id="retypeNewPassword" placeholder = "Confirm Password"
                                    <?php 
                                    if(!isset($_POST["password2"]) || empty($_POST["password2"])){
                                        echo "placeholder = 'Confirm Password'"; 
                                    } else{
                                        echo "value = " . $_POST["password2"];
                                    }?>  style="margin-bottom:8px">
                                <div class="invalid-feedback d-block"><?php echo $password2Error;?></div>
                            </div>
                                
                            <div align ="center">
                            <input class="btn btn-primary" type = "submit" value = "Submit">
                            </div>
                        </div>
                    </form>
                </div>
                <?php
                if (!empty($changesSaved)){
                    echo '<div class="alert alert-success">
                        <small><strong>'.$changesSaved.'</strong></small>
                         <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>';
                    }
                ?>
                
        </div>
    </div>
</div>
<!-- Include page footer -->
<?php include "pageFooter.php"; ?>
</body>
<?php
// Close the connection
?>
</html>