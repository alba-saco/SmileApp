<?php
// The visual display of the table in this file has been adapted from https://datatables.net/manual/installation
// The Javascript Function Datatable has been adapted from https://datatables.net/manual/installation

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


//Initiating Error Variables:
$errorMessageAppAdmins = "";


//Creating the query for the tracked products display:
$query_appAdmins = "SELECT admin_id, first_name, last_name, email, institution, department FROM smiledatabase.admin ORDER BY last_name asc";

$query_result_appAdmin = mysqli_query($link, $query_appAdmins);
$errorMessageAppAdmins = "An error ocurred retrieving the existing App Admins from the data base. Please, try later again.";


// Creating the logic of the form to delete an appAdmin using the email as an identifier
//Define error variables
$emailErr = $errorMessage = "";

//Define input variables
$email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $admin_id = $_POST['identifier'];

// Creating the delete query for the database
    $query = "DELETE FROM smiledatabase.admin WHERE admin_id='$admin_id'";

    if(mysqli_query($link, $query)){
        // Redirect to the login page
        $validSubmission = "";
        header("location: manageAppAdmin.php?deleteSuccess=True");
    }
    else{
        $validSubmission = False;
        $errorMessage = "*An error ocurred while attempting to delete the App Admin. Please, try later again.";
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
    <title>Manage App Admins</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  </head>
  <body>
    <?php include_once "pageTop.php"; ?>
    <div class = "container" style = "margin-top:30px">
    <?php 
    if(isset($_GET["deleteSuccess"]) == "True"){
                echo '<div class="row justify-content-center" style="margin-top: 5%;">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="vertical-align: top"><span aria-hidden="true">&times;</span></button>
                            <strong>Great!</strong> The App Admin has been deleted successfully.
                        </div>
                        </div>';
            }
            if(isset($_GET["addSuccess"]) == "True"){
              echo '<div class="row justify-content-center" style="margin-top: 5%;">
                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" style="vertical-align: top">&times;</span></button>
                          <strong>Great!</strong> The App Admin has been successfully added to the database.
                      </div>
                      </div>';
          }
    if($validSubmission === False){
      echo '<div class="alert alert-danger">
                  <small><strong>'.$errorMessage.'</strong></small>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>';
      $validSubmission = "";
    }else{
        echo '';
    }
           ?>
    <div class="row" style="margin-top: 30px; margin-left: 60px; margin-right: 60px;">
      <div class="col float-right" style="text-align: right;">
        <img src="images/plus.svg" style="padding-top: 25px; height: 75px; widht: 75px;" alt="Plus Image" onclick="window.location.href='addAppAdmin.php'">
      </div>
    </div>
    <div class="row justify-center">
        <div class="col auto">
          <div class = "jumbotron rounded-lg" id="enclosing-jumbotron-green-border" style="margin-top: 30px; margin-left: 60px; margin-right: 60px;">
            <div class = "jumbotron jumbotron-fluid" id="inner-jumbotron-inside-green" >
            <h2 style = "color:white">App Admins</h2>
            </div>
                <?php
                if($query_result_appAdmin == TRUE){
                  if (mysqli_num_rows($query_result_appAdmin) >= 1){ 
                    echo
                          '<div style="display: block; max-height: 400px; overflow-y: auto; margin-top: 40px; margin-bottom: 20px; margin-left: 40px; margin-right: 40px;">
                          <table id="userTable" align = "center" class="table table-hover" style = "background-color:#f8f9fa; margin-top: 20px; margin-bottom: 0px; border-width: 4px;">
                          <thead>
                          <tr>
                            <th align="left" scope="col">User&nbsp;ID</th>
                            <th align="left" scope="col">Last&nbsp;Name</th>
                            <th align="left" scope="col">First&nbsp;Name</th>
                            <th align="left" scope="col">Email&nbsp;Address</th>
                            <th align="left" scope="col">Institution</th>
                            <th align="left" scope="col">Department</th>
                            <th align="left" scope="col">Action</th>
                          </tr>
                          </thead>
                          <tbody>';
                      while ($row_appAdmin = mysqli_fetch_array($query_result_appAdmin))
                        {
                          echo'<tr class=""table table-hover">
                                <td align="left">'.$row_appAdmin['admin_id'].'</td>
                                <td align="left">'.$row_appAdmin['last_name'].'</td>
                                <td align="left">'.$row_appAdmin['first_name'].'</td>
                                <td align="left">'.$row_appAdmin['email'].'</td>
                                <td align="left">'.$row_appAdmin['institution'].'</td>
                                <td align="left">'.$row_appAdmin['department'].'</td>
                                <td align="left">
                                  <form id="contentForm" method="POST" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" enctype="multipart/form-data" autocomplete="off">
                                    <input type="hidden" id="identifier" name="identifier" value="'.$row_appAdmin['admin_id'].'">
                                    <button class="btn btn-primary" type="submit" style="background-color: #ffffff !important;"><img src="images/delete.png" style="height: 30px; widht: 30px; object-fit: contain;" alt="Delete Image"></button>
                                    </form>
                                </td>
                              </tr>';      
                          }
                      echo '</tbody>
                            </table>
                            </div>';  
                    }
                    else{
                    echo '<p align="middle" id="stats-para">There are no AppAdmins registered yet.</p>';
                    }
                }
                ?>
            <!-- closing large jumbotron div-->
            </div>
          </div>
        </div>
      </div>
         <!-- Integrating Javascript library from Bootstrap (jQuery, Popper.js and Javascript sublibraries)-->
         <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
    <script>
      $(document).ready( function () {
        $('#userTable').DataTable();
      } );
    </script>
    <?php include "pageFooter.php"; ?>
  </body>
</html>