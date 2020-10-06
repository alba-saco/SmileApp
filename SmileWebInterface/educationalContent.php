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

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Integrating the Bootstrap CSS Library-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="SmileCustom.css" type="text/css">
    <title>Manage Educational Content</title>
  </head>
  <body>
    <?php include_once "pageTop.php"; ?>

    <div class="row justify-content-center" style="margin-top: 5%;">
      <div class="card-deck" style="margin-left: 20%; margin-right: 20%;">
        <div class="card">
            <!-- Source of Image: https://www.flaticon.com/free-icon/cloud-computing_1103739?term=upload&page=1&position=3 -->
            <img class="card-img-top" src="images/cloud-computing.png" style="height:200px; widht: 200px; object-fit: contain;" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">Upload Educational Content</h5>
              <p class="card-text">Select on of the upload content options below and fill out the following form to upload new educational content for the Smile Mobile App.</p>
          </div>
          <div class="card-footer" style="text-align: center;">
          <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButtonEducation" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Upload Content
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonEducation">
                <a class="dropdown-item" onclick="window.location.href='uploadEducationalContentnewCategory.php'">Upload Educational Content for new Category</a>
                <a class="dropdown-item" onclick="window.location.href='uploadEducationalContentexistingCategory.php'">Upload Educational Content for Existing Category</a>
                <a class="dropdown-item" onclick="window.location.href='uploadQuiz.php'">Upload a Quiz for an Existing Chapter</a>
              </div>
             </div>
          </div>
        </div>
        <div class="card">
           <!-- Source of Image: https://www.flaticon.com/free-icon/delete_875550?term=trash&page=1&position=11 -->
            <img class="card-img-top" src="images/magnifying-glass.svg" style="height:200px; widht: 200px; object-fit: contain;" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">Manage Educational Content</h5>
              <p class="card-text">Select one of the content management options below and gain an overview of the specified content provided in the app. Here, you can also delete content.</p>
          </div>
          <div class="card-footer" style="text-align: center;">
              <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButtonEducation" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Manage Content
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonEducation">
                <a class="dropdown-item" onclick="window.location.href='deleteEducationalContentCategory.php'">Manage Entire Category</a>
                <a class="dropdown-item" onclick="window.location.href='deleteEducationalContentChapter.php'">Manage Entire Chapter Content</a>
                <a class="dropdown-item" onclick="window.location.href='deleteEducationalContentQuiz.php'">Manage Chapter Quiz</a>
              </div>
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
</html>