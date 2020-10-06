<?php
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


// Initiating necessary variables
$index_accountName="";


// Retriving the Account name to display it at on the index page
    $query_name = "SELECT first_name, last_name FROM smiledatabase.admin WHERE admin_id='$userID'";
    $query_name_result=mysqli_query($link, $query_name);

    if($query_name_result == TRUE){
        $name_array=mysqli_fetch_array($query_name_result);
        if(strlen($name_array['first_name']) > 18){
            $index_accountName="Admin";
        }else{
            $index_accountName=$name_array['first_name'];
        }
    }else{
        $index_accountName="Admin";
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
    <title>Home Page</title>
  </head>
  <body>
    <?php include_once "pageTop.php"; ?>
    <div class="container" style="margin-top:30px;">
      <?php
            echo '<div class="row justify-content-center">';
            echo '<p align="middle" style="font-size: 50px;">Hey '.$index_accountName.', what do you want to do?</p>';
            echo '</div>';
      ?>
      <div class="row justify-content-center" style="margin-top: 5%;">
        <div class="card-deck">
          <div class="card">
              <img class="card-img-top" src="images/educational_content.jpg" style="object-fit: contain;" alt="Card image cap">
              <div class="card-body">
                <h5 class="card-title">Manage Educational Content</h5>
                <p class="card-text">Upload or delete educational content for the Smile Mobile App.</p>
            </div>
            <div class="card-footer" style="text-align: center;">
            <button onclick="window.location.href='educationalContent.php'" type="button" class="btn btn-outline-primary">Manage Content</button>
            </div>
          </div>
          <div class="card">
              <img class="card-img-top" src="images/data_image.jpg" style="object-fit: contain;" alt="Card image cap">
              <div class="card-body">
                <h5 class="card-title">App Statistics</h5>
                <p class="card-text">View the most important usage and content statistics of the mobile app.</p>
            </div>
            <div class="card-footer" style="text-align: center;">
              <button onclick="window.location.href='userStatistics.php'" type="button" class="btn btn-outline-primary">App Statistics</button>
            </div>
          </div>
          <div class="card">
              <img class="card-img-top" src="images/app_admin.jpg" style="object-fit: contain;" alt="Card image cap">
              <div class="card-body">
                <h5 class="card-title">Manage Admin Accounts</h5>
                <p class="card-text">Add or delete accounts of application administrators.</p>
            </div>
            <div class="card-footer" style="text-align: center;">
              <button onclick="window.location.href='manageAppAdmin.php'" type="button" class="btn btn-outline-primary">Manage Admins</button>
            </div>
          </div>
          <div class="card" style="text-align: center;">
              <img class="card-img-top" src="images/user_image1.jpg" style="object-fit: contain;" alt="Card image cap">
              <div class="card-body">
                <h5 class="card-title">Manage User Accounts</h5>
                <p class="card-text">View and delete user accounts of the Smile moblie app.</p>
            </div>
            <div class="card-footer" style="text-align: center;">
            <button onclick="window.location.href='manageUserAccounts.php'" type="button" class="btn btn-outline-primary">Manage Users</button>
            </div>
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
// Close the connection to database
mysqli_close($link);
?>
</html>