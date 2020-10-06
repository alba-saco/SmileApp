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


//Get the current profile information of the AppAdmin
$query = "SELECT * FROM smiledatabase.admin WHERE admin_id = '$userID'";
$queryResult = mysqli_query($link, $query);

// Only continue if the query returned an appAdmin
if (mysqli_num_rows($queryResult) == 1){
     // get the retuned row in an array and apply the values to variables
    $data = mysqli_fetch_array($queryResult);
    $fname = $data['first_name'];
    $lname = $data['last_name'];
    $email = $data['email'];
    $institution = $data['institution'];
    $department = $data['department'];


    //Define a changes saved variable to display after submiting
    $changesSaved = "";


    // define error variables
    $fnameErr = $lnameErr = $departmentErr = $emailErr = $institutionErr = "";


    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (empty($_POST['fname'])){
            $fnameErr = "*First name required";
        }
        else{
            $fname = $_POST["fname"];
        }
        if (empty($_POST['lname'])){
            $lnameErr = "*Last name required";
        }
        else{
            $lname = $_POST["lname"];
        }
        if (empty($_POST['email'])){
            $emailErr = "*E-Mail required";
        }
        //If user changed the email Check if email already exists
        elseif ($email != $_POST['email']){
            $email2 = $_POST['email'];
            $email_query = "SELECT smiledatabase.email FROM admins WHERE email= '$email2'";
            $result = mysqli_query($link, $email_query);
            if (mysqli_num_rows($result) == 1){
                $emailErr = "The provided email already exists";
            }
            else{
                $email = $_POST["email"];
            }
        }
        if (empty($_POST['institution'])){
            $institutionErr = "*Last name required";
        }
        else{
            $institution = $_POST["institution"];
        }
        if (empty($_POST['department'])){
            $departmentErr = "*Last name required";
        }
        else{
            $department = $_POST["department"];
        }

 

        // Update the data 
        if (empty($fnameErr) && empty($lnameErr) && empty($institutionErr) && empty($emailErr) && empty($departmentErr)){
        $query = "UPDATE smiledatabase.admin SET first_name = '$fname', last_name = '$lname', email = '$email', institution = '$institution', department = '$department' WHERE admin_id = '$userID'";

        if(mysqli_query($link, $query)){
            // Let the client know that the changes have been successfully saved
            $changesSaved = "Your changes have been saved!";
        }
        else{
            echo "*An error ocurred, please try again later.";
        }
    }
    }
}
else {
    echo "An error occurred. Please try again later";
}



?>

<!DOCTYPE html>
<html>
<head>
<title>Smile Edit Profile</title>
<meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smile Edit Profile</title>
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
.center p {
  margin: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
}
.center h1 {
  margin: 0;
  position: absolute;
  top: 13%;
  left: 50%;
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
}

</style>
</head>
<body>
<?php include_once "pageTop.php"; ?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">


<div class = "container" style = "margin-top:30px">
    <div class="row justify-content-center">
            <div class="col-sm-5" style="margin-top:250px; text-align: center;">
              <h1 style="color:#d6efff">Manage Account</h1>
              <svg class="bi bi-caret-down" width="3.5em" height="3.5em" viewBox="0 0 16 16" fill="currentColor" style="color:#6ac5fe;"  xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M3.204 5L8 10.481 12.796 5H3.204zm-.753.659l4.796 5.48a1 1 0 001.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 00-.753 1.659z" clip-rule="evenodd"/>
              </svg>
              <h1 style="color:#6ac5fe">Edit Your <kbd style="background-color: #6ac5fe">Smile</kbd>&nbsp;Profile</h1>
            </div>
        <div class="col-sm-7" style="margin-top:30px">
            <div class = "jumbotron rounded-lg" style = " min-width:90%; padding-top:0rem; padding-right: 0rem; padding-left:0rem; padding-bottom:1rem; margin-bottom: 2rem; margin-top:30px; background-color:#FFFFFF; padding-bottom:10px;border: solid; border-color:#6ac5fe; border-width: 4px;">
                <div class = "jumbotron jumbotron-fluid" style="background-color:#6ac5fe; padding-top:10px; padding-bottom:5px; text-align: center" >
                    <h3 style = "color:white">Edit Profile</h3>
                </div>
                    <div style="margin-left:32px; margin-right:32px">
                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <br>
                                <input  class= "form-control" type="text" name="fname" id="firstName" value="<?php echo $fname; ?>"style="margin-bottom:8px">
                                <div class="invalid-feedback d-block"><?php echo $fnameErr;?></div>
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name</label>
                                <br>
                                <input class ="form-control" type="text" name="lname" id="lastName" value="<?php echo $lname; ?>"style="margin-bottom:8px">
                                <div class="invalid-feedback d-block"><?php echo $lnameErr;?></div>
                            </div>
                            <div class="form-group">
                                <label for="eMail">Email</label>
                                <br>
                                <input class="form-control" type="email" name="email" id="eMail" value="<?php echo $email; ?>"style="margin-bottom:8px">
                                <div class="invalid-feedback d-block"><?php echo $emailErr;?></div>
                            </div>
                            <div class="form-group">
                                <label for="name">Name of Institution</label>
                                <br>
                                <input class="form-control" type="text" name="institution" id="institution" value="<?php echo $institution; ?>" style="margin-bottom:8px">
                                <div class="invalid-feedback d-block"><?php echo $institutionErr;?></div>
                            </div>
                            <div class="form-group">
                                <label for="name">Name of Department</label>
                                <br>
                                <input class="form-control" type="text" name="department" id="department" value="<?php echo $department; ?>"style="margin-bottom:8px">
                                <div class="invalid-feedback d-block"><?php echo $departmentErr;?></div>
                            </div>

                            <div align="center">
                            <input class="btn btn-primary" type="submit" value="Submit">
                            </div>  
                    </div>
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
</form>
<?php include "pageFooter.php"; ?>
</body>
<?php
// Close the connection

?>
</html>