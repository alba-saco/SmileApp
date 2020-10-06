<?php
// The function safeStrInput has been adapted from personal written code for the Module "Database and Information Management Systems (19/20)" with the course code COMP0022-PG taught at UCL

function safeStrInput($inputName, $placeholderValue){
    if(!isset($_POST[$inputName]) || empty($_POST[$inputName])){
        echo "placeholder=".$placeholderValue;
        }else{
            echo "value=".$_POST[$inputName];}
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


//initiating variables
$error_message = $question1Err = $question2Err = $question3Err = $question4Err = $q1CorAnswerErr = $q2CorAnswerErr = $q3CorAnswerErr = $q4CorAnswerErr =  "";
$q1FalAnswer1Err = $q1FalAnswer2Err = $q1FalAnswer3Err = $q2FalAnswer1Err = $q2FalAnswer2Err = $q2FalAnswer3Err = $q3FalAnswer1Err = $q3FalAnswer2Err = $q3FalAnswer3Err = $q4FalAnswer1Err = $q4FalAnswer2Err = $q4FalAnswer3Err = "";
$question1 = $question2 = $question3 = $question4 = $q1CorAnswer = $q2CorAnswer = $q3CorAnswer = $q4CorAnswer = "";
$q1CorAnswer = $q1FalAnswer1 = $q1FalAnswer2 = $q1FalAnswer3 = $q2CorAnswer = $q2FalAnswer1 = $q2FalAnswer2 = $q2FalAnswer3 = "";
$q3CorAnswer = $q3FalAnswer1 = $q3FalAnswer2 = $q3FalAnswer3 = $q3FalAnswer1 = $q4CorAnswer = $q4FalAnswer1 = $q4FalAnswer2 = $q4FalAnswer3 = "";
$qestion5 = $q5CorAnswer = $q5FalAnswer1 = $q5FalAnswer2 = $q5FalAnswer3 = $question5Err = $q5CorAnswerErr = $q5FalAnswer1Err = $q5FalAnswer2Err = $q5FalAnswer3Err = "";
$validSubmission = "";
$styleDisappear = "";
$chapterExist = "";

// retrieving the category and chapter names for the drop-down choice menu

$catchap_query = "SELECT cat.category_id AS catCategoryID, category_name, chap.chapter_id AS chapChapterID, chap.category_id AS chapCategoryID, chapter_title, chapter_number 
                    FROM smiledatabase.chapter as chap
                    LEFT JOIN smiledatabase.category AS cat ON cat.category_id = chap.category_id
                    WHERE chap.chapter_id NOT IN (SELECT chapter_id FROM quiz)";

if(mysqli_query($link, $catchap_query)){
    $catchap_query_result = mysqli_query($link, $catchap_query);
    
    if(mysqli_num_rows($catchap_query_result) < 1){
        $error_message = "You cannot upload a quiz for a chapter, as either every chapter already has a quiz or you have not uploaded any educational content yet.";
        $styleDisappear = '"display:none;"';
        $chapterExist = False;
    }
}else{
    $error_message = "Sorry, an error occurred connecting to the database. Please, try again later.";
    $styleDisappear = "'display:none;'";
    $chapterExist = "error";
}

// preparing the data submission

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['question1'])){
        $question1Err = "*A question is required";
    }
    else{
        $question1 = $_POST["question1"];
    }
    if (empty($_POST['q1CorAnswer'])){
        $q1CorAnswerErr = "*Correct answer is required";
    }
    else{
        $q1CorAnswer = $_POST["q1CorAnswer"];
    }
    if (empty($_POST['q1FalAnswer1'])){
        $q1FalAnswer1Err = "*False answer is required";
    }
    else{
        $q1FalAnswer1 = $_POST["q1FalAnswer1"];
    }
    if (empty($_POST['q1FalAnswer2'])){
        $q1FalAnswer2Err = "*False answer is required";
    }
    else{
        $q1FalAnswer2 = $_POST["q1FalAnswer2"];
    }
    if (empty($_POST['q1FalAnswer3'])){
        $q1FalAnswer3Err = "*False answer is required";
    }
    else{
        $q1FalAnswer3 = $_POST["q1FalAnswer3"];
    }
    if (empty($_POST['question2'])){
        $question2Err = "*A question is required";
    }
    else{
        $question2 = $_POST["question2"];
    }
    if (empty($_POST['q2CorAnswer'])){
        $q2CorAnswerErr = "*Correct answer is required";
    }
    else{
        $q2CorAnswer = $_POST["q2CorAnswer"];
    }
    if (empty($_POST['q2FalAnswer1'])){
        $q2FalAnswer1Err = "*False answer is required";
    }
    else{
        $q2FalAnswer1 = $_POST["q2FalAnswer1"];
    }
    if (empty($_POST['q2FalAnswer2'])){
        $q2FalAnswer2Err = "*False answer is required";
    }
    else{
        $q2FalAnswer2 = $_POST["q2FalAnswer2"];
    }
    if (empty($_POST['q2FalAnswer3'])){
        $q2FalAnswer3Err = "*False answer is required";
    }
    else{
        $q2FalAnswer3 = $_POST["q2FalAnswer3"];
    }
    if (empty($_POST['question3'])){
        $question3Err = "*A question is required";
    }
    else{
        $question3 = $_POST["question3"];
    }
    if (empty($_POST['q3CorAnswer'])){
        $q3CorAnswerErr = "*Correct answer is required";
    }
    else{
        $q3CorAnswer = $_POST["q3CorAnswer"];
    }
    if (empty($_POST['q3FalAnswer1'])){
        $q3FalAnswer1Err = "*False answer is required";
    }
    else{
        $q3FalAnswer1 = $_POST["q3FalAnswer1"];
    }
    if (empty($_POST['q3FalAnswer2'])){
        $q3FalAnswer2Err = "*False answer is required";
    }
    else{
        $q3FalAnswer2 = $_POST["q3FalAnswer2"];
    }
    if (empty($_POST['q3FalAnswer3'])){
        $q3FalAnswer3Err = "*False answer is required";
    }
    else{
        $q3FalAnswer3 = $_POST["q3FalAnswer3"];
    }
    if (empty($_POST['question4'])){
        $question4Err = "*A question is required";
    }
    else{
        $question4 = $_POST["question4"];
    }
    if (empty($_POST['q4CorAnswer'])){
        $q4CorAnswerErr = "*Correct answer is required";
    }
    else{
        $q4CorAnswer = $_POST["q4CorAnswer"];
    }
    if (empty($_POST['q4FalAnswer1'])){
        $q4FalAnswer1Err = "*False answer is required";
    }
    else{
        $q4FalAnswer1 = $_POST["q4FalAnswer1"];
    }
    if (empty($_POST['q4FalAnswer2'])){
        $q4FalAnswer2Err = "*False answer is required";
    }
    else{
        $q4FalAnswer2 = $_POST["q4FalAnswer2"];
    }
    if (empty($_POST['q4FalAnswer3'])){
        $q4FalAnswer3Err = "*False answer is required";
    }
    else{
        $q4FalAnswer3 = $_POST["q4FalAnswer3"];
    }
    if (empty($_POST['question4'])){
        $question4Err = "*A question is required";
    }
    else{
        $question5 = $_POST["question5"];
    }
    if (empty($_POST['q5CorAnswer'])){
        $q5CorAnswerErr = "*Correct answer is required";
    }
    else{
        $q5CorAnswer = $_POST["q5CorAnswer"];
    }
    if (empty($_POST['q5FalAnswer1'])){
        $q5FalAnswer1Err = "*False answer is required";
    }
    else{
        $q5FalAnswer1 = $_POST["q5FalAnswer1"];
    }
    if (empty($_POST['q5FalAnswer2'])){
        $q5FalAnswer2Err = "*False answer is required";
    }
    else{
        $q5FalAnswer2 = $_POST["q5FalAnswer2"];
    }
    if (empty($_POST['q5FalAnswer3'])){
        $q5FalAnswer3Err = "*False answer is required";
    }
    else{
        $q5FalAnswer3 = $_POST["q5FalAnswer3"];
    }
    
        // Insert question into the database
        if (empty($question1Err) && empty($question2Err) && empty($question3Err) && empty($question4Err) && empty($question5Err) && empty($q1CorAnswerErr) && empty($q2CorAnswerErr) && empty($q3CorAnswerErr) && empty($q4CorAnswerErr) && empty($q5CorAnswerErr) && empty($q1FalAnswer1Err) && empty($q1FalAnswer2Err) && empty($q1FalAnswer3Err) && empty($q2FalAnswer1Err) && empty($q2FalAnswer2Err) && empty($q2FalAnswer3Err) && empty($q3FalAnswer1Err) && empty($q3FalAnswer2Err) && empty($q3FalAnswer3Err) && empty($q4FalAnswer1Err) && empty($q4FalAnswer2Err) && empty($q4FalAnswer3Err)&& empty($q5FalAnswer1Err) && empty($q5FalAnswer2Err) && empty($q5FalAnswer3Err)){
            $chapterID = $_POST['selectedChapter'];
            $query = "INSERT INTO smiledatabase.quiz (chapter_id, question1, answer_1, falseAnswer1_1, falseAnswer1_2, falseAnswer1_3, question2, answer_2, falseAnswer2_1, falseAnswer2_2, falseAnswer2_3, question3, answer_3, falseAnswer3_1, falseAnswer3_2, falseAnswer3_3, question4, answer_4, falseAnswer4_1, falseAnswer4_2, falseAnswer4_3, question5, answer_5, falseAnswer5_1, falseAnswer5_2, falseAnswer5_3) VALUES('$chapterID', '$question1', '$q1CorAnswer', '$q1FalAnswer1', '$q1FalAnswer2', '$q1FalAnswer3', '$question2', '$q2CorAnswer', '$q2FalAnswer1', '$q2FalAnswer2', '$q2FalAnswer3', '$question3', '$q3CorAnswer', '$q3FalAnswer1', '$q3FalAnswer2', '$q3FalAnswer3', '$question4', '$q4CorAnswer', '$q4FalAnswer1', '$q4FalAnswer2', '$q4FalAnswer3', '$question5', '$q5CorAnswer', '$q5FalAnswer1', '$q5FalAnswer2', '$q5FalAnswer3')";
    
            if(mysqli_query($link, $query)){
                $validSubmission = True;
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
    <title>Upload Smile Quiz</title>
  </head>
  <body>
    <?php include_once "pageTop.php"; ?>
    <div class = "container" style = "margin-top:30px">
    <?php
        //Displays, in case of a successful or a faulty error form submission.
        if($validSubmission === True){
            echo '<div class="alert alert-success">
                        <small><strong>The quiz has been successfully submitted to the database!</strong></small>
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
    //Displays, in case an no chapters have been created yet or an error occurred retrieving those
        if($chapterExist === False){
            echo '<div class="row justify-content-center">
                <div class="col-sm-3" style="margin-top:100px; text-align: center;">
                    <h1 style="color:#d6efff">Manage Content</h1>
                    <svg class="bi bi-caret-down" width="3.5em" height="3.5em" viewBox="0 0 16 16" fill="currentColor" style="color:#6ac5fe;"  xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3.204 5L8 10.481 12.796 5H3.204zm-.753.659l4.796 5.48a1 1 0 001.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 00-.753 1.659z" clip-rule="evenodd"/>
                    </svg>
                    <h1 style="color:#6ac5fe">Upload <kbd style="background-color: #6ac5fe">Smile</kbd>&nbsp;Quiz</h1>
                </div>
                <div class="col-sm-9" style="margin-top:150px">
                    <div class="alert alert-secondary" style="text-align: center;">
                        <h6><strong>'.$error_message.'</strong></h6>
                    </div>
                </div>
                </div>';
            $chapterExist = "";
        }
        elseif($chapterExist == "error"){
            echo '<div class="row justify-content-center">
                <div class="col-sm-3" style="margin-top:100px">
                    <h1 style="color:#6ac5fe">Upload<br><kbd style="background-color: #6ac5fe">Smile</kbd>&nbsp;quizzes<br>here.</h1>
                </div>
                <div class="col-sm-9" style="margin-top:150px">
                    <div class="alert alert-danger" style="text-align: center;">
                        <h6><strong>'.$error_message.'</strong></h6>
                    </div>
                </div>
                </div>';
            $chapterExist = "";
        }else{
            echo '';
        }
        ?>
        <div class="row justify-content-center" style=<?php echo $styleDisappear; ?>>
            <div class="col-sm-3" style="margin-top:70px; text-align: center;">
              <h2 style="color:#d6efff">Manage Content</h2>
              <svg class="bi bi-caret-down" width="3.5em" height="3.5em" viewBox="0 0 16 16" fill="currentColor" style="color:#6ac5fe;"  xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M3.204 5L8 10.481 12.796 5H3.204zm-.753.659l4.796 5.48a1 1 0 001.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 00-.753 1.659z" clip-rule="evenodd"/>
              </svg>
              <h2 style="color:#6ac5fe">Upload <kbd style="background-color: #6ac5fe">Smile</kbd>&nbsp;Quiz</h2>
            </div>
            <div class="col-sm-9" style="margin-top:30px">
                <div class = "jumbotron rounded-lg" style = "padding-top:0;padding-right:0;padding-left:0; margin-top:30px; padding-bottom:10px; background-color:white; border: solid; border-color:#6ac5fe; border-width: 4px;">
                    <div class = "jumbotron jumbotron-fluid" style="background-color:#6ac5fe; padding-top:10px; padding-bottom:5px; text-align: center" >
                    <h2 style = "color:white">Uploading a Quiz</h2>
                </div>
                <form id="contentForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
                  <div style="margin-left: 30px; margin-right: 30px;">
                      
                      <div class="form-group">
                          <label for="selectedChapter">Select a Category and Chapter</label>
                          <br>
                          <select class="form-control" name="selectedChapter" id="selectedChapter">
                          <?php 
                          while ($catchapItem = mysqli_fetch_array($catchap_query_result)){
                            echo('<option value='.$catchapItem['chapChapterID'].'>'.$catchapItem['category_name'].' - Chapter '.$catchapItem['chapter_number'].': '.$catchapItem['chapter_title'].'</option>');
                          }
                          ?>
                          </select>
                      </div>
                  </div>
              </div>
            </div>
        </div>
        <div class="row justify-content-center" style=<?php echo $styleDisappear; ?>>
            <div class="col-sm-6" style="margin-top:30px">
                <div class = "jumbotron rounded-lg" style = "padding-top:0;padding-right:0;padding-left:0; margin-top:30px; padding-bottom:10px; background-color:white; border: solid; border-color:#6ac5fe; border-width: 4px;">
                    <div class = "jumbotron jumbotron-fluid" style="background-color:#6ac5fe; padding-top:10px; padding-bottom:5px; text-align: center" >
                    <h2 style = "color:white">1. Question</h2>
                </div>
                <div style="margin-left: 30px; margin-right: 30px;">
                  <div class="form-group">
                      <label for="question1">1. Question</label>
                      <br>
                      <input class="form-control" type="text" name="question1" id="question1" <?php safeStrInput("question1", "Question");?>>
                      <div class="invalid-feedback d-block"><?php echo $question1Err; ?></div>
                  </div>
                  <div class="form-group">
                      <label for="question1">Correct Answer</label>
                      <br>
                      <input class="form-control" type="text" name="q1CorAnswer" id="q1CorAnswer" <?php safeStrInput("q1CorAnswer", "Correct Answer Possibility");?>>
                      <div class="invalid-feedback d-block"><?php echo $q1CorAnswerErr; ?></div>
                  </div>
                  <div class="form-group">
                      <label for="question1">False Answer Possibility 1</label>
                      <br>
                      <input class="form-control" type="text" name="q1FalAnswer1" id="q1FalAnswer1" <?php safeStrInput("q1FalAnswer1", "False Answer Possibility");?>>
                      <div class="invalid-feedback d-block"><?php echo $q1FalAnswer1Err; ?></div>
                  </div>
                  <div class="form-group">
                      <label for="question1">False Answer Possibility 2</label>
                      <br>
                      <input class="form-control" type="text" name="q1FalAnswer2" id="q1FalAnswer2" <?php safeStrInput("q1FalAnswer2", "False Answer Possibility");?>>
                      <div class="invalid-feedback d-block"><?php echo $q1FalAnswer2Err; ?></div>
                  </div>
                  <div class="form-group">
                      <label for="question1">False Answer Possibility 3</label>
                      <br>
                      <input class="form-control" type="text" name="q1FalAnswer3" id="q1FalAnswer3" <?php safeStrInput("q1FalAnswer3", "False Answer Possibility");?>>
                      <div class="invalid-feedback d-block"><?php echo $q1FalAnswer3Err; ?></div>
                  </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6" style="margin-top:30px">
                <div class = "jumbotron rounded-lg" style = "padding-top:0;padding-right:0;padding-left:0; margin-top:30px; padding-bottom:10px; background-color:white; border: solid; border-color:#6ac5fe; border-width: 4px;">
                    <div class = "jumbotron jumbotron-fluid" style="background-color:#6ac5fe; padding-top:10px; padding-bottom:5px; text-align: center" >
                    <h2 style = "color:white">2. Question</h2>
                </div>
                <div style="margin-left: 30px; margin-right: 30px;">
                  <div class="form-group">
                      <label for="question1">2. Question</label>
                      <br>
                      <input class="form-control" type="text" name="question2" id="question2" <?php safeStrInput("question1", "Question");?>>
                      <div class="invalid-feedback d-block"><?php echo $question2Err; ?></div>
                  </div>
                  <div class="form-group">
                      <label for="question1">Correct Answer</label>
                      <br>
                      <input class="form-control" type="text" name="q2CorAnswer" id="q2CorAnswer" <?php safeStrInput("q2CorAnswer", "Correct Answer Possibility");?>>
                      <div class="invalid-feedback d-block"><?php echo $q2CorAnswerErr; ?></div>
                  </div>
                  <div class="form-group">
                      <label for="question1">False Answer Possibility 1</label>
                      <br>
                      <input class="form-control" type="text" name="q2FalAnswer1" id="q2FalAnswer1" <?php safeStrInput("q2FalAnswer1", "False Answer Possibility");?>>
                      <div class="invalid-feedback d-block"><?php echo $q2FalAnswer1Err; ?></div>
                  </div>
                  <div class="form-group">
                      <label for="question1">False Answer Possibility 2</label>
                      <br>
                      <input class="form-control" type="text" name="q2FalAnswer2" id="q2FalAnswer2" <?php safeStrInput("q2FalAnswer2", "False Answer Possibility");?>>
                      <div class="invalid-feedback d-block"><?php echo $q2FalAnswer2Err; ?></div>
                  </div>
                  <div class="form-group">
                      <label for="question1">False Answer Possibility 3</label>
                      <br>
                      <input class="form-control" type="text" name="q2FalAnswer3" id="q2FalAnswer3" <?php safeStrInput("q2FalAnswer3", "False Answer Possibility");?>>
                      <div class="invalid-feedback d-block"><?php echo $q2FalAnswer3Err; ?></div>
                  </div>
              </div>
            </div>
          </div>
          </div>
          <div class="row justify-content-center" style=<?php echo $styleDisappear; ?>>
          <div class="col-sm-6" style="margin-top:30px">
                <div class = "jumbotron rounded-lg" style = "padding-top:0;padding-right:0;padding-left:0; margin-top:30px; padding-bottom:10px; background-color:white; border: solid; border-color:#6ac5fe; border-width: 4px;">
                    <div class = "jumbotron jumbotron-fluid" style="background-color:#6ac5fe; padding-top:10px; padding-bottom:5px; text-align: center" >
                    <h2 style = "color:white">3. Question</h2>
                </div>
                <div style="margin-left: 30px; margin-right: 30px;">
                  <div class="form-group">
                      <label for="question1">3. Question</label>
                      <br>
                      <input class="form-control" type="text" name="question3" id="question3" <?php safeStrInput("question3", "Question");?>>
                      <div class="invalid-feedback d-block"><?php echo $question3Err; ?></div>
                  </div>
                  <div class="form-group">
                      <label for="question1">Correct Answer</label>
                      <br>
                      <input class="form-control" type="text" name="q3CorAnswer" id="q3CorAnswer" <?php safeStrInput("q3CorAnswer", " Correct Answer Possibility");?>>
                      <div class="invalid-feedback d-block"><?php echo $q3CorAnswerErr; ?></div>
                  </div>
                  <div class="form-group">
                      <label for="question1">False Answer Possibility 1</label>
                      <br>
                      <input class="form-control" type="text" name="q3FalAnswer1" id="q3FalAnswer1" <?php safeStrInput("q3FalAnswer1", "False Answer Possibility");?>>
                      <div class="invalid-feedback d-block"><?php echo $q3FalAnswer1Err; ?></div>
                  </div>
                  <div class="form-group">
                      <label for="question1">False Answer Possibility 2</label>
                      <br>
                      <input class="form-control" type="text" name="q3FalAnswer2" id="q3FalAnswer2" <?php safeStrInput("q3FalAnswer2", " False Answer Possibility");?>>
                      <div class="invalid-feedback d-block"><?php echo $q3FalAnswer2Err; ?></div>
                  </div>
                  <div class="form-group">
                      <label for="question1">False Answer Possibility 3</label>
                      <br>
                      <input class="form-control" type="text" name="q3FalAnswer3" id="q3FalAnswer3" <?php safeStrInput("q3FalAnswer3", "False Answer Possibility");?>>
                      <div class="invalid-feedback d-block"><?php echo $q3FalAnswer2Err; ?></div>
                  </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6" style="margin-top:30px">
                <div class = "jumbotron rounded-lg" style = "padding-top:0;padding-right:0;padding-left:0; margin-top:30px; padding-bottom:10px; background-color:white; border: solid; border-color:#6ac5fe; border-width: 4px;">
                    <div class = "jumbotron jumbotron-fluid" style="background-color:#6ac5fe; padding-top:10px; padding-bottom:5px; text-align: center" >
                    <h2 style = "color:white">4. Question</h2>
                </div>
                <div style="margin-left: 30px; margin-right: 30px;">
                  <div class="form-group">
                      <label for="question1">4. Question</label>
                      <br>
                      <input class="form-control" type="text" name="question4" id="question4" <?php safeStrInput("question4", "Question");?>>
                      <div class="invalid-feedback d-block"><?php echo $question4Err; ?></div>
                  </div>
                  <div class="form-group">
                      <label for="question1">Correct Answer</label>
                      <br>
                      <input class="form-control" type="text" name="q4CorAnswer" id="q4CorAnswer" <?php safeStrInput("q4CorAnswer", "Correct Answer Possibility");?>>
                      <div class="invalid-feedback d-block"><?php echo $q4CorAnswerErr; ?></div>
                  </div>
                  <div class="form-group">
                      <label for="question1">False Answer Possibility 1</label>
                      <br>
                      <input class="form-control" type="text" name="q4FalAnswer1" id="q4FalAnswer1" <?php safeStrInput("q4FalAnswer1", "False Answer Possibility");?>>
                      <div class="invalid-feedback d-block"><?php echo $q4FalAnswer1Err; ?></div>
                  </div>
                  <div class="form-group">
                      <label for="question1">False Answer Possibility 2</label>
                      <br>
                      <input class="form-control" type="text" name="q4FalAnswer2" id="q4FalAnswer2" <?php safeStrInput("q4FalAnswer2", "False Answer Possibility");?>>
                      <div class="invalid-feedback d-block"><?php echo $q4FalAnswer2Err; ?></div>
                  </div>
                  <div class="form-group">
                      <label for="question1">False Answer Possibility 3</label>
                      <br>
                      <input class="form-control" type="text" name="q4FalAnswer3" id="q4FalAnswer3" <?php safeStrInput("q4FalAnswer3", "False Answer Possibility");?>>
                      <div class="invalid-feedback d-block"><?php echo $q4FalAnswer3Err; ?></div>
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row justify-content-center" style=<?php echo $styleDisappear; ?>>
          <div class="col-sm-6" style="margin-top:30px">
                <div class = "jumbotron rounded-lg" style = "padding-top:0;padding-right:0;padding-left:0; margin-top:30px; padding-bottom:10px; background-color:white; border: solid; border-color:#6ac5fe; border-width: 4px;">
                    <div class = "jumbotron jumbotron-fluid" style="background-color:#6ac5fe; padding-top:10px; padding-bottom:5px; text-align: center" >
                    <h2 style = "color:white">5. Question</h2>
                </div>
                <div style="margin-left: 30px; margin-right: 30px;">
                  <div class="form-group">
                      <label for="question5">5. Question</label>
                      <br>
                      <input class="form-control" type="text" name="question5" id="question5" <?php safeStrInput("question5", "Question");?>>
                      <div class="invalid-feedback d-block"><?php echo $question5Err; ?></div>
                  </div>
                  <div class="form-group">
                      <label for="question1">Correct Answer</label>
                      <br>
                      <input class="form-control" type="text" name="q5CorAnswer" id="q5CorAnswer" <?php safeStrInput("q5CorAnswer", " Correct Answer Possibility");?>>
                      <div class="invalid-feedback d-block"><?php echo $q5CorAnswerErr; ?></div>
                  </div>
                  <div class="form-group">
                      <label for="question1">False Answer Possibility 1</label>
                      <br>
                      <input class="form-control" type="text" name="q5FalAnswer1" id="q5FalAnswer1" <?php safeStrInput("q5FalAnswer1", "False Answer Possibility");?>>
                      <div class="invalid-feedback d-block"><?php echo $q5FalAnswer1Err; ?></div>
                  </div>
                  <div class="form-group">
                      <label for="question1">False Answer Possibility 2</label>
                      <br>
                      <input class="form-control" type="text" name="q5FalAnswer2" id="q5FalAnswer2" <?php safeStrInput("q5FalAnswer2", " False Answer Possibility");?>>
                      <div class="invalid-feedback d-block"><?php echo $q5FalAnswer2Err; ?></div>
                  </div>
                  <div class="form-group">
                      <label for="question1">False Answer Possibility 3</label>
                      <br>
                      <input class="form-control" type="text" name="q5FalAnswer3" id="q5FalAnswer3" <?php safeStrInput("q5FalAnswer3", "False Answer Possibility");?>>
                      <div class="invalid-feedback d-block"><?php echo $q5FalAnswer3Err; ?></div>
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row justify-content-center" style=<?php echo $styleDisappear; ?>>
            <button class="btn btn-primary" type="submit">Submit</button>
        </div>
        </form>
    </div>
  </div>
     <!-- Integrating Javascript library from Bootstrap (jQuery, Popper.js and Javascript sublibraries)-->
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <?php include "pageFooter.php"; ?>
  </body>
</html>