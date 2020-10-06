<?php
//function to calculate percentage
function percentage($numerator, $denominator){
  if($denominator > 0){
    return strval(round((($numerator/$denominator)*100),2))."%";
  }else{
    return "n. a.";
  }
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



//Assigning related variables:
$rowTotalUsers = 20000;
$rowTotalBrushingTime = "xx";
$rowTotalEducationalPoints = "xx";

// Calculating the number of users
$query_number_users = "SELECT user_id FROM smiledatabase.users";

if(mysqli_query($link, $query_number_users)){
  $result_query_number_users = mysqli_query($link, $query_number_users);
  $number_users = mysqli_num_rows($result_query_number_users);
}else{
  $number_users = "n. a.";
}

// Calculating the number of appAdmins
$query_number_admins = "SELECT admin_id FROM smiledatabase.admin";

if(mysqli_query($link, $query_number_admins)){
  $result_query_number_admins = mysqli_query($link, $query_number_admins);
  $number_admins = mysqli_num_rows($result_query_number_admins);
}else{
  $number_admins = "n. a.";
}

// Calculating the number of categories
$query_number_categories = "SELECT category_id FROM smiledatabase.category";

if(mysqli_query($link, $query_number_categories)){
  $result_query_number_categories = mysqli_query($link, $query_number_categories);
  $number_categories = mysqli_num_rows($result_query_number_categories);
}else{
  $number_categories = "n. a.";
}

// Calculating the number of chapters
$query_number_chapters = "SELECT chapter_id FROM smiledatabase.chapter";

if(mysqli_query($link, $query_number_chapters)){
  $result_query_number_chapters = mysqli_query($link, $query_number_chapters);
  $number_chapters = mysqli_num_rows($result_query_number_chapters);
}else{
  $number_chapters = "n. a.";
}

// Calculating the number of quizzes
$query_number_quizzes = "SELECT chapter_id FROM smiledatabase.quiz";

if(mysqli_query($link, $query_number_quizzes)){
  $result_query_number_quizzes = mysqli_query($link, $query_number_quizzes);
  $number_quizzes = mysqli_num_rows($result_query_number_quizzes);
}else{
  $number_quizzes = "n. a.";
}

// Fetching general usage statistics from database about Smile app

$query_general_stats = "SELECT * FROM smiledatabase.generalstats";

if(mysqli_query($link, $query_general_stats)){
  $result_query_general_stats = mysqli_query($link, $query_general_stats);
  $general_stats_entries = mysqli_fetch_array($result_query_general_stats);

  $accumulated_quiz_points = $general_stats_entries["total_count_achieved_quiz_points"];
  $total_quiz_attempts = $general_stats_entries["total_count_quiz_attempts"];
  $total_timer_clicks = $general_stats_entries["total_count_timer_usage"] * 3;
  $accumulated_reading_counts = $general_stats_entries["total_count_reading_accessed"];
  $accumulated_video_counts = $general_stats_entries["total_count_videos_accessed"];
  if($total_quiz_attempts > 0){
    $total_average_quiz_score = round($accumulated_quiz_points/$total_quiz_attempts, 2);
  }else{
    $total_average_quiz_score = "n. a.";
  }
}else{
  $accumulated_quiz_points = "n. a.";
  $total_quiz_attempts = "n. a.";
  $total_timer_clicks = "n. a.";
  $accumulated_reading_counts = "n. a.";
  $accumulated_video_counts = "n. a.";
  $total_average_quiz_score = "n. a.";
}

// Fetching gingivitis self-diagnosis statistics from database

$query_selfdiagnosis_stats = "SELECT * FROM smiledatabase.selfdiagnosisstats";

if(mysqli_query($link, $query_selfdiagnosis_stats)){
  $result_query_selfdiagnosis_stats = mysqli_query($link, $query_selfdiagnosis_stats);
  $selfdiagnosis_stats_entries = mysqli_fetch_array($result_query_selfdiagnosis_stats);

  $selfdiagnosis_total_count = $selfdiagnosis_stats_entries["total_count"];
  $selfdiagnosis_total_count_message_A = $selfdiagnosis_stats_entries["total_count_message_A"];
  $selfdiagnosis_Q1_count_message_A = $selfdiagnosis_stats_entries["Q1_count_message_A"];
  $selfdiagnosis_Q2_count_message_A = $selfdiagnosis_stats_entries["Q2_count_message_A"];
  $selfdiagnosis_Q4_count_message_A = $selfdiagnosis_stats_entries["Q4_count_message_A"];
  $selfdiagnosis_Q5_count_message_A = $selfdiagnosis_stats_entries["Q5_count_message_A"];
  $selfdiagnosis_Q6_count_message_A = $selfdiagnosis_stats_entries["Q6_count_message_A"];
  $selfdiagnosis_Q7_count_message_C = $selfdiagnosis_stats_entries["Q7_count_message_C"];
  $selfdiagnosis_Q8_count_message_D = $selfdiagnosis_stats_entries["Q8_count_message_D"];

  $relative_count_Q1 = percentage($selfdiagnosis_Q1_count_message_A, $selfdiagnosis_total_count);
  $relative_count_Q2 = percentage($selfdiagnosis_Q2_count_message_A, $selfdiagnosis_total_count);
  $relative_count_Q4 = percentage($selfdiagnosis_Q4_count_message_A, $selfdiagnosis_total_count);
  $relative_count_Q5 = percentage($selfdiagnosis_Q5_count_message_A, $selfdiagnosis_total_count);
  $relative_count_Q6 = percentage($selfdiagnosis_Q6_count_message_A, $selfdiagnosis_total_count);
  $relative_count_Q7 = percentage($selfdiagnosis_Q7_count_message_C, $selfdiagnosis_total_count);
  $relative_count_Q8 = percentage($selfdiagnosis_Q8_count_message_D, $selfdiagnosis_total_count);
  $relative_count_Q1to6 = percentage($selfdiagnosis_total_count_message_A, $selfdiagnosis_total_count);
  
}else{
  $selfdiagnosis_total_count = "n. a.";
  $selfdiagnosis_total_count_message_A = "n. a.";
  $selfdiagnosis_Q1_count_message_A = "n. a.";
  $selfdiagnosis_Q2_count_message_A = "n. a.";
  $selfdiagnosis_Q4_count_message_A = "n. a.";
  $selfdiagnosis_Q5_count_message_A = "n. a.";
  $selfdiagnosis_Q6_count_message_A = "n. a.";
  $selfdiagnosis_Q7_count_message_C = "n. a.";
  $selfdiagnosis_Q8_count_message_D = "n. a.";

  $relative_count_Q1 = "n. a.";
  $relative_count_Q2 = "n. a.";
  $relative_count_Q4 = "n. a.";
  $relative_count_Q5 = "n. a.";
  $relative_count_Q6 = "n. a.";
  $relative_count_Q7 = "n. a.";
  $relative_count_Q8 = "n. a.";
  $relative_count_Q1to6 = "n. a.";
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
    <title>Smile App Statistics</title>
  </head>
  <body>
    <?php include_once "pageTop.php"; ?>
    <div class="container" style="margin-top:30px;">
    <br>
    <div class="row justify-content-center">
          <h1 style="color:#6ac5fe"><kbd style="background-color: #6ac5fe">Smile</kbd>&nbsp;App Statistics</h1>
    </div>
    <br><br><br>
    <!-- Displaying the facts box -->
    <div class="row justify-content-center">
     <div class = "jumbotron rounded-lg" id="fact-jumbotron-green-border" style="margin-bottom:0px;">
        <div class = "jumbotron jumbotron-fluid" style="background-color:#6ac5fe; padding-top:10px; padding-bottom:5px; text-align: center" >
            <h3 style = "color:white">General Usage Statistic</h3>
        </div>
        <div class="row align-items-center">
          <div class="col-sm-6">
            <p align="middle" id="stats-para">Total # of Users:<br><b><?php echo $number_users; ?></b></p>                      
          </div>
          <div class="col-sm-6">
            <p align="middle" id="stats-para">Total time brushed with the app:
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#timerStat" style="background-color: #ffffff !important;">
                <svg class="bi bi-info-circle" style="color:#6ac5fe;" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M8 15A7 7 0 108 1a7 7 0 000 14zm0 1A8 8 0 108 0a8 8 0 000 16z" clip-rule="evenodd"/>
                  <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"/>
                  <circle cx="8" cy="4.5" r="1"/>
                </svg>
              </button>
              <br><b><?php echo $total_timer_clicks." min.";?></b>
              </p>
            <!-- Modal Starts-->
              <div class="modal fade" id="timerStat" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Total Time Brushed</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      The statistic describes the accumulated total time, users have brushed their teeth with the Smile App.
                      It is being approximated by multiplying the number of clicks on the timer with the recommended 3 minutes brushing time.
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
          <!-- Modal Ends"-->
          </div>
        </div>
      <!-- closing div of above enclosing "jumbotron rounded-lg"-->
      </div>
    </div>
    <!-- Displaying the facts box -->
    <div class="row justify-content-center">
     <div class = "jumbotron rounded-lg" id="fact-jumbotron-green-border" style="margin-bottom:0px; margin-top: 30px;">
        <div class = "jumbotron jumbotron-fluid" style="background-color:#6ac5fe; padding-top:10px; padding-bottom:5px; text-align: center" >
            <h3 style = "color:white">Content Management Statistics</h3>
        </div>
        <div class="row align-items-center">
          <div class="col-sm-4">
            <p align="middle" id="stats-para">Total # of Uploaded Categories:<br><b><?php echo $number_categories; ?></b></p>                      
          </div>
          <div class="col-sm-4">
            <p align="middle" id="stats-para">Total # of Uploaded Chapters:<br><b><?php echo $number_chapters; ?></b></p>                      
          </div>
          <div class="col-sm-4">
            <p align="middle" id="stats-para">Total # of Uploaded Quizzes:<br><b><?php echo $number_quizzes; ?></b></p>                      
          </div>
            
        </div>
      <!-- closing div of above enclosing "jumbotron rounded-lg"-->
      </div>
    </div>

    <div class="row justify-content-center">
     <div class = "jumbotron rounded-lg" id="fact-jumbotron-green-border" style="margin-bottom:0px; margin-top: 30px;">
        <div class = "jumbotron jumbotron-fluid" style="background-color:#6ac5fe; padding-top:10px; padding-bottom:5px; text-align: center" >
            <h3 style = "color:white">Educational Content Statistics</h3>
        </div>
        <div class="row align-items-center">
          <div class="col-sm-6">
            <p align="middle" id="stats-para">Accumulated # of Times<br>Reading was Preferred:
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#readingStat" style="background-color: #ffffff !important;">
                <svg class="bi bi-info-circle" style="color:#6ac5fe;" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M8 15A7 7 0 108 1a7 7 0 000 14zm0 1A8 8 0 108 0a8 8 0 000 16z" clip-rule="evenodd"/>
                  <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"/>
                  <circle cx="8" cy="4.5" r="1"/>
                </svg>
              </button>
              <br><b><?php echo $accumulated_reading_counts; ?></b>
            </p>
            <!-- Modal Starts-->
            <div class="modal fade" id="readingStat" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Accumulated # of Times Reading was Preferred</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      This statistic describes the total accumulated amount of times a user viewed the reading content,
                      as opposed to clicking to view the video content. This can indicate an overall learning
                      preference.
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
          <!-- Modal Ends"-->                      
          </div>
          <div class="col-sm-6">
            <p align="middle" id="stats-para">Accumulated # of Times<br>Video was Preferred:
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#videoStat" style="background-color: #ffffff !important;">
                <svg class="bi bi-info-circle" style="color:#6ac5fe;" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M8 15A7 7 0 108 1a7 7 0 000 14zm0 1A8 8 0 108 0a8 8 0 000 16z" clip-rule="evenodd"/>
                  <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"/>
                  <circle cx="8" cy="4.5" r="1"/>
                </svg>
              </button>
              <br><b><?php echo $accumulated_video_counts; ?></b>
            </p>
            <!-- Modal Starts-->
            <div class="modal fade" id="videoStat" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Accumulated # of Times Video was Preferred</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      This statistic describes the total accumulated amount of times a user viewed the video content,
                      as opposed to clicking to view the reading content. This can indicate an overall learning
                      preference.
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
          <!-- Modal Ends"-->                      
          </div>  
        </div>
      <!-- closing div of above enclosing "jumbotron rounded-lg"-->
      </div>
    </div>

    <div class="row justify-content-center">
     <div class = "jumbotron rounded-lg" id="fact-jumbotron-green-border" style="margin-bottom:0px; margin-top: 30px;">
        <div class = "jumbotron jumbotron-fluid" style="background-color:#6ac5fe; padding-top:10px; padding-bottom:5px; text-align: center" >
            <h3 style = "color:white">Educational Quiz Statistics</h3>
        </div>
        <div class="row align-items-center">
          <div class="col-sm-4">
            <p align="middle" id="stats-para">Total # of Quizzes<br>Taken:
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#totalQuizStat" style="background-color: #ffffff !important;">
                <svg class="bi bi-info-circle" style="color:#6ac5fe;" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M8 15A7 7 0 108 1a7 7 0 000 14zm0 1A8 8 0 108 0a8 8 0 000 16z" clip-rule="evenodd"/>
                  <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"/>
                  <circle cx="8" cy="4.5" r="1"/>
                </svg>
              </button>
              <br><b><?php echo $total_quiz_attempts; ?></b>
            </p>
             <!-- Modal Starts-->
             <div class="modal fade" id="totalQuizStat" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Total # of Quizzes Taken</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      This statistic measures the number of times a quiz has been taken by tracking
                      how often a quiz was completed. The measurement applies in general to all educational quizzes.
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
          <!-- Modal Ends"-->                        
          </div>
          <div class="col-sm-4">
            <p align="middle" id="stats-para">Accumulated Points Achieved in Quizzes:
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#quizPointsStat" style="background-color: #ffffff !important;">
                <svg class="bi bi-info-circle" style="color:#6ac5fe;" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M8 15A7 7 0 108 1a7 7 0 000 14zm0 1A8 8 0 108 0a8 8 0 000 16z" clip-rule="evenodd"/>
                  <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"/>
                  <circle cx="8" cy="4.5" r="1"/>
                </svg>
              </button>
              <br><b><?php echo $accumulated_quiz_points; ?></b>
            </p>
             <!-- Modal Starts-->
             <div class="modal fade" id="quizPointsStat" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Accumulated Points Achieved in Quizzes</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      This statistic represents the accumulated sum of all educational quiz scores achieved by the users.
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
          <!-- Modal Ends"-->                       
          </div>
          <div class="col-sm-4">
            <p align="middle" id="stats-para">Total Average Score in<br>Quizzes:
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#quizAverageStat" style="background-color: #ffffff !important;">
                <svg class="bi bi-info-circle" style="color:#6ac5fe;" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M8 15A7 7 0 108 1a7 7 0 000 14zm0 1A8 8 0 108 0a8 8 0 000 16z" clip-rule="evenodd"/>
                  <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"/>
                  <circle cx="8" cy="4.5" r="1"/>
                </svg>
              </button>
              <br><b><?php echo $total_average_quiz_score; ?></b>
            </p>
             <!-- Modal Starts-->
             <div class="modal fade" id="quizAverageStat" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Total Average Quiz Score</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      This statistic is the average quiz score calculated by the accumulated points achieved in quizzes and the total # of quizzes taken. The maximum score, which can be achieved in a quiz are 5 points.
                      <br><br>Expressed as Formula:<br>Accumulated Points Achieved in Quizzes / Total # of Quizzes Taken<br><br>
                      This measurement can provide indication, whether the quizzes are too challenging or too easy for the users.
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
          <!-- Modal Ends"-->                        
          </div>
            
        </div>
      <!-- closing div of above enclosing "jumbotron rounded-lg"-->
      </div>
    </div>

    <div class="row justify-content-center">
     <div class = "jumbotron rounded-lg" id="fact-jumbotron-green-border" style="margin-bottom:0px; margin-top: 30px;">
        <div class = "jumbotron jumbotron-fluid" style="background-color:#6ac5fe; padding-top:10px; padding-bottom:5px; text-align: center" >
            <h3 style = "color:white">Gingivitis Self-Diagnosis Quiz Statistics</h3>
        </div>
        <div class="row align-items-center">
          <div class="col-sm-12">
            <p align="middle" id="stats-para">Total # of Times Taken:<br><b><?php echo $selfdiagnosis_total_count; ?></b></p>                      
          </div>
        </div>
        <br>
        <hr style="border-top: 2px dashed #6ac5fe;" width="90%">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <p align="middle" id="stats-para">Question 1 -<br># of Positive Answers:
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Q1Stat" style="background-color: #ffffff !important;">
                <svg class="bi bi-info-circle" style="color:#6ac5fe;" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M8 15A7 7 0 108 1a7 7 0 000 14zm0 1A8 8 0 108 0a8 8 0 000 16z" clip-rule="evenodd"/>
                  <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"/>
                  <circle cx="8" cy="4.5" r="1"/>
                </svg>
              </button>
              <br><b><?php echo $selfdiagnosis_Q1_count_message_A; ?> | <?php echo $relative_count_Q1; ?></b>
            </p>
            <!-- Modal Starts-->
            <div class="modal fade" id="Q1Stat" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle"># of Positive Answers (Absolute | Relative)</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      This statistic shows in absolute and relative terms, how often the following answer has been shown as a result of the
                      first question of the questionaire:
                      <br><br>Question:<br>Do you think you might have gum disease? (Yes, No, Don’t Know)
                      <br><br>Answer: <br>To keep your teeth and gums healthy brush your teeth thoroughly twice daily, visit your dentist for regular check-ups and ask your dentist, therapist or hygienist to show you how to brush and clean between teeth. Gum disease is usually pain-free and you might be unaware of having it until your dentist checks for it. Over half the population has mild gum disease, and severe gum disease is the sixth most common disease in the world. Symptoms and signs of gum disease include bleeding gums, swollen gums, bad breath, loose or drifting teeth, gaps appearing between teeth, receding gums and sensitivity to cold or hot. Diabetes, smoking, stress, poor diet and obesity put people at higher risk of getting severe gum disease.
                      <br><br>The answer was shown if the answer to the question was "Yes". The absolute measurement is the
                      total accumulated count the answer has been shown because of a positive response for this question.
                      The relative measurement sets it in perspective to the # fo times the self-diagnosis questionaire has been
                      answered ((# of Positive Answers for Question 1 / total # of times the questionaire was taken)*100).
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
          <!-- Modal Ends"-->                        
          </div>
          <div class="col-sm-6">
            <p align="middle" id="stats-para">Question 2 -<br># of Answers < "Good":
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Q2Stat" style="background-color: #ffffff !important;">
                <svg class="bi bi-info-circle" style="color:#6ac5fe;" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M8 15A7 7 0 108 1a7 7 0 000 14zm0 1A8 8 0 108 0a8 8 0 000 16z" clip-rule="evenodd"/>
                  <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"/>
                  <circle cx="8" cy="4.5" r="1"/>
                </svg>
              </button>
              <br><b><?php echo $selfdiagnosis_Q2_count_message_A; ?> | <?php echo $relative_count_Q2; ?></b>
            </p>
            <!-- Modal Starts-->
            <div class="modal fade" id="Q2Stat" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle"># of Positive Answers (including "Don't Know") (Absolute | Relative)</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      This statistic shows in absolute and relative terms, how often the following answer has been shown as a result of the
                      second question of the questionaire:
                      <br><br>Question:<br>Overall, how would you rate the health of your teeth and gums? (Excellent, Very good, Good, Fair, Poor, Don’t Know)
                      <br><br>Answer: <br>To keep your teeth and gums healthy brush your teeth thoroughly twice daily, visit your dentist for regular check-ups and ask your dentist, therapist or hygienist to show you how to brush and clean between teeth. Gum disease is usually pain-free and you might be unaware of having it until your dentist checks for it. Over half the population has mild gum disease, and severe gum disease is the sixth most common disease in the world. Symptoms and signs of gum disease include bleeding gums, swollen gums, bad breath, loose or drifting teeth, gaps appearing between teeth, receding gums and sensitivity to cold or hot. Diabetes, smoking, stress, poor diet and obesity put people at higher risk of getting severe gum disease.
                      <br><br>The answer was shown if the answer to the question was "Fair", "Poor", or "Don't Know". The absolute measurement is the
                      total accumulated count the answer has been shown because of a positive response for this question.
                      The relative measurement sets it in perspective to the # fo times the self-diagnosis questionaire has been
                      answered ((# of Positive Answers for Question 2 / total # of times the questionaire was taken)*100).
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
          <!-- Modal Ends"-->                        
          </div>
        </div>
        <br>
        <hr style="border-top: 2px dashed #DADAD9;" width="80%">
        <div class="row align-items-center">
          <div class="col-sm-4">
            <p align="middle" id="stats-para">Question 4 -<br># of Positive Answers:
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Q4Stat" style="background-color: #ffffff !important;">
                <svg class="bi bi-info-circle" style="color:#6ac5fe;" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M8 15A7 7 0 108 1a7 7 0 000 14zm0 1A8 8 0 108 0a8 8 0 000 16z" clip-rule="evenodd"/>
                  <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"/>
                  <circle cx="8" cy="4.5" r="1"/>
                </svg>
              </button>
              <br><b><?php echo $selfdiagnosis_Q4_count_message_A; ?> | <?php echo $relative_count_Q4; ?></b>
            </p>
            <!-- Modal Starts-->
            <div class="modal fade" id="Q4Stat" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle"># of Positive Answers (Absolute | Relative)</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      This statistic shows in absolute and relative terms, how often the following answer has been shown as a result of the
                      fourth question of the questionaire:
                      <br><br>Question:<br>Have you ever had any teeth become loose on their own, without an injury? (Yes, No, Don’t Know)
                      <br><br>Answer: <br>To keep your teeth and gums healthy brush your teeth thoroughly twice daily, visit your dentist for regular check-ups and ask your dentist, therapist or hygienist to show you how to brush and clean between teeth. Gum disease is usually pain-free and you might be unaware of having it until your dentist checks for it. Over half the population has mild gum disease, and severe gum disease is the sixth most common disease in the world. Symptoms and signs of gum disease include bleeding gums, swollen gums, bad breath, loose or drifting teeth, gaps appearing between teeth, receding gums and sensitivity to cold or hot. Diabetes, smoking, stress, poor diet and obesity put people at higher risk of getting severe gum disease.
                      <br><br>The answer was shown if the answer to the question was "Yes". The absolute measurement is the
                      total accumulated count the answer has been shown because of a positive response for this question.
                      The relative measurement sets it in perspective to the # fo times the self-diagnosis questionaire has been
                      answered ((# of Positive Answers for Question 4 / total # of times the questionaire was taken)*100).
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
          <!-- Modal Ends"-->                        
          </div>
          <div class="col-sm-4">
            <p align="middle" id="stats-para">Question 5 -<br># of Positive Answers:
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Q5Stat" style="background-color: #ffffff !important;">
                <svg class="bi bi-info-circle" style="color:#6ac5fe;" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M8 15A7 7 0 108 1a7 7 0 000 14zm0 1A8 8 0 108 0a8 8 0 000 16z" clip-rule="evenodd"/>
                  <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"/>
                  <circle cx="8" cy="4.5" r="1"/>
                </svg>
              </button>
              <br><b><?php echo $selfdiagnosis_Q5_count_message_A; ?> | <?php echo $relative_count_Q5; ?></b>
            </p>
            <!-- Modal Starts-->
            <div class="modal fade" id="Q5Stat" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle"># of Positive Answers (Absolute | Relative)</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      This statistic shows in absolute and relative terms, how often the following answer has been shown as a result of the
                      fifth question of the questionaire:
                      <br><br>Question:<br>Have you ever been told by a dental professional that you lost bone around your teeth? (Yes, No, Don’t Know)
                      <br><br>Answer: <br>To keep your teeth and gums healthy brush your teeth thoroughly twice daily, visit your dentist for regular check-ups and ask your dentist, therapist or hygienist to show you how to brush and clean between teeth. Gum disease is usually pain-free and you might be unaware of having it until your dentist checks for it. Over half the population has mild gum disease, and severe gum disease is the sixth most common disease in the world. Symptoms and signs of gum disease include bleeding gums, swollen gums, bad breath, loose or drifting teeth, gaps appearing between teeth, receding gums and sensitivity to cold or hot. Diabetes, smoking, stress, poor diet and obesity put people at higher risk of getting severe gum disease.
                      <br><br>The answer was shown if the answer to the question was "Yes". The absolute measurement is the
                      total accumulated count the answer has been shown because of a positive response for this question.
                      The relative measurement sets it in perspective to the # fo times the self-diagnosis questionaire has been
                      answered ((# of Positive Answers for Question 5 / total # of times the questionaire was taken)*100).
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
          <!-- Modal Ends"-->                        
          </div>
          <div class="col-sm-4">
            <p align="middle" id="stats-para">Question 6 -<br># of Positive Answers:
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Q6Stat" style="background-color: #ffffff !important;">
                <svg class="bi bi-info-circle" style="color:#6ac5fe;" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M8 15A7 7 0 108 1a7 7 0 000 14zm0 1A8 8 0 108 0a8 8 0 000 16z" clip-rule="evenodd"/>
                  <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"/>
                  <circle cx="8" cy="4.5" r="1"/>
                </svg>
              </button>
              <br><b><?php echo $selfdiagnosis_Q6_count_message_A; ?> | <?php echo $relative_count_Q6; ?></b>
            </p>
            <!-- Modal Starts-->
            <div class="modal fade" id="Q6Stat" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle"># of Positive Answers (Absolute | Relative)</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      This statistic shows in absolute and relative terms, how often the following answer has been shown as a result of the
                      sixth question of the questionaire:
                      <br><br>Question:<br>During the past three months, have you noticed a tooth that doesn’t look right? (Yes, No, Don’t Know)
                      <br><br>Answer: <br>To keep your teeth and gums healthy brush your teeth thoroughly twice daily, visit your dentist for regular check-ups and ask your dentist, therapist or hygienist to show you how to brush and clean between teeth. Gum disease is usually pain-free and you might be unaware of having it until your dentist checks for it. Over half the population has mild gum disease, and severe gum disease is the sixth most common disease in the world. Symptoms and signs of gum disease include bleeding gums, swollen gums, bad breath, loose or drifting teeth, gaps appearing between teeth, receding gums and sensitivity to cold or hot. Diabetes, smoking, stress, poor diet and obesity put people at higher risk of getting severe gum disease.
                      <br><br>The answer was shown if the answer to the question was "Yes". The absolute measurement is the
                      total accumulated count the answer has been shown because of a positive response for this question.
                      The relative measurement sets it in perspective to the # fo times the self-diagnosis questionaire has been
                      answered ((# of Positive Answers for Question 6 / total # of times the questionaire was taken)*100).
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
          <!-- Modal Ends"-->                        
          </div>
        </div>
        <br>
        <hr style="border-top: 2px dashed #DADAD9;" width="80%">
        <div class="row align-items-center">
          <div class="col-sm-12" style="text-align:center;">
            <svg class="bi bi-caret-down" width="3.5em" height="3.5em" viewBox="0 0 16 16" fill="currentColor" style="color:#6ac5fe; margin-top: 10px;"  xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M3.204 5L8 10.481 12.796 5H3.204zm-.753.659l4.796 5.48a1 1 0 001.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 00-.753 1.659z" clip-rule="evenodd"/>
            </svg>
          </div>
        </div>
        <div class="row align-items-center">
          <div class="col-sm-12">
            <p style ="margin-top: 10px;" align="middle" id="stats-para">Question 1-6 -<br>total # of Positive Answers:
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Q1to6Stat" style="background-color: #ffffff !important;">
                <svg class="bi bi-info-circle" style="color:#6ac5fe;" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M8 15A7 7 0 108 1a7 7 0 000 14zm0 1A8 8 0 108 0a8 8 0 000 16z" clip-rule="evenodd"/>
                  <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"/>
                  <circle cx="8" cy="4.5" r="1"/>
                </svg>
              </button>
              <br><b><?php echo $selfdiagnosis_total_count_message_A; ?> | <?php echo $relative_count_Q1to6; ?></b>
            </p>
            <!-- Modal Starts-->
            <div class="modal fade" id="Q1to6Stat" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle"># of Positive Answers (Absolute | Relative)</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      This statistic shows in absolute and relative terms, how often the following answer has been shown as a result of the
                      of the questions 1, 2, 4, 5, 6 in the questionaire:
                      <br><br>Answer: <br>To keep your teeth and gums healthy brush your teeth thoroughly twice daily, visit your dentist for regular check-ups and ask your dentist, therapist or hygienist to show you how to brush and clean between teeth. Gum disease is usually pain-free and you might be unaware of having it until your dentist checks for it. Over half the population has mild gum disease, and severe gum disease is the sixth most common disease in the world. Symptoms and signs of gum disease include bleeding gums, swollen gums, bad breath, loose or drifting teeth, gaps appearing between teeth, receding gums and sensitivity to cold or hot. Diabetes, smoking, stress, poor diet and obesity put people at higher risk of getting severe gum disease.
                      <br><br>The answer was shown if the answer to the questions 1, 2, 4, 5, 6 was positive. The absolute measurement is the
                      total accumulated count the answer has been shown because of a positive response to one of those questions, meaning it counts the whether the answer was triggered, when a user answered the questionaire, or not.
                      The relative measurement sets it in perspective to the # fo times the self-diagnosis questionaire has been
                      answered ((# of times the answer was triggered in a questionaire / total # of times the questionaire was taken)*100).
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
          <!-- Modal Ends"-->                        
          </div>
        </div>
        <br>
        <hr style="border-top: 2px dashed #6ac5fe;" width="90%">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <p align="middle" id="stats-para">Question 7 -<br># of Positive Answers:
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Q7Stat" style="background-color: #ffffff !important;">
                <svg class="bi bi-info-circle" style="color:#6ac5fe;" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M8 15A7 7 0 108 1a7 7 0 000 14zm0 1A8 8 0 108 0a8 8 0 000 16z" clip-rule="evenodd"/>
                  <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"/>
                  <circle cx="8" cy="4.5" r="1"/>
                </svg>
              </button>
              <br><b><?php echo $selfdiagnosis_Q7_count_message_C; ?> | <?php echo $relative_count_Q7; ?></b>
            </p>
            <!-- Modal Starts-->
            <div class="modal fade" id="Q7Stat" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle"># of Positive Answers (Absolute | Relative)</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      This statistic shows in absolute and relative terms, how often the following answer has been shown as a result of the
                      seventh question of the questionaire:
                      <br><br>Question:<br>Aside from brushing your teeth with a toothbrush, in the last seven days, how many times did you use dental floss or any other device to clean between your teeth? (???: Number of Times)
                      <br><br>Answer: <br>Daily cleaning between teeth using floss or interdental brushes is recommended for preventing gum disease and tooth decay.
                      <br><br>The answer was shown if the answer to the question ranged between 0 and 7 times, including 0 and 7. The absolute measurement is the
                      total accumulated count the answer has been shown because of a positive response for this question.
                      The relative measurement sets it in perspective to the # fo times the self-diagnosis questionaire has been
                      answered ((# of Positive Answers for Question 7 / total # of times the questionaire was taken)*100).
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
          <!-- Modal Ends"-->                        
          </div> 
          <div class="col-sm-6">
            <p align="middle" id="stats-para">Question 8 -<br># of Positive Answers: 
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Q8Stat" style="background-color: #ffffff !important;">
                <svg class="bi bi-info-circle" style="color:#6ac5fe;" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M8 15A7 7 0 108 1a7 7 0 000 14zm0 1A8 8 0 108 0a8 8 0 000 16z" clip-rule="evenodd"/>
                  <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"/>
                  <circle cx="8" cy="4.5" r="1"/>
                </svg>
              </button>
              <br><b><?php echo $selfdiagnosis_Q8_count_message_D; ?> | <?php echo $relative_count_Q8; ?></b>
            </p>
            <!-- Modal Starts-->
            <div class="modal fade" id="Q8Stat" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle"># of Positive Answers (Absolute | Relative)</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      This statistic shows in absolute and relative terms, how often the following answer has been shown as a result of the
                      eighth question of the questionaire:
                      <br><br>Question:<br>Aside from brushing your teeth with a toothbrush, in the last seven days, how many times did you use mouthwash or other dental rinse product that you use to treat dental disease or dental problems? (???: Number of Times)
                      <br><br>Answer: <br>Mouthwash use along brushing and flossing could be beneficial, but It is not necessary to keep your teeth clean and gums healthy. If you are unsure whether to use mouthwash and how often, seek advice from your dentist, therapist or hygienist. Bleeding gums and bad breath could be a sign of gum disease.
                      <br><br>The answer was shown if the answer to the question ranged between 0 and 7 times, including 0 and 7. The absolute measurement is the
                      total accumulated count the answer has been shown because of a positive response for this question.
                      The relative measurement sets it in perspective to the # fo times the self-diagnosis questionaire has been
                      answered ((# of Positive Answers for Question 8 / total # of times the questionaire was taken)*100).
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
          <!-- Modal Ends"-->                        
          </div>
        </div>     
        </div>
      <!-- closing div of above enclosing "jumbotron rounded-lg"-->
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