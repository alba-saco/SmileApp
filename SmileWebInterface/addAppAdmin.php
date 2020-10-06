<?php
// The file addAppAdmin.php is adapted from personal written code for the Module "Database and Information Management Systems (19/20)" with the course code COMP0022-PG taught at UCL

function safeStrInput($inputName, $placeholderValue){
  if(!isset($_POST[$inputName]) || empty($_POST[$inputName])){
      echo "placeholder='".$placeholderValue."'";
      }else{
          echo "value='".$_POST[$inputName]."'";}
}

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


//Define error variables
$error_message = $fnameErr = $lnameErr = $emailErr = $institutionErr = $departmentErr = $passwordErr = $password2Err = "";

//Define input variables
$firstname = $lastname = $email = $institution = $department = $password = $password2 = "";

//Other variables to define
$validSubmission = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['fname'])){
        $fnameErr = "*First name required";
    }
    else{
        $firstname = $_POST["fname"];
    }
    if (empty($_POST['lname'])){
        $lnameErr = "*Last name required";
    }
    else{
        $lastname = $_POST["lname"];
    }
    if (empty($_POST['email'])){
        $emailErr = "*E-Mail required";
    }
    //Check if email already exists
    else{
        $email = $_POST['email'];
        $email_query = "SELECT smiledatabase.email FROM admin WHERE email= '$email'";
        $result = mysqli_query($link, $email_query);
        if (mysqli_num_rows($result) != false){
            $emailErr = "*The provided email already exists";
        }
        else{
            $email = $_POST["email"];
        }
    }
    if (empty($_POST['institution'])){
        $institutionErr = "*Institution required";
    }
    else{
        $institution = $_POST["institution"];
    }
    if (empty($_POST['department'])){
        $departmentErr = "*Department required";
    }
    else{
        $department = $_POST["department"];
    }
    if (empty($_POST['password'])){
        $passwordErr = "*Password required";
    }
    else{
        $password = $_POST["retypePassword"];
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    }
    if (empty($_POST['retypePassword'])){
        $password2Err = "*Password Required";
    }
    else{
        $password2 = $_POST["retypePassword"];
        //Check if passwords match
        if ($password != $password2){
            $passwordErr = "*Password did not match";
        }
    }

        // Register the user in the database
        if (empty($fnameErr) && empty($lnameErr) && empty($departmentErr) && empty($emailErr) && empty($institutionErr) && empty($passwordErr) && empty($password2Err)){
            $query = "INSERT INTO smiledatabase.admin (first_name, last_name, institution, department, email, password) VALUES('$firstname', '$lastname', '$institution', '$department', '$email', '$passwordHash')";
    
            if(mysqli_query($link, $query)){
                $validSubmission = True;
                header("location: manageAppAdmin.php?addSuccess=True");
            }
            else{
                $validSubmission = False;
                $error_message = "An error occurred connecting to the database, such that the quiz was not uploaded. Please, try again later.";
            }
        }
    
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Integrating the Bootstrap CSS Library-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="SmileCustom.css" type="text/css">
    <title>Add App Admin</title>
  </head>
  <body>
    <?php include_once "pageTop.php"; ?>
    <div class = "container" style = "margin-top:30px">
    <?php
        if($validSubmission === True){
            echo '<div class="alert alert-success">
                        <small><strong>The App Admin has been successfully submitted to the database!</strong></small>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            $validSubmission = "";
        }
        elseif($validSubmission === False){
            echo '<div class="alert alert-danger">
                        <small><strong>'.$error_message.'</strong></small>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            $validSubmission = "";
        }else{
            echo '';
        }
        ?>
        <div class="row justify-content-center">
            <div class="col-sm-4" style="margin-top:440px">
                <h1 style="color:#6ac5fe">Register a<br><kbd style="background-color: #6ac5fe">Smile</kbd>&nbsp;App Admin<br>here.</h1>
            </div>
            <div class="col-sm-8" style="margin-top:30px">
                <div class = "jumbotron rounded-lg" style = "padding-top:0;padding-right:0;padding-left:0; margin-top:30px; padding-bottom:10px; background-color:white; border: solid; border-color:#6ac5fe; border-width: 4px;">
                    <div class = "jumbotron jumbotron-fluid" style="background-color:#6ac5fe; padding-top:10px; padding-bottom:5px; text-align: center" >
                    <h2 style = "color:white">Details of App Admin</h2>
                </div>
                <form id="contentForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" autocomplete="off">
                        <div style="margin-left: 30px; margin-right: 30px;">
                            <div class="form-group">
                                <label for="name">First Name</label>
                                <br>
                                <input class="form-control" type="text" name="fname" id="fame" maxlength="100" <?php safeStrInput("fname", "Enter First Name");?>>
                                <div class="invalid-feedback d-block"><?php echo $fnameErr;?></div>
                            </div>
                            <div class="form-group">
                                <label for="name">Last Name</label>
                                <br>
                                <input class="form-control" type="text" name="lname" id="lname" maxlength="100" <?php safeStrInput("lname", "Enter Last Name");?>>
                                <div class="invalid-feedback d-block"><?php echo $lnameErr;?></div>
                            </div>
                            <div class="form-group">
                                <label for="name">Username/Email Address</label>
                                <br>
                                <input class="form-control" type="email" name="email" id="email" maxlength="200" <?php safeStrInput("email", "Enter Email/Username");?>>
                                <div class="invalid-feedback d-block"><?php echo $emailErr;?></div>
                            </div>
                            <div class="form-group">
                                <label for="name">Name of Institution</label>
                                <br>
                                <input class="form-control" type="text" name="institution" id="institution" maxlength="200" <?php safeStrInput("institution", "Enter Institution Name");?>>
                                <div class="invalid-feedback d-block"><?php echo $institutionErr;?></div>
                            </div>
                            <div class="form-group">
                                <label for="name">Name of Department</label>
                                <br>
                                <input class="form-control" type="text" name="department" id="department" maxlength="200" <?php safeStrInput("department", "Enter Department Name");?>>
                                <div class="invalid-feedback d-block"><?php echo $departmentErr;?></div>
                            </div>
                            <div class="form-group">
                                <label for="name">Set Password</label>
                                <br>
                                <input class="form-control" type="password" name="password" id="password" maxlength="100" autocomplete="new-password" <?php safeStrInput("password", "Enter Password");?>>
                                <div class="invalid-feedback d-block"><?php echo $passwordErr;?></div>
                            </div>
                            <div class="form-group">
                                <label for="name">Retype Password</label>
                                <br>
                                <input class="form-control" type="password" name="retypePassword" id="retypePassword" maxlength="100" autocomplete="new-password" <?php safeStrInput("retypePassword", "Retype Password");?>>
                                <div class="invalid-feedback d-block"><?php echo $password2Err;?></div>
                            </div>
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
     <!-- Integrating Javascript library from Bootstrap (jQuery, Popper.js and Javascript sublibraries)-->
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <?php include "pageFooter.php"; ?>
  </body>
  <?php
     // Close the connection
     mysqli_close($link);
  ?>
</html>