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
$query_users = "SELECT user_id, first_name, last_name, email FROM smiledatabase.users ORDER BY last_name asc";

$query_result_users = mysqli_query($link, $query_users);
$errorMessageUsers = "An error ocurred retrieving the existing SmileUsers from the data base. Please, try later again.";

// Creating the logic of the form to delete an appAdmin using the email as an identifier
//Define error variables
$emailErr = $errorMessage = "";

//Define input variables
$email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $user_id = $_POST['identifier'];
  // Creating of Delete Query for Database
    $query = "DELETE FROM smiledatabase.users WHERE user_id='$user_id'";

    if(mysqli_query($link, $query)){
        // Redirect to the login page
        $validSubmission="";
        header("location: manageUserAccounts.php?deleteSuccess=True");
    }
    else{
        $validSubmission=False;
        $errorMessage = "*An error ocurred while attempting to delete the SmileUser. Please, try later again.";
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
    <title>Manage User Accounts</title>
  </head>
  <body>
    <?php include_once "pageTop.php"; ?>
    <div class = "container" style = "margin-top:30px">
    <?php 
    if(isset($_GET["deleteSuccess"]) == "True"){
                echo '<div class="row justify-content-center" style="margin-top: 5%;">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="vertical-align: top"><span aria-hidden="true">&times;</span></button>
                            <strong>Great!</strong> The Smile User has been deleted successfully.
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
    <div class="row justify-center">
        <div class="col auto">
          <div class = "jumbotron rounded-lg" id="enclosing-jumbotron-green-border" style="margin-top: 60px; margin-left: 60px; margin-right: 60px;">
            <div class = "jumbotron jumbotron-fluid" id="inner-jumbotron-inside-green" >
            <h2 style = "color:white">Smile Users</h2>
            </div>
                <?php
                if($query_result_users == TRUE){
                  if (mysqli_num_rows($query_result_users) >= 1){
                    $counter = 0;  
                    echo
                          '<div style="display: block; max-height: 400px; overflow-y: auto;  margin-top: 40px; margin-bottom: 20px; margin-left: 40px; margin-right: 40px;">
                          <table id="userTable" align = "center" class="table table-hover" style = "background-color:#f8f9fa; border-width: 4px;">
                          <thead>
                          <tr>
                            <th align="left" scope="col">User&nbsp;ID</th>
                            <th align="left" scope="col">First&nbsp;Name</th>
                            <th align="left" scope="col">Last&nbsp;Name</th>
                            <th align="left" scope="col">Email&nbsp;Address</th>
                            <th align="left" scope="col">Action</th>
                          </tr>
                          </thead>
                          <tbody>';
                      while ($row_user = mysqli_fetch_array($query_result_users))
                        {
                          $counter++;
                          echo'<tr class=""table table-hover">
                                <td align="left">'.$row_user['user_id'].'</td>
                                <td align="left">'.$row_user['first_name'].'</td>
                                <td align="left">'.$row_user['last_name'].'</td>
                                <td align="left">'.$row_user['email'].'</td>
                                <td align="left">
                                  <form id="contentForm" method="POST" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" enctype="multipart/form-data" autocomplete="off">
                                    <input type="hidden" id="identifier" name="identifier" value="'.$row_user['user_id'].'">
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
                    echo '<p align="middle" id="stats-para">There are no SmileUsers registered yet.</p>';
                    }
                }
                else{
                  echo '<p align="middle" id="stats-para">'.$errorMessageUsers.'</p>';
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